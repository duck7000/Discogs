<?php
#############################################################################
# CDDB                                                               (c) Ed #
# written by Ed                                                             #
# maintained by Ed                                                          #
#                                                                           #
# ------------------------------------------------------------------------- #
# This program is free software; you can redistribute and/or modify it      #
# under the terms of the GNU General Public License (see doc/LICENSE)       #
#############################################################################

namespace Discogs;

/**
 * A title on Discogs
 * @author Ed
 * @copyright (c) 2005-2023 by ed
 */
class Title extends MdbBase
{

    protected $main = array();
    protected $mainImage = '';
    protected $tracklist = '';
    protected $credits = '';
    protected $barcode = '';
    protected $main_artist = "";
    protected $main_title = "";
    protected $main_year = "";
    protected $main_country = "";
    protected $main_style = "";
    protected $main_genre = "";
    protected $main_label = "";
    protected $main_format = "";
    protected $main_released = "";

    protected $pageUrls = array("Title" => "/");

    /**
     * @param string $url
     * @param Config $config OPTIONAL override default config
     */
    public function __construct(
        $url,
        Config $config = null
    ) {
        parent::__construct($config);
        $this->setPageUrl($url);
    }

    #-------------------------------------------------------------[ Open Page ]---

    protected function buildUrl($page = null)
    {
        return "https://" . $this->discogsSite . $this->pageUrl;
    }

    #---------------------------------------------------------------[ Main ]---
    /**
     * Retrieve main data
     * @return array main
     * @see Discogs page
     */
    protected function main()
    {
        $xpath = $this->getXpathPage("Title");
        if ($xpath->query("//div[@class=\"main_2FbVC\"]//div[@class=\"body_32Bo9\"]")->length != 0) {
            $item = $xpath->query("//div[@class=\"main_2FbVC\"]//div[@class=\"body_32Bo9\"]");
            if ($titleAlbumData = $item->item(0)->getElementsByTagname('h1')->item(0)->textContent) {
                if ($titleAlbumData != '') {
                    $titleAlbum = explode('–', $titleAlbumData); //not a normal dash!
                    $this->main["artist"] = trim(str_replace('*', '', $titleAlbum[0]));
                    if (isset($titleAlbum[1]) && trim($titleAlbum[1]) != '') {
                        $this->main["title"] = trim(str_replace('*', '', $titleAlbum[1]));
                    }
                }
            }
            if ($mainData = $item->item(0)->getElementsByTagname('tr')) {
                foreach ($mainData as $value) {
                    $row = explode(':', $value->textContent, 2);
                    if ($row[0] == 'Released') {
                        if (isset($row[1]) && trim($row[1]) != '') {
                            if (stripos($row[1], ',') !== false) {
                                $temp = explode(',', $row[1]);
                                $this->main["year"] = preg_replace('/[^0-9]+/', '', $temp[1]);
                            } else {
                                $this->main["year"] = preg_replace('/[^0-9]+/', '', $row[1]);
                            }
                        } else {
                            $this->main["year"] = 0;
                        }
                    } else {
                        if (isset($row[1])) {
                            $content = str_replace('& ', '', $row[1]);
                            $content = str_replace(', ', "\n", $content);
                            $this->main[strtolower($row[0])] = trim($content);
                        } else {
                            $this->main[strtolower($row[0])] = '';
                        }
                    }
                }
            }
        }
        return $this->main;
    }

    /** Get cd artist
     * @return string artist cd artist (name)
     * @see Discogs page
     */
    public function artist()
    {
        if ($this->main_artist == "") {
            $this->main();
        }
        return $this->main["artist"];
    }

    /** Get cd title
     * @return string title cd title (name)
     * @see Discogs page
     */
    public function title()
    {
        if ($this->main_title == "") {
            $this->main();
        }
        return $this->main["title"];
    }

    /** Get cd year
     * @return string year cd year (name)
     * @see Discogs page
     */
    public function year()
    {
        if ($this->main_year == "") {
            $this->main();
        }
        return $this->main["year"];
    }

    /** Get cd label
     * @return string label cd label (name)
     * @see Discogs page
     */
    public function label()
    {
        if ($this->main_label == "") {
            $this->main();
        }
        return $this->main["label"];
    }

    /** Get cd country
     * @return string country cd country (name)
     * @see Discogs page
     */
    public function country()
    {
        if ($this->main_country == "") {
            $this->main();
        }
        return $this->main["country"];
    }

    /** Get cd format
     * @return string format cd format (name)
     * @see Discogs page
     */
    public function format()
    {
        if ($this->main_format == "") {
            $this->main();
        }
        return $this->main["format"];
    }

    /** Get cd genre
     * @return string genre cd genre (name)
     * @see Discogs page
     */
    public function genre()
    {
        if ($this->main_genre == "") {
            $this->main();
        }
        return $this->main["genre"];
    }

    /** Get cd style
     * @return string style cd style (name)
     * @see Discogs page
     */
    public function style()
    {
        if ($this->main_style == "") {
            $this->main();
        }
        return $this->main["style"];
    }

    /** Get cd release number
     * @return string released release number from Discogs
     * @see Discogs page
     */
    public function released()
    {
        if ($this->main_released == "") {
            $values = explode('-', $this->pageUrl);
            $release = explode('/', $values[0]);
        }
        return $this->main["released"] = $release[2];
    }

    #---------------------------------------------------------------[ Images ]---
    /**
     * Retrieve front image
     * @return string img url
     * @see Discogs page
     */
    public function photo()
    {
        $xpath = $this->getXpathPage("Title");
        if ($xpath->query("//meta")->length != 0) {
            $items = $xpath->query("//meta");
            foreach ($items as $item) {
                if ($metaProperty = $item->getAttribute('property')) {
                    if ($metaProperty == 'twitter:image:src') {
                        $imgUrl = $item->getAttribute('content');
                        if ($imgUrl != '') {
                            $this->mainImage = $imgUrl;
                        }
                    }
                }
            }
        }
        return $this->mainImage;
    }

    #---------------------------------------------------------------[ Tracklist ]---
    /**
     * Retrieve tracklist data
     * @return string tracklist
     * @see Discogs page
     */
    public function tracklist()
    {
        $xpath = $this->getXpathPage("Title");
        if ($xpath->query("//table[@class=\"tracklist_3QGRS\"]")->length != 0) {
            $rows = $xpath->query("//table[@class=\"tracklist_3QGRS\"]//tr");
            if ($rows->length != 0) {
                $track = '';
                $count2 = count($rows) - 1;
                foreach ($rows as $key2 => $row) {
                    if ($rowTds = $row->getElementsByTagname('td')) {
                        $count = count($rowTds) - 1;
                        foreach ($rowTds as $key => $rowTd) {
                            if (trim($rowTd->textContent) == '' || stripos($rowTd->getAttribute('class'), 'artist_3zAQD') !== false) {
                                continue;
                            }
                            if (stripos($rowTd->getAttribute('class'), 'trackTitle_CTKp4') !== false) {
                                if ($rowTd->getElementsByTagname('span')->length != null) {
                                    $track .= str_replace('-', ' ', $rowTd->getElementsByTagname('span')->item(0)->textContent);
                                    if ($key < $count) {
                                        $track .= ' - ';
                                    }
                                } elseif (stripos($rowTd->textContent, 'bonus') !== false) {
                                    $track .= ' - ' . str_replace('-', ' ', $rowTd->textContent);
                                    if ($key < $count) {
                                        $track .= ' - ' . "\n";
                                    }
                                }
                            } else {
                                if (strpos($rowTd->textContent, '-') !== false) {
                                    $track .= str_replace('-', '_', $rowTd->textContent);
                                } else {
                                    $track .= $rowTd->textContent;
                                }
                                if ($key < $count) {
                                    $track .= ' - ';
                                }
                            }
                        }
                    }
                    if ($rowTd->getElementsByTagname('span')->length != null) {
                        if ($key2 < $count2) {
                            $track .= "\n";
                        }
                    }
                }
            }
        }
        $this->tracklist = $track;
        return $this->tracklist;
    }

    #---------------------------------------------------------------[ Credits ]---
    /**
     * Retrieve credits data
     * @return string credits
     * @see Discogs page
     */
    public function credits()
    {
        $xpath = $this->getXpathPage("Title");
        $credit = '';
        if ($xpath->query("//ul[@class=\"list_1HutQ\"]")->length != 0) {
            $listItems = $xpath->query("//ul[@class=\"list_1HutQ\"]//li");
            if ($listItems->length != 0) {
                $count = count($listItems) - 1;
                foreach ($listItems as $key => $listItem) {
                    $credit .= trim(str_replace('*', '', $listItem->textContent));
                    if ($key < $count) {
                        $credit .= "\n";
                    }
                }
            }
        }
        $this->credits = $credit;
        return $this->credits;
    }

    #---------------------------------------------------------------[ Identifiers ]---
    /**
     * Retrieve barcode data
     * @return string barcode
     * @see Discogs page
     */
    public function barcode()
    {
        $xpath = $this->getXpathPage("Title");
        if ($xpath->query("//ul[@class=\"simple_iPiaF\"]")->length != 0) {
            $listItems = $xpath->query("//ul[@class=\"simple_iPiaF\"]//li");
            if ($listItems->length != 0) {
                foreach ($listItems as $listItem) {
                    if (stripos($listItem->textContent, 'barcode') !== false) {
                        $item = explode(':', $listItem->textContent, 2);
                        if (isset($item[1]) && $item[1] != '') {
                            $this->barcode = preg_replace('/[^0-9.]+/', '', $item[1]);
                            break;
                        }
                    } else {
                        continue;
                    }
                }
            }
        }
        return $this->barcode;
    }

    #========================================================[ Helper functions ]===

    protected function getPage($page = null)
    {
        if (!empty($this->page[$page])) {
            return $this->page[$page];
        }

        $this->page[$page] = parent::getPage($page);

        return $this->page[$page];
    }
}