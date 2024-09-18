<?php
namespace Tigren\CustomerGroupCatalog\Observer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Model\Session as CustomerSession;

class Logouthandles implements ObserverInterface
{
    protected $customerSession;
    public function __construct(CustomerSession $customerSession)
    {
        $this->customerSession = $customerSession;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $layout = $observer->getEvent()->getLayout();

        if (!$this->customerSession->isLoggedIn())
        {
            $layout->getUpdate()->addHandle('customer_logged_out');
        }
    }
}
