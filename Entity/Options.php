<?php

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

    public function __get($name)
    {
        return $this->passwordGenerator->getOptionValue(strtoupper($name));
    }

    public function __set($name, $value)
    {
        $this->passwordGenerator->setOptionValue(strtoupper($name), $value);
    }

    public function getQuantity()
    {
        return (int) $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
}
