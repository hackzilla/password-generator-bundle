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

    public function getUppercase(): bool
    {
        return (bool) $this->__get('uppercase');
    }

    public function setUppercase(bool $uppercase): void
    {
        $this->__set('uppercase', $uppercase);
    }

    public function getLowercase(): bool
    {
        return (bool) $this->__get('lowercase');
    }

    public function setLowercase(bool $lowercase): void
    {
        $this->__set('lowercase', $lowercase);
    }

    public function getNumbers(): bool
    {
        return (bool) $this->__get('numbers');
    }

    public function setNumbers(bool $numbers): void
    {
        $this->__set('numbers', $numbers);
    }

    public function getSymbols(): bool
    {
        return (bool) $this->__get('symbols');
    }

    public function setSymbols(bool $symbols): void
    {
        $this->__set('symbols', $symbols);
    }

    public function getAvoidSimilar(): bool
    {
        return (bool) $this->__get('avoid_similar');
    }

    public function setAvoidSimilar(bool $symbols): void
    {
        $this->__set('avoid_similar', $symbols);
    }

    public function getLength(): ?int
    {
        return $this->__get('length');
    }

    public function setLength(?int $symbols): void
    {
        $this->__set('length', $symbols);
    }

    public function getWords(): int
    {
        return (int) $this->__get('words');
    }

    public function setWords(int $symbols): void
    {
        $this->__set('words', $symbols);
    }

    public function getMin(): int
    {
        return (int) $this->__get('min');
    }

    public function setMin(int $symbols): void
    {
        $this->__set('min', $symbols);
    }

    public function getMax(): int
    {
        return (int) $this->__get('max');
    }

    public function setMax(int $symbols): void
    {
        $this->__set('max', $symbols);
    }

    public function getSegmentCount(): int
    {
        return (int) $this->__get('segment_count');
    }

    public function setSegmentCount(int $segmentCount): void
    {
        $this->__set('segment_count', $segmentCount);
    }

    public function getSegmentLength(): int
    {
        return (int) $this->__get('segment_length');
    }

    public function setSegmentLength(int $segmentCount): void
    {
        $this->__set('segment_length', $segmentCount);
    }
}
