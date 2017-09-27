<?php 

namespace Bandwidth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string sendRequest($data, $host = false)
 *
 * @see \Bandwidth\BandwidthE911
 * @see \Bandwidth\BandwidthE911Core
 * @see \Bandwidth\Facades\BandwidthE911
 */
class BandwidthE911 extends Facade {

	/**
	 * Get the registered name of the component
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'bandwidthE911'; }
}