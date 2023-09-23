<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Apim;
use Kanekescom\Siasn\Api\Credentials\Sso;
use Kanekescom\Siasn\Api\Credentials\Token;

class GenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siasn:token
                            {--fresh : Always request new token}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Apim and SSO Token';

    /**
     * Execute the console command.
     */
    public function handle()
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
    }
}
