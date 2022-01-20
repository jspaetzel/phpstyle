<?php

namespace PHPStyle;

use Nette\Neon\Neon;
use PhpCsFixer\Config;
use PhpCsFixer\ConfigInterface;
use PhpCsFixer\Finder;

class PHPStyle
{
    public function getStyleConfig($path): StyleConfig
    {
        $value = Neon::decodeFile($path);
        return new StyleConfig($value);
    }

    public function getPhpCsFixerConfig(StyleConfig $style): ConfigInterface
    {
        $paths = $style->getPaths();

        $finder = Finder::create()
            ->in($paths);

        $config = new Config();

        $phpcsfixer_rules = [];

        $rules = $style->getRules();
        if (isset($rules['PSR12'])) {
            $phpcsfixer_rules['@PSR12'] = true;
        }
        $phpcsfixer_rules['array_syntax'] = ['syntax' => 'short'];

        return $config->setRules($phpcsfixer_rules)->setFinder($finder);
    }

    public function getConfig(string $path): ConfigInterface
    {
        $style = $this->getStyleConfig($path);
        return $this->getPhpCsFixerConfig($style);
    }
}
