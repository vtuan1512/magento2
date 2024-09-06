<?php
namespace Tigren\Blog\Model;
class Post extends \Magento\Framework\Model\AbstractModel
{
	protected function _construct()
	{
		$this->_init('Tigren\Blog\Model\ResourceModel\Post');
	}
}
