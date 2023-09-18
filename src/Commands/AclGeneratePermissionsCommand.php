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
        if ($this->confirm('Do you want to generate permissions for the Filament Acl package?')) {
            $delete = $this->confirm('Do you want to delete all existing permissions?'); 
            LoadRouterHelper::make()->save($delete );
            $this->info('Permissions generated successfully.');
            return;
        }
        $this->info('Permissions not generated.');
    }
}
