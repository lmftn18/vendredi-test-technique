<?php


namespace Tests\App\Http;

use Tests\TestCase;

class PageControllerTest extends TestCase
{
    private $mobileUserAgent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A5376e Safari/8536.25';

    /**
     * @dataProvider pagesStatusCodeDataProvider
     *
     * @param $uri
     */
    public function testPagesStatusCodeDesktop( $uri )
    {
        $this->assertEquals(
            200, $this->call( 'GET', $uri )->status(), 'regular desktop loading is working'
        );
    }

    /**
     * We need to separate this test, otherwise the user agent header is set by the first query
     * and is not changed afterward.
     *
     * @dataProvider pagesStatusCodeDataProvider
     *
     * @param $uri
     */
    public function testPageStatusCodeMobile($uri)
    {
        $mobileStatus = $this->call(
            'GET', $uri,
            [], [], [],
            [ 'HTTP_USER_AGENT' => $this->mobileUserAgent ]
        )->status();
        $this->assertEquals(
            200, $mobileStatus, 'mobile loading is working'
        );
    }

    public function pagesStatusCodeDataProvider()
    {
        return [
            [ '/' ],
            [ '/concept' ],
            [ '/equipe' ],
        ];
    }
}