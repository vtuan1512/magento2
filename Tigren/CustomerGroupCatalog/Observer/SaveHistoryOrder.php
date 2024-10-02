<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2024 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Tigren\CustomerGroupCatalog\Model\ResourceModel\Post\CollectionFactory as CustomerGroupCatalogCollectionFactory;
use Magento\Framework\App\ResourceConnection;
use Tigren\CustomerGroupCatalog\Model\RuleHistoryFactory;
/**
 * Apply order placed
 */
class SaveHistoryOrder implements ObserverInterface
{
    /**
     * @param LoggerInterface $logger
     */
    protected LoggerInterface $logger;

    /**
     * @var CustomerGroupCatalogCollectionFactory
     */
    protected CustomerGroupCatalogCollectionFactory $CollectionFactory;

    /**
     * @var ResourceConnection
     */
    protected ResourceConnection $resourceConnection;
    /**
     * @var RuleHistoryFactory
     */
    protected RuleHistoryFactory $RuleHistoryFactory;

    /**
     * @param LoggerInterface $logger
     * @param CustomerGroupCatalogCollectionFactory $CollectionFactory
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        LoggerInterface                       $logger,
        CustomerGroupCatalogCollectionFactory $CollectionFactory,
        ResourceConnection                    $resourceConnection,
        RuleHistoryFactory                    $RuleHistoryFactory
    )
    {
        $this->logger = $logger;
        $this->CollectionFactory = $CollectionFactory;
        $this->resourceConnection = $resourceConnection;
        $this->RuleHistoryFactory = $RuleHistoryFactory;
    }

    /**
     * @param $order
     * @param $productIds
     * @return void
     */
    protected function getRuleId($order, &$productIds)
    {
        $productIds = [];
        $itemCollection = $order->getAllItems();
        foreach ($itemCollection as $item) {
            $productIds[] = $item->getProductId();
        }
        $customerGroupId = $order->getCustomerGroupId();

        $ruleCollection = $this->CollectionFactory->create();

        $ruleCollection->addFieldToFilter('products', ['finset' => implode(',', $productIds)])
            ->addFieldToFilter('customer_group', ['finset' => $customerGroupId])
            ->addFieldToFilter('start_time', ['lteq' => date('Y-m-d H:i:s')])
            ->addFieldToFilter('end_time', ['gteq' => date('Y-m-d H:i:s')])
            ->addFieldToFilter('active', 1)
            ->setOrder('priority', 'ASC');

        $this->logger->info("Rule Collection Count: " . $ruleCollection->getSize());

        if ($ruleCollection->getSize() > 0) {
            $rule = $ruleCollection->getFirstItem();
            $ruleId = $rule->getId();
            $this->logger->info("Found Rule ID: " . $ruleId);

            $order->setData('rule_id', $ruleId);
            $order->save();

            return $ruleId;
        }

        return null;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $this->logger->info('Observer applied successfully');

        $orderItem = $observer->getEvent()->getOrder();
        $productIds = [];
        $ruleId = $this->getRuleId($orderItem, $productIds);

        if (!$orderItem || !$orderItem->getEntityId()) {
            $this->logger->error("Order object is null or Order ID is invalid.");
            return;
        }
        $customerId = $orderItem->getCustomerId();
        $orderId = $orderItem->getEntityId();

        if (!$orderId) {
            $this->logger->error("Order ID is empty or invalid.");
            return;
        }


        $history = $this->RuleHistoryFactory->create();
        if ($ruleId) {
            $history->load($ruleId);
            $newData = [
                'customer_id' => $customerId,
                'order_id' => $orderId,
                'rule_id' => $ruleId,
                'product_id' => implode(',', $productIds),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $history->addData($newData);
            $history->save();
        }
        $this->logger->error("Failed to save rule history: ");
    }
}
