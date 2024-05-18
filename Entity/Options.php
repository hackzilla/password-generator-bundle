<?php

declare(strict_types=1);

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Entity;

use Hackzilla\PasswordGenerator\Generator\PasswordGeneratorInterface;

class Options
{
    private $quantity = 5;
    private $passwordGenerator;

    public function __construct(PasswordGeneratorInterface &$passwordGenerator)
    {
        $this->passwordGenerator = $passwordGenerator;
    }

    public function __get($name): mixed
    {
        return $this->passwordGenerator->getOptionValue(strtoupper($name));
    }

    public function __set($name, $value): void
    {
        $this->passwordGenerator->setOptionValue(strtoupper($name), $value);
    }

    public function getQuantity(): int
    {
        return (int) $this->quantity;
    }

    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }
}
