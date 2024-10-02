<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

declare(strict_types=1);

namespace Tigren\Blog\Block\Adminhtml\Edit\Button;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Back extends Generic implements ButtonProviderInterface
{
    public function getButtonData(): array
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s'", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10,
        ];
    }

    private function getBackUrl(): string
    {
        return $this->getUrl('*/*/');
    }
}
