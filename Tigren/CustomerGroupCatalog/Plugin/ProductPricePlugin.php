<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Plugin;

use Magento\Customer\Model\Session as CustomerSession;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Post\CollectionFactory as CustomerGroupCatalogCollectionFactory;

/**
 *
 */
class ProductPricePlugin
{
    /**
     * @var CustomerSession
     */
    private $_customerSession;

    /**
     * @var CustomerGroupCatalogCollectionFactory
     */
    private $collectionFactory;

    /**
     * @param CustomerSession $customerSession
     * @param CustomerGroupCatalogCollectionFactory $collectionFactory
     */
    public function __construct(
        CustomerSession $customerSession,
        CustomerGroupCatalogCollectionFactory $collectionFactory
    ) {
        $this->_customerSession = $customerSession;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Modify product price after getPrice method
     *
     * @param \Magento\Catalog\Model\Product $subject
     * @param float $result
     * @return float
     */
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        $productId = $subject->getId();

        if ($this->_customerSession->getCustomer()) {
            $customer = $this->_customerSession->getCustomer();
            $customerGroupId = $customer->getGroupId();
        } else {
            $customerGroupId = 0;
        }

        $ruleCollection = $this->collectionFactory->create();
        $ruleCollection->addFieldToFilter('products', ['finset' => $productId])
            ->addFieldToFilter('customer_group', ['finset' => $customerGroupId])
            ->addFieldToFilter('start_time', ['lteq' => date('Y-m-d H:i:s')])
            ->addFieldToFilter('end_time', ['gteq' => date('Y-m-d H:i:s')])
            ->addFieldToFilter('active', 1)
            ->setOrder('priority', 'ASC');

        if ($ruleCollection->getSize()) {
            $discountAmount = $this->calculateDiscount($ruleCollection, $result);
            $discountedPrice = $result - $discountAmount;

            return $discountedPrice;
        }

        return $result;
    }

    /**
     * Calculate discount amount
     *
     * @param $ruleCollection
     * @param $price
     * @return float
     */
    protected function calculateDiscount($ruleCollection, $price)
    {
        $discountPercentage = 0;

        foreach ($ruleCollection as $rule) {
            $discountPercentage = $rule->getDiscountAmount();
            break;
        }

        return ($price * $discountPercentage) / 100;
    }
}
