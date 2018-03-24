<?php

namespace Xuad\BlogBundle\Model;

class NewsArchiveModel
{
    /** @var int */
    private $id;

    /** @var string */
    private $title;

    /** @var string */
    private $alias;

    /** @var int */
    private $numberOfNews;

    /** @var string */
    private $url;

    /** @var bool */
    private $active = false;

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active) : NewsArchiveModel
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlias() : string
    {
        return $this->alias;
    }

    /**
     * @param string $alias
     *
     * @return $this
     */
    public function setAlias(string $alias) : NewsArchiveModel
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId(int $id) : NewsArchiveModel
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title) : NewsArchiveModel
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumberOfNews() : int
    {
        return $this->numberOfNews;
    }

    /**
     * @param int $numberOfNews
     *
     * @return $this
     */
    public function setNumberOfNews(int $numberOfNews) : NewsArchiveModel
    {
        $this->numberOfNews = $numberOfNews;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        return $this->url;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    public function setUrl(string $url) : NewsArchiveModel
    {
        $this->url = $url;

        return $this;
    }
}