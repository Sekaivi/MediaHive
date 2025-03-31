<<<<<<< HEAD
<?php

class Translation {
    private static $instance = null;
    private $translations = [];
    private $lang = 'en'; // Default language

    private function __construct() {
        $this->loadTranslations();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Translation();
        }
        return self::$instance;
    }

    public function setLanguage($lang) {
        $this->lang = $lang;
        $this->loadTranslations();
    }

    private function loadTranslations() {
        $file = __DIR__ . "/../lang/{$this->lang}.php";
        if (file_exists($file)) {
            $this->translations = include $file;
        } else {
            $this->translations = [];
        }
    }

    public function get($key) {
        return $this->translations[$key] ?? "[$key]";
    }

    public function getAll() {
        return $this->translations;
    }
}
=======
<?php

class Translation {
    private static $instance = null;
    private $translations = [];
    private $lang = 'en'; // Default language

    private function __construct() {
        $this->loadTranslations();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Translation();
        }
        return self::$instance;
    }

    public function setLanguage($lang) {
        $this->lang = $lang;
        $this->loadTranslations();
    }

    private function loadTranslations() {
        $file = __DIR__ . "/../lang/{$this->lang}.php";
        if (file_exists($file)) {
            $this->translations = include $file;
        } else {
            $this->translations = [];
        }
    }

    public function get($key) {
        return $this->translations[$key] ?? "[$key]";
    }

    public function getAll() {
        return $this->translations;
    }
}
>>>>>>> 38c97c2a7c21885c6f0ca7ab019c19a977e8285c
