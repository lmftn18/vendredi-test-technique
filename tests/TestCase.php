<?php

namespace Tests;

use App\Http\Requests\ValidationMessages;
use App\Facades\AppHelper;
use App\User;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\UploadedFile;


abstract class TestCase extends BaseTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /** @var  $baseUri: ex '/admin/job', base uri */
    protected $baseUri;

    /**
     * Headers of the CSV file we want to import.
     * @var array
     */
    protected $defaultCSVrow = [];

    use DatabaseTransactions;

    protected $connectionsToTransact = [ 'testing' ];

    protected function setUpWithoutLogin()
    {
        parent::setUp();
    }

    protected function setUp()
    {
        parent::setUp();

        $user = factory( User::class )->make( [
            'is_admin' => true,
            'email' => 'admin@example.org',
            'created_at' => new \DateTime(),
        ] );
        $this->be( $user );
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make( Kernel::class )->bootstrap();

        return $app;
    }

    protected function requiredFieldMessage( $field )
    {
        return ValidationMessages::isRequired( $field );
    }

    /**
     * Mock our AppHelper, expecting the save picture method to be called once
     */
    protected function mockAppHelperExpectingSavePicture()
    {
        AppHelper::shouldReceive( 'resizeAndUploadToS3' )
                 ->atLeast()->times( 1 )
                 ->andReturnUsing( function ( $width, $height, $value, $destinationPath ) {
                     return $value;
                 } );
        AppHelper::makePartial();
    }

    /**
     * Mock AirTable sync and expect it to be called.
     *
     * @param $type
     * @param $method
     */
    protected function mockAirTableExpecting( $type, $method )
    {
        $airTableConnector = new \Mockery\Mock();
        $airTableConnector->shouldReceive( $method )->once();
        \AirTable::shouldReceive( 'get' )
                 ->atLeast()->times( 1 )
                 ->with( $type )
                 ->andReturnUsing( function () use ( $airTableConnector ) {
                     return $airTableConnector;
                 } );
    }

    /**
     * Mock importer and expect it to be called.
     *
     * @param $type
     */
    protected function mockImporterExpecting( $type )
    {
        $importerMock = new \Mockery\Mock();
        $importerMock->shouldReceive( 'importFile' )->once();
        \Importer::shouldReceive( 'get' )
                 ->atLeast()->times( 1 )
                 ->with( $type )
                 ->andReturnUsing( function () use ( $importerMock ) {
                     return $importerMock;
                 } );
    }

    /**
     * Dynamically creates an UploadedFile with CSV info.
     *
     * @param array $data: and array of array with the data to be written. We take the default csv row as a basis, so we
     * only need to override the fields we want to change.
     *
     * For ex: [ [ 'col1' => 'data', 'col2' => 'data' ], [ 'col2' => 'line2 data!' ] ]
     *
     * @return UploadedFile
     * @throws \App\Exceptions\VendrediException
     */
    protected function createCSVUploadedFile($data)
    {
        if (!$this->defaultCSVrow) {
            throw new \App\Exceptions\VendrediException('The default CSV row must be filled to generate a test CSV.');
        }

        $name = str_random(8).'.csv';
        $path = sys_get_temp_dir().'/'.$name;
        $file = fopen($path, 'w');

        fputcsv($file, array_keys($this->defaultCSVrow));
        foreach ($data as $datum) {
            $row = array_merge($this->defaultCSVrow, $datum);
            fputcsv($file, $row);
        }
        fclose($file);

        return new UploadedFile($path, $name, filesize($path), 'text/csv', null, true);
    }

    /**
     * Tries to import a dummy file and check the correct importer is called.
     *
     * @param $importerName
     */
    protected function assertImportIsOk($importerName)
    {
        $this->mockImporterExpecting($importerName);

        $name = str_random( 8 ) . '.csv';
        $path = sys_get_temp_dir() . '/' . $name;
        $file = fopen( $path, 'w' );
        fputcsv( $file, [ 'a field' ] );

        $csv = new UploadedFile( $path, $name, filesize( $path ), 'text/csv', null, true );

        $this->call(
            'POST',
            $this->baseUri . '/import',
            [], [],
            [ 'import' => $csv ]
        );

        $this->assertEquals(302, $this->response->status(), 'import leads to a redirect');
    }
}
