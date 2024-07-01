<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Apim;
use Kanekescom\Siasn\Api\Credentials\Sso;
use Kanekescom\Siasn\Api\Credentials\Token;

class GenerateTokenCommand extends Command
{
    protected $signature = 'siasn:token
                            {--fresh : Always request new token}';

    protected $description = 'Generate APIM and SSO Token';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            $apimToken = Apim::getToken()->object();
            $ssoToken = Sso::getToken()->object();
        } else {
            $apimToken = Token::getApimToken();
            $ssoToken = Token::getSsoToken();
        }

        $this->info(json_encode([
            'sso' => $ssoToken,
            'apim' => $apimToken,
        ], JSON_PRETTY_PRINT));

        return self::SUCCESS;
    }
}
