<?php

namespace Eikon7\Ribbon\Model\ResourceModel;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Eikon7\Ribbon\Model\Ribbon', 'Eikon7\Ribbon\Model\ResourceModel\Ribbon');
    }
}
