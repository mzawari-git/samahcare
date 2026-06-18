<?php

declare(strict_types=1);

require_once __DIR__ . '/../../includes/helpers.php';

function admin_user(): ?array
{
    if (!isset($_SESSION['admin_user'])) {
        return null;
    }
    return is_array($_SESSION['admin_user']) ? $_SESSION['admin_user'] : null;
}

function admin_role(): string
{
    $u = admin_user();
    if (!$u) {
        return '';
    }
    return (string)($u['role'] ?? '');
}

function require_admin(): void
{
    if (!admin_user()) {
        header('Location: login.php');
        exit;
    }
}

function require_roles(array $roles): void
{
    require_admin();
    $role = admin_role();
    if ($role === '' || !in_array($role, $roles, true)) {
        http_response_code(403);
        echo 'Forbidden';
        exit;
    }
}

