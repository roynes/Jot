<?php

namespace App\Console;

use Tymon\JWTAuth\Commands\JWTGenerateCommand;

class JWTGenerateCommandFix extends JWTGenerateCommand
{

    // Todo: This is a temporary fix since PR is not yet merged from the Source Will find another Package later

    public function handle()
    {
        $this->fire();
    }
}