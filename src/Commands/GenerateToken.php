<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;
use Kanekescom\Siasn\Api\Credentials\Sso;
use Kanekescom\Siasn\Api\Credentials\Token;
use Kanekescom\Siasn\Api\Credentials\Ws;

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
    protected $description = 'Generate SSO and WS Token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('fresh')) {
            $ssoToken = Sso::getToken()->object();
            $wsToken = Ws::getToken()->object();
        } else {
            $ssoToken = Token::getSsoToken();
            $wsToken = Token::getWsToken();
        }

        $this->info(json_encode([
            'sso' => $ssoToken,
            'ws' => $wsToken,
        ], JSON_PRETTY_PRINT));
    }
}
