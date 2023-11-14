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

use Contao\ArrayUtil;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridWrapperStartController;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridWrapperStopController;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridRowStartController;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridRowStopController;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridColumnStartController;
use Dma\DmaSimpleGrid\Controller\ContentElement\DmaSimplegridColumnStopController;
use Dma\DmaSimpleGrid\DataContainer\AcrossTablesDcaCallbacks;
use Dma\DmaSimpleGrid\DataContainer\DcaUtil;

/**
 * Operations
 */
ArrayUtil::arrayInsert($GLOBALS['TL_DCA']['tl_content']['list']['operations'], 0, [
    'show_simplegrid_infos' => [],
]);

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_content']['palettes'][DmaSimplegridWrapperStartController::TYPE] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes'][DmaSimplegridWrapperStopController::TYPE] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes'][DmaSimplegridRowStartController::TYPE] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes'][DmaSimplegridRowStopController::TYPE] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes'][DmaSimplegridColumnStartController::TYPE] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes'][DmaSimplegridColumnStopController::TYPE] = '{type_legend},type;{protected_legend:hide},protected;{expert_legend:hide},guests;{invisible_legend:hide},invisible,start,stop';

/**
 * Fields
 */
$GLOBALS['TL_DCA']['tl_content']['fields']['dma_simplegrid_columnsettings'] = [
    'exclude'   => true,
    'inputType' => 'multiColumnWizard',
    'eval'      => [
        'maxCount'        => 1,
        'buttons'         => [
            'up'     => false,
            'down'   => false,
            'move'   => false,
            'new'    => false,
            'copy'   => false,
            'delete' => false,
        ],
        'columnsCallback' => [AcrossTablesDcaCallbacks::class, 'columnsSelectCallback'],
    ],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['dma_simplegrid_offsetsettings'] = [
    'exclude'   => true,
    'inputType' => 'multiColumnWizard',
    'eval'      => [
        'maxCount'        => 1,
        'buttons'         => [
            'up'     => false,
            'down'   => false,
            'move'   => false,
            'new'    => false,
            'copy'   => false,
            'delete' => false,
        ],
        'columnsCallback' => [AcrossTablesDcaCallbacks::class, 'columnsSelectCallback'],
    ],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['dma_simplegrid_offsetrightsettings'] = [
    'exclude'   => true,
    'inputType' => 'multiColumnWizard',
    'eval'      => [
        'maxCount'        => 1,
        'buttons'         => [
            'up'     => false,
            'down'   => false,
            'move'   => false,
            'new'    => false,
            'copy'   => false,
            'delete' => false,
        ],
        'columnsCallback' => [AcrossTablesDcaCallbacks::class, 'columnsSelectCallback'],
    ],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['dma_simplegrid_pullsettings'] = [
    'exclude'   => true,
    'inputType' => 'multiColumnWizard',
    'eval'      => [
        'maxCount'        => 1,
        'buttons'         => [
            'up'     => false,
            'down'   => false,
            'move'   => false,
            'new'    => false,
            'copy'   => false,
            'delete' => false,
        ],
        'columnsCallback' => [AcrossTablesDcaCallbacks::class, 'columnsSelectCallback'],
    ],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['dma_simplegrid_pushsettings'] = [
    'exclude'   => true,
    'inputType' => 'multiColumnWizard',
    'eval'      => [
        'maxCount'        => 1,
        'buttons'         => [
            'up'     => false,
            'down'   => false,
            'move'   => false,
            'new'    => false,
            'copy'   => false,
            'delete' => false,
        ],
        'columnsCallback' => [AcrossTablesDcaCallbacks::class, 'columnsSelectCallback'],
    ],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['dma_simplegrid_blocksettings'] = [
    'exclude'   => true,
    'inputType' => 'multiColumnWizard',
    'eval'      => [
        'maxCount'        => 1,
        'buttons'         => [
            'up'     => false,
            'down'   => false,
            'move'   => false,
            'new'    => false,
            'copy'   => false,
            'delete' => false,
        ],
        'columnsCallback' => [AcrossTablesDcaCallbacks::class, 'blockSelectCallback'],
    ],
    'sql'       => "text NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['dma_simplegrid_additionalwrapperclasses'] = [
    'exclude'   => true,
    'inputType' => 'select',
    'eval'      => ['multiple' => true, 'chosen' => true],
    'sql'       => "blob NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['dma_simplegrid_additionalcolumnclasses'] = [
    'exclude'   => true,
    'inputType' => 'select',
    'eval'      => ['multiple' => true, 'chosen' => true],
    'sql'       => "blob NULL",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['dma_simplegrid_additionalrowclasses'] = [
    'exclude'   => true,
    'inputType' => 'select',
    'eval'      => ['multiple' => true, 'chosen' => true],
    'sql'       => "blob NULL",
];
