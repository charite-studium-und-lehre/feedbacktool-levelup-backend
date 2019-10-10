<?php

namespace Studi\Infrastructure\Service;

abstract class AbstractHashCreator
{
    const SEPARATOR = "|";
    const OPTIONS = [
        'memory_cost' => 1 << 12, // 4 KB
        'time_cost'   => 10,
        'threads'     => 2,
    ];

    /** @var string */
    private $appSecret;

    public function __construct(string $appSecret) {
        $this->appSecret = $appSecret;
    }

    protected function createHash(string $stringToHash): string {
        return password_hash(
            $this->getStringToHashWithSecret($stringToHash),
            PASSWORD_ARGON2I,
            self::OPTIONS
        );
    }

    protected function verifyHash(string $stringToHash, string $hash): bool {
        return password_verify(
            $this->getStringToHashWithSecret($stringToHash),
            $hash
        );
    }

    private function getStringToHashWithSecret(string $stringToHash): string {
        return $stringToHash . "-" . $this->appSecret;
    }

}