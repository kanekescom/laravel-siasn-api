<?php

namespace Kanekes\Siasn\Api\Commands\Token;

use Illuminate\Console\Command;
use Kanekes\Siasn\Api\Contracts\TokenManager;

class GenerateTokenCommand extends Command
{
    protected $signature = 'siasn:token
                            {--fresh : Always request a new token}';

    protected $description = 'Generate APIM and SSO Token';

    public function __construct(private readonly TokenManager $tokenManager)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $tokens = $this->retrieveTokens($this->option('fresh'));

            $this->info(collect($tokens)->toJson(JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));

            return self::SUCCESS;
        } catch (\Throwable $e) {
            report($e);
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    private function retrieveTokens(bool $fresh): array
    {
        return [
            'apim_token' => $fresh
                ? $this->tokenManager->getFreshToken('apim')
                : $this->tokenManager->getToken('apim'),

            'sso_token' => $fresh
                ? $this->tokenManager->getFreshToken('sso')
                : $this->tokenManager->getToken('sso'),
        ];
    }
}
