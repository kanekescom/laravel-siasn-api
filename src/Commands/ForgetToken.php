<?php

namespace Kanekescom\Siasn\Api\Commands;

use Illuminate\Console\Command;

class ForgetToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siasn:forget-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete tokens';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        cache()->forget('apim-token');
        cache()->forget('sso-token');

        $this->comment('Tokens has been removed');
    }
}
