<?php

namespace Kanekescom\Siasn\Api\Commands;

use Exception;
use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Token;

class GenerateTokenCommand extends Command
{
    protected $signature = 'siasn:token
                            {--fresh : Always request a new token}';

    protected $description = 'Generate an APIM and SSO Token';

    public function handle(): int
    {
        try {
            if ($this->option('fresh')) {
                $apimToken = Token::getNewApimToken();
                $ssoToken = Token::getNewSsoToken();
            } else {
                $apimToken = Token::getApimToken();
                $ssoToken = Token::getSsoToken();
            }

            $this->info(json_encode([
                'apim_token' => $apimToken,
                'sso_token' => $ssoToken,
            ], JSON_PRETTY_PRINT));

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
