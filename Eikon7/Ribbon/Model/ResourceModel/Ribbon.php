<?php

namespace Eikon7\Ribbon\Model\ResourceModel;

class Ribbon extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('eikon7_page_ribbon_record', 'entity_id');
    }
}
