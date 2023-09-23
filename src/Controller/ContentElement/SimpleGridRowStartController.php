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

namespace Dma\DmaSimpleGrid\Controller\ContentElement;

use Contao\ArrayUtil;
use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\StringUtil;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(SimpleGridRowStartController::TYPE, category:'dma_simplegrid', template:'ce_dma_simplegrid_rowstart')]
class SimpleGridRowStartController extends AbstractContentElementController
{
    public const TYPE = 'dma_simplegrid_row_start';

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        $arrConfiguredClasses = [];

        if (($GLOBALS['TL_CONFIG']['dmaSimpleGridType'] ?? false) && ($GLOBALS['DMA_SIMPLEGRID_CONFIG'][($GLOBALS['TL_CONFIG']['dmaSimpleGridType'] ?? null)] ?? false)) {
            $arrConfigData = $GLOBALS['DMA_SIMPLEGRID_CONFIG'][$GLOBALS['TL_CONFIG']['dmaSimpleGridType']];
        } else {
            $arrConfigData = $GLOBALS['DMA_SIMPLEGRID_CONFIG'][$GLOBALS['DMA_SIMPLEGRID_CONFIG']['DMA_SIMPLEGRID_FALLBACK']];
        }

        if (($GLOBALS['TL_CONFIG']['dmaSimpleGrid_useBlockGrid'] ?? false) && $model->dma_simplegrid_blocksettings) {
            $arrBlockSettings = StringUtil::deserialize($model->dma_simplegrid_blocksettings, true);

            if (1 === \count($arrBlockSettings)) {
                $arrElementSettings = $arrBlockSettings[0];

                if (\is_array($arrElementSettings)) {
                    foreach ($arrElementSettings as $columnKey => $varValue) {
                        if ($varValue) {
                            $arrConfiguredClasses[] = sprintf($arrConfigData['config']['block-config'][$columnKey]['block-class'], $varValue);
                        }
                    }
                }
            }
        }

        if (($GLOBALS['TL_CONFIG']['dmaSimpleGrid_useAdditionalRowClasses'] ?? false) && $arrConfigData['config']['additional-classes']['row'] && $model->dma_simplegrid_additionalrowclasses) {
            $arrAdditionalClasses = StringUtil::deserialize($model->dma_simplegrid_additionalrowclasses, true);

            if (\count($arrAdditionalClasses) > 0) {
                foreach ($arrAdditionalClasses as $strClassKey) {
                    $arrConfiguredClasses[] = $strClassKey;
                }
            }
        }

        if ($arrConfigData['config']['row-class'] ?? false) {
            ArrayUtil::arrayInsert($arrConfiguredClasses, 0, $arrConfigData['config']['row-class']);
        }

        $strClasses = implode(' ', $arrConfiguredClasses);

        if (str_contains($strClasses, '^')) {
            $strClasses = str_replace(' ^', '', $strClasses);
        }

        $template->class .= ' '.$strClasses;

        return $template->getResponse();
    }
}
