<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\Session as CustomerSession;

/**
 *
 */
class CustomerID extends Template
{
    /**
     * @var CustomerSession
     */
    protected CustomerSession $customerSession;

    /**
     * @param Template\Context $context
     * @param CustomerSession $customerSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        CustomerSession $customerSession,
        array $data = []
    ) {
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        $isLoggedIn = $this->customerSession->isLoggedIn();
        $customerId = $this->customerSession->getCustomerId();

        // In ra thông tin debug
        error_log("Is Logged In: " . ($isLoggedIn ? "Yes" : "No"));
        error_log("Customer ID: " . $customerId);

        if ($isLoggedIn) {
            return $customerId;
        } else {
            return "Khách hàng chưa đăng nhập.";
        }
    }

}
