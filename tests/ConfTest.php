<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use PHPStan\DependencyInjection\ContainerFactory;
use PHPUnit\Framework\TestCase;

/**
 * @coversNothing
 */
final class ConfTest extends TestCase
{
    /**
     * @dataProvider confProvider
     */
    public function testConfIsValid(string $filename)
    {
        $containerFactory = new ContainerFactory(__DIR__);
        static::assertNotEmpty($containerFactory->create(__DIR__ . '/TmpAsset', [$filename], []));
    }

    public function confProvider(): array
    {
        $confFolder = \dirname(__DIR__) . '/conf';
        $confs      = \glob($confFolder . '/*.neon');

        static::assertIsArray($confs);
        static::assertNotEmpty($confs);

        return \array_map(function (string $filename): array {
            return [$filename];
        }, $confs);
    }
}
