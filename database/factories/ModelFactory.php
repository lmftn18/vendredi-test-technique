<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'firstname' => $faker->firstName,
        'lastname' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'is_admin' => false,
    ];
});


$factory->define(App\Region::class, function (Faker\Generator $faker) {
    return [
        'value' => $faker->words(3, true),
    ];
});

$factory->define(App\City::class, function (Faker\Generator $faker) {
    return [
        'value' => $faker->words(3, true),
        'region_id' => function() {
            return factory(App\Region::class)->create()->id;
        }
    ];
});


$factory->define(App\Contract::class, function (Faker\Generator $faker) {
    return [
        'value' => $faker->word,
    ];
});

$factory->define(App\Rythm::class, function (Faker\Generator $faker) {
    return [
        'value' => $faker->word,
    ];
});

$factory->define(App\Company::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->regexify('[A-Z]{2}');
    $vendrediId = \AppHelper::getShortVendrediId(
        \App\Company::all()->pluck( 'vendredi_id' )->toArray(), $name
    );

    return [
        'name' => $name,
        'url' => $faker->url,
        'logo' => $faker->regexify('/\w{4,20}/job/\w{20}.jpg'),
        'vendredi_id' => $vendrediId,
    ];
});

$factory->define(App\Worktype::class, function (Faker\Generator $faker) {
    return [
        'value' => $faker->words(3, true),
    ];
});


$factory->define(App\Job::class, function (Faker\Generator $faker) {
    return [
        'company_id' => function() {
            $company = App\Company::first();
            return $company ? $company->id : factory(App\Company::class)->create()->id;
        },
        'city_id' => function() use ($faker) {
            return factory(App\City::class)->create()->id;
        },
        'contract_id' => function() use ($faker) {
            return factory(App\Contract::class)->create()->id;
        },
        'rythm_id' => function() use ($faker) {
            return factory(App\Rythm::class)->create()->id;
        },
        'worktype_id' => function() use ($faker) {
            return factory(App\Worktype::class)->create()->id;
        },
        'url' => $faker->url,
        'title' => $faker->words(5, true),
        'description' => $faker->sentences(5, true),
        'start_date' => $faker->dateTimeBetween('- 1 year', '+ 1 year'),
        'duration_months' => $faker->numberBetween(12, 52),
        'vendredi_id' => $faker->unique()->regexify('\d\d[A-Z]{2}\d\d'),
        'picture' => $faker->regexify('/\w{4,20}/job/\w{20}\.jpg'),
        'order' => $faker->randomDigitNotNull,
        'first_published_at' => new DateTime(),
        'published_at' => new DateTime(),
        'unpublished_at' => null,
    ];
});

$factory->define(App\Education::class, function (Faker\Generator $faker) {
    return [
        'value' => $faker->unique()->words(3, true),
    ];
});

$factory->define(App\School::class, function (Faker\Generator $faker) {
    return [
        'value' => $faker->unique()->words(3, true),
    ];
});

$factory->define(App\Candidate::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function() {
            return factory(App\User::class)->create()->id;
        },
        'school_id' => function() use ($faker) {
            return $faker->boolean ? factory(App\School::class)->create()->id : null;
        },
        'education_id' => function() use ($faker) {
            return $faker->boolean ? factory(App\Education::class)->create()->id : null;
        },
        'registration_date' => $faker->dateTimeBetween('- 1 year', '+ 1 year')->format('Y-m-d'),
        'is_recruited' => $faker->boolean,
    ];
});


$factory->define(App\Application::class, function (Faker\Generator $faker) {
    return [
        'candidate_id' => function() {
            return factory(App\Candidate::class)->create()->id;
        },
        'job_id' => function() use ($faker) {
            return factory(App\Job::class)->create()->id;
        },
        'timestamp' => $faker->dateTimeBetween('- 1 year', 'now')->format('Y-m-d H:i:s'),
    ];
});



$factory->define(App\Cause::class, function (Faker\Generator $faker) {
    return [
        'value' => $faker->unique()->words(3, true),
    ];
});


$factory->define(App\Association::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->regexify('[A-Z]{2}');
    $vendrediId = \AppHelper::getShortVendrediId(
        \App\Association::all()->pluck( 'vendredi_id' )->toArray(), $name
    );

    return [
        'name' => $name,
        'url' => $faker->url,
        'logo' => $faker->regexify('/\w{4,20}/job/\w{20}\.jpg'),
        'picture_desktop' => $faker->regexify('/\w{4,20}/job/\w{20}\.jpg'),
        'picture_mobile' => $faker->regexify('/\w{4,20}/job/\w{20}\.jpg'),
        'vendredi_id' => $vendrediId,
        'tagline' => $faker->words(3, true),
        'description' => $faker->sentences(2, true),
        'order' => $faker->randomDigitNotNull,
        'region_id' => function() {
            return factory(App\Region::class)->create()->id;
        },
        'first_published_at' => new DateTime(),
        'published_at' => new DateTime(),
        'unpublished_at' => null,
    ];
});

$factory->define(App\Mission::class, function (Faker\Generator $faker) {
    return [
        'association_id' => function() {
            return factory(App\Association::class)->create()->id;
        },
        'worktype_id' => function() use ($faker) {
            return factory(App\Worktype::class)->create()->id;
        },
        'title' => $faker->words(5, true),
        'vendredi_id' => $faker->unique()->regexify('\d\d[A-Z]{2}\d\d'),
        'first_published_at' => new DateTime(),
        'published_at' => new DateTime(),
        'unpublished_at' => null,
    ];
});