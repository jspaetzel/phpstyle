<?php

namespace PHPStyle;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class Plugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io): void
    {
        $verify_installation = function () {
            $root_path = str_replace('\\', '/', getcwd());

            $phpstyle_config_file_path = $root_path . '/phpstyle.neon';
            if (!file_exists($phpstyle_config_file_path)) {
                $phpstyle_neon = <<< 'PHPSTYLE'
parameters:
    php: 7.1
    risky: false
    paths:
        - src
        - tests
    excludePaths:
        - src/path/you/want/to/skip
        - src/or/a/file-to-skip.php
PHPSTYLE;
                file_put_contents($phpstyle_config_file_path, $phpstyle_neon);
            }

            $php_cs_fixer_dist_file_path = $root_path . '/.php-cs-fixer.dist.php';
            if (!file_exists($php_cs_fixer_dist_file_path)) {
                $php_cs_fixer_file_content = <<< 'PHPCSFIXER'
/**
 * This file was automatically generated by the php.style plugin
 * to change style settings, modify the phpstyle.neon file.
 * https://github.com/jspaetzel/phpstyle
 */
use PHPStyle\PHPStyle;

require_once __DIR__ . '/vendor/autoload.php';

return (new PHPStyle())->getConfig('phpstyle.neon');
PHPCSFIXER;
                file_put_contents($php_cs_fixer_dist_file_path, $php_cs_fixer_file_content);
            }

        };

        $composer->getEventDispatcher()->addListener('post-install-cmd', $verify_installation);
        $composer->getEventDispatcher()->addListener('post-update-cmd', $verify_installation);
    }

    public function deactivate(Composer $composer, IOInterface $io): void
    {
        // At the moment empty; needed for composer 2.x support
    }

    public function uninstall(Composer $composer, IOInterface $io): void
    {
        // At the moment empty; needed for composer 2.x support
    }
}
