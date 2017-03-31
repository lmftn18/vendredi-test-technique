<?php

namespace Tests\App\Http;

use App\School;
use Tests\TestCase;

class SchoolControllerTest extends TestCase
{
    /*
     * Test school search
     */

    private function assertSchoolSearchCallFractalWithCorrectSchool($parameters, $expectedSchoolIds)
    {
        // send the request
        $response = $this->call('GET', '/ajax/school', $parameters);
        // we have a JsonResponse as a response here
        $content = $response->getData(true);

        $this->assertTrue(isset($content['data']), 'response has a data field');

        // extract a list of Ids from the jobs
        $schoolIds = array_map(
          function ($school) {
              return $school['id'];
          },
          $content['data']
        );
        // the $canonicalize option makes phpunit sort the array before comparing, so the order doesn't matter
        $this->assertEquals(
          $expectedSchoolIds, $schoolIds, 'The expected jobs have been returned',
          $delta = 0.0, $maxDepth = 10, $canonicalize = true
        );
    }

    public function testSchoolSearchOneResult()
    {
        $school = factory(School::class)->create();


        $parameters = ['search' => $school->value];
        $expectedSchoolIds = [$school->id];
        $this->assertSchoolSearchCallFractalWithCorrectSchool($parameters, $expectedSchoolIds);
    }


    public function testSchoolSearchOneResultCaseInsensitive()
    {
        $school = factory(School::class)->create();


        $parameters = ['search' => mb_strtoupper($school->value)];
        $expectedSchoolIds = [$school->id];
        $this->assertSchoolSearchCallFractalWithCorrectSchool($parameters, $expectedSchoolIds);
    }


    public function testSchoolSearchTwoResult()
    {
        $school1 = factory(School::class)->create();
        $school1->value = "École Centrale";
        $school1->save();

        $school2 = factory(School::class)->create();
        $school2->value = "École Normale";
        $school2->save();

        $parameters = ['search' => 'ecole'];
        $expectedSchoolIds = [$school1->id, $school2->id];
        $this->assertSchoolSearchCallFractalWithCorrectSchool($parameters, $expectedSchoolIds);
    }
}