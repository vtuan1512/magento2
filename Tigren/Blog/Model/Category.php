<?php
namespace Tigren\Blog\Model;
class Category extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('Tigren\Blog\Model\ResourceModel\Category');
    }
}
