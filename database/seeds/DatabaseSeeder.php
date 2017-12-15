<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Provider;


class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(UsersTableSeeder::class);
		$this->call(ProvidersTableSeeder::class);
		$this->call(ProductsTableSeeder::class);
	}
}

class UsersTableSeeder extends Seeder {
	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		DB::table('users')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');

		User::create(['email' => 'davidcouto@gmail.com', 'password' => bcrypt('prueba'), 'name' => 'David Couto', 'role' => 2]);
	}
}

class ProvidersTableSeeder extends Seeder {
	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		DB::table('providers')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');

		factory(Provider::class, 12)->create();
	}
}

class ProductsTableSeeder extends Seeder {
	public function run()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS = 0');
		DB::table('products')->truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS = 1');

		factory(Product::class, 40)->create();
	}
}
