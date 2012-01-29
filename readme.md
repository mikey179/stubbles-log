Stubbles Log classes

Preconditions for any installation
----------------------------------

Stubbles Log is meant to be used as composer package. If you are not familiar
with Composer, see [Composer - Package Management for PHP](https://github.com/composer/composer#readme).

Stubbles Log requires PHP 5.3.


Usage as library
----------------
1. In your application or dependent library, create a _composer.json_ file.
2. In the _requirements_ section, add the following dependency: `"stubbles/log": "2.0.0-dev"`
3. In the _repositories_ section, add the following repositories:
`
    "stubbles-log": {
            "vcs": {
                "url": "https://github.com/stubbles/stubbles-log"
            }
        }
`
4. Run Composer to get Stubbles Log: `php composer.phar install`
5. Run `php vendor/bin/bootstrap`. This will copy the required _bootstrap.php_ to the project`s root dir.


Installation from source
------------------------
1. Run `git clone https://github.com/stubbles/stubbles-log.git`
2. cd into your checkout
3. Run Composer to get the dependencies: `php composer.phar install`

You should now be able to run the unit tests with `phpunit`.


Build status
------------

[![Build Status](https://secure.travis-ci.org/stubbles/stubbles-log.png)](http://travis-ci.org/stubbles/stubbles-log)