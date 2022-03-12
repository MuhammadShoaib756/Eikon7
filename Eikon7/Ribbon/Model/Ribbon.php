<?php

namespace Eikon7\Ribbon\Model;

use Eikon7\Ribbon\Api\Data\RibbonInterface;
use Magento\Framework\Model\AbstractModel;

class Ribbon extends AbstractModel implements RibbonInterface
{
    /**
     * Ribbon cache tag.
     */
    const CACHE_TAG = 'eikon7_page_ribbon_record';

    /**
     * @inheritdoc
     */
    protected $_cacheTag = 'eikon7_page_ribbon_record';

    /**
     * @inheritdoc
     */
    protected $_eventPrefix = 'eikon7_ribbon_records';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('Eikon7\Ribbon\Model\ResourceModel\Ribbon');
    }

    /**
     * @inheritdoc
     */
    public function getEntityId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * @inheritdoc
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritdoc
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritdoc
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritdoc
     */
    public function getLink()
    {
        return $this->getData(self::LINK);
    }

    /**
     * @inheritdoc
     */
    public function setLink($link)
    {
        return $this->setData(self::LINK, $link);
    }

    /**
     * @inheritdoc
     */
    public function getBandColor()
    {
        return $this->getData(self::BAND_COLOR);
    }

    /**
     * @inheritdoc
     */
    public function setBandColor($bandColor)
    {
        return $this->setData(self::BAND_COLOR, $bandColor);
    }

    /**
     * @inheritdoc
     */
    public function getFromDate()
    {
        return $this->getData(self::FROM_DATE);
    }

    /**
     * @inheritdoc
     */
    public function setFromDate($fromDate)
    {
        return $this->setData(self::FROM_DATE, $fromDate);
    }

    /**
     * @inheritdoc
     */
    public function getToDate()
    {
        return $this->getData(self::TO_DATE);
    }

    /**
     * @inheritdoc
     */
    public function setToDate($toDate)
    {
        return $this->setData(self::TO_DATE, $toDate);
    }

    /**
     * @inheritdoc
     */
    public function getPagesToDisplay()
    {
        return $this->getData(self::PAGES_TO_DISPLAY);
    }

    /**
     * @inheritdoc
     */
    public function setPagesToDisplay($pagesToDisplay)
    {
        return $this->setData(self::PAGES_TO_DISPLAY, $pagesToDisplay);
    }
}
