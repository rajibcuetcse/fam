<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\Router;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
Router::defaultRouteClass('DashedRoute');

Router::scope('/', function ($routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/admin', ['controller' => 'Cmsusers', 'action' => 'login']);

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/users/logout/', ['controller' => 'Cmsusers', 'action' => 'logout']);
    $routes->connect('/users/edit-profile/', ['controller' => 'Cmsusers', 'action' => 'editProfile']);
    $routes->connect('/users/add/', ['controller' => 'Cmsusers', 'action' => 'add']);
    $routes->connect('/users/forgot_password', ['controller' => 'Cmsusers', 'action' => 'forgotPassword']);
    $routes->connect('/users/bulk-action', ['controller' => 'Cmsusers', 'action' => 'bulkAction']);
    $routes->connect('/users/edit/*', ['controller' => 'Cmsusers', 'action' => 'edit']);
    $routes->connect('/users/view/*', ['controller' => 'Cmsusers', 'action' => 'view']);
    $routes->connect('/users/*', ['controller' => 'Cmsusers']);

    $routes->connect('/pages/*', ['controller' => 'Pages']);
    $routes->connect('/pages/edit/*', ['controller' => 'Pages', 'action' => 'edit']);
    $routes->connect('/pages/add', ['controller' => 'Pages', 'action' => 'add']);
    $routes->connect('/pages/delete/*', ['controller' => 'Pages', 'action' => 'delete']);
    $routes->connect('/pages/bulk-action', ['controller' => 'Pages', 'action' => 'bulkAction']);

    $routes->connect('/submodules/*', ['controller' => 'SubModules']);
    $routes->connect('/submodules/add', ['controller' => 'SubModules', 'action' => 'add']);
    $routes->connect('/submodules/edit/*', ['controller' => 'SubModules', 'action' => 'edit']);
    $routes->connect('/submodules/delete/*', ['controller' => 'SubModules', 'action' => 'delete']);
    $routes->connect('/submodules/bulk-action', ['controller' => 'SubModules', 'action' => 'bulkAction']);


    $routes->connect('/companies/*', ['controller' => 'Companies']);
    $routes->connect('/companies/add', ['controller' => 'Companies', 'action' => 'add']);
    $routes->connect('/companies/edit/*', ['controller' => 'Companies', 'action' => 'edit']);
    $routes->connect('/companies/delete/*', ['controller' => 'Companies', 'action' => 'delete']);
    $routes->connect('/companies/view/*', ['controller' => 'Companies', 'action' => 'view']);
    $routes->connect('/companies/bulk-action', ['controller' => 'Companies', 'action' => 'bulkAction']);
    $routes->connect('/companies/uploadPicture', ['controller' => 'Companies', 'action' => 'uploadPicture']);
    $routes->connect('/companies/companyActive', ['controller' => 'Companies', 'action' => 'companyActive']);
    $routes->connect('/companies/trnsToaws/*', ['controller' => 'Companies', 'action' => 'trnsToaws']);
    
    $routes->connect('/settings/edit/*', ['controller' => 'Settings', 'action' => 'edit']);


    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('DashedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
