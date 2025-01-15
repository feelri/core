<?php
namespace Feelri\Core;

use Feelri\Core\Console\Commands\Generate\HttpCommand;
use Feelri\Core\Console\Commands\TestCommand;
use Feelri\Core\Models\Admin\Admin;
use Feelri\Core\Models\User\User;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Register services.
     * @return void
     */
    public function register(): void
    {
		// 合并 auth 配置
		config([
			'auth.guards.admin' => array_merge([
					'driver' => 'sanctum',
					'provider' => 'admin',
				],
				config('auth.guards.admin', [])
			),
			'auth.guards.user' => array_merge([
					'driver' => 'sanctum',
					'provider' => 'user',
				],
				config('auth.guards.admin', [])
			),
			'auth.providers.admin' => array_merge([
					'driver' => 'eloquent',
					'model'  => Admin::class,
				],
				config('auth.providers.admin', [])
			),
			'auth.providers.user' => array_merge([
				'driver' => 'eloquent',
				'model'  => User::class,
			],
				config('auth.providers.user', [])
			),
		]);
		if (! app()->configurationIsCached()) {
			$this->mergeConfigFrom(__DIR__.'/../config/auth.php', 'auth');
		}
    }

    /**
     * Bootstrap services.
     * @return void
     */
    public function boot(): void
    {
		// 配置
		$this->publishes([
			__DIR__.'/../config/cache' => config_path('cache'),
		], 'feelri.core.config');

		// 路由
		$this->loadRoutesFrom(__DIR__.'/../routes/web-end.php');
		$this->publishes([
			__DIR__.'/../routes/admin-api.php' => base_path('routes/admin-api.php'),
			__DIR__.'/../routes/user-api.php' => base_path('routes/user-api.php'),
			__DIR__.'/../routes/api.php' => base_path('routes/api.php'),
		], 'feelri.core.route');

		// 数据库迁移
		$this->publishes([
			__DIR__.'/../database/migrations' => database_path('migrations'),
			__DIR__.'/../database/seeders' => database_path('seeders'),
			__DIR__.'/../database/permission.sql' => database_path('permission.sql'),
			__DIR__.'/../database/district.sql' => database_path('district.sql'),
		], 'feelri.core.database');

		// 入口初始化
		$this->publishes([
			__DIR__.'/../bootstrap' => base_path('bootstrap'),
		]);

		// 命令
		if ($this->app->runningInConsole()) {
			$this->commands([
				TestCommand::class,
				HttpCommand::class
			]);
		}
	}
}
