<?php

declare(strict_types=1);

namespace PHPStyle;

class StyleConfig
{
    /** @var array */
    private $paths;

    /** @var string */
    private $phpv;

    /** @var bool */
    private $is_risky;
    /**
     * @var array
     */
    private $dirs_to_exclude;
    /**
     * @var array
     */
    private $files_to_exclude;

    public function __construct(array $values)
    {
        $this->paths = [];
        $this->is_risky = false;

        if (!isset($values['parameters'])) {
            throw new InvalidConfigException();
        }
        $parameters = $values['parameters'];

        if (isset($parameters['paths'])) {
            $this->paths = $parameters['paths'];
        }
        if (isset($parameters['exclude'])) {
            $this->setExclude($parameters['exclude']);
        }
        if (isset($parameters['php'])) {
            $this->phpv = $parameters['php'];
        }
        if (isset($parameters['risky'])) {
            $this->is_risky = $parameters['risky'];
        }
    }

    public function getPhpVersion(): ?string
    {
        if ($this->phpv !== null) {
            return (string) $this->phpv;
        }
        return $this->phpv;
    }

    public function getPaths(): array
    {
        return $this->paths;
    }

    public function isRisky(): bool
    {
        return $this->is_risky;
    }

    public function getExcludedFiles(): array
    {
        return $this->files_to_exclude ?? [];
    }

    public function getExcludedDirectories(): array
    {
        return $this->dirs_to_exclude ?? [];
    }

    private function setExclude($paths): void
    {
        foreach ($paths as $path) {
            if (strpos($path, '.php')) {
                $this->files_to_exclude = $path;
            } else {
                $this->dirs_to_exclude = $path;
            }
        }
    }
}
