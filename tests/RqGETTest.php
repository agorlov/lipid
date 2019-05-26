<?php
declare(strict_types=1);

namespace Lipid\Request;

use PHPUnit\Framework\TestCase;
use Lipid\Request\RqGET;

/**
 * RqGET Test
 *
 * @author agorlov
 */
final class RqGETTest extends TestCase
{
    public function testGetParamValue(): void
    {
        $this->assertEquals(
            123,
            (new RqGET(['test' => '123']))->param('test')
        );
    }

    public function testGetParamNull(): void
    {
        $this->assertEquals(
            null,
            (new RqGET(['test' => '123']))->param('test123')
        );
    }
}
