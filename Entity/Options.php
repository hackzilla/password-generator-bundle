<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Entity;

class Options
{

    public $length = 8;
    private $options = array();

    public function __get($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    public function __set($name, $value)
    {
        $this->options[$name] = $value;
    }

    public function getOptionValue()
    {
        $value = 0;

        foreach ($options as $option) {
            if ($option) {
                $value += $option;
            }
        }

        return $value;
    }

}
