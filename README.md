Discogs
=======

PHP library for retrieving CD information from Discogs.<br>
Retrieve most of the information you can see on Discogs page of specific CD.<br>
Search for titles on Discogs by barcode, cd code, artist, album etc.<br>
Get front poster image url.<br>
Search is default for CD.<br>
For each title found by search there are these methods available:<br>

artist()<br>
title()<br>
year() (release year)<br>
label()<br>
country() (release country)<br>
genre()<br>
style()<br>
released() (Discogs release ID)<br>
photo() (front image url)<br>
tracklist() (get track information, tracknumber, track title, track length)<br>
credits()<br>
barcode()<br>
format()<br>


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

This library scrapes discogs.com so changes to their site can cause parts of this library to fail.

Get the files with one of:
* [Composer](https://www.getcomposer.org)
* Git clone. Checkout the latest release tag.
* [Zip/Tar download]

### Requirements
* PHP >= 7.4 - 8.1
* PHP cURL extension


Configuration
=============

DiscogsPHP needs no configuration but there are some options in config:

Default user agent
Default search: CD (this can be LP, cassette etc)
Default search limit: 10


Searching for a CD
====================

```php
// include "bootstrap.php"; // Load the class in if you're not using an autoloader
$search = new \Discogs\TitleSearch();
$results = $search->search('Batmobile');

// $results is an array of Titles
// The array will have artist, title, and Discogsid. And a link to the discogs page.
```
Credits to imdbphp, i used their search part to make this.
