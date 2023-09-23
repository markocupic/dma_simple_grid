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
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(SimpleGridRowStopController::TYPE, category:'dma_simplegrid', template:'ce_dma_simplegrid_rowstop')]
class SimpleGridRowStopController extends AbstractContentElementController
{
    public const TYPE = 'dma_simplegrid_row_stop';

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        return $template->getResponse();
    }
}
