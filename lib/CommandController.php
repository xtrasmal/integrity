<?php

namespace App;

abstract class CommandController
{
    protected Integrity $app;

    abstract public function run(array $argv = []);

    public function __construct(Integrity $app)
    {
        $this->app = $app;
    }

    protected function app(): Integrity
    {
        return $this->app;
    }

    protected function appName(): string
    {
        return (string) $this->app();
    }

    protected function printer(): Printer
    {
        return $this->app()->printer();
    }

    protected function projectFiles(): ProjectFiles
    {
        return new ProjectFiles($this->rootPath());
    }

    protected function rootPath(): string
    {
        return $this->app()->rootPath();
    }
}