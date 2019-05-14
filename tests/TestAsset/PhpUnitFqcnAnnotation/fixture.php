<?php

namespace SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation;

/**
 */

class PhpUnitFqcnAnnotationPre {}

/**
 * @ExpectedException Value
 *
 * @expectedException
 * @expectedException PhpUnitFqcnAnnotation
 * @expectedException \PhpUnitFqcnAnnotation
 * @expectedException SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation\PhpUnitFqcnAnnotation
 * @expectedException \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation\PhpUnitFqcnAnnotation
 *
 * @expectedExceptionCode 123
 * @expectedExceptionMessage Foo bar
 */

class PhpUnitFqcnAnnotation {}

/**
 * @covers FooBar\PhpUnitFqcnAnnotation::method
 * @covers \FooBar\PhpUnitFqcnAnnotation
 * @covers SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation\PhpUnitFqcnAnnotation::method
 * @covers \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation\PhpUnitFqcnAnnotation
 *
 * @covers ::fooMethod
 */

function foo() {}

/**
 * @coversDefaultClass PhpUnitFqcnAnnotation
 * @coversDefaultClass \PhpUnitFqcnAnnotation::method
 * @coversDefaultClass SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation\PhpUnitFqcnAnnotation
 * @coversDefaultClass \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation\PhpUnitFqcnAnnotation::method
 */

$var = 1;

/**
 * @uses FooBar\PhpUnitFqcnAnnotation
 * @uses \FooBar\PhpUnitFqcnAnnotation
 * @uses SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation\PhpUnitFqcnAnnotation
 * @uses \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation\PhpUnitFqcnAnnotation
 */
