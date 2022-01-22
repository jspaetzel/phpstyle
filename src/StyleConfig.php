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
    private $to_exclude;

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
        if (isset($parameters['excludePaths'])) {
            $this->setExclude($parameters['excludePaths']);
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

    public function getExcluded(): array
    {
        return $this->to_exclude ?? [];
    }

    private function setExclude($exclude_paths): void
    {
        foreach ($exclude_paths as $exclude_path) {
            $this->to_exclude[] = $exclude_path;
        }
    }
}
