<?php

namespace Tests\App\Helpers;

use App\Company;
use App\Job;
use Tests\TestCase;

class AppHelperTest extends TestCase
{
    public function testGetS3Url()
    {
        $bucket = 's3-bucket';
        $region = 's3-region';
        $path = 'a/path/to/file.jpg';

        \Config::set( 'filesystems.disks.s3.bucket', $bucket );
        \Config::set( 'filesystems.disks.s3.region', $region );

        $this->assertEquals(
            'https://s3.' . $region . '.amazonaws.com/' . $bucket . '/' . $path,
            \AppHelper::getS3Url( $path ),
            'correct s3 url to file is generated'
        );
    }




    public function testIsExternalLink()
    {

        $externalLink = "http://www.welcometothejungle.co/companies/monbanquet/jobs/chef-de-projet-marketing_paris";
        $googleDriveLink1 = "https://drive.google.com/open?id=0B3M2wSltqVLmV0pETDhDRS05VTQ";
        $googleDriveLink2 = "https://drive.google.com/file/d/0B3M2wSltqVLmb25YYW1fMVVIdUU/view?usp=sharing";

        $this->assertTrue( \AppHelper::isExternalLink( $externalLink ) );
        $this->assertFalse( \AppHelper::isExternalLink( $googleDriveLink1 ) );
        $this->assertFalse( \AppHelper::isExternalLink( $googleDriveLink2 ) );

    }

    public function testIfPdfPreviewLink()
    {

        $externalLink = "http://www.welcometothejungle.co/companies/monbanquet/jobs/chef-de-projet-marketing_paris";

        $googleDriveLink1 = "https://drive.google.com/open?id=0B3M2wSltqVLmV0pETDhDRS05VTQ";
        $googleDrivePreview1 = "https://drive.google.com/file/d/0B3M2wSltqVLmV0pETDhDRS05VTQ/preview";


        $googleDriveLink2 = "https://drive.google.com/file/d/0B3M2wSltqVLmb25YYW1fMVVIdUU/view?usp=sharing";
        $googleDrivePreview2 = "https://drive.google.com/file/d/0B3M2wSltqVLmb25YYW1fMVVIdUU/preview";

        $this->assertFalse( \AppHelper::getPdfPreviewLink( $externalLink ) );
        $this->assertEquals( $googleDrivePreview1, \AppHelper::getPdfPreviewLink( $googleDriveLink1 ) );
        $this->assertEquals( $googleDrivePreview2, \AppHelper::getPdfPreviewLink( $googleDriveLink2 ) );


    }

}