<?php

namespace Kanekes\Siasn\Api\Services;

class Config
{
    public function getMode(): string
    {
        return config('siasn-api.mode');
    }

    public function isProduction(): bool
    {
        return $this->getMode() === 'production';
    }

    public function isTraining(): bool
    {
        return $this->getMode() === 'training';
    }

    public function isDebugMode(): bool
    {
        return config('siasn-api.debug');
    }

    public function isSslVerificationEnabled(): bool
    {
        return config('siasn-api.enable_ssl_verification');
    }

    public function getApimCredential(): object
    {
        return (object) [
            'url' => config('siasn-api.apim.'.$this->getMode().'.url'),
            'grant_type' => config('siasn-api.apim.'.$this->getMode().'.grant_type'),
            'username' => config('siasn-api.apim.'.$this->getMode().'.username'),
            'password' => config('siasn-api.apim.'.$this->getMode().'.password'),
        ];
    }

    public function getSsoCredential(): object
    {
        return (object) [
            'url' => config('siasn-api.sso.'.$this->getMode().'.url'),
            'grant_type' => config('siasn-api.sso.'.$this->getMode().'.grant_type'),
            'client_id' => config('siasn-api.sso.'.$this->getMode().'.client_id'),
            'username' => config('siasn-api.sso.'.$this->getMode().'.username'),
            'generate' => config('siasn-api.sso.'.$this->getMode().'.generate'),
            'password' => config('siasn-api.sso.'.$this->getMode().'.password'),
            'token_type' => config('siasn-api.sso.'.$this->getMode().'.token_type'),
            'access_token' => config('siasn-api.sso.'.$this->getMode().'.access_token'),
        ];
    }

    public function getInstitution(): object
    {
        return (object) [
            'instansi_id' => config('siasn-api.institution.instansi_id'),
            'satuan_kerja_id' => config('siasn-api.institution.satuan_kerja_id'),
        ];
    }

    public function getApimTokenAge(): ?int
    {
        return config('siasn-api.token_age.apim');
    }

    public function getSsoTokenAge(): ?int
    {
        return config('siasn-api.token_age.sso');
    }

    public function getRequestTimeout(): int
    {
        return config('siasn-api.request_timeout');
    }

    public function getMaxRequestAttempts(): int
    {
        return config('siasn-api.max_request_attempts');
    }

    public function getMaxRequestWaitAttempts(): int
    {
        return config('siasn-api.max_request_wait_attempts');
    }
}
