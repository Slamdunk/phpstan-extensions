<?php

declare(strict_types=1);

namespace SlamPhpStan\Tests;

use Nette\Neon\Decoder;
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
        static::assertIsReadable($filename);
        $fileContent = \file_get_contents($filename);
        static::assertNotEmpty($fileContent);

        $decoder = new Decoder();
        static::assertIsArray($decoder->decode($fileContent));
    }

    public function confProvider(): array
    {
        $confFolder = \dirname(__DIR__) . '/conf';

        return \array_map(function (string $filename): array {
            return [$filename];
        }, \glob($confFolder . '/*.neon'));
    }
}
