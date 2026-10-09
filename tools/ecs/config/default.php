<?php

declare(strict_types=1);

use Contao\EasyCodingStandard\Set\SetList;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

return ECSConfig::configure()
    ->withSets([SetList::CONTAO])
    ->withPaths([
        __DIR__.'/../../../src',
        __DIR__.'/../../../tests',
    ])
    ->withParallel()
    ->withSpacing(Option::INDENTATION_SPACES, "\n")
    ->withConfiguredRule(HeaderCommentFixer::class, [
        'header' => "This file is part of Dma Simple Grid.\n\n(c) Janosch Oltmanns 2023 <kontakt@janosch-oltmanns.de>\n@license LGPL-3.0+\nFor the full copyright and license information,\nplease view the LICENSE file that was distributed with this source code.\n@link https://github.com/DMAGmbH/dma_simple_grid",
    ])
    ->withCache(sys_get_temp_dir().'/ecs/dma/dma_simple_grid')
;
