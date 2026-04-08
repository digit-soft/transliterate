<?php

namespace DigitSoft\Transliterate;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Facade extends BaseFacade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor(): string
    {
        return 'Transliterate';
    }
}
