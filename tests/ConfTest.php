<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\DependencyInjection\ContainerFactory;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversNothing]
final class ConfTest extends TestCase
{
    #[DataProvider('confProvider')]
    public function testConfIsValid(string $filename): void
    {
        $containerFactory = new ContainerFactory(__DIR__);
        self::assertNotEmpty($containerFactory->create(__DIR__ . '/TmpAsset', [$filename], []));
    }

    /** @return mixed[] */
    public static function confProvider(): array
    {
        $confFolder = \dirname(__DIR__) . '/conf';
        $confs      = \glob($confFolder . '/*.neon');

        self::assertIsArray($confs);
        self::assertNotEmpty($confs);

        return \array_map(function (string $filename): array {
            return [$filename];
        }, $confs);
    }
}
