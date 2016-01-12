Password Generator Bundle
=========================

Bundle for implementing Hackzilla/password-generator in Symfony.

Simple multilingual bundle to add to any project. Available languages (Pull Requests welcome):

* English
* French

[![Build Status](https://travis-ci.org/hackzilla/password-generator-bundle.png?branch=master)](https://travis-ci.org/hackzilla/password-generator-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/022d0d22-f291-4923-8c03-14e665d94b9c/mini.png)](https://insight.sensiolabs.com/projects/022d0d22-f291-4923-8c03-14e665d94b9c)

Requirements
------------

* PHP >= 5.3.2
* [hackzilla/password-generator](https://github.com/hackzilla/password-generator) ~1.0
* symfony ~2.3


Version Matrix
--------------

| Password Generator Bundle | Symfony    | PHP   |
| ------------------------- | ---------- | ----- |
| 2.x (master)              | ^2.7\|^3.0 | >=5.5 |
| 1.x                       | ^2.3       | >=5.3 |


Installation
------------

Add HackzillaPasswordGeneratorBundle in your composer.json:

```yaml
{
    "require": {
        "hackzilla/password-generator-bundle": "~1.0"
    }
}
```

Install Composer

```
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

Now tell composer to download the library by running the command:

``` bash
$ composer update hackzilla/password-generator
```

Composer will install the bundle into your project's `vendor/hackzilla` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Hackzilla\Bundle\PasswordGeneratorBundle\HackzillaPasswordGeneratorBundle(),
    );
}
```

### Step 3: Enable Translations

// app/config/config.yml
```yaml
parameters:
    locale: en

framework:
    #esi:             ~
    translator:      { fallbacks: ["%locale%"] }
```


Example Implementation
----------------------

See [Password generator app](https://github.com/hackzilla/password-generator-app)


Pull Requests
-------------

I'm open to pull requests for additional languages, features and/or improvements.
