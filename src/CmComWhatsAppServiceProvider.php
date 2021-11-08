<?php

namespace NotificationChannels\CmComWhatsApp;

use CMText\TextClient;
use Illuminate\Support\ServiceProvider;
use NotificationChannels\CmComWhatsApp\Exceptions\InvalidConfiguration;

class CmComWhatsAppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // Bootstrap code here.

        $this->app->when(CmComWhatsAppChannel::class)
            ->needs(TextClient::class)
            ->give(function () {
                if (is_null($productToken = config('services.cmcomwhatsapp.product_token'))) {
                    throw InvalidConfiguration::configurationNotSet();
                }
                return new TextClient($productToken);
            });
    }
}
