<?php

use PHPStyle\PHPStyle;

require_once __DIR__ . '/vendor/autoload.php';

$path = $_ENV['STYLE_NEON'] ?? 'phpstyle.neon';
return (new PHPStyle())->getConfig($path);

