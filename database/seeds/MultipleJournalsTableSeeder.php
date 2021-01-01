<?php

use Illuminate\Database\Seeder;
use App\Models\MultipleJournal;

class MultipleJournalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MultipleJournal::class, 1)->create();
    }
}
