<?php

namespace SlamPhpStan\Tests\NotNow\TestAsset\NoRelativeDateTimeInterfaceRule;

// Not OK
$a1 = new \DateTime('now');
$a1bis = new \DateTime();
$a1ter = new class('now') extends \DateTimeImmutable
{};
$a2 = new \DateTimeImmutable('noon');
$a2bis = new MyDateTimeImmutable('yesterday');

$myFunc1 = static function (): string {
    return 'now';
};
$a6 = new \DateTimeImmutable($myFunc1());

// OK
$a3 = new \SlamPhpStan\Tests\NotNow\TestAsset\NoRelativeDateTimeInterfaceRule\NonDateTime('now');
$a4 = new NonDateTimeImmutable('noon');

$class = 'DateTime';
$a5 = new $class();

$myFunc2 = static function (): string {
    return '2020-10-14T00:00:00+02:00';
};
$a6 = new \DateTimeImmutable($myFunc2());

$a8 = new \DateTime('2020-10-14T00:00:00+02:00');
$a8ter = new class('2020-10-14T00:00:00+02:00') extends \DateTimeImmutable
{};
$a9 = new \DateTimeImmutable('2020-10-14T00:00:00+02:00 noon');
$a9bis = new MyDateTimeImmutable('2020-10-14T00:00:00+02:00 yesterday');

final class MyDateTimeImmutable extends \DateTimeImmutable
{}

final class NonDateTime
{}

final class NonDateTimeImmutable
{}
