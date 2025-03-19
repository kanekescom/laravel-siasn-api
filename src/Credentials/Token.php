<?php

namespace Kanekes\Siasn\Api\Credentials;

use Kanekes\Siasn\Api\Contracts\TokenManager;
use Kanekes\Siasn\Api\Services\Config;

class Token implements TokenManager
{
    private array $providers;

    public function __construct(private readonly Config $config)
    {
        $this->providers = [
            'apim' => new Apim($config),
            'sso' => new Sso($config),
        ];
    }

    public function getToken(string $provider): object
    {
        $cacheKey = $this->getCacheKey($provider);
        $tokenAge = $this->getTokenAge($provider);

        return cache()->remember($cacheKey, $tokenAge, function () use ($provider) {
            return $this->providers[$provider]->getToken();
        });
    }

    public function getFreshToken(string $provider): object
    {
        $cacheKey = $this->getCacheKey($provider);
        cache()->forget($cacheKey);

        return $this->getToken($provider);
    }

    public function forgetTokens(): void
    {
        foreach (array_keys($this->providers) as $provider) {
            cache()->forget($this->getCacheKey($provider));
        }
    }

    public function getApimToken(): object
    {
        return $this->getToken('apim');
    }

    public function getSsoToken(): object
    {
        return $this->getToken('sso');
    }

    public function getNewApimToken(): object
    {
        return $this->getFreshToken('apim');
    }

    public function getNewSsoToken(): object
    {
        return $this->getFreshToken('sso');
    }

    private function getCacheKey(string $provider): string
    {
        return $provider.'-token';
    }

    private function getTokenAge(string $provider): ?int
    {
        return match ($provider) {
            'apim' => $this->config->getApimTokenAge(),
            'sso' => $this->config->getSsoTokenAge(),
            default => null,
        };
    }
}
