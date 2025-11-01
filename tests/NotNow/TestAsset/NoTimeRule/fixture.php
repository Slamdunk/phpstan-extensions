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

// Not OK
$a1 = \microtime();
$a2 = microtime();

// OK
$a3 = \MyNamespace\microtime();
$a4 = MySubNamespace\microtime();

$string = 'microtime';
$a5 = $string();
