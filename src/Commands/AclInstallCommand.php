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

        // $this->call('vendor:publish', ['--tag' => 'acl-config']);
        // $this->call('vendor:publish', ['--tag' => 'acl-migrations']);
        // $this->call('vendor:publish', ['--tag' => 'acl-translations']);


        // if (!is_dir(app_path('Models/Callcocam'))) {
        //     File::makeDirectory(app_path('Models/Callcocam'), 0755, true);
        // }
        // if (!class_exists('App\Models\Callcocam\AbstractModel')) {
        //     File::put(app_path('Models/Callcocam/AbstractModel.php'), file_get_contents(__DIR__ . '/stubs/abstract-model.stub'));
        // }

        // if (!class_exists('App\Models\Callcocam\Role')) {
        //     File::put(app_path('Models/Callcocam/Role.php'), file_get_contents(__DIR__ . '/stubs/role-model.stub'));
        //     if (!class_exists('App\Models\Callcocam\Permission')) {
        //         File::put(app_path('Models/Callcocam/Permission.php'), file_get_contents(__DIR__ . '/stubs/permission-model.stub'));
        //     }
        //     if (!class_exists('App\Models\Callcocam\AccessGroup')) {
        //         File::put(app_path('Models/Callcocam/AccessGroup.php'), file_get_contents(__DIR__ . '/stubs/access-group-model.stub'));
        //     }
        //     $this->info('Abstract model created successfully.');
        //     $this->info('Please run "php artisan app:acl-install" to continue...');
        //     return true;
        // }


        $this->call('migrate');

        if ($this->confirm(trans('acl.do-you-want-to-create-roles'))) {
            $this->createRoles();
        }

        if ($this->confirm(trans('acl.do-you-want-to-create-permissions'))) {
            $this->createPermissions();
        }

        $this->info('Filament Acl installed successfully.');
    }


    protected function createRoles()
    {
        $name = $this->ask('What is the name of the super admin role?', 'Super Admin');
        $slug = $this->ask('What is the slug of the super admin role?', 'super-admin');
        $allAccess = $this->ask('What is the special of the super admin role?', 'all-access');
        $description = $this->ask('What is the description of the super admin role?', 'Super Administrador do sistema');

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
            $user = $this->choice('Select a user to be super admin', User::pluck('name', 'id')->toArray());
            if ($user) { 
                $role->users()->sync(User::query()->whereName($user)->first());
            }
        } else {

            if ($this->confirm('Do you want to create a super admin user?')) {
                $name = $this->ask('What is the name of the super admin user?', 'Super Admin');
                $email = $this->ask('What is the email of the super admin user?', 'super-admin@example.com');
                $user =  User::factory()->create([
                    'name' => $name,
                    'email' => $email,
                ]);
                $role->users()->sync($user);
                $this->info(sprintf('Super admin user `%s` created successfully.', $email));
            }

            $name = $this->ask('What is the name of the admin role?', 'Admin');
            $slug = $this->ask('What is the slug of the admin role?', 'admin');
            $description = $this->ask('What is the description of the admin role?', 'Administrador do sistema');
            $role = Role::create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
            ]);

            if ($this->confirm('Do you want to create a admin user?')) {
                $name = $this->ask('What is the name of the admin user?', 'Admin');
                $email = $this->ask('What is the email of the admin user?', 'admin@example.com');
                $user =  User::factory()->create([
                    'name' => $name,
                    'email' => $email
                ]);
                $role->users()->sync($user);
                $this->info(sprintf('Admin user `%s` created successfully.', $email));
            }

            $name = $this->ask('What is the name of the user role?', 'User');
            $slug = $this->ask('What is the slug of the user role?', 'user');
            $description = $this->ask('What is the description of the user role?', 'Usuário do sistema');
            $role = Role::create([
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
            ]);

            if ($this->confirm('Do you want to create a user?')) {
                $name = $this->ask('What is the name of the user?', 'User');
                $email = $this->ask('What is the email of the user?', 'user@example.com');
                $user = User::factory()->create([
                    'name' => $name,
                    'email' => $email
                ]);
                $role->users()->sync($user);
                $this->info('User user `user@example.com` created successfully.');
            }
        }
    }

    protected function createPermissions()
    {
        LoadRouterHelper::make()->save();
    }
}
