<?php

namespace NotificationChannels\CmComSmsWhatsApp;

use CMText\TextClient;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\CmComSmsWhatsApp\Exceptions\InvalidConfiguration;

class CmComSmsWhatsAppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Bootstrap code here.
        $this->app->when(CmComSmsWhatsAppChannel::class)
            ->needs(TextClient::class)
            ->give(function () {
                if (is_null($productToken = config('services.cmcomsmswhatsapp.product_token'))) {
                    throw InvalidConfiguration::configurationNotSet();
                }
                return new TextClient($productToken);
            });
    }
}
