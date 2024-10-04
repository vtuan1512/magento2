<?php
/*
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2022 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 *
 */

namespace Tigren\CustomerGroupCatalog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Customer\Model\SessionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 *
 */
class CustomerID extends Template
{
    /**
     * @var SessionFactory
     */
    protected SessionFactory $customerSessionFactory;

    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productRepository;

    /**
     * @var CustomerRepositoryInterface
     */
    protected CustomerRepositoryInterface $customerRepository;

    /**
     * @var OrderRepositoryInterface
     */
    protected OrderRepositoryInterface $orderRepository;

    /**
     * @param Template\Context $context
     * @param SessionFactory $customerSessionFactory
     * @param ProductRepositoryInterface $productRepository
     * @param CustomerRepositoryInterface $customerRepository
     * @param OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        SessionFactory $customerSessionFactory,
        ProductRepositoryInterface $productRepository,
        CustomerRepositoryInterface $customerRepository,
        OrderRepositoryInterface $orderRepository,
        array $data = []
    ) {
        $this->customerSessionFactory = $customerSessionFactory;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->orderRepository = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * @return int|string
     */
    public function getCustomerId()
    {
        $customerSession = $this->customerSessionFactory->create();
        $customerId = $customerSession->getCustomerId();

        if ($customerId) {
            return $customerId;
        } else {
            return "không tìm thấy ID khách hàng";
        }
    }

    public function getProductRepository()
    {
        return $this->productRepository;
    }

    public function getCustomerRepository()
    {
        return $this->customerRepository;
    }

    public function getOrderRepository()
    {
        return $this->orderRepository;
    }
}
