<?php
namespace Picrab\Core;
class Context {
    public $renderer;
    public $db;
    public $modules;
    public $pageContent;
    public $currentTheme;

    public function __construct($renderer, $db, $modules, $pageContent, $currentTheme = 'default') {
        $this->renderer = $renderer;
        $this->db = $db;
        $this->modules = $modules;
        $this->pageContent = $pageContent;
        $this->currentTheme = $currentTheme;
    }
}