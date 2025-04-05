<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.9-dev
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

return array(
	/**
	 * -------------------------------------------------------------------------
	 *  Default route
	 * -------------------------------------------------------------------------
	 *
	 */

	'_root_' => 'beer/index',

	/**
	 * -------------------------------------------------------------------------
	 *  Page not found
	 * -------------------------------------------------------------------------
	 *
	 */

	//'_404_' => 'welcome/404',

	/**
	 * -------------------------------------------------------------------------
	 *  Example for Presenter
	 * -------------------------------------------------------------------------
	 *
	 *  A route for showing page using Presenter
	 *
	 */

	//'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),


		// UIページ（HTML）
	'login' => 'userPage/login',
	'register' => 'userPage/register',
	'logout' => 'userPage/logout',

	// APIエンドポイント
	'api/user/login'    => 'api/user/login',
	'api/user/register' => 'api/user/register',

	'api/beer'        => 'api/beerController',
	'api/beer/:id' => 'api/beerController/index/$1',




);
