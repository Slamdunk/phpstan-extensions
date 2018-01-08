<?php

namespace SlamPhpStan\Tests\TestAsset;

interface A {}
interface AInterface {}
interface SubAInterface extends A {}

abstract class B {}
abstract class AbstractB {}
abstract class AbstractSubB extends B {}

abstract class Abstract_B {}
abstract class Abstract_AbstractB {}
abstract class Abstract_AbstractSubB extends Abstract_B {}

trait C {}
trait CTrait {}

class E extends \Exception {}
class EException extends \Exception {}
class SubEException extends E {}

class F {}
class G extends \ArrayObject {}

A::class;
B::class;
C::class;
E::class;
F::class;
G::class;

$var = new class {};
