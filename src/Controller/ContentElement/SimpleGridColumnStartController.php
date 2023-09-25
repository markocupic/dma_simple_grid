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
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(SimpleGridColumnStartController::TYPE, category:'dma_simplegrid', template:'ce_dma_simplegrid_columnstart')]
class SimpleGridColumnStartController extends AbstractContentElementController
{
    public const TYPE = 'dma_simplegrid_column_start';

    public function __construct(private readonly ScopeMatcher $scopeMatcher)
    {}

    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        if($this->scopeMatcher->isBackendRequest($request))
        {
            return new Response('', Response::HTTP_NO_CONTENT);
        }

        $arrClasses = explode(' ', $template->class.' column');
        $arrClasses = array_unique(array_filter($arrClasses));

        $template->class = implode(' ', $arrClasses);

        return $template->getResponse();
    }
}
