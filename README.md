Password Generator Bundle
=========================

For usage and examples see: Resources/doc/index.rst

[![Build Status](https://travis-ci.org/hackzilla/password-generator-bundle.png?branch=master)](https://travis-ci.org/hackzilla/password-generator-bundle)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/466fe3cc-04cc-4d4e-a119-2bd874c2cea4/big.png)](https://insight.sensiolabs.com/projects/466fe3cc-04cc-4d4e-a119-2bd874c2cea4)

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
        new Hackzilla\BarcodeBundle\HackzillaPasswordGeneratorBundle(),
    );
}
```

Example Implementation
----------------------

See [Password generator app](https://github.com/hackzilla/password-generator-app)
