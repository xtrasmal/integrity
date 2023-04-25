<?php

namespace Wirelab\Command;

use App\CommandController;
use App\Hash;
use App\Integrity;

final class SetupController extends CommandController
{
    public function run(array $argv = []): void
    {
        $this->printer()->info("Setting up");
        $this->printer()->info("-------------");
        file_put_contents(Hash::HASH_FILENAME, '');
        $this->printer()->info("Created empty checksum file");
        file_put_contents(Integrity::APP_NAME.'.zip', '');
        $this->printer()->info("Created empty zip file");
    }
}