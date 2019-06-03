<?php
declare(strict_types=1);

namespace Lipid\Action;

use PHPUnit\Framework\TestCase;
use Lipid\Request\RqGET;
use Lipid\Action;
use Lipid\Request;
use Lipid\Response;
use Lipid\NotFoundException;
use Exception;

/**
 * RqGET Test
 *
 * @author agorlov
 */
final class ActRoutedTest extends TestCase
{
    private $action;
    private $response;

    protected function setUp(): void
    {
        $this->action = new class() implements Action
        {
            public $isInvoked = false;
            public function handle(Response $resp): Response
            {
                $this->isInvoked = true;
                return $resp;
            }
        };
        
        $this->response = new class() implements Response
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
    }

    public function testRoot(): void
    {
        $request = new class() implements Request
        {
            public function param($param)
            {
                return '/';
            }
        };

        (new ActRouted($request, [ '/' => $this->action ]))->handle($this->response);

        $this->assertTrue($this->action->isInvoked);
    }

    public function testRootRoot(): void
    {
        $this->expectException(Exception::class);

        $request = new class() implements Request
        {
            public function param($param)
            {
                return '////';
            }
        };

        (new ActRouted($request, [ '/' => $this->action ]))->handle($this->response);

        // $this->assertTrue($this->action->isInvoked);
    }

    public function testPage(): void
    {
        $request = new class() implements Request
        {
            public function param($param)
            {
                return '/page';
            }
        };

        (new ActRouted($request, [ '/page' => $this->action ]))->handle($this->response);

        $this->assertTrue($this->action->isInvoked);
    }

    public function testPageSlash(): void
    {
        $request = new class() implements Request
        {
            public function param($param)
            {
                return '/page/';
            }
        };

        (new ActRouted($request, [ '/page' => $this->action ]))->handle($this->response);

        $this->assertTrue($this->action->isInvoked);
    }

    public function testPageSlashQuery(): void
    {
        $request = new class() implements Request
        {
            public function param($param)
            {
                return '/page/?asdf=234';
            }
        };

        (new ActRouted($request, [ '/page' => $this->action ]))->handle($this->response);

        $this->assertTrue($this->action->isInvoked);
    }

    public function test404(): void
    {
        $this->expectException(NotFoundException::class);

        $request = new class() implements Request
        {
            public function param($param)
            {
                return '/page1234';
            }
        };

        (new ActRouted($request, [ '/page' => $this->action ]))->handle($this->response);
    }
}
