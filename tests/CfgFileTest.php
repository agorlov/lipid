<?php
declare(strict_types=1);

namespace Lipid\Action;

use PHPUnit\Framework\TestCase;
use Lipid\Config\CfgFile;
use Exception;

/**
 * CfgFile Test
 *
 * @author agorlov
 */
final class CfgFileTest extends TestCase
{

    public function testParam(): void
    {
        $this->assertEquals(
            'asdf',
            (new CfgFile(__DIR__ . '/data/config.php'))->param('param')
        );
    }   
}
