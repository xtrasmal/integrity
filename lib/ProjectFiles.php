<?php

namespace App;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

final class ProjectFiles
{
    private string $rootPath;

    public function __construct(string $rootPath)
    {
        $this->rootPath = $rootPath;
    }

    public function all(): array
    {
        $projectFiles = [];
        $files = $this->iterator();

        foreach ($files as $file) {

            $baseName = $file->getBasename();
            $realPath = $file->getRealPath();

            if ( $file->isDir() ) {
                continue;
            }

            if ( $this->shouldBeExcluded($baseName, $realPath) ) {
                continue;
            }

            $projectFiles[] = $realPath;
        }

        return $projectFiles;
    }

    public function iterator(): RecursiveIteratorIterator
    {
        /** @var SplFileInfo[] $files */
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->rootPath, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
    }

    public function cleanUp(string $filename): void
    {
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    private function shouldBeExcluded($baseName, $realPath): bool
    {
        if (in_array($baseName, $this->exclude(), true)) {
            return true;
        }

        foreach ($this->exclude() as $excluded ) {
            if ( str_starts_with($realPath, $excluded) ) {
                return true;
            }
        }

        return false;
    }

    private function exclude(): array
    {
        $excluded = include($this->rootPath."/excluded.php");
        $cwd = realpath(getcwd());

        return array_merge($excluded, [
            ".DS_Store",
            "$cwd/node_modules",
            "$cwd/.idea",
            "$cwd/.git",
            "$cwd/".Integrity::APP_NAME.".phar",
            "$cwd/".Integrity::APP_NAME.".zip",
            "$cwd/.env",
            "$cwd/.idea",
            "$cwd/.vscode",
        ]);
    }
}