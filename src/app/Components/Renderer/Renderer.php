<?php
namespace Picrab\Components\Renderer;

class Renderer {
    private string $currentTheme;

    public function __construct(array $config) {
        $this->currentTheme = $config['current_theme'] ?? $config['default_theme_name'];
    }

    public function renderTemplate(string $templatePath, array $data = []): string {
        if (!file_exists($templatePath)) {
            return '';
        }
        extract($data);
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    public function getThemePath(): string {
        return "/var/www/html/app/Themes/" . $this->currentTheme;
    }
}
