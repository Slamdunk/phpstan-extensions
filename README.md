# Slam PHPStan extensions

[![Build Status](https://travis-ci.org/Slamdunk/phpstan-extensions.svg?branch=master)](https://travis-ci.org/Slamdunk/phpstan-extensions)
[![Code Coverage](https://scrutinizer-ci.com/g/Slamdunk/phpstan-extensions/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/Slamdunk/phpstan-extensions/?branch=master)
[![Packagist](https://img.shields.io/packagist/v/slam/phpstan-extensions.svg)](https://packagist.org/packages/slam/phpstan-extensions)
[![Total Downloads](https://img.shields.io/packagist/dt/slam/phpstan-extensions.svg)](https://packagist.org/packages/slam/phpstan-extensions)

Extensions for [PHPStan](https://phpstan.org/)

## Installation

To use this extension, require it in [Composer](https://getcomposer.org/):

```bash
composer require --dev slam/phpstan-extensions
```

## Usage

When you are using [`phpstan/extension-installer`](https://github.com/phpstan/extension-installer),
`conf/slam-rules.neon` will be automatically included.

Otherwise you need to include `conf/slam-rules.neon` in your `phpstan.neon`:

```yaml
includes:
    - vendor/slam/phpstan-extensions/conf/slam-rules.neon
```

## Rules

1. `SlamPhpStan\UnusedVariableRule`: check for variable inside functions never used after initial assignment
1. `SlamPhpStan\MissingClosureParameterTypehintRule`: requires parameter typehints for closures; WARNING: no PhpDoc
allowed, see [`phpstan/phpstan-strict-rules#87`](https://github.com/phpstan/phpstan-strict-rules/issues/87)
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
1.  `SlamPhpStan\AccessGlobalVariableWithinContextRule`: inhibit the access to globals within
classes that extend or implement a certain class/interface
1.  `SlamPhpStan\AccessStaticPropertyWithinModelContextRule`: inhibit the access to static attributes of a class within
classes that extend or implement a certain class/interface, useful to prohibit usage of singletons in models

## Symfony-specific config

A `symfony-rules.neon` config is present for Symfony projects:

```yaml
includes:
    - vendor/slam/phpstan-extensions/conf/symfony-rules.neon
```

With the following configurations:

1. `SlamPhpStan\SymfonyFilesystemRule`: forbid calls to raw filesystem functions well wrapped by
[`symfony/filesystem`](https://github.com/symfony/filesystem) component
1. `SlamPhpStan\SymfonyProcessRule`: forbid calls to raw system functions well wrapped by
[`symfony/process`](https://github.com/symfony/process) component

## Yii-specific config

A `yii-rules.neon` config is present for Yii projects:

```yaml
includes:
    - vendor/slam/phpstan-extensions/conf/yii-rules.neon
```

With the following configurations:

1. `SlamPhpStan\AccessGlobalVariableWithinContextRule` to deny the usage of `$_GET`, `$_POST` and other global variables
in models implementing `yii\db\ActiveRecordInterface`: accessing to singletons in models is considered an anti-pattern
1. `SlamPhpStan\AccessStaticPropertyWithinModelContextRule` to deny the usage of `yii\BaseYii` static variables like
`$app` in models implementing `yii\db\ActiveRecordInterface`: accessing to singletons in models is considered an
anti-pattern
