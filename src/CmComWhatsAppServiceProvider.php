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

        /**
         * Here's some example code we use for the pusher package.
         *
         * $this->app->when(HipChatChannel::class)
         * ->needs(HipChat::class)
         * ->give(function () {
         * return new HipChat(
         * new HttpClient,
         * config('services.hipchat.url'),
         * config('services.hipchat.token'),
         * config('services.hipchat.room')
         * );
         * });
         */

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
