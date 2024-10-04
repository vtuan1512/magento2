<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Framework\App\Helper\Context
     */

    protected $userContext;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Authorization\Model\UserContextInterface $userContext
    )
    {
        $this->userContext = $userContext;
        parent::__construct($context);
    }

    public function getCustomerId()
    {
        return $this->userContext->getUserId();
    }
}
