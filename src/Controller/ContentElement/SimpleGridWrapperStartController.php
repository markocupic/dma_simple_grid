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

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\StringUtil;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(SimpleGridWrapperStartController::TYPE, category:'dma_simplegrid', template:'ce_dma_simplegrid_wrapperstart')]
class SimpleGridWrapperStartController extends AbstractContentElementController
{
    public const TYPE = 'dma_simplegrid_wrapper_start';

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        $strAdditionalClasses = '';

        if (($GLOBALS['TL_CONFIG']['dmaSimpleGridType'] ?? false) && ($GLOBALS['DMA_SIMPLEGRID_CONFIG'][($GLOBALS['TL_CONFIG']['dmaSimpleGridType'] ?? null)] ?? false)) {
            $arrConfigData = $GLOBALS['DMA_SIMPLEGRID_CONFIG'][$GLOBALS['TL_CONFIG']['dmaSimpleGridType']];
        } else {
            $arrConfigData = $GLOBALS['DMA_SIMPLEGRID_CONFIG'][$GLOBALS['DMA_SIMPLEGRID_CONFIG']['DMA_SIMPLEGRID_FALLBACK']];
        }

        if (($GLOBALS['TL_CONFIG']['dmaSimpleGrid_useAdditionalWrapperClasses'] ?? false) && $arrConfigData['config']['additional-classes']['wrapper'] && $model->dma_simplegrid_additionalwrapperclasses) {
            $arrAdditionalClasses = StringUtil::deserialize($model->dma_simplegrid_additionalwrapperclasses, true);

            if (\count($arrAdditionalClasses) > 0) {
                foreach ($arrAdditionalClasses as $strClassKey) {
                    $strAdditionalClasses .= ' '.$strClassKey;
                }
            }
        }

        $template->class = 'wrapper '.$arrConfigData['config']['wrapper-class'].$strAdditionalClasses;

        return $template->getResponse();
    }
}
