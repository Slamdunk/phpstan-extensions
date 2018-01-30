<?php

namespace SlamPhpStan\Tests\TestAsset;

function foo($ref)
{
    $var1 = 1;

    // Could have been passed by reference, do not check
    $ref = 1;

    // Only variable assignment is checked
    ++$var2;

    // Only declared and never used variables are checked
    $var3 = 2;
    ++$var3;

    // Only declared and never used variables are checked
    $string = '';
    $var4 = 1;
    $string .= "$var4";

    $function = function($var5) {
        $var5 = 1;

        $var5bis = 1;
    };
    $function($string);

    $var6 = 1;
    ${'var6'};

    ${bar()};

    $var7 = 1;
    $$var7;

    $var8 = 1;
    if (empty($var8)) {
        // Ok
    }

    if (false) {
        $var9 = 1;
        $var9bis = 2;
        new MyClass($var9, [$var9bis]);

        $var10 = 1;
    }

    $var11 = 1;
    isset($var12[$var11]);

    // Resembles a session
    $var13 = new \stdClass();
    $var13->var14 = 1;
}

$outsideFunctionVar = 1;
