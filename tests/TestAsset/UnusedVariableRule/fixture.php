<?php

namespace SlamPhpStan\Tests\TestAsset\UnusedVariableRule;

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

    $function1 = function($var5) {
        $var5 = 1;

        $var5bis = 1;
    };
    $function1($string);

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

    // Resembles an object retrieved by ref
    $var13 = new \stdClass();
    $var13->foo = 1;

    // Resembles an ArrayAccess object retrieved by ref
    $var14 = [];
    $var14[] = 1;

    $var15 = 1;
    $var16[$var15] = 2;

    $var17 = 1;
    $function2 = function() use ($var17) {};
    $function2();

    $var18 = 1;
    $function2 = static function() use (& $var18) {
        $var18 = 2;
    };
    $function2();

    $_SESSION = ['var19' => 1];
    $GLOBALS['foo'] = 'bar';
}

class Test
{
    function foo(array $numVals)
    {
        $arr = [
            "1" => "propOne",
            "2" => "propTwo",
        ];

        foreach ($numVals as $num => $v) {
            $key = $arr[$num];
            $this->{$key} = $v;

            $key2 = $arr[$num];
            $this->{$key2}();

            $this->key = 1;
            $this->key2();
        }
    }
}

$outsideFunctionVar = 1;
