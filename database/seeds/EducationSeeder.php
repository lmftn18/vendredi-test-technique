<?php
use Illuminate\Database\Seeder;

/**
 * Created by PhpStorm.
 * User: jguerin
 * Date: 31/03/2017
 * Time: 13:34
 */
class EducationSeeder extends Seeder
{
    private $educationValues = [
      'BAC +1',
      'BAC +2',
      'BAC +3',
      'BAC +4',
      'BAC +5',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->educationValues as $educationValue) {
            $education = App\Education::firstOrNew([ 'value' => $educationValue ]);
            $education->value = $educationValue;
            $education->save();
        }
    }
}
