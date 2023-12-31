<?php

namespace Tarek\Fsa;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class FSAServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations/');
        Config::set([
            'auth.guards.admin' => [
                // driver was session
                'driver'    => 'sanctum',
                'provider'  => 'admins'
            ],
            'auth.providers.admins' => [
                'driver'    => 'eloquent',
                'model'     => \App\Models\FsaAdmin::class
            ],
            'auth.passwords.admins' => [
                'provider'  => 'admins',
                'table'     => 'password_reset_tokens',
                'expire'    => 60,
                'throttle'  => 60,
            ]
        ]);
        $this->addPublishGroup('fsa',[
            __DIR__ . '/Http/'          => app_path('/Http/'),
            __DIR__ . '/Models/FsaAdmin.php'        => app_path('/Models/Tarek/Fsa/FsaAdmin.php'),
            __DIR__ . '/Models/FsaProfile.php'      => app_path('/Models/Tarek/Fsa/FsaProfile.php'),
            __DIR__ . '/routes/'                    => base_path('/routes/'),
            __DIR__. '/database/migrations/'        => base_path('/database/migrations/')
        ]);

      /*AboutCommand::add('My Package', fn () => ['Version' => '1.0.0']);*/
    }
}
