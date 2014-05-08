<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Entity;

class Options
{

    private $mode;
    private $quantity = 1;
    private $length = 8;
    private $options = array();
    private $actualOptions = array();

    public function __construct($options)
    {
        foreach ($options as $key => $option) {
            $this->actualOptions[$option['key']] = $key;
        }
    }

    public function __get($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : false;
    }

    public function __set($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function getOptionValue()
    {
        $value = 0;

        foreach ($this->options as $option => $checked) {
            if ($checked) {
                $value += $this->actualOptions[$option];
            }
        }

        return $value;
    }

    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function getMode()
    {
        return $this->mode;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return (int) $this->quantity;
    }

    public function setLength($characterCount)
    {
        $this->length = $characterCount;
    }

    public function getLength()
    {
        return (int) $this->length;
    }

}
