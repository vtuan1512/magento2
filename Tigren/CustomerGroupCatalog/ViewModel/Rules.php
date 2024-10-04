<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

declare(strict_types=1);

namespace Tigren\CustomerGroupCatalog\ViewModel;

use Tigren\CustomerGroupCatalog\Model\ResourceModel\Post\Collection;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Tigren\CustomerGroupCatalog\Service\RulesProvider;


class Rules implements ArgumentInterface
{
    public function __construct(
        private RulesProvider $rulesProvider,

    ) {}

    public function getPosts(): Collection
    {
        return $this->rulesProvider->getPosts();
    }


}
