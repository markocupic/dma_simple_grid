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

use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridColumnStartController;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridColumnStopController;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridRowStartController;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridRowStopController;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridWrapperStartController;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridWrapperStopController;

/*
 * Content elements
 */
$GLOBALS['TL_LANG']['CTE']['dma_simplegrid'] = 'Grid System (DMA SimpleGrid)';
$GLOBALS['TL_LANG']['CTE'][DmaSimplegridWrapperStartController::TYPE] = ['SimpleGrid: Wrapper Start', 'SimpleGrid: Wrapper Start'];
$GLOBALS['TL_LANG']['CTE'][DmaSimplegridWrapperStopController::TYPE] = ['SimpleGrid: Wrapper Stop', 'SimpleGrid: Wrapper Stop'];
$GLOBALS['TL_LANG']['CTE'][DmaSimplegridRowStartController::TYPE] = ['SimpleGrid: Row Start', 'SimpleGrid: Row Start'];
$GLOBALS['TL_LANG']['CTE'][DmaSimplegridRowStopController::TYPE] = ['SimpleGrid: Row Stop', 'SimpleGrid: Row Stop'];
$GLOBALS['TL_LANG']['CTE'][DmaSimplegridColumnStartController::TYPE] = ['SimpleGrid: Column Start', 'SimpleGrid: Column Start'];
$GLOBALS['TL_LANG']['CTE'][DmaSimplegridColumnStopController::TYPE] = ['SimpleGrid: Column Stop', 'SimpleGrid: Column Stop'];

/*
 * Form fields
 */
$GLOBALS['TL_LANG']['FFL']['dma_simplegrid_row_start'] = ['Grid Row Start', 'Grid Row Start'];
$GLOBALS['TL_LANG']['FFL']['dma_simplegrid_row_stop'] = ['Grid Row Stop', 'Grid Row Stop'];
$GLOBALS['TL_LANG']['FFL']['dma_simplegrid_column_start'] = ['Grid Column Start', 'Grid Column Start'];
$GLOBALS['TL_LANG']['FFL']['dma_simplegrid_column_stop'] = ['Grid Column Stop', 'Grid Column Stop'];

/*
 * Miscellaneous
 */
$GLOBALS['TL_LANG']['MSC']['dma_simplegrid_hidden'] = 'Hidden';
