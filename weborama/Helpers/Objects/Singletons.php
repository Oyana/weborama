<?php

namespace Weborama\Helpers\Objects;

abstract class Singletons
{
    protected static $instances = [];

    protected function __construct()
    {
    }

    final public static function instance()
    {
        $class = get_called_class();
        if (!isset(self::$instances[$class])) {
            self::$instances[$class] = new $class();
        }
        return self::$instances[$class];
    }
}
