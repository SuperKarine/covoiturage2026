<?php

class Renderer 
{
    public function __construct(
        private string $viewPath,
        private string $basePath
    ) {}

    public function view()
    {
        ob_start();

        require $this->basePath . $this->viewPath . '.php';

        return ob_get_clean();
    }

    public static function make(string $viewPath): static
    {
        return new static(
            $viewPath,
            __DIR__ . '/../../views/'
        );
    }
}