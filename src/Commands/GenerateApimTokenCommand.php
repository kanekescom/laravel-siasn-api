<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Apim;
use Kanekescom\Siasn\Api\Credentials\Token;

class GenerateApimTokenCommand extends Command
{
    protected $signature = 'siasn:apim-token
                            {--fresh : Always request new token}';

    protected $description = 'Generate APIM Token';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            $token = Apim::getToken()->object();
        } else {
            $token = Token::getApimToken();
        }

        $this->info(json_encode($token, JSON_PRETTY_PRINT));

        return self::SUCCESS;
    }
}
