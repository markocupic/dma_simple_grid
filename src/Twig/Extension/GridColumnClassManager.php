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

use Contao\CoreBundle\Framework\Adapter;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Dma\DmaSimpleGrid\DataContainer\DcaUtil;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class GridColumnClassManager extends AbstractExtension
{
    private Adapter $member;

    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly ScopeMatcher $scopeMatcher,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('get_dma_grid_classes', [$this, 'getDmaGridClasses']),
        ];
    }

    /**
     * Append the additional grid classes that have been set in the content element.
     */
    public function getDmaGridClasses(array $dataTemplate): string
    {
        $origClasses = $dataTemplate['element_css_classes'] ?? '';

        $request = $this->requestStack->getCurrentRequest();

        if (!$this->scopeMatcher->isFrontendRequest($request)) {
            return $origClasses;
        }

        $dataContentElement = $dataTemplate['data'] ?? [];

        if (!DcaUtil::hasDmaGridInfos($dataContentElement)) {
            return $origClasses;
        }

        $arrClasses = array_merge(explode(' ', $origClasses), explode(' ', DcaUtil::getColumnClasses($dataContentElement)));

        return implode(' ', array_filter(array_unique($arrClasses)));
    }
}
