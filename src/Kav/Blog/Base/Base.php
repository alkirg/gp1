<?php
namespace Kav\Blog\Base;

class Base
{
    const DATE_FORMAT = 'Y-m-d H:i:s';

    public static function getDateFormat()
    {
        return self::DATE_FORMAT;
    }
}
