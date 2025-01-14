<?php

namespace Database\Seeders;

use Feelri\Core\Models\Admin\Admin;
use Feelri\Core\Models\Admin\Role;
use Feelri\Core\Models\User\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$role = Role::query()->create([
			'name'         => '超级管理员',
			'is_top_level' => 1,
		]);

		$admin = Admin::query()->create([
			'account'  => 'admin',
			'name'     => 'Admin',
			'nickname' => '超级管理员',
			'password' => Hash::make('123456'),
		]);

		$admin->roles()->attach([$role->id]);

		// 权限
		DB::unprepared(file_get_contents(database_path('permission.sql')));

		User::query()->create([
			'account'  => 'user',
			'nickname' => 'user',
			'password' => Hash::make('123456'),
		]);

		// 地区树
		DB::unprepared(file_get_contents(database_path('district.sql')));
	}
}
