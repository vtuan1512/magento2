<?php

namespace Tigren\CustomerGroupCatalog\Plugin;

class Product
{
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        $result = $subject->getData('price');
        return $result + 100;
    }
}
