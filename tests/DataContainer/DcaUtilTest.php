<?php

declare(strict_types=1);

/*
 * This file is part of Dma Simple Grid.
 *
 * (c) Janosch Oltmanns 2023 <kontakt@janosch-oltmanns.de>
 * @license LGPL-3.0+
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/DMAGmbH/dma_simple_grid
 */

namespace Dma\DmaSimpleGrid\Tests\DataContainer;

use Dma\DmaSimpleGrid\Config\GridConfig;
use Dma\DmaSimpleGrid\DataContainer\AcrossTablesDcaCallbacks;
use Dma\DmaSimpleGrid\DataContainer\DcaUtil;
use PHPUnit\Framework\TestCase;

class DcaUtilTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        include __DIR__.'/../../contao/config/config.php';

        $GLOBALS['TL_CONFIG'] = [
            'dmaSimpleGridType' => 'bootstrap4',
            'dmaSimpleGrid_useColumns' => true,
            'dmaSimpleGrid_useOffset' => true,
            'dmaSimpleGrid_useAdditionalWrapperClasses' => true,
        ];

        GridConfig::reset();
    }

    protected function tearDown(): void
    {
        unset($GLOBALS['TL_CONFIG'], $GLOBALS['DMA_SIMPLEGRID_CONFIG'], $GLOBALS['DMA_SIMPLEGRID_FALLBACK'], $GLOBALS['TL_WRAPPERS'], $GLOBALS['TL_FFL']);

        GridConfig::reset();

        parent::tearDown();
    }

    public function testGetColumnClasses(): void
    {
        $row = [
            'dma_simplegrid_columnsettings' => serialize([['xs' => '12', 'md' => '6', 'lg' => 'hide']]),
            'dma_simplegrid_offsetsettings' => serialize([['md' => 'reset', 'lg' => '2']]),
        ];

        $this->assertTrue(DcaUtil::hasDmaGridInfos($row));
        $this->assertSame('col-12 col-md-6 d-lg-none offset-md-0 offset-lg-2', DcaUtil::getColumnClasses($row));
    }

    public function testIgnoresOffsetsIfDisabled(): void
    {
        $GLOBALS['TL_CONFIG']['dmaSimpleGrid_useOffset'] = false;

        $row = [
            'dma_simplegrid_columnsettings' => serialize([['md' => '4']]),
            'dma_simplegrid_offsetsettings' => serialize([['md' => '2']]),
        ];

        $this->assertSame('col-md-4', DcaUtil::getColumnClasses($row));
    }

    public function testGetColumnStartClasses(): void
    {
        $row = [
            'type' => 'dma_simplegrid_column_start',
            'dma_simplegrid_columnsettings' => serialize([['sm' => '6']]),
        ];

        $this->assertSame(['column', 'col-sm-6'], DcaUtil::getColumnStartClasses($row));
    }

    public function testGetRowClasses(): void
    {
        $this->assertSame(['row'], DcaUtil::getRowClasses([]));
    }

    public function testGetWrapperClasses(): void
    {
        $row = ['dma_simplegrid_additionalwrapperclasses' => serialize(['container-fluid'])];

        $this->assertSame(['container-fluid', 'wrapper'], DcaUtil::getWrapperClasses($row));
    }

    public function testGetRowClassesWithBlockGridAndPrefixes(): void
    {
        $GLOBALS['TL_CONFIG'] = [
            'dmaSimpleGridType' => 'gridlex',
            'dmaSimpleGrid_useBlockGrid' => true,
            'dmaSimpleGrid_useAdditionalRowClasses' => true,
        ];

        GridConfig::reset();

        $row = [
            'dma_simplegrid_blocksettings' => serialize([['all' => '3', 'md' => '2']]),
            'dma_simplegrid_additionalrowclasses' => serialize(['^-center']),
        ];

        $this->assertSame(['-3', '_md-2', '-center', 'grid'], DcaUtil::getRowClasses($row));
    }

    public function testFallsBackToTheDefaultGrid(): void
    {
        $GLOBALS['TL_CONFIG'] = ['dmaSimpleGridType' => 'does-not-exist'];

        GridConfig::reset();

        $this->assertSame('row', GridConfig::getData('row-class'));
        $this->assertSame(['3', '4', '6', '8', '9', '12'], GridConfig::getData('columns-sizes'));
    }

    public function testGeneratesTheGridInfos(): void
    {
        $row = ['dma_simplegrid_columnsettings' => serialize([['xs' => '12', 'md' => '6']])];

        $html = AcrossTablesDcaCallbacks::generateSimpleGridInfos($row);

        $this->assertStringContainsString('title="extra small: 12; medium: 6"', $html);
        $this->assertSame('', AcrossTablesDcaCallbacks::generateSimpleGridInfos([]));
    }
}
