<?php
/**
* Created by Claudio Campos.
* User: callcocam@gmail.com, contato@sigasmart.com.br
* https://www.sigasmart.com.br
*/
namespace Callcocam\Acl;

use Callcocam\Acl\Commands\AclAddRuleCommand;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Callcocam\Acl\Commands\AclCommand;
use Callcocam\Acl\Commands\AclGeneratePermissionsCommand;
use Callcocam\Acl\Commands\AclInstallCommand;
use Callcocam\Acl\Commands\AclPolicyCommand;
use Callcocam\Acl\Testing\TestsAcl;
use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AclServiceProvider extends PackageServiceProvider
{
    public static string $name = 'acl';

    public static string $viewNamespace = 'acl';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('callcocam/acl');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
        
        if (file_exists($package->basePath('/../routes'))) {
            $package->hasRoutes($this->getRoutes());
        }
    }

    public function packageRegistered(): void
    {
        $this->app->bind(StatefulGuard::class, function () {
            return Auth::guard(config('fortify.guard', null));
        });
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/acl/{$file->getFilename()}"),
                ], 'acl-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsAcl());

        $this->registerGates();
    }

    protected function getAssetPackageName(): ?string
    {
        return 'callcocam/acl';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('acl', __DIR__ . '/../resources/dist/components/acl.js'),
            // Css::make('acl-styles', __DIR__ . '/../resources/dist/acl.css'),
            // Js::make('acl-scripts', __DIR__ . '/../resources/dist/acl.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            AclCommand::class,
            AclGeneratePermissionsCommand::class,
            AclInstallCommand::class,
            AclPolicyCommand::class,
            AclAddRuleCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [
            'web',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_access_groups_table',
            'create_roles_table',
            'create_permissions_table',
            'create_role_user_table',
            'create_permission_role_table',
            'create_permission_user_table'

        ];
    }

        /**
     * Register the permission gates.
     *
     * @return void
     */
    protected function registerGates()
    {
        Gate::before(function (Authorizable $user, $permission) {
            try {
                if (method_exists($user, 'hasPermissionTo')) {
                    return $user->hasPermissionTo($permission) ?: null;
                }
            } catch (\Exception $e) {
                //dd($e);
            }
        });
    }
}
