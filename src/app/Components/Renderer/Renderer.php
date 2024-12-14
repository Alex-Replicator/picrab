<?php
namespace Picrab\Components\Renderer;



class Renderer
{
    public $theme;
    private static $DB;

    public function __construct(mixed $config)
    {

    }

    public function renderPage($config)
    {
        __dd($config, 1);
    }


    public function renderBlock(string $template, array $data = []): string
    {
        if (!file_exists($template)) {
            return '';
        }
        extract($data);
        ob_start();
        include $template;
        return ob_get_clean();
    }

}