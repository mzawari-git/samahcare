<?php

declare(strict_types=1);

function current_lang(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (isset($_GET['lang'])) {
        $lang = strtolower((string)$_GET['lang']);
        if (in_array($lang, ['ar', 'en'], true)) {
            $_SESSION['lang'] = $lang;
        }
    }

    if (isset($_SESSION['lang']) && in_array((string)$_SESSION['lang'], ['ar', 'en'], true)) {
        return (string)$_SESSION['lang'];
    }

    return defined('DEFAULT_LANG') ? DEFAULT_LANG : 'ar';
}

function is_rtl(): bool
{
    return current_lang() === 'ar';
}

function lang_url(string $lang): string
{
    $lang = strtolower($lang);
    if (!in_array($lang, ['ar', 'en'], true)) {
        $lang = 'ar';
    }

    if (PHP_SAPI === 'cli' || !isset($_SERVER['REQUEST_URI'])) {
        return '?lang=' . rawurlencode($lang);
    }

    $path = (string)(parse_url((string)$_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '');
    if ($path === '') {
        $path = '';
    }

    $params = $_GET;
    $params['lang'] = $lang;
    $query = http_build_query($params);

    return $path . ($query !== '' ? ('?' . $query) : '');
}

function t(string $key): string
{
    static $dict = null;

    $lang = current_lang();

    if (!is_array($dict) || ($dict['_lang'] ?? null) !== $lang) {
        $file = __DIR__ . '/../lang/' . $lang . '.php';
        $dict = is_file($file) ? require $file : [];
        $dict['_lang'] = $lang;
    }

    return (string)($dict[$key] ?? $key);
}

