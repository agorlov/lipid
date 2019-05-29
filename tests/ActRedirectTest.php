<?php
declare(strict_types=1);

namespace Lipid\Action;

use PHPUnit\Framework\TestCase;
use Lipid\Request\RqGET;
use Lipid\Action;
use Lipid\Request;
use Lipid\Response;
use Lipid\NotFoundException;

/**
 * RqGET Test
 *
 * @author agorlov
 */
final class ActRedirectTest extends TestCase
{

    public function testRedirect(): void
    {

        $response = (new ActRedirect('http://agorlov.ru/'))->handle(
            new class() implements Response
            {
                public $headers;

                public function print(): void
                {
                }
                public function withBody(string $body): Response
                {
                    return $this;
                }
                public function withHeaders(array $headers): Response
                {
                    $this->headers = $headers;
                    return $this;
                }
            }
        );

        $this->assertContains('Location: http://agorlov.ru/', $response->headers);
    }
}
