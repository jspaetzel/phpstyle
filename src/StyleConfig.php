<?php

namespace PHPStyle;

class StyleConfig
{
    private array $paths;

    private array $rules;

    public function __construct(array $values)
    {
        $this->paths = [];
        $this->rules = [];

        if (!isset($values['parameters'])) {
            throw new InvalidConfigException();
        }
        $parameters = $values['parameters'];

        if (isset($parameters['paths'])) {
            $this->paths = $parameters['paths'];
        }

        if (isset($parameters['rules'])) {
            $this->rules = $parameters['rules'];
        }
    }

    public function getPaths(): array
    {
        return $this->paths;
    }

    public function getRules(): array
    {
        return $this->rules;
    }
}
