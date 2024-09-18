<?php
namespace Tigren\CustomerGroupCatalog\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Quote\Model\Quote\Item;

class CustomPriceInCart implements ObserverInterface
{
    protected ResourceConnection $_resourceConnection;

    public function __construct(
        ResourceConnection $resourceConnection
    ) {
        $this->_resourceConnection = $resourceConnection;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var Item $item */
        $item = $observer->getEvent()->getData('quote_item');
        $item = $item->getParentItem() ? $item->getParentItem() : $item;

        $connection = $this->_resourceConnection->getConnection();
        $tableName = $connection->getTableName('tigren_rule');

        $select = $connection->select()
            ->from($tableName)
            ->where('products = ?', $item->getProductId())
            ->where('customer_group = ?', $item->getQuote()->getCustomerGroupId())
            ->where('start_time <= ?', date('Y-m-d H:i:s'))
            ->where('end_time >= ?', date('Y-m-d H:i:s'))
            ->where('active = ?', 1)
            ->order('priority ASC');

        $ruleData = $connection->fetchRow($select);

        if ($ruleData) {
            if ($this->checkRuleApplicability($ruleData, $item)) {
                $discountAmount = $this->calculateDiscount($ruleData, $item->getPrice());
                $discountedPrice = $item->getPrice() - $discountAmount;
                $item->setCustomPrice($discountedPrice);
                $item->setOriginalCustomPrice($discountedPrice);
                $item->getProduct()->setIsSuperMode(true);
            }
        }
    }

    protected function checkRuleApplicability($ruleData, $item)
    {
        return true;
    }

    protected function calculateDiscount($ruleData, $price)
    {
        $discountPercentage = isset($ruleData['discount_amount']) ? $ruleData['discount_amount'] : 0;
        return ($price * $discountPercentage) / 100; // Calculate discount as percentage of original price
    }
}
