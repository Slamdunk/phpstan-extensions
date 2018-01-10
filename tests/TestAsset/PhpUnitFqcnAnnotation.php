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
 * @covers FooBar\PhpUnitFqcnAnnotation::method
 * @covers \FooBar\PhpUnitFqcnAnnotation
 * @covers SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation::method
 * @covers \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 *
 * @covers ::fooMethod
 */

function foo() {}

/**
 * @coversDefaultClass PhpUnitFqcnAnnotation
 * @coversDefaultClass \PhpUnitFqcnAnnotation::method
 * @coversDefaultClass SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 * @coversDefaultClass \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation::method
 */

$var = 1;

/**
 * @uses FooBar\PhpUnitFqcnAnnotation
 * @uses \FooBar\PhpUnitFqcnAnnotation
 * @uses SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 * @uses \SlamPhpStan\Tests\TestAsset\PhpUnitFqcnAnnotation
 */
