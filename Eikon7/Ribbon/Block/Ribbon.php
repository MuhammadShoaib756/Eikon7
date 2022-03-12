<?php

namespace Eikon7\Ribbon\Block;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Eikon7\Ribbon\Api\RibbonRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Eikon7\Ribbon\Api\Data\RibbonInterface;

class Ribbon extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var RibbonRepositoryInterface
     */
    protected $ribbonRepositoryInterface;

    /**
     * @var SearchCriteriaInterface
     */
    protected $searchCriteriaInterface;

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @var FilterBuilder
     */
    protected $filterBuilder;

    /**
     * @var FilterGroupBuilder
     */
    protected $filterGroupBuilder;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param Template\Context $context
     * @param \Magento\Framework\App\Request\Http $request
     * @param RibbonRepositoryInterface $ribbonRepositoryInterface
     * @param SearchCriteriaInterface $searchCriteriaInterface
     * @param FilterBuilder $filterBuilder
     * @param DateTime $dateTime
     * @param FilterGroupBuilder $filterGroupBuilder
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Magento\Framework\App\Request\Http $request,
        RibbonRepositoryInterface $ribbonRepositoryInterface,
        SearchCriteriaInterface $searchCriteriaInterface,
        FilterBuilder $filterBuilder,
        DateTime $dateTime,
        FilterGroupBuilder $filterGroupBuilder,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->request = $request;
        $this->ribbonRepositoryInterface = $ribbonRepositoryInterface;
        $this->searchCriteriaInterface = $searchCriteriaInterface;
        $this->filterBuilder = $filterBuilder;
        $this->dateTime = $dateTime;
        $this->filterGroupBuilder = $filterGroupBuilder;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @return bool
     */
    public function isHomePage()
    {
        if ($this->request->getFullActionName() == 'cms_index_index') {
            return true;
        }
        return false;
    }

    /**
     * @return \Eikon7\Ribbon\Model\Ribbon|false
     */
    public function getActiveRibbon()
    {
        $currentDate = strtotime($this->dateTime->gmtDate('Y-m-d'));
        $fromDateFilter = $this->filterBuilder
            ->setField(RibbonInterface::FROM_DATE)
            ->setValue($currentDate)
            ->setConditionType('lteq')
            ->create();
        $toDateFilter = $this->filterBuilder
            ->setField(RibbonInterface::TO_DATE)
            ->setValue($currentDate)
            ->setConditionType('gteq')
            ->create();
        $fromFilterGroup = $this->filterGroupBuilder
            ->addFilter($fromDateFilter)
            ->create();
        $toFilterGroup = $this->filterGroupBuilder
            ->addFilter($toDateFilter)
            ->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->setFilterGroups([$fromFilterGroup, $toFilterGroup])
            ->create();
        $ribbonList = $this->ribbonRepositoryInterface->getList($searchCriteria);
        /** @var \Eikon7\Ribbon\Model\Ribbon $activeRibbon */
        $activeRibbon = current($ribbonList->getItems());

        if($activeRibbon->getPagesToDisplay() == 'all') {
            return $activeRibbon;
        } elseif ($this->isHomePage()) {
            return $activeRibbon;
        }
        return false;
    }
}
