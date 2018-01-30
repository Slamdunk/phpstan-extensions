# Slam PHPStan extensions

[![Build Status](https://travis-ci.org/Slamdunk/phpstan-extensions.svg?branch=master)](https://travis-ci.org/Slamdunk/phpstan-extensions)
[![Code Coverage](https://scrutinizer-ci.com/g/Slamdunk/phpstan-extensions/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Slamdunk/phpstan-extensions/?branch=master)
[![Packagist](https://img.shields.io/packagist/v/slam/phpstan-extensions.svg)](https://packagist.org/packages/slam/phpstan-extensions)

Extensions for [PHPStan](https://github.com/phpstan/phpstan)

## Installation

To use this extension, require it in [Composer](https://getcomposer.org/):

```bash
composer require --dev slam/phpstan-extensions
```

And include slam-rules.neon in your project's PHPStan config:

```yaml
includes:
    - vendor/slam/phpstan-extensions/conf/slam-rules.neon
```

## Rules

1. `SlamPhpStan\UnusedVariableRule`: check for variable inside functions never used after initial assignment
1. `SlamPhpStan\StringToClassRule`: requires strings that refer to classes to be expressed with `::class` notation
1. `SlamPhpStan\GotoRule`: no goto allowed
1. `SlamPhpStan\ClassNotationRule`:
    1. Interfaces must end with "Interface"
    1. Traits must end with "Trait"
    1. Abstract classes must start with "Abstract"
    1. Exceptions must end with "Exception"
1. `SlamPhpStan\PhpUnitFqcnAnnotationRule`: classes found in following PHPUnit annotations must exist:
    1. `@expectedException`
    1. `@covers`
    1. `@coversDefaultClass`
    1. `@uses`
