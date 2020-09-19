<?php

namespace SlamPhpStan\Tests\TestAsset\UnusedVariableRule;

function foo($ref)
{
    $var1 = 1;

    // Variables used in arrow functions
    $arrowFunctionVariable = 'foo';
    fn($arrowFunctionVariable) => $arrowFunctionVariable;
}
