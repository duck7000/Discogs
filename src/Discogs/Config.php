<?php

#############################################################################
# CDDB                                 (c)                               Ed #
# written by ed                                                             #
# extended & maintained by Ed                                               #
# ------------------------------------------------------------------------- #
# This program is free software; you can redistribute and/or modify it      #
# under the terms of the GNU General Public License (see doc/LICENSE)       #
#############################################################################

namespace Discogs;

/**
 * Configuration class for Discogs
 * @author Ed
 * @copyright (c) Ed
 */
class Config
{

    /**
     * Discogs domain to use.
     * @var string discogs site
     */
    public $discogsSite = "www.discogs.com";

    /**
     * Set the default user agent (if none is detected)
     * @var string
     */
    public $default_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0';

    /**
     * Search limit, max search results
     * @var int max results
     */
    public $searchLimit = 9;

    /**
     * Search format, CD, LP etc
     * @var string search format
     */
    public $searchFormat = "CD";

}
