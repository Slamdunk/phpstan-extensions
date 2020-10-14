<?php

namespace SlamPhpStan\Tests\NotNow\TestAsset\NoRelativeStrtotimeRule;

// Not OK
$a1 = \strtotime('now');
$a2 = strtotime('noon');

// OK
$a1 = \strtotime('2020-10-14T00:00:00+02:00');
$a2 = strtotime('2020-10-14T00:00:00+02:00');

$a3 = \MyNamespace\strtotime('now');
$a4 = MySubNamespace\strtotime('noon');

$string = 'strtotime';
$a5 = $string();

$a6 = \strtotime('now', 1500000000);
$a7 = strtotime('noon', 1500000000);
