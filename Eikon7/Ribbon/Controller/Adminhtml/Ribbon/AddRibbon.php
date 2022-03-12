<?php

namespace Eikon7\Ribbon\Controller\Adminhtml\Ribbon;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Eikon7\Ribbon\Model\RibbonFactory;
use Magento\Framework\Registry;
use Magento\Framework\Controller\ResultFactory;

class AddRibbon extends \Magento\Backend\App\Action
{
    /**
     * @var Registry
     */
    private $coreRegistry;

    /** @var RibbonFactory*/
    private $ribbonFactory;

    /**
     * @param Context $context
     * @param RibbonFactory $ribbonFactory
     * @param Registry $registry
     */
    public function __construct(
        Context $context,
        RibbonFactory $ribbonFactory,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->ribbonFactory = $ribbonFactory;
        $this->coreRegistry = $registry;
    }

    /**
     * @return ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $ribbonId = (int) $this->getRequest()->getParam('id');
        $ribbonData = $this->ribbonFactory->create();
        if ($ribbonId) {
            $ribbonData = $ribbonData->load($ribbonId);
            $ribbonTitle = $ribbonData->getTitle();
            if (!$ribbonData->getEntityId()) {
                $this->messageManager->addErrorMessage(__('row data no longer exist.'));
                $this->_redirect('ribbon/ribbon/rowdata');
            }
        }
        $this->coreRegistry->register('ribbon_data', $ribbonData);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $title = $ribbonId ? __('Edit Ribbon Data ').$ribbonTitle : __('Add Ribbon Data');
        $resultPage->getConfig()->getTitle()->prepend($title);
        return $resultPage;
    }
}
