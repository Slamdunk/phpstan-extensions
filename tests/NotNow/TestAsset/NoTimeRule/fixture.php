<?php

namespace SlamPhpStan\Tests\NotNow\TestAsset\NoTimeRule;

// Not OK
$a1 = \time();
$a2 = time();

// OK
$a3 = \MyNamespace\time();
$a4 = MySubNamespace\time();

$string = 'time';
$a5 = $string();
