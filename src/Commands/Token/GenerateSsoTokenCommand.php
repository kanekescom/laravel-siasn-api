<?php

namespace Kanekes\Siasn\Api\Commands\Token;

use Illuminate\Console\Command;
use Kanekes\Siasn\Api\Contracts\TokenManager;

class GenerateSsoTokenCommand extends Command
{
    protected $signature = 'siasn:sso-token
                            {--fresh : Always request a new token}';

    protected $description = 'Generate SSO Token';

    public function __construct(private readonly TokenManager $tokenManager)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        try {
            $token = $this->option('fresh')
                ? $this->tokenManager->getFreshToken('sso')
                : $this->tokenManager->getToken('sso');

            $this->info(collect($token)->toJson(JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR));

            return self::SUCCESS;
        } catch (\Throwable $e) {
            report($e);
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
