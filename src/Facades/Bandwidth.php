<?php 

namespace Bandwidth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string sendRequest($data, $host = false)
 *
 * @see \Bandwidth\Bandwidth
 * @see \Bandwidth\BandwidthCore
 * @see \Bandwidth\Facades\Bandwidth
 */
class Bandwidth extends Facade {

	/**
	 * Get the registered name of the component
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'bandwidth'; }
}