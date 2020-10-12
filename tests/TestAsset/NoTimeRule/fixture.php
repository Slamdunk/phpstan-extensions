<?php

namespace SlamPhpStan\Tests\TestAsset\NoTimeRule;

$a1 = \time();
$a2 = time();

$a3 = \MyNamespace\time();
$a4 = MySubNamespace\time();

$string = 'time';
$a5 = $string();
