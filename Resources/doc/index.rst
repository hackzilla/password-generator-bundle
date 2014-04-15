Basic Usage
-----------

``` php
<?php
// src/Acme/DemoBundle/Controller/Default.php

namespace Acme\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Hackzilla\BarcodeBundle\Utility\Barcode;

class Default extends Controller
{
    /**
     * Display code as a png image
     */
    public function barcodeImageAction($code)
    {
        $barcode = new Barcode();
        $barcode->setMode(Barcode::mode_png);

        $headers = array(
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="'.$code.'.png"'
        );

        return new Response($barcode->outputImage($code), 200, $headers);
    }

    /**
     * Display code using html
     */
    public function barcodeHtmlAction($code)
    {
        $barcode = new Barcode($this->container);

        $headers = array(
        );

        return new Response($barcode->outputHtml($code), 200, $headers);
    }

    /**
     * Display code as a textual representation
     */
    public function barcodeTextAction($code)
    {
        $barcode = new Barcode();

        $headers = array(
        );

        return new Response($barcode->outputText($code), 200, $headers);
    }
}
```

