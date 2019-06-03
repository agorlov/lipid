<?php
declare(strict_types=1);

namespace Lipid\Action;

use PHPUnit\Framework\TestCase;
use Lipid\Config\CfgArr;
use Exception;

/**
 * CfgArr Test
 *
 * @author agorlov
 */
final class CfgArrTest extends TestCase
{

    public function testParam(): void
    {
        $this->assertEquals(
            123,
            (new CfgArr(['param' => 123]))->param('param')
        );
    }

    public function testNoParam(): void
    {
        $this->expectException(Exception::class);
        (new CfgArr(['paramNotInConfig' => 123]))->param('param');
    }
}
