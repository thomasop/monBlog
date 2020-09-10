<?php
namespace App\tool;

class PHPSession {
    protected $flash = [];

    public function __construct() {
        $this->ensureStarted();
    }

    private function ensureStarted() {
        if (session_status() === PHP_SESSION_NONE) session_start();
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function get(string $key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public function getFlashMessage(string $key, $default = null) {
        if (!isset($this->flash[$key])) {
            $message = $this->get($key, $default);
            unset($_SESSION[$key]);
            $this->flash[$key] = $message;
        }

        return $this->flash[$key];
    }
    public function redirect(string $url, $param = null) {
        header('location: '.$url.$param);
        exit;
    }
}