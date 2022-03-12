<?php

namespace Eikon7\Ribbon\Model\Repository;

use Eikon7\Ribbon\Api\Data\RibbonInterface;
use Eikon7\Ribbon\Api\RibbonRepositoryInterface;
use Eikon7\Ribbon\Model\RibbonFactory;
use Eikon7\Ribbon\Model\ResourceModel\Ribbon as RibbonResourceModel;
use Magento\Framework\Api\Search\FilterGroup;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Ui\Api\Data\BookmarkSearchResultsInterfaceFactory;
use Eikon7\Ribbon\Model\ResourceModel\CollectionFactory as RibbonCollectionFactory;
use Eikon7\Ribbon\Model\ResourceModel\Collection;

class RibbonRepository implements RibbonRepositoryInterface
{
    /**
     * @var RibbonResourceModel
     */
    protected $ribbonResource;

    /**
     * @var RibbonFactory
     */
    protected $ribbonFactory;
    /**
     * @var BookmarkSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    /**
     * @var RibbonCollectionFactory
     */
    private $ribbonCollectionFactory;

    /**
     * @param RibbonResourceModel $ribbonResource
     * @param RibbonFactory $ribbonFactory
     * @param RibbonCollectionFactory $ribbonCollectionFactory
     */
    public function __construct(
        RibbonResourceModel $ribbonResource,
        RibbonFactory $ribbonFactory,
        RibbonCollectionFactory $ribbonCollectionFactory,
        BookmarkSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->ribbonResource = $ribbonResource;
        $this->ribbonFactory = $ribbonFactory;
        $this->ribbonCollectionFactory = $ribbonCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @param RibbonInterface $ribbon
     * @return mixed|void
     * @throws CouldNotSaveException
     */
    public function save(RibbonInterface $ribbon)
    {
        try {
            $this->ribbonResource->save($ribbon);
        } catch (\Exception $e) {
            if ($ribbon->getEntityId()) {
                throw new CouldNotSaveException(
                    __(
                        'Unable to save Ribbon record with entity ID %1. Error: %2',
                        [$ribbon->getEntityId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to save new Ribbon record. Error: %1', $e->getMessage()));
        }
    }

    /**
     * @param $entityId
     * @return mixed|void
     * @throws CouldNotSaveException
     */
    public function getById($entityId)
    {
        $ribbon = $this->ribbonFactory->create();
        try {
            $this->ribbonResource->load($ribbon, $entityId);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__('Ribbon with specified ID "%1" not found.', $entityId));
        }
        return $ribbon;
    }

    /**
     * @param $entityId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws CouldNotSaveException
     */
    public function deleteById($entityId)
    {
        $ribbon = $this->getById($entityId);
        try {
            $this->ribbonResource->delete($ribbon);
        } catch (\Exception $e) {
            if ($ribbon->getEntityId()) {
                throw new CouldNotDeleteException(
                    __(
                        'Unable to remove Ribbon Record with ID %1. Error: %2',
                        [$ribbon->getEntityId(), $e->getMessage()]
                    )
                );
            }
            throw new CouldNotSaveException(__('Unable to remove Ribbon Record.
             Error: %1', $e->getMessage()));
        }
        return true;
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        /** @var  $collection Collection */
        $collection = $this->ribbonCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $group) {
            $this->addFilterGroupToCollection($group, $collection);
        }
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            $this->addOrderToCollection($sortOrders, $collection);
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * @param FilterGroup $filterGroup
     * @param Collection $collection
     * @return void
     */
    private function addFilterGroupToCollection(FilterGroup $filterGroup, Collection $collection)
    {
        foreach ($filterGroup->getFilters() as $filter) {
            $condition = $filter->getConditionType() ?: 'eq';
            $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
        }
    }

    /**
     * @param $sortOrders
     * @param Collection $collection
     * @return void
     */
    private function addOrderToCollection($sortOrders, Collection $collection)
    {
        /** @var SortOrder $sortOrder */
        foreach ($sortOrders as $sortOrder) {
            $field = $sortOrder->getField();
            $collection->addOrder(
                $field,
                ($sortOrder->getDirection() == SortOrder::SORT_DESC) ? SortOrder::SORT_DESC : SortOrder::SORT_ASC
            );
        }
    }
}
