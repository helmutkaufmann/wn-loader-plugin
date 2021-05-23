<?php namespace Mercator\Loader;

use Backend;
use Crypt;
use System\Classes\PluginBase;

/**
 * Loader Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Mercator Loader',
            'description' => 'File upload and download made easy.',
            'author'      => 'Helmut Kaufmann',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }
    

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
    
        return [
            'Mercator\Loader\Components\Loader' => 'Loader',
        ];
    }
    
    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'mercator.dropload.some_permission' => [
                'tab' => 'Loader',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'dropload' => [
                'label'       => 'Loader',
                'url'         => Backend::url('mercator/loader/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['mercator.dropload.*'],
                'order'       => 500,
            ],
        ];
    }
}
