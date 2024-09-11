<?php
namespace Tigren\Faq\Model;
class Post extends \Magento\Framework\Model\AbstractModel
{
	protected function _construct()
	{
		$this->_init('Tigren\Faq\Model\ResourceModel\Post');
	}
}
