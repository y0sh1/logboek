<?php
class UserTableSeeder extends Seeder {
	public function run() {
		$users = array(
			[
				'username' => 'owner',
				'email' => 'owner@example.com',
			]
		);

		$users = array_map(function($user) {
			$user['password'] = Hash::make('changeme');
			return $user;
		}, $users);

		User::insert($users);
	}
}
