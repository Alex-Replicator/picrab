<?php
namespace Picrab\Components\Renderer;



class Renderer
{

    public array $pageContent;


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