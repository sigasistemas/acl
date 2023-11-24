<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

namespace Callcocam\Acl\Commands;

use Callcocam\Acl\LoadRouterHelper;
use Illuminate\Console\Command;

class AclGeneratePermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:acl-generate-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate permissions for the Filament Acl package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //Deseja gerar permissões para o pacote Filament Acl?
        if ($this->confirm('Deseja gerar permissões para o pacote Filament Acl??')) {
            $delete = $this->confirm('Você deseja excluir todas as permissões existentes?'); 
            LoadRouterHelper::make()->save($delete );
            $this->info('Permissões geradas com sucesso.');
            return;
        }
        $this->info('Permissões não geradas.');
    }
}
