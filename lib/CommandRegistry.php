<?php

namespace App;

use RuntimeException;

final class CommandRegistry
{
    protected array $registry = [];

    protected array $controllers = [];

    public function registerController($name, CommandController $controller): void
    {
        $this->controllers[$name] = $controller;
    }

    public function registerCommand($name, $callable): void
    {
        $this->registry[$name] = $callable;
    }

    public function getController($name): mixed
    {
        return $this->controllers[$name] ?? null;
    }

    public function getCommand($name): mixed
    {
        return $this->registry[$name] ?? null;
    }

    public function getCallable($name): mixed
    {
        $controller = $this->getController($name);

        if ($controller instanceof CommandController) {
            return [ $controller, 'run' ];
        }

        $command = $this->getCommand($name);

        if ($command === null) {
            throw new RuntimeException("Command \"$name\" not found.");
        }

        return $command;
    }
}