<?php

namespace SlamPhpStan\Tests\TestAsset\SymfonyProcessRule;

use function passthru as passthru_customname;

class Foo
{
    public function bar()
    {
        \shell_exec('date');
        passthru_customname('date');
        proc_open('date');

        // \shell_exec('date');
        /*
        passthru_customname('date');
        proc_open('date');
         */

        shell_exec();
        self::shell_exec();

        \idontexist();
        $var = 'shell_exec';
        $var();
    }

    public static function shell_exec()
    {
    }
}