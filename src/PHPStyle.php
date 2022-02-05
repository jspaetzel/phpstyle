<?php

declare(strict_types=1);

namespace PHPStyle;

use Nette\Neon\Exception;
use Nette\Neon\Neon;
use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;

class PHPStyle
{
    private const PHPVERSION_RULE_MAP = [
        '7.0' => '@PHP70Migration',
        '7.1' => '@PHP71Migration',
        '7.2' => '@PHP72Migration',
        '7.3' => '@PHP73Migration',
        '7.4' => '@PHP74Migration',
        '8.0' => '@PHP80Migration',
        '8.1' => '@PHP81Migration',
    ];

    public function getStyleConfig($path): StyleConfig
    {
        try {
            $value = Neon::decodeFile($path);
        } catch (Exception $tr) {
            throw new InvalidConfigException($tr->getMessage());
        }

        return new StyleConfig($value);
    }

    public function getPhpCsFixerConfig(StyleConfig $style): ConfigInterface
    {
        $finder = Finder::create();

        // use cwd since this should be run from root of project
        $in_dir = getcwd();
        $finder = $finder->in($in_dir);

        $paths = $style->getPaths();
        if ($paths) {
            $finder->path($paths);
        }

        $excluded_files = $style->getExcluded();
        if ($excluded_files) {
            $finder->notPath($excluded_files);
        }

        $config = new Config();

        if ($style->isRisky()) {
            $config->setRiskyAllowed(true);
        }

        $phpcsfixer_rules = [
            '@PSR12' => true,
            '@Symfony' => true,
            'array_syntax' => ['syntax' => 'short'],
            'backtick_to_shell_exec' => true,
            'no_mixed_echo_print' => true,
            'concat_space' => ['spacing' => 'one'],
            'global_namespace_import' => true,
            'fully_qualified_strict_types' => true,
            'increment_style' => false,
            'phpdoc_align' => ['align' => 'left'],
            'phpdoc_separation' => false,
            'phpdoc_summary' => false,
            'single_line_throw' => false,
            'yoda_style' => false,
        ];

        $version = $style->getPhpVersion();
        if ($version) {
            $phpcsfixer_rules[self::PHPVERSION_RULE_MAP[$version]] = true;
            if ($style->isRisky()) {
                $phpcsfixer_rules[self::PHPVERSION_RULE_MAP[$version] . ':risky'] = true;
            }
        }

        return $config->setRules($phpcsfixer_rules)->setFinder($finder);
    }

    public function getConfig(string $path): ConfigInterface
    {
        $style = $this->getStyleConfig($path);

        return $this->getPhpCsFixerConfig($style);
    }
}
