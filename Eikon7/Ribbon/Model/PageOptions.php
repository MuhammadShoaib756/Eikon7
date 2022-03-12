<?php

namespace Eikon7\Ribbon\Model;

use Magento\Framework\Data\OptionSourceInterface;

class PageOptions implements OptionSourceInterface
{

    /**
     * @return array[]
     */
    public function toOptionArray()
    {
       return [
           ['value' => 'all', 'label' => __('All Pages')],
           ['value' => 'home', 'label' => __('Homepage')],
       ];
    }
}
