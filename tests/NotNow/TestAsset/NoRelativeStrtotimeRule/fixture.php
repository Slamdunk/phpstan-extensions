<?php

namespace SlamPhpStan\Tests\NotNow\TestAsset\NoRelativeStrtotimeRule;

// Not OK
$a1 = \strtotime('now');
$a2 = strtotime('noon');

$myFunc1 = static function (): string {
    return 'now';
};
$a8 = \strtotime($myFunc1());

// OK
$a1 = \strtotime('2020-10-14T00:00:00+02:00');
$a2 = strtotime('2020-10-14T00:00:00+02:00');

$a3 = \MyNamespace\strtotime('now');
$a4 = MySubNamespace\strtotime('noon');

$string = 'strtotime';
$a5 = $string();

$a6 = \strtotime('now', 1500000000);
$a7 = strtotime('noon', 1500000000);

$myFunc2 = static function (): string {
    return '2020-10-14T00:00:00+02:00';
};
$a8 = \strtotime($myFunc2());
