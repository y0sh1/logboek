<?php
class LogbooksTableSeeder extends Seeder {
	public function run() {
		$general = new Logbook(['title' => 'Algemeen logboek', 'user_id' => 1]);
		$general->save();

		// Create a personal logbook for every user
		foreach(User::all() as $user) {
			if(substr($user->email, 0, 6) === 'system') continue;

			$name = ucfirst($user->username);

			$logbook = new Logbook(['title' => "$name's logboek", 'user_id' => $user->id]);

			$logbook->save();
		}
	}
}
