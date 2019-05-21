<?php
// declare(strict_types=1);

//namespace AG\WebApp;

use PHPUnit\Framework\TestCase;
use AG\WebApp\Request;
use AG\WebApp\Request\RqGET;

final class RqGETTest extends TestCase
{
    public function testGetParamValue(): void
    {
        echo "ASDFASDFASDF\n";
        $this->assertEquals(1, 1);

        $rqGET = new RqGET();

        // @todo complete this test





        // $action = new class() implements Action
        // {
        //     public function handle(Response $resp): Response
        //     {
        //         return $resp->withBody('Hello!');
        //     }
        // };

        // $this->assertInstanceOf(
        //     Email::class,
        //     Email::fromString('user@example.com')
        // );
    }
}
