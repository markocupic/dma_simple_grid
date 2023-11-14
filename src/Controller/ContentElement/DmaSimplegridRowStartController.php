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
use Contao\CoreBundle\Routing\ScopeMatcher;
use Contao\StringUtil;
use Contao\System;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(DmaSimplegridRowStartController::TYPE, category:'dma_simplegrid', template:'ce_dma_simplegrid_row_start')]
class DmaSimplegridRowStartController extends AbstractContentElementController
{
    public const TYPE = 'dma_simplegrid_row_start';

    public function __construct(private readonly ScopeMatcher $scopeMatcher)
    {
    }

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        if ($this->scopeMatcher->isBackendRequest($request)) {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        $arrClasses = explode(' ', $template->class);

        if (($GLOBALS['TL_CONFIG']['dmaSimpleGridType'] ?? false) && ($GLOBALS['DMA_SIMPLEGRID_CONFIG'][$GLOBALS['TL_CONFIG']['dmaSimpleGridType']] ?? false)) {
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
                            $arrClasses[] = sprintf($arrConfigData['config']['block-config'][$columnKey]['block-class'], $varValue);
                        }
                    }
                }
            }
        }

        if (($GLOBALS['TL_CONFIG']['dmaSimpleGrid_useAdditionalRowClasses'] ?? false) && !empty($arrConfigData['config']['additional-classes']['row']) && $model->dma_simplegrid_additionalrowclasses) {
            $arrAdditionalClasses = StringUtil::deserialize($model->dma_simplegrid_additionalrowclasses, true);
            $arrClasses = array_merge($arrClasses, $arrAdditionalClasses);
        }

        if (!empty($arrConfigData['config']['row-class'])) {
            $arrClasses = array_merge($arrClasses, explode(' ', (string) $arrConfigData['config']['row-class']));
        }

        $arrClasses = array_map(
            static fn ($strClass) => str_replace('^', '', $strClass), // gridlex
            $arrClasses,
        );

        $arrClasses = array_unique(array_filter($arrClasses));

        $template->class = implode(' ', $arrClasses);

        return $template->getResponse();
    }
}
