<?php

namespace SlamPhpStan\Tests\NotNow\TestAsset\NoDateWithoutSecondArgumentRule;

$a1 = \date('d');
$a2 = date(DATE_RFC2822);

$a3 = \MyNamespace\date('d');
$a4 = MySubNamespace\date(DATE_RFC2822);

$string = 'date';
$a5 = $string(DATE_RFC2822);

$a6 = \date('d', '2020-02-01 10:00:00');
$a7 = date(DATE_RFC2822, '2020-02-01 10:00:00');
