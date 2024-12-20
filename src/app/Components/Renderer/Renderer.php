<?php
namespace Picrab\Components\Renderer;

class Renderer
{
    public string $currentTheme;
    public array $globalConfig;

    public function __construct(array $config, $globalConfig = [])
    {
        $this->currentTheme = $config['current_theme'] ?? $config['default_theme_name'];
        $this->globalConfig = $globalConfig;
    }

    public function renderTemplate(string $templatePath, array $data = []): string {
        if (!file_exists($templatePath)) {
            return '';
        }
        extract($this->globalConfig);
        extract($data);
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    public function getThemePath(): string {
        return __DIR__ . "/../../Themes/" . $this->currentTheme;
    }
}
