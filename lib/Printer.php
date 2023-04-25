<?php

namespace App;

final class Printer
{
    public function out(string $message, string $style = "default"): void
    {
        echo sprintf("\e[%sm%s\e[0m", $this->color($style), $message);
    }

    public function info(string $message = ''): void
    {
        $this->display($message, $this->color('info'));
    }

    public function success(string $message = ''): void
    {
        $this->display($message, $this->color('success'));
    }

    public function display(string $message, string $color = 'default'): void
    {
        $this->newline();
        $this->out($message, $color);
    }

    public function error(string $message = ''): void
    {
        $this->display($message, $this->color('error'));
    }

    private function newline(): void
    {
        $this->out("\n");
    }

    private function color(string $color = 'default'): string
    {
        $colors = [
            'bold'        => PrinterColors::BOLD,
            'default'     => PrinterColors::FG_WHITE,
            'dim'         => PrinterColors::DIM,
            'error'       => PrinterColors::FG_RED,
            'info'        => PrinterColors::FG_CYAN,
            'invert'      => PrinterColors::INVERT,
            'italic'      => PrinterColors::ITALIC,
            'success'     => PrinterColors::FG_GREEN,
            'underline'   => PrinterColors::UNDERLINE,
        ];

        return $colors[$color] ?? $colors['default'];
    }
}