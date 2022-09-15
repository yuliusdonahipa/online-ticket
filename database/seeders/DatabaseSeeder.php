<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password')
        ]);

        collect([
            [
                "name" => 'Event 1',
                'slug' => 'event-1',
                'desc' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit debitis dolores fuga nihil perspiciatis voluptate nam inventore optio voluptatum suscipit!',
                'image' => 'https://images.pexels.com/photos/976866/pexels-photo-976866.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500',
                "price" => 100000
            ],

            [
                "name" => 'Event 2',
                'slug' => 'event-2',
                'desc' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit debitis dolores fuga nihil perspiciatis voluptate nam inventore optio voluptatum suscipit!',
                'image' => 'https://images.pexels.com/photos/4940642/pexels-photo-4940642.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500',
                "price" => 200000
            ],
            [
                "name" => 'Event 3',
                'slug' => 'event-3',
                'desc' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit debitis dolores fuga nihil perspiciatis voluptate nam inventore optio voluptatum suscipit!',
                'image' => 'https://images.pexels.com/photos/382297/pexels-photo-382297.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500',
                "price" => 300000
            ],
            [
                "name" => 'Event 4',
                'slug' => 'event-4',
                'desc' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit debitis dolores fuga nihil perspiciatis voluptate nam inventore optio voluptatum suscipit!',
                'image' => 'https://images.pexels.com/photos/2608517/pexels-photo-2608517.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500',
                "price" => 400000
            ],
            [
                "name" => 'Event 5',
                'slug' => 'event-5',
                'desc' => 'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit debitis dolores fuga nihil perspiciatis voluptate nam inventore optio voluptatum suscipit!',
                'image' => 'https://images.pexels.com/photos/919734/pexels-photo-919734.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500',
                "price" => 500000
            ],

        ])->each(fn ($data) => Event::create($data));

        \App\Models\Participant::factory(15)->create();
    }
}
