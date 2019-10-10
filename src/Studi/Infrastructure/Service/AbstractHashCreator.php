<?php

namespace Studi\Infrastructure\Service;

abstract class AbstractHashCreator
{
    const SEPARATOR = "|";


    /** @var string */
    private $appSecret;

    public function __construct(string $appSecret) {
        $this->appSecret = $appSecret;
    }

    protected function getStringToHashWithSecret(string $stringToHash): string {
        return $stringToHash . self::SEPARATOR . $this->appSecret;
    }

    protected function createHash(string $stringToHash): string {
        return hash(
            "sha256",
            $this->getStringToHashWithSecret($stringToHash)
        );
    }

    protected function verifyHash(string $stringToHash, string $hash): bool {
        return $this->createHash($stringToHash) == $hash;
    }

}