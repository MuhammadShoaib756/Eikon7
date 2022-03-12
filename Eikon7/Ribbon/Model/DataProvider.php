<?php

namespace Eikon7\Ribbon\Model;

use Eikon7\Ribbon\Model\ResourceModel\CollectionFactory;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    private $ribbonCollection;

    protected $loadedData;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $ribbonCollection
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $ribbonCollection,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->collection = $ribbonCollection->create();
    }

    /**
     * @return array
     */
    public function getData()
    {
        $items = $this->getCollection()->getItems();
        /** @var  $item Ribbon */
        foreach ($items as $item) {
            $item->setFromDate(date('Y/m/d', $item->getFromDate()));
            $item->setToDate(date('Y/m/d', $item->getToDate()));
            $this->loadedData[$item->getEntityId()] = $item->getData();
        }
        return $this->loadedData;
    }
}
