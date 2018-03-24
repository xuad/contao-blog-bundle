<?php

namespace Xuad\BlogBundle\EventListener;

use Contao\Backend;
use Contao\DataContainer;
use Xuad\BlogBundle\Service\NewsArchiveBackendService;

class NewsArchiveListener extends Backend
{
    /** @var NewsArchiveBackendService */
    private $newsArchiveBackendService;

    /**
     * NewsArchiveListener constructor.
     *
     * @param NewsArchiveBackendService $newsArchiveBackendService
     */
    public function __construct(NewsArchiveBackendService $newsArchiveBackendService)
    {
        parent::__construct();

        $this->newsArchiveBackendService = $newsArchiveBackendService;
        $this->import('BackendUser', 'User');
    }

    /**
     * @param $value
     * @param DataContainer $dataContainer
     *
     * @return string
     */
    public function onSaveArchive($value, DataContainer $dataContainer) : string
    {
        return $this->newsArchiveBackendService->getNewAliasByValueAndDataContainer($value, $dataContainer);
    }
}