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

namespace Dma\DmaSimpleGrid\EventListener\ContaoHook;

use Contao\ContentModel;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\CoreBundle\Routing\ScopeMatcher;
use Dma\DmaSimpleGrid\DataContainer\DcaUtil;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsHook('getContentElement', priority: 100)]
class GetContentElementListener
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly ScopeMatcher $scopeMatcher,
    ) {
    }

    /**
     * Because Contao 5 modern TWIG content element templates will not be affected by the "parseFrontendTemplate" hook,
     * additional column classes has to be injected by parsing the output buffer of the content element.
     *
     * @param $element
     */
    public function __invoke(ContentModel $contentModel, string $buffer, $element): string
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!$this->scopeMatcher->isFrontendRequest($request)) {
            return $buffer;
        }

        $dataContentElement = $contentModel->row();

        if (!DcaUtil::hasDmaGridInfos($dataContentElement)) {
            return $buffer;
        }

        $strMoreClasses = DcaUtil::getColumnClasses($dataContentElement);

        if (empty($strMoreClasses)) {
            return $buffer;
        }

        // Append the column classes to the class attribute
        return preg_replace_callback(
            '#<([a-zA-Z0-9]+)(\s[^>]*?)?(?<!/)>#',
            static function ($matches) use ($strMoreClasses) {
                $tag = $matches[1];
                $attr = $matches[2];

                if (!preg_match('#class="([^"]+)"#', $attr, $strClasses) || !str_contains($strClasses[1],'content-')) {
                    return "<{$tag}{$attr}>";
                }

                $strClasses = implode(' ', array_filter(array_unique(explode(' ', $strClasses[1].' '.$strMoreClasses))));

                $attr = preg_replace('#class="([^"]+)"#', 'class="'.$strClasses.'"', $attr, 1, $count);

                return "<{$tag}{$attr}>";
            },
            $buffer,
            1
        );
    }
}
