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
        '8.2' => '@PHP82Migration',
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

        // This type of information is available to you in your VCS
        // and you should be using a CODEOWNERS file to establish ownership of code
        $useless_annotations = ['author', 'package', 'subpackage', 'version'];

        $phpcsfixer_rules = [
            '@PhpCsFixer' => true,
            '@DoctrineAnnotation' => true,
            'blank_line_before_statement' => ['statements' => ['return']],
            'concat_space' => ['spacing' => 'one'],
            'declare_parentheses' => true,
            'global_namespace_import' => true,
            'general_phpdoc_annotation_remove' => ['annotations' => $useless_annotations],
            'increment_style' => false,
            'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
            'phpdoc_line_span' => ['property' => 'single'],
            'phpdoc_separation' => false,
            'phpdoc_summary' => false,
            'php_unit_internal_class' => false,
            'php_unit_test_class_requires_covers' => false,
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
