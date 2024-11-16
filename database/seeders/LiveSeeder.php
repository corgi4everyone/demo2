<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Submission;
use App\Models\Grade;

class LiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create subsmissions and grades for existing assignments
        Submission::factory(20)->create();
        // Create grades
        Grade::factory(20)->create();
    }
}
