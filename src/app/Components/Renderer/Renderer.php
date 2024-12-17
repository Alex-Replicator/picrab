<?php
namespace Picrab\Components\Renderer;

class Renderer
{
    private string $defaultThemeName;

    public function __construct(array $config)
    {
        $this->defaultThemeName = $config['default_theme_name'] ?? 'default';
    }

    public function renderTemplate(string $templatePath, array $data = []): string
    {
        if (!file_exists($templatePath)) {
            return '';
        }
        extract($data);
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    public function getThemePath(): string
    {
        return "/var/www/html/app/Themes/" . $this->defaultThemeName;
    }
}