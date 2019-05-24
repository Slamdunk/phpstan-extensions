<?php

namespace SlamPhpStan\Tests\TestAsset\SymfonyFilesystemRule;

use function readlink as readlink_customname;

class Foo
{
    public function bar()
    {
        \mkdir('foo');
        readlink_customname('bar');
        touch('zzz');

        // \mkdir('foo');
        /*
        readlink_customname('bar');
        touch('zzz');
         */

        mkdir();
        self::tempnam('c', 'd');
    }

    public static function tempnam($dir, $prefix)
    {
    }
}