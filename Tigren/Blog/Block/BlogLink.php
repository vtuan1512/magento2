<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\Blog\Block;

use Magento\Framework\View\Element\Html\Link;

class BlogLink extends Link
{
    public function _toHtml()
    {
        $html = '<li
        class="level0 nav-7 category-item last level-top ui-menu-item">';
        $html .=
            '<a href="' . $this->getUrl($this->getPath())
            . '" class="level-top ui-menu-item-wrapper" '
            . $this->getLinkAttributes() . '>';

        $html .= $this->escapeHtml($this->getLabel()) . '</a></li>';
        return $html;
    }
}
