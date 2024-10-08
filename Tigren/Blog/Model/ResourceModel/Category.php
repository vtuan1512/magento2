<?php
namespace Tigren\Blog\Model\ResourceModel;


class Category extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('blog_category', 'cate_id');
    }

}
