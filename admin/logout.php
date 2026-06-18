<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/helpers.php';

unset($_SESSION['admin_user']);
header('Location: login.php');
exit;

