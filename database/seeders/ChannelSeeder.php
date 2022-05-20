<?php

namespace Database\Seeders;

use App\Models\Channel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ChannelSeeder extends Seeder
{
    protected Collection $teams;

    public function run()
    {
        Channel::factory(3)->create();
    }
}
