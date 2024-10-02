<?php
namespace Tigren\CustomerGroupCatalog\Observer;

use AllowDynamicProperties;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Customer\Model\Session as CustomerSession;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Post\CollectionFactory as CustomerGroupCatalogCollectionFactory;
#[AllowDynamicProperties] class Product implements ObserverInterface
{
    /**
     * @var ResourceConnection
     */
    protected $_resourceConnection;
    /**
     * @var CustomerSession
     */
    private $_customerSession;

    /**
     * @param ResourceConnection $resourceConnection
     * @param CustomerSession $customerSession
     * @param CustomerGroupCatalogCollectionFactory $CollectionFactory
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        CustomerSession $customerSession,
        CustomerGroupCatalogCollectionFactory $CollectionFactory,
    ) {
        $this->_resourceConnection = $resourceConnection;
        $this->_customerSession = $customerSession;
        $this->CollectionFactory = $CollectionFactory;
    }

    /**
     * @param EventObserver $observer
     * @return void
     */
    public function execute(EventObserver $observer)
    {
        $collection = $observer->getEvent()->getData('collection');
//        $connection = $this->_resourceConnection->getConnection();
//        $tableName = $connection->getTableName('tigren_rule');

        foreach ($collection as $product) {
            $productId = $product->getId();
            if ($this->_customerSession->getCustomer()) {
                $customer = $this->_customerSession->getCustomer();
                $customerGroupId = $customer->getGroupId();
            } else {
                $customerGroupId = 0;
            }
            $ruleCollection = $this->CollectionFactory->create();
            $ruleCollection->addFieldToFilter('products', ['finset' => $productId])
                ->addFieldToFilter('customer_group', ['finset' => $customerGroupId])
                ->addFieldToFilter('start_time', ['lteq' => date('Y-m-d H:i:s')])
                ->addFieldToFilter('end_time', ['gteq' => date('Y-m-d H:i:s')])
                ->addFieldToFilter('active', 1)
                ->setOrder('priority', 'ASC');
//            $select = $connection->select()
//                ->from($tableName)
//                ->where('products = ?', $productId)
//                ->where('customer_group = ?', $customerGroupId)
//                ->where('start_time <= ?', date('Y-m-d H:i:s'))
//                ->where('end_time >= ?', date('Y-m-d H:i:s'))
//                ->where('active = ?', 1)
//                ->order('priority ASC');
//
//            $ruleData = $connection->fetchRow($select);

            if ($ruleCollection) {
                $discountAmount = $this->calculateDiscount($ruleCollection, $product->getPrice());
                $discountedPrice = $product->getPrice() - $discountAmount;
                $product->setPrice($discountedPrice);
                $product->setFinalPrice($discountedPrice);
            }
        }
    }

    /**
     * @param $ruleCollection
     * @param $price
     * @return float|int
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
