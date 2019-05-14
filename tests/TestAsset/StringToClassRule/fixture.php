<?php

namespace SlamPhpStan\Tests\TestAsset\StringToClassRule;

class FooStringToClass {}

$var = 'SlamPhpStan\Tests\TestAsset\Bar';
$var = 'SlamPhpStan\\Tests\\TestAsset\\Bar';
$var = 'datetime';
$var = 'stdclass';

$var = 'SlamPhpStan\Tests\TestAsset\StringToClassRule\FooStringToClass';
$var = 'SlamPhpStan\\Tests\\TestAsset\\StringToClassRule\\FooStringToClass';
$var = 'DateTimeImmutable';
$var = 'stdClass';

$var = '\SlamPhpStan\Tests\TestAsset\StringToClassRule\FooStringToClass';
$var = '\\SlamPhpStan\\Tests\\TestAsset\\StringToClassRule\\FooStringToClass';
$var = '\DateTimeImmutable';
$var = '\\stdClass';

$var = '\\\\SlamPhpStan\Tests\TestAsset\StringToClassRule\FooStringToClass';
$var = '\\\\DateTimeImmutable';

$var = '';
$var = '\\';
$var = '_';
