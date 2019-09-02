<?php

namespace SlamPhpStan\Tests\TestAsset\MissingClosureParameterTypehintRule;

function foo($ref) {}

$foo1 = function ($class) {};
$foo2 = function (array $array, $int = null) {};
$foo3 = function (\stdClass $class) {};
$foo4 = function (?int $int) {};
