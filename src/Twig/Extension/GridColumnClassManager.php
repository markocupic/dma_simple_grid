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

namespace Dma\DmaSimpleGrid\Twig\Extension;

use Contao\CoreBundle\Routing\ScopeMatcher;
use Dma\DmaSimpleGrid\DataContainer\DcaUtil;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GridColumnClassManager extends AbstractExtension
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly ScopeMatcher $scopeMatcher,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_dma_grid_classes', [$this, 'getDmaGridClasses'], ['needs_context' => true]),
        ];
    }

    /**
     * Append the additional grid classes, that have been set in the content element.
     */
    public function getDmaGridClasses(array $_context): string
    {
        $origElementCssClasses = $_context['element_css_classes'] ?? '';

        $request = $this->requestStack->getCurrentRequest();

        if (!$this->scopeMatcher->isFrontendRequest($request)) {
            return $origElementCssClasses;
        }

        $rowContentElement = $_context['data'] ?? [];

        if (!DcaUtil::hasDmaGridInfos($rowContentElement)) {
            return $origElementCssClasses;
        }

        $arrElementCssClasses = array_merge(explode(' ', $origElementCssClasses), explode(' ', DcaUtil::getColumnClasses($rowContentElement)));

        return implode(' ', array_filter(array_unique($arrElementCssClasses)));
    }
}
