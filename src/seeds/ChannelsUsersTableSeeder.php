<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Models\Channel;
use Carbon\Carbon;

class ChannelsUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('id', '!=', 1)->get();
        $user = User::find(1);
        foreach ($users as $currentUser)
        {
        	$channel = new Channel();
        	$channel->save();
        	DB::table('channel_user')->insert([
        		'channel_id' => $channel->id,
        		'user_id' => $user->id,
        		'created_at' => Carbon::now()
        	]);
        	DB::table('channel_user')->insert([
        		'channel_id' => $channel->id,
        		'user_id' => $currentUser->id,
        		'created_at' => Carbon::now()
        	]);
        }
    }
}
