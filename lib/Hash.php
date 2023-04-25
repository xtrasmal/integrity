<?php

namespace App;

final class Hash
{
    public const HASH_FILENAME = 'checksum';

    public static function getChecksum(): string
    {
        return file_get_contents(self::HASH_FILENAME);
    }

    public static function forFile($filename): string
    {
        return sha1_file($filename, false);
    }

    public static function check(string $filename): bool
    {
        $current = self::getChecksum();
        $known = self::forFile($filename);

        if ($current === $known) {
            return true;
        }

        return false;
    }

    public static function storeFor(string $filename): void
    {
        file_put_contents(self::HASH_FILENAME, self::forFile($filename));
    }
}
