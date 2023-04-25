<?php 

namespace App;

use Exception;

final class Integrity
{
    public const APP_NAME = 'integrity';
    protected Printer $printer;
    protected CommandRegistry $registry;
    private string $rootPath;

    public function __construct(string $path)
    {
        $this->rootPath = realpath($path);
        $this->printer = new Printer();
        $this->registry = new CommandRegistry();
    }

    public function printer(): Printer
    {
        return $this->printer;
    }

    public function rootPath(): string
    {
        return $this->rootPath;
    }

    public function appName(): string
    {
        return (string) $this;
    }

    public function registerController(string $name, CommandController $controller): void
    {
        $this->registry->registerController($name, $controller);
    }

    public function registerCommand(string $name, $callable): void
    {
        $this->registry->registerCommand($name, $callable);
    }

    public function runCommand(array $argv = [], string $command = 'help'): void
    {
        $commandName = $argv[1] ?? $command;

        try {
            call_user_func($this->registry->getCallable($commandName), $argv);
        } catch (Exception $e) {
            $this->printer()->error("ERROR: " . $e->getMessage());
            exit;
        }
    }

    public function __toString(): string
    {
        return self::APP_NAME;
    }
}
