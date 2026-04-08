<?php

namespace DigitSoft\Transliterate\Tests;

use DigitSoft\Transliterate\Transformer;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        $config = require dirname(__DIR__).'/src/config/transliterate.php';
        $app['config']->set('transliterate', $config);

        Transformer::override([
            \Closure::fromCallable('trim'),
        ]);
    }
}
