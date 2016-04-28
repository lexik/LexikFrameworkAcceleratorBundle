LexikAcceleratorBundle
======================

April fools :smiley_cat: 

In web development everyone has been faced with customers who want faster pages.
As Lexik cares about application performance a lot, our team has invested many years of R&D in order to develop a brand new optimization technique.

Thus we have developed this formidable bundle, the LexikAcceleratorBundle. 
And at Lexik as we are cool we share this bundle. 
This little bundle helps to make pages rendering 3 to 8 times faster.

Before:

![before screen](http://devblog.lexik.fr/wp-content/uploads/2016/03/sf28-before.jpg)

After:

![after screen](http://devblog.lexik.fr/wp-content/uploads/2016/03/sf28-after.jpg)

Our great technique is actually based on the very simple and well known function, namely, the `rand()` function (short for Randolf).
Indeed what better technique than calculation with a random value to optimize pages rendering time.

Read full article [on our blog](http://devblog.lexik.fr/symfony2/lexik-accelerator-bundle-2994).

Installation
------------

Add [`lexik/accelerator-bundle`](https://packagist/packages/lexik/accelerator-bundle) to your `composer.json` file:

    php composer.phar require lexik/accelerator-bundle

Register the bundle in `app/AppKernel.php`:

``` php
public function registerBundles()
{
    return array(
        // ...
        new Lexik\Bundle\AcceleratorBundle\LexikAcceleratorBundle(),
    );
}
```

Configuration
-------------

If you need to add other data collector to not accelerate, just add their tag name to the `lexik_accelerator.ignore_data_collector` parameter:
``` yaml
# ...
lexik_accelerator:
    ignore_data_collector:
        - data_collector.time
        - data_collector.memory
        # ...
```
