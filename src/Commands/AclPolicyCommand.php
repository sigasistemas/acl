<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Commands;

use Callcocam\Acl\Models\AccessGroup;
use Callcocam\Acl\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Support\Str;
use LogicException;

use function Laravel\Prompts\suggest;

class AclPolicyCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:acl-policy {name : The name of the policy}
        {--model= : The model that the policy applies to} 
        {--guard= : The guard that the policy relies on} 
        {--force : Create the class even if the policy already exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new policy class for acl';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Policy';

    protected $permissions;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $options = Permission::query()
            ->whereIn('access_group_id', AccessGroup::query()->where('slug',  'index')->pluck('id', 'id')->toArray())->pluck('name', 'slug')
            ->toArray();

        if (!$options) {
            $this->error('You have not created any permissions yet.');
            return;
        }
        $policy = $this->choice('Which policy would you like to generate?', $options, false);

        if (!$policy) {
            $this->error('You have not created any permissions yet.');
            return;
        }
        $this->permissions = Str::beforeLast($policy, '.');


        parent::handle();
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->replaceUserNamespace(
            parent::buildClass($name)
        );

        $model = $this->option('model');

        return $model ? $this->replaceModel($stub, $model) : $stub;
    }

    /**
     * Replace the User model namespace.
     *
     * @param  string  $stub
     * @return string
     */
    protected function replaceUserNamespace($stub)
    {
        $model = $this->userProviderModel();

        if (!$model) {
            return $stub;
        }

        return str_replace(
            $this->rootNamespace() . 'User',
            $model,
            $stub
        );
    }

    /**
     * Get the model for the guard's user provider.
     *
     * @return string|null
     *
     * @throws \LogicException
     */
    protected function userProviderModel()
    {
        $config = $this->laravel['config'];

        $guard = $this->option('guard') ?: $config->get('auth.defaults.guard');

        if (is_null($guardProvider = $config->get('auth.guards.' . $guard . '.provider'))) {
            throw new LogicException('The [' . $guard . '] guard is not defined in your "auth" configuration file.');
        }

        if (!$config->get('auth.providers.' . $guardProvider . '.model')) {
            return 'App\\Models\\User';
        }

        return $config->get(
            'auth.providers.' . $guardProvider . '.model'
        );
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @param  string  $model
     * @return string
     */
    protected function replaceModel($stub, $model)
    {
        $model = str_replace('/', '\\', $model);

        if (str_starts_with($model, '\\')) {
            $namespacedModel = trim($model, '\\');
        } else {
            $namespacedModel = $this->qualifyModel($model);
        }

        $model = class_basename(trim($model, '\\'));

        $dummyUser = class_basename($this->userProviderModel());

        $dummyModel = Str::camel($model) === 'user' ? 'model' : $model;

        $replace = [
            'NamespacedDummyModel' => $namespacedModel,
            '{{ namespacedModel }}' => $namespacedModel,
            '{{namespacedModel}}' => $namespacedModel,
            'DummyModel' => $model,
            '{{ model }}' => $model,
            '{{model}}' => $model,
            'dummyModel' => Str::camel($dummyModel),
            '{{ modelVariable }}' => Str::camel($dummyModel),
            '{{modelVariable}}' => Str::camel($dummyModel),
            'DummyUser' => $dummyUser,
            '{{ user }}' => $dummyUser,
            '{{user}}' => $dummyUser,
            '$user' => '$' . Str::camel($dummyUser),
            '{{ permission }}' => $this->permissions
        ];

        $stub = str_replace(
            array_keys($replace),
            array_values($replace),
            $stub
        );

        return preg_replace(
            vsprintf('/use %s;[\r\n]+use %s;/', [
                preg_quote($namespacedModel, '/'),
                preg_quote($namespacedModel, '/'),
            ]),
            "use {$namespacedModel};",
            $stub
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/acl-policy.stub';
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Policies';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the policy already exists'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model that the policy applies to'],
            ['guard', 'g', InputOption::VALUE_OPTIONAL, 'The guard that the policy relies on'],
        ];
    }

    /**
     * Interact further with the user if they were prompted for missing arguments.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output)
    {
        if ($this->isReservedName($this->getNameInput()) || $this->didReceiveOptions($input)) {
            return;
        }

        $model = suggest(
            'What model should this policy apply to? (Optional)',
            $this->possibleModels(),
        );

        if ($model) {
            $input->setOption('model', $model);
        }
    }
}
