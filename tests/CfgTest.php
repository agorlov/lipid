<?php
declare(strict_types=1);

namespace Lipid\Action;

use PHPUnit\Framework\TestCase;
use Lipid\Config\Cfg;
use Lipid\Config\CfgFile;
use Exception;

/**
 * CfgFile Test
 *
 * @author agorlov
 */
final class CfgTest extends TestCase
{

    public function testParam(): void
    {
        $cfg = new Cfg(
            new CfgFile(__DIR__ . '/data/creds.php'),
            new CfgFile(__DIR__ . '/data/config.php')
        );

        $this->assertEquals(
            'user',
            $cfg->param('dbuser')
        );

        $this->assertEquals(
            'asdf',
            $cfg->param('param')
        );
    }
}
