<?php

declare(strict_types=1);

namespace Eikon7\Ribbon\Api\Data;

interface RibbonInterface
{
    const ENTITY_ID = 'entity_id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const LINK = 'link';
    const BAND_COLOR = 'band_color';
    const FROM_DATE = 'from_date';
    const TO_DATE = 'to_date';
    const PAGES_TO_DISPLAY = 'pages_to_display';

    /**
     * @return mixed
     */
    public function getEntityId();

    /**
     * @param $entityId
     * @return mixed
     */
    public function setEntityId($entityId);

    /**
     * @return mixed
     */
    public function getTitle();

    /**
     * @param $title
     * @return mixed
     */
    public function setTitle($title);

    /**
     * @return mixed
     */
    public function getDescription();

    /**
     * @param $description
     * @return mixed
     */
    public function setDescription($description);

    /**
     * @return mixed
     */
    public function getLink();

    /**
     * @param $link
     * @return mixed
     */
    public function setLink($link);

    /**
     * @return mixed
     */
    public function getBandColor();

    /**
     * @param $bandColor
     * @return mixed
     */
    public function setBandColor($bandColor);

    /**
     * @return mixed
     */
    public function getFromDate();

    /**
     * @param $fromDate
     * @return mixed
     */
    public function setFromDate($fromDate);

    /**
     * @return mixed
     */
    public function getToDate();

    /**
     * @param $toDate
     * @return mixed
     */
    public function setToDate($toDate);

    /**
     * @return mixed
     */
    public function getPagesToDisplay();

    /**
     * @param $pagesToDisplay
     * @return mixed
     */
    public function setPagesToDisplay($pagesToDisplay);
}
