<?php

declare(strict_types=1);

namespace Infinite;

use Slim\Csrf\Guard;
use Aura\Session\Session;

/**
 * CSRF protection middleware.
 */
class ExtendedGuard extends Guard
{
    private $lazySession;

    /**
     * @return array
     *
     * @throws Exception
     */
    public function generateToken(): array
    {
        if ($this->lazySession) {
            $this->lazySession->regenerateId();
            return [];
        }

        // Generate new CSRF token if persistentTokenMode is false, or if a valid keyPair has not yet been stored
        if (!$this->persistentTokenMode || !$this->loadLastKeyPair()) {
        // Generate new CSRF token
            $name = \uniqid($this->prefix);
            $value = $this->createToken();
            $this->saveTokenToStorage($name, $value);

            $this->keyPair = [
            $this->getTokenNameKey() => $name,
            $this->getTokenValueKey() => $this->maskToken($value)
            ];
            $this->enforceStorageLimit();
        } elseif ($this->persistentTokenMode) {
            $pair = $this->loadLastKeyPair() ? $this->keyPair : $this->generateToken();
        }
        return $this->keyPair;
    }

    /**
     * @return string|null
     */
    public function getTokenValue(): ?string
    {
        if ($this->lazySession) {
            return $this->lazySession->getCsrfToken()->getValue($this->getTokenNameKey());
        }

        return parent::getTokenValue();
    }

    /**
     * Validate CSRF token from current request against token value
     * stored in $_SESSION or user provided storage
     *
     * @param  string $name  CSRF name
     * @param  string $value CSRF token value
     *
     * @return bool
     */
    public function validateToken(string $name, string $value): bool
    {
        if ($this->lazySession) {
            return $this->lazySession->getCsrfToken()->isValid($value, $this->getTokenNameKey());
        }

        return parent::validateToken($name, $value);
    }

    /**
     * @param  array|ArrayAccess|null $storage
     *
     * @return self
     *
     * @throws RuntimeException
     */
    public function setStorage(&$storage = null): self
    {
        if ($storage instanceof Session) {
            $this->lazySession = $storage;

            return $this;
        }

        parent::setStorage($storage);

        return $this;
    }
    /**
     *
     * @param mixed $lazySession
     * @return $this
     */
    public function setLazySession($lazySession)
    {
        $this->lazySession = $lazySession;

        return $this;
    }

    /**
     * Mask token using random key and doing a XOR between this key and provided token. It will prevent BREACH attack.
     *
     * @param string $token Token to mask
     *
     * @return string Masked token, base64 encoded
     *
     * @throws Exception
     */
    private function maskToken(string $token): string
    {
        // Key length need to be the same as the length of the token
        $key = \random_bytes(\strlen($token));
        return \base64_encode($key . ($key ^ $token));
    }
}
