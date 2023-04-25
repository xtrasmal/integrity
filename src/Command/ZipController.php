<?php

namespace Wirelab\Command;

use App\CommandController;
use App\Hash;
use ZipArchive;

final class ZipController extends CommandController
{


    public function run(array $argv = []): void
    {
        $this->printer()->info("Zip: Zipping files and folders");
        $this->printer()->info("-------------");
        $this->build();
        $this->printer()->info("------------- finished");
    }

    public function build(): void
    {
        $zipFile = $this->appName().".zip";

        // Clean up
        $this->projectFiles()->cleanUp($zipFile);

        // Initialize archive object
        $zip = new ZipArchive();
        $zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Load all files that are considered project files
        $files = $this->projectFiles()->all();

        foreach ($files as $filePath)
        {
            $relativePath = substr($filePath, strlen($this->rootPath()) + 1);
            // Add current file to archive
            $zip->addFromString($relativePath, file_get_contents($filePath));
        }

        // Close to create the archive
        $zip->close();

        // Create hash
        $this->makeHashFor($zipFile);

        // Cleanup
        // $this->projectFiles()->cleanUp($zipFile);

        foreach ($files as $file) {
            $this->printer()->info("Added $file");
        }

    }

    private function makeHashFor(string $filename): void
    {
        Hash::storeFor($filename);
    }
}