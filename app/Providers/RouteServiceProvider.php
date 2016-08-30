<?php

namespace App\Providers;

use Route;
use Illuminate\Routing\Router;
use App\Contracts\Model\ListableInterface;
use App\Contracts\Model\ShowableInterface;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        Route::model('reward-type', 'App\RewardType');

        $this->bindResourceModels($router);

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }

    /**
     * Bind all applicable resources to the router by converting the
     * resource string into a valid model.
     *
     * Aborts with a 404 if the model isn't found in the container, or if
     * the model doesn't implement both ListableInterface and ShowableInterface.
     *
     * Example bindings:
     * -----------------
     * hero -> App\Hero
     * reward-type -> App\RewardType
     *
     * @todo Both ListableInterface and ShowableInterface are required at the moment
     * as there are no checks here to determine whether the request is for a 'list'
     * or a 'show' route. This is needed to prevent a 500 error when the ResourceController
     * action type hints fail if we pass it an incorrect instance.
     * It would be ideal if this was not the case.
     *
     * @param  Router $router
     * @return void
     */
    protected function bindResourceModels(Router $router)
    {
        $router->bind('resource', function ($resource) {
            $parts = explode('-', $resource);

            array_walk($parts, function (&$item) {
                $item = ucwords($item);
            });

            try {
                $model = $this->app->make('App\\'.implode($parts));

                if (! $model instanceof ListableInterface || ! $model instanceof ShowableInterface) {
                    abort(404);
                }

                return $model;
            } catch (\ReflectionException $e) {
                abort(404);
            }
        });
    }
}
