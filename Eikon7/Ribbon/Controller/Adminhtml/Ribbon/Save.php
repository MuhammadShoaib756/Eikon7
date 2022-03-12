<?php

namespace Eikon7\Ribbon\Controller\Adminhtml\Ribbon;

use Eikon7\Ribbon\Api\Data\RibbonInterfaceFactory;
use Eikon7\Ribbon\Api\Data\RibbonInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Eikon7\Ribbon\Api\RibbonRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Stdlib\DateTime\DateTime;

class Save extends Action
{
    /**
     * @var RibbonInterfaceFactory
     */
    protected $ribbonFactory;

    /**
     * @var RibbonRepositoryInterface
     */
    protected $ribbonRepositoryInterface;

    /**
     * Setup model
     *
     * @var ModuleDataSetupInterface
     */
    private $setup;

    /**
     * @var DateTime
     */
    protected $dateTime;

    /**
     * @param Context $context
     * @param RibbonInterfaceFactory $ribbonFactory
     * @param RibbonRepositoryInterface $ribbonRepositoryInterface
     * @param DateTime $dateTime
     * @param ModuleDataSetupInterface $setup
     */
    public function __construct(
        Context $context,
        RibbonInterfaceFactory $ribbonFactory,
        RibbonRepositoryInterface $ribbonRepositoryInterface,
        DateTime $dateTime,
        ModuleDataSetupInterface $setup
    ) {
        parent::__construct($context);
        $this->ribbonFactory = $ribbonFactory;
        $this->ribbonRepositoryInterface = $ribbonRepositoryInterface;
        $this->dateTime = $dateTime;
        $this->setup = $setup;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\Result\Redirect|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $postFormData = (object) $this->getRequest()->getParams();
        if ($postFormData->entity_id != null) {
            try {
                /** @var  $ribbon RibbonInterface */
                $ribbon = $this->ribbonRepositoryInterface->getById($postFormData->entity_id);
                $ribbon->setTitle($postFormData->title);
                $ribbon->setDescription($postFormData->description);
                $ribbon->setLink($postFormData->link);
                $ribbon->setBandColor($postFormData->band_color);
                $ribbon->setFromDate(strtotime($postFormData->from_date));
                $ribbon->setToDate(strtotime($postFormData->to_date));
                $ribbon->setPagesToDisplay($postFormData->pages_to_display);
                $this->validateRibbon($ribbon);
                $this->ribbonRepositoryInterface->save($ribbon);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e);
            }
        } else {
            try {
                /** @var  $ribbon RibbonInterface */
                $ribbon = $this->ribbonFactory->create();
                $ribbon->setTitle($postFormData->title);
                $ribbon->setDescription($postFormData->description);
                $ribbon->setLink($postFormData->link);
                $ribbon->setBandColor($postFormData->band_color);
                $ribbon->setFromDate(strtotime($postFormData->from_date));
                $ribbon->setToDate(strtotime($postFormData->to_date));
                $ribbon->setPagesToDisplay($postFormData->pages_to_display);
                $this->validateRibbon($ribbon);
                $this->ribbonRepositoryInterface->save($ribbon);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e);
            }
        }
        $redirect = $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_REDIRECT);
        $redirect->setPath('*/*/index');
        return $redirect;
    }

    /**
     * @param $ribbon
     * @return array|null
     * @throws CouldNotSaveException
     */
    public function validateRibbon($ribbon) {
        $select = $this->setup->getConnection()->select();
        $select->from('eikon7_page_ribbon_record')
            ->where(new \Zend_Db_Expr('from_date <= ' . $ribbon->getFromDate() . ' AND to_date >=' . $ribbon->getFromDate() .
                ' OR (from_date <= ' . $ribbon->getToDate() .' AND to_date >= ' . $ribbon->getToDate() . ')' ));
        $result = $this->setup->getConnection()->fetchAll($select);
        if ($result) {
            throw new CouldNotSaveException(
                __('Unable to save new Ribbon record because ribbon with the same time interval is already saved!')
            );
        }
        return $result;
    }
}
