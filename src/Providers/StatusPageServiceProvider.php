<?php

namespace Azuriom\Plugin\StatusPage\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Plugin\StatusPage\Commands\CheckServers;
use Illuminate\Console\Scheduling\Schedule;

class StatusPageServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [
        // \Azuriom\Plugin\StatusPage\Middleware\ExampleMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\StatusPage\Middleware\ExampleRouteMiddleware::class,
    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [
        // User::class => UserPolicy::class,
    ];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        // $this->registerMiddleware();

        //
//        require_once __DIR__.'/../../vendor/autoload.php';
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
         $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        $this->commands(CheckServers::class);

        Permission::registerPermissions([
            'statuspage.admin' => 'statuspage::admin.permissions.admin',
        ]);
        if (method_exists($this, 'registerSchedule')) {
            $this->registerSchedule();
        }
    }
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('statuspage:check-servers')
            ->everyMinute()
            ->onFailure(function () {
                $this->app['log']->error('Failed to check servers');
            });
    }
    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            //
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, string>>
     */
    protected function adminNavigation(): array
    {
        return [
            'statuspage' => [
                'name' => 'Status Page',
                'icon' => 'bi bi-server',
                'route' => 'statuspage.admin.index',
                'permission' => 'statuspage.admin',
            ],
        ];
    }

    /**
     * Return the user navigations routes to register in the user menu.
     *
     * @return array<string, array<string, string>>
     */
    protected function userNavigation(): array
    {
        return [
//            'statuspage' => [
//                'name' => 'Status Page',
//                'icon' => 'bi bi-server',
//                'route' => 'statuspage.index',
//            ],
        ];
    }

    protected function registerPermissions(): array
    {
        return [
            'statuspage.admin' => 'statuspage::admin.permissions.admin',
        ];
    }
}
