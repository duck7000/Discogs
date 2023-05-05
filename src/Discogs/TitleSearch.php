<?php

namespace Discogs;

class TitleSearch extends MdbBase
{

    /**
     * Search Discogs for titles matching $searchTerms
     * @param string $searchTerms
     * @return Title[] array of Titles
     */
    public function search($searchTerms)
    {
        $results = array();
        $page = $this->getXpathPage($searchTerms);
        if ($page != "") {
            if ($listItem = $page->query("//ul[@id=\"search_results\"]//li")) {
                foreach ($listItem as $key => $match) {
                    $url = '';
                    $artist = '';
                    $album = '';
                    $released = '';
                    if ($match->getElementsByTagName('a')->length > 0) {
                        if ($match->getElementsByTagName('a')->item(1) != null) {
                            $url = $match->getElementsByTagName('a')->item(1)->getAttribute('href');
                            $album = $match->getElementsByTagName('a')->item(1)->nodeValue;
                            $values = explode('-', $url);
                            $released = explode('/', $values[0]);
                        }
                        if ($match->getElementsByTagName('a')->item(2) != null) {
                            $artist = $match->getElementsByTagName('a')->item(2)->nodeValue;
                        }
                    }
                    $results[] = array(
                            'artist' => $artist,
                            'album' => $album,
                            'released' => $released[2],
                            'url' => $url
                        );
                    if ($key === 9) {
                        break;
                    }
                }
                return $results;
            }
        }
    }

    protected function buildUrl($searchTerms = null)
    {
        return "https://www.discogs.com/search/?q=" . urlencode($searchTerms) . "&type=release&format_exact=CD";
    }
}