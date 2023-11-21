<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Commands;

use App\Models\User;
use Callcocam\Acl\LoadRouterHelper;
use Callcocam\Acl\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File; 


class AclInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:acl-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Filament Acl package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Installing Filament Acl...');

        $this->call('migrate');

        if ($this->confirm(__('acl::acl.do-you-want-to-create-roles'))) {
            $this->createRoles();
        }

        if ($this->confirm(trans('acl::acl.do-you-want-to-create-permissions'))) {
            $this->createPermissions();
        }

        $this->info('Filament Acl installed successfully.');
    }


    protected function createRoles()
    {
        $name = $this->ask('Qual é o nome da função de super administrador?', 'Super Admin');
        $slug = $this->ask('Qual é o slug da função de super administrador?', 'super-admin');
        $allAccess = $this->ask('Qual é o nível de acesso especial da função de super administrador?', 'all-access');
        $description = $this->ask('Qual é a descrição da função de super administrador?', 'Super Administrador do sistema');

        if ($role = Role::where('slug', $slug)->first()) {
            $this->info(sprintf('Role `%s` already exists.', $slug)); 
        } else {
            $role = Role::create([
                'name' => $name,
                'slug' => $slug,
                'special' => $allAccess,
                'description' => $description,
            ]);
        }

        if (User::count()) {
            $user = $this->choice('Selecione um usuário para ser super administrador', User::pluck('name', 'id')->toArray());
            if ($user) { 
                $role->users()->sync(User::query()->whereName($user)->first());
            }
        } else {

            if ($this->confirm('Deseja criar um usuário super administrador?')) {
                $name = $this->ask('Qual é o nome do usuário super administrador?', 'Super Admin');
                $email = $this->ask('Qual é o e-mail do usuário super administrador?', 'super-admin@example.com');
                $user =  User::factory()->create([
                    'name' => $name,
                    'email' => $email,
                ]);
                $role->users()->sync($user);
                $this->info(sprintf('Usuário super administrador `%s` criado com sucesso.', $email));
            }

            $name = $this->ask('Qual é o nome da função de administrador?', 'Admin');
            $slug = $this->ask('Qual é o slug da função de administrador?', 'admin');
            $description = $this->ask('Qual é a descrição da função de administrador?', 'Administrador do sistema');
            $role = Role::create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
            ]);

            if ($this->confirm('Deseja criar um usuário administrador?')) {
                $name = $this->ask('Nome do usuário?', 'Admin');
                $email = $this->ask('E-Mail para o usuário?', 'admin@example.com');
                $user =  User::factory()->create([
                    'name' => $name,
                    'email' => $email
                ]);
                $role->users()->sync($user);
                $this->info(sprintf('Usuário administrador `%s` criado com sucesso.', $email));
            }

            $name = $this->ask('Qual é o nome da função de usuário?', 'Usuário');
            $slug = $this->ask('Qual é o slug da função de usuário?', 'user');
            $description = $this->ask('Qual é a descrição da função de usuário?', 'Usuário do sistema');
            $role = Role::create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
            ]);

            if ($this->confirm('Deseja criar um usuário?')) {
                $name = $this->ask('Qual é o nome do usuário?', 'Usuário');
                $email = $this->ask('Qual é o e-mail do usuário?', 'user@example.com');
                $user = User::factory()->create([
                    'name' => $name,
                    'email' => $email
                ]);
                $role->users()->sync($user);
                $this->info('Usuário `user@example.com` criado com sucesso.');
            }
        }
    }

    protected function createPermissions()
    {
        LoadRouterHelper::make()->save();
    }
}
