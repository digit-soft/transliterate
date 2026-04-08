<?php

namespace DigitSoft\Transliterate\Tests;

use DigitSoft\Transliterate\Transformer;
use DigitSoft\Transliterate\Transliterator;

class TransformersTest extends TestCase
{
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        Transformer::override([
            \Closure::fromCallable('trim'),
            \Closure::fromCallable('strtoupper'),
        ]);
    }

    /**
     * @covers \DigitSoft\Transliterate\Transliterator::applyTransformers
     */
    public function testTransformers()
    {
        $initialString = '  Строка с пробелами  ';
        $transliterator = (new Transliterator())->from('ru')->useMap('common');

        $this->assertEquals(
            strtoupper(trim('  Stroka s probelami  ')),
            $transliterator->make($initialString)
        );
    }
}
