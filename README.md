Discogs
=======

PHP library for retrieving CD information from Discogs.<br>
Retrieve most of the information you can see on Discogs.<br>
Search for titles on Discogs by barcode, cd code or artist, album etc.<br>
Get front poster image url.<br>
Search is default for CD.<br>
For each title found by search there are these methods available:<br>

artist()<br>
title()<br>
year() (release year)<br>
label()<br>
country()<br>
genre()<br>
style()<br>
released() (Discogs release ID)<br>
photo() (Get front image url)<br>
tracklist() (get tracks information, tracknumber, track title, track length)<br>
credits()<br>
barcode()<br>


Quick Start
===========

* If you're not using composer or an autoloader include `bootstrap.php`.
* Get some data
```php
$title = new \Discogs\Title($searchTerm);
$artist = $title->artist();
$albumTitle = $title->title();


Installation
============

This library scrapes discogs.com so changes their site can cause parts of this library to fail.

Get the files with one of:
* [Composer](https://www.getcomposer.org)
* Git clone. Checkout the latest release tag.
* [Zip/Tar download]

### Requirements
* PHP >= 7.4 - 8.1
* PHP cURL extension


Configuration
=============

DiscogsPHP needs no configuration but a few things can be changed:<br>
user agent can be reconfigured in config.<br>
Search is default CD, can be configured in config.<br>
Search Limit default = 10, can be configured in config


Searching for a CD
====================

```php
// include "bootstrap.php"; // Load the class in if you're not using an autoloader
$search = new \Discogs\TitleSearch();
$results = $search->search('The Matrix');

// $results is an array of Titles
// The array will have artist, title, and Discogsid. And a link to the discogs page.
```
Credits to imdbphp, i used their search part to make this.
