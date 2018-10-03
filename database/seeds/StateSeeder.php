<?php

use Illuminate\Database\Seeder;
use App\Models\State;
class StateSeeder extends Seeder
{
    public function run()
    {
        $this->truncate();

        $states = [
            ['name' => 'New South Wales', 'abbr' => 'NSW'],
            ['name' => 'Australian Capital Territory', 'abbr' => 'ACT'],
            ['name' => 'Victoria', 'abbr' => 'VIC'],
            ['name' => 'Queensland', 'abbr' => 'QLD'],
            ['name' => 'South Australia', 'abbr' => 'SA'],
            ['name' => 'Western Australia', 'abbr' => 'WA'],
            ['name' => 'Tasmania', 'abbr' => 'TAS'],
            ['name' => 'Northern Territory', 'abbr' => 'NT']
        ];

        foreach ($states as $state)
        {
            State::create($state);
        }
    }

    public function truncate()
    {
        DB::table('states')->truncate();
    }
}