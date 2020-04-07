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

* PHP >= 5.5
* [hackzilla/password-generator](https://github.com/hackzilla/password-generator) ~1.0
* Symfony ~2.7|~3.0|^4.0


Version Matrix
--------------

| Password Generator Bundle | Symfony         | PHP   |
| ------------------------- | --------------- | ----- |
| 4.x                       | ^3.0\|^4.0|^5.0 | >=7.1 |
| 3.x                       | ^3.0\|^4.0      | >=7.1 |
| 2.x                       | ^2.7\|^3.0      | >=5.5 |
| 1.x                       | ^2.3            | >=5.3 |


Installation
------------

Add HackzillaPasswordGeneratorBundle in your composer.json:

```yaml
{
    "require": {
        "hackzilla/password-generator-bundle": "^4.0"
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
$ composer require hackzilla/password-generator-bundle
```

Composer will install the bundle into your project's `vendor/hackzilla` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php or config/bundles.php

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

Migrating from v3
-----------------

Version 4 release is just a version bump.


Migrating from v2
-----------------

Version 3 release is just a version bump.


Migrating from v1
-----------------

Migration should be straight forward, as much of the changes are related to Symfony v3

* Upgrade to at least PHP 5.5
* Reference Types by Fully Qualified Class Name (FQCN) (>= Symfony 2.8)
* FormTypes use getBlockPrefix, rather than getName
* OptionType is now a service
* CamelCased services are now lowercase with separator (e.g. hackzilla.password_generator.human.maxWordLength changed to hackzilla.password_generator.human.max_word_length)
* Removed previously deprecated service (hackzilla.password_generator).

Example Implementation
----------------------

See [Password generator app](https://github.com/hackzilla/password-generator-app)


Pull Requests
-------------

I'm open to pull requests for additional languages, features and/or improvements.
