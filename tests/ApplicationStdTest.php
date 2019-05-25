<?php
// declare(strict_types=1);

namespace AG\WebApp;

use PHPUnit\Framework\TestCase;
use AG\WebApp\App\ApplicationStd;
use AG\WebApp\Action;
use AG\WebApp\Request;
use AG\WebApp\Response;

final class ApplicationStdTest extends TestCase
{
    /**
     * @runInSeparateProcess
     */
    public function testActionNotFound(): void
    {

        $response = new class() implements Response
        {
            public function print(): void
            {
            }
            public function withBody(string $body): Response
            {
                return $this;
            }
            public function withHeaders(array $headers): Response
            {
                return $this;
            }
        };

        $request = new class() implements Request
        {
            public function param($param)
            {
                return '/asdf';
            }
        };

        $action = new class() implements Action
        {
            public function handle(Response $resp): Response
            {
            }
        };

        (new ApplicationStd(
            [ '/' => $action ],
            $response,
            $request
        ))->start();

        $this->expectOutputRegex('/404/');
    }

    public function testActionStart(): void
    {
        $response = new class() implements Response
        {
            public $printCallCount = 0;
            public $body;

            public function print(): void
            {
                $this->printCallCount++;
            }
            public function withBody(string $body): Response
            {
                $this->body = $body;
                return $this;
            }
            public function withHeaders(array $headers): Response
            {
                return $this;
            }
        };

        $request = new class() implements Request
        {
            public function param($param)
            {
                return '/';
            }
        };

        $action = new class() implements Action
        {
            public function handle(Response $resp): Response
            {
                return $resp->withBody('Hello!');
            }
        };

        (new ApplicationStd(
            [ '/' => $action ],
            $response,
            $request
        ))->start();

        $this->assertEquals(1, $response->printCallCount);
        $this->assertEquals('Hello!', $response->body);
    }


    public function testActionStartOneAction(): void
    {
        $response = new class() implements Response
        {
            public $printCallCount = 0;
            public $body;

            public function print(): void
            {
                $this->printCallCount++;
            }
            public function withBody(string $body): Response
            {
                $this->body = $body;
                return $this;
            }
            public function withHeaders(array $headers): Response
            {
                return $this;
            }
        };

        $request = new class() implements Request
        {
            public function param($param)
            {
                return '/';
            }
        };

        $action = new class() implements Action
        {
            public function handle(Response $resp): Response
            {
                return $resp->withBody('Hello!');
            }
        };

        (new ApplicationStd(
            $action,
            $response,
            $request
        ))->start();

        $this->assertEquals(1, $response->printCallCount);
        $this->assertEquals('Hello!', $response->body);
    }
}
