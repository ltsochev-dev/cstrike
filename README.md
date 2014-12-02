CSStats Binary Parser
===========
A simple API for reading CSStats.dat binary data with PHP 5.4+

Installation
------------
This library can be found on [Packagist](https://packagist.org/packages/naminator/lyra).
The recommended way to install this is through [composer](http://getcomposer.org).

Edit your `composer.json` and add:

```json
{
    "require": {
        "naminator/cstrike": "dev-master"
    }
}
```

And install dependencies:

```bash
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

Features
--------
- PSR-4 compliant for easy interoperability
- Various methods to work with the user data
- Everything is packaged in its own object for easy IDE inspection
- phpDocBlock commented code