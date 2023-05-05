<?php
#############################################################################
# PHP CD API                                            (c) Itzchak Rehberg #
# written by Itzchak Rehberg <izzysoft AT qumran DOT org>                   #
# http://www.izzysoft.de/                                                   #
# ------------------------------------------------------------------------- #
# This program is free software; you can redistribute and/or modify it      #
# under the terms of the GNU General Public License (see doc/LICENSE)       #
#############################################################################

namespace Discogs;

/**
 * Accessing CD information
 * @author Georgos Giagas
 * @author Izzy (izzysoft AT qumran DOT org)
 * @author Ed
 * @copyright (c) 2002-2004 by Giorgos Giagas and (c) 2004-2009 by Itzchak Rehberg and IzzySoft
 */
class MdbBase extends Config
{
    public $version = '1.0.0';

    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Pages
     */
    protected $pages;

    protected $page = array();

    protected $xpathPage = array();

    /**
     * @param Config $config OPTIONAL override default config
     */
    public function __construct(Config $config = null)
    {
        $this->config = $config ?: $this;
        $this->pages = new Pages($this->config);
    }

    /**
     * Set page url
     * @param string url pageUrl
     */
    protected function setPageUrl($url)
    {
        $this->pageUrl = $url;
    }

    /**
     * Get a page from Discogs, which will be cached in memory for repeated use
     * @param string $context Name of the page or some other context to build the URL with to retrieve the page
     * @return string
     */
    protected function getPage($context = null)
    {
        return $this->pages->get($this->buildUrl($context));
    }

    /**
     * @param string $page
     * @return \DomXPath
     */
    protected function getXpathPage($page)
    {
        if (!empty($this->xpathPage[$page])) {
            return $this->xpathPage[$page];
        }
        $source = $this->getPage($page);
        libxml_use_internal_errors(true);
        /* Creates a new DomDocument object */
        $dom = new \DomDocument();
        /* Load the HTML */
        $dom->loadHTML('<?xml encoding="utf-8" ?>' .$source);
        /* Create a new XPath object */
        $this->xpathPage[$page] = new \DomXPath($dom);
        return $this->xpathPage[$page];
    }

    /**
     * Overrideable method to build the URL used by getPage
     * @param string $context OPTIONAL
     * @return string
     */
    protected function buildUrl($context = null)
    {
        return '';
    }
}