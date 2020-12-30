<?php

use Illuminate\Database\Seeder;
use App\Models\Journal;

class JournalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Journal::class, 1)->create();
    }
}
