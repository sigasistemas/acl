<?php

namespace Callcocam\Acl\Commands;
 
use App\Models\User;
use Callcocam\Acl\Models\Role;
use Illuminate\Console\Command;

class AclAddRuleCommand extends Command
{
    public $signature = 'app:acl-add-rule';

    public $description = 'Adicionar regra de acesso ao um usuário';

    public function handle(): int
    {
        $this->info('Adicionar regra de acesso ao um usuário');
        if (Role::count()) {
            $role = $this->choice('Selecione uma regra', Role::pluck('name', 'id')->toArray());
            if ($role) {
                $role = Role::query()->whereId($role)->first();
                if (User::count()) {
                    $user = $this->choice('Selecione um usuário para ser super administrador', User::pluck('name', 'id')->toArray());
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
