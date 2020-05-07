<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\ResponseFactory;
use Config;
class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(ResponseFactory $factory)
    {
        $factory->macro('api', function ($data, $errorCode = null) use ($factory) {

            $customFormat = [
                'code' => isset($errorCode) ? $errorCode : "OK",
                'message' => isset($errorCode) ?  Config::get('enums.Errors_En.'.$errorCode) :  "Operation completed successfully",
                'isSuccessful' => !isset($errorCode),
                'hasContent' => $data != null,
                'data' => $data
            ];
            return $factory->make($customFormat);
        });
    }
}
