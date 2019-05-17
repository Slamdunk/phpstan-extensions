<?php

namespace SlamPhpStan\Tests\TestAsset\DateTimeImmutableAlteredAndUnusedRule;

(new \DateTimeImmutable())->add(new \DateInterval('P1D'));

$date1 = new MyDateTimeImmutable();
$date1->sub(new \DateInterval('P1D'));

$date2 = $date1->add(new \DateInterval('P1D'));

foo($date1->add(new \DateInterval('P1D')));
$dates = [$date1->add(new \DateInterval('P1D'))];

$date3 = new MyDateTime();
$date3->add(new \DateInterval('P1D'));
$date3 = $date3->add(new \DateInterval('P1D'));

$date4 = (new \DateTimeImmutable())->add(new \DateInterval('P1D'));

class MyDateTime extends \DateTime {}
class MyDateTimeImmutable extends \DateTimeImmutable {}

function foo(\DateTimeInterface $date) {}
