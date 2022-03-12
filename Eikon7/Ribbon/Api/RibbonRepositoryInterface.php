<?php

namespace Eikon7\Ribbon\Api;

interface RibbonRepositoryInterface
{
    /**
     * @param Data\RibbonInterface $ribbon
     * @return mixed
     */
    public function save(\Eikon7\Ribbon\Api\Data\RibbonInterface $ribbon);

    /**
     * @return mixed
     */
    public function getById($entityId);

    /**
     * @param $entityId
     * @return mixed
     */
    public function deleteById($entityId);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}
