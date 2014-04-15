<?php

namespace Hackzilla\Bundle\PasswordGeneratorBundle\Entity;

class Options
{

    public $length = 8;
    public $includeUpperCase = 1;
    public $includeLowerCase = 1;
    public $includeNumbers = 1;
    public $includeSymbols = 0;
    public $avoidSimilar = 0;

}
