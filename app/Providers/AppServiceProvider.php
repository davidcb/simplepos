<?php

namespace App\Providers;

use App\Models;
use App\Observers;
use Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Schema::defaultStringLength(191);
		Models\Order::observe(Observers\OrderObserver::class);
		Models\Product::observe(Observers\ProductObserver::class);
		Models\Sale::observe(Observers\SaleObserver::class);
		Models\User::observe(Observers\UserObserver::class);
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
