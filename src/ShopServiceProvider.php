<?php

namespace Laralum\Shop;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Laralum\Shop\Models\Category;
use Laralum\Shop\Policies\CategoryPolicy;
use Laralum\Shop\Models\Order;
use Laralum\Shop\Policies\OrderPolicy;

use Laralum\Permissions\PermissionsChecker;

class ShopServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Order::class => OrderPolicy::class,
    ];

    /**
     * The mandatory permissions for the module.
     *
     * @var array
     */
    protected $permissions = [
        [
            'name' => 'Edit Shop Categories',
            'slug' => 'laralum::shop.category.access',
            'desc' => "Grants access to shop categories",
        ],
        [
            'name' => 'Create Shop Categories',
            'slug' => 'laralum::shop.category.create',
            'desc' => "Allows creating shop categories",
        ],
        [
            'name' => 'Edit Shop Categories',
            'slug' => 'laralum::shop.category.update',
            'desc' => "Allows editing shop categories",
        ],
        [
            'name' => 'Delete Shop Categories',
            'slug' => 'laralum::shop.category.delete',
            'desc' => "Allows deleting shop categories",
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->loadTranslationsFrom(__DIR__.'/Translations', 'laralum_shop');

        $this->loadViewsFrom(__DIR__.'/Views', 'laralum_shop');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Make sure the permissions are OK
        PermissionsChecker::check($this->permissions);
    }

    /**
     * I cheated this comes from the AuthServiceProvider extended by the App\Providers\AuthServiceProvider
     *
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
