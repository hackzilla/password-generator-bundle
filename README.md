Password Generator Bundle
=========================

Bundle for implementing Hackzilla/password-generator in Symfony.

Simple multilingual bundle to add to any project. Available languages (Pull Requests welcome):

* Bulgarian
* English
* French

Requirements
------------

* PHP >= 8.0.2
* [hackzilla/password-generator](https://github.com/hackzilla/password-generator) ^1.3.0
* Symfony ^6.0|^7.0


Version Matrix
--------------

| Password Generator Bundle | Symfony                      | PHP      |
|---------------------------|------------------------------|----------|
| 6.x                       | ^6.0 &#124; ^7.0             | >=8.0.2* |
| 5.x                       | ^4.0 &#124; ^5.0 &#124; ^6.0 | >=7.1*   |
| 4.x                       | ^3.0 &#124; ^4.0 &#124; ^5.0 | >=7.1*   |
| 3.x                       | ^3.0 &#124; ^4.0             | >=7.1    |
| 2.x                       | ^2.7 &#124; ^3.0             | >=5.5    |
| 1.x                       | ^2.3                         | >=5.3    |

* Symfony 5.0 requires PHP v7.2+
* Symfony 6.0 requires PHP v8.0.2+
* Symfony 7.0 requires PHP v8.2+

Installation
------------

Add HackzillaPasswordGeneratorBundle in your composer.json:

```yaml
{
    "require": {
        "hackzilla/password-generator-bundle": "^6.0"
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

Migrating from v5
-----------------

Version 6 release is drops support for Symfony v4 & v5 and requires PHP >=8.0.2

Migrating from v4
-----------------

Version 5 release is just drops support for Symfony v3.

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
