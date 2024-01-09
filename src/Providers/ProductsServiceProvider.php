<?php

namespace IsteSitem\Products\Providers;

use Illuminate\Support\ServiceProvider;
use IsteSitem\Products\Commands;

class ProductsServiceProvider extends ServiceProvider
{
    /**
     * Our root directory for this package to make traversal easier
     */
    const PACKAGE_DIR = __DIR__ . '/../../';

    /**
     * Bootstrap the application services
     *
     * @return void
     */
    public function boot()
    {
        $this->strapRoutes();
        $this->strapPublishers();
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'istesitem-products');
        $this->strapViews();
        $this->strapMigrations();
        $this->strapCommands();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap our Routes
     */
    protected function strapRoutes()
    {
        $this->loadRoutesFrom(self::PACKAGE_DIR . 'routes/web.php');
    }

    /**
     * Bootstrap our Publishers
     */
    protected function strapPublishers()
    {
        $this->publishes([
            self::PACKAGE_DIR . 'resources/lang' => resource_path('lang/vendor/istesitem-products'),
        ], 'translations');
    }

    /**
     * Bootstrap our Views
     */
    protected function strapViews()
    {
        // Load views
        $this->loadViewsFrom(self::PACKAGE_DIR . 'resources/views', 'istesitem-products');
    }

    /**
     * Bootstrap our Migrations
     */
    protected function strapMigrations()
    {
        // Load migrations
        $this->loadMigrationsFrom(self::PACKAGE_DIR . 'database/migrations');

        // Locate our factories for testing if they exist
        $factoryClass = 'Illuminate\Database\Eloquent\Factory';

        if (class_exists($factoryClass)) {
            $this->app->make($factoryClass)->load(
                self::PACKAGE_DIR . 'database/factories'
            );
        }
    }

    /**
     * Bootstrap our Commands/Schedules
     */
    protected function strapCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallCommand::class
            ]);
        }
    }
}
