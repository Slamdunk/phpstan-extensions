<?php

namespace SlamPhpStan\Tests\TestAsset;

/**
 */

class PhpUnitFqcnAnnotationPre {}

/**
 * @ExpectedException Value
 *
 * @expectedException
 * @expectedException PhpUnitFqcnAnnotation
 * @expectedException \PhpUnitFqcnAnnotation
 * @expectedException SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 * @expectedException \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 *
 * @expectedExceptionCode 123
 * @expectedExceptionMessage Foo bar
 */

class PhpUnitFqcnAnnotation {}

/**
 * @covers PhpUnitFqcnAnnotation
 * @covers \PhpUnitFqcnAnnotation
 * @covers SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 * @covers \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 *
 * @covers ::fooMethod
 */

function foo() {}

/**
 * @coversDefaultClass PhpUnitFqcnAnnotation
 * @coversDefaultClass \PhpUnitFqcnAnnotation
 * @coversDefaultClass SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 * @coversDefaultClass \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 */

$var = 1;

/**
 * @uses PhpUnitFqcnAnnotation
 * @uses \PhpUnitFqcnAnnotation
 * @uses SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 * @uses \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 */
