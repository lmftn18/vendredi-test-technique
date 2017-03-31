<?php

namespace Tests\Database\Seeds;

use App\Application;
use App\Association;
use App\Candidate;
use App\Cause;
use App\City;
use App\Company;
use App\Contract;
use App\Education;
use App\Job;
use App\Mission;
use App\Region;
use App\Rythm;
use App\School;
use App\User;
use App\Worktype;
use Illuminate\Database\Seeder;

class TestModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Education::class, 10)->create();
        factory(School::class, 10)->create();
        factory(User::class, 10)->create();
        factory(Candidate::class, 10)->create();
    }
}
