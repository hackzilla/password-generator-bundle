Password Generator Bundle
=========================


[![Build Status](https://travis-ci.org/hackzilla/password-generator-bundle.png?branch=master)](https://travis-ci.org/hackzilla/password-generator-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/022d0d22-f291-4923-8c03-14e665d94b9c/mini.png)](https://insight.sensiolabs.com/projects/022d0d22-f291-4923-8c03-14e665d94b9c)

Requirements
------------

PHP 5.3.2


Installation
------------

Add HackzillaPasswordGeneratorBundle in your composer.json:

```js
{
    "require": {
        "hackzilla/password-generator-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update hackzilla/password-generator-bundle
```

Composer will install the bundle to your project's `vendor/hackzilla` directory.

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

Example Implementation
----------------------

See [Password generator app](https://github.com/hackzilla/password-generator-app)
