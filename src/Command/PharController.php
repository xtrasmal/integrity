<?php

namespace Xtrasmal\Command;

use App\CommandController;
use Phar;

final class PharController extends CommandController
{
    public function run(array $argv = []): void
    {
        $this->printer()->info("Phar: Compressing files and folders");
        $this->printer()->info("-------------");
        $this->build();
    }

    public function build(): void
    {
        $pharFile = $this->appName() . ".phar";

        // clean up
        if (file_exists($pharFile)) {
            unlink($pharFile);
        }

        try {

            // create phar
            $phar = new Phar($pharFile);

            // start buffering
            $phar->startBuffering();

            // Add all files that are considered project files
            foreach ($this->projectFiles()->all() as $filePath)
            {
                $relativePath = substr($filePath, strlen($this->rootPath()) + 1);
                $phar->addFromString($relativePath, file_get_contents($filePath));
            }

            // add the stub
            $phar->setStub($this->bootstrapStub());

            // stop buffering
            $phar->stopBuffering();

            // compressing it into gzip
            $phar->compressFiles(Phar::GZ);

            # Make the file executable
            chmod($pharFile, 0770);

        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    private function bootstrapStub(): string
    {
        $appName = $this->appName();
        return "<?php include 'phar://$appName.phar/$appName';__HALT_COMPILER();";
    }
}
