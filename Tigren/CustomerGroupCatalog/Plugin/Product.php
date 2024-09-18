<?php

namespace Tigren\CustomerGroupCatalog\Plugin;

use Magento\Tests\NamingConvention\true\float;

class Product
{
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result) :float
    {
        $result = $subject->getData('price');
        return $result + 100;
    }
}
