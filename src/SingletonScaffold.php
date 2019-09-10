<?php

namespace Precious;

use Exception;

trait SingletonScaffold
{
    protected static $instance;

    private function __construct()
    {
        // nothing is good
    }

    final public function __clone()
    {
        throw new Exception('You can not clone a singleton');
    }

    final public function __sleep()
    {
        throw new Exception('You can not serialize a singleton');
    }

    final public function __wakeup()
    {
        throw new Exception('You can not deserialize a singleton');
    }

    /**
     * @returns static
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
