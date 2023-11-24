<?php

namespace Callcocam\Acl\Commands;

use App\Models\User;
use Callcocam\Acl\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AclAddRuleCommand extends Command
{
    public $signature = 'app:acl-add-rule {--connection=mysql} {--user=users} {--role=} ';

    public $description = 'Adicionar regra de acesso ao um usuário';

    public function handle(): int
    { 
        $this->info('Adicionar regra de acesso ao um usuário');
        if (Role::count()) {
            $role = $this->choice('Selecione uma regra', Role::pluck('name', 'id')->toArray());
            if ($role) {
                $role = Role::query()->whereId($role)->first();
                if (DB::connection($this->option('connection'))->table($this->option('user'))->count()) {
                    $user = $this->choice('Selecione um usuário para ser super administrador', DB::connection($this->option('connection'))->table($this->option('user'))->pluck('name', 'id')->toArray());
                    if ($user) {
                        $role->users()->sync([$user]);
                    }
                }
            }
        }
        $this->info('Regra adicionada com sucesso');
        return 0;
    }
}
