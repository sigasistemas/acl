<?php

namespace Callcocam\Acl\Commands;

use Illuminate\Console\Command;

class AclCommand extends Command
{
    public $signature = 'acl';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
