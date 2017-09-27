<?php

namespace Bandwidth\Providers;

use Illuminate\Support\ServiceProvider;

class BandwidthE911ServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
        //
    }

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('bandwidthE911', function($app) {
		    return new \Bandwidth\BandwidthE911;
		});

		$this->app->booting(function() {
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('BandwidthE911', 'Bandwidth\Facades\BandwidthE911');
		});

        $configPath = config_path('bandwidth.php');
        if (!\Illuminate\Support\Facades\File::exists($configPath)) {
            $this->publishes([
                __DIR__ . '/../config/bandwidth.php' => $configPath
            ]);
        }
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('bandwidthE911');
	}

}
