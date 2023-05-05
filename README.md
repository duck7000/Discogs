Discogs
=======

PHP library for retrieving CD information from Discogs.
Retrieve most of the information you can see on Discogs
Search for titles on Discogs by barcode, cd code or artist, album etc
Get front poster image url.
Search is intended for CD but can be changed to LP in TitleSearch line 53
For each title found by search there are these methods available:

artist()
title()
year() (release year)
label()
country()
genre()
style()
released() (Discogs release ID)
photo() (Get front image url)
tracklist() (get tracks information, tracknumber, track title, track length)
credits()
barcode()


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
* PHP >= 7.4 (tested with 8.1)
* PHP cURL extension


Configuration
=============

imdbphp needs no configuration by default but user agent can be reconfigured in config.

Searching for a CD
====================

```php
// include "bootstrap.php"; // Load the class in if you're not using an autoloader
$search = new \Imdb\TitleSearch(); // Optional $config parameter
$results = $search->search('The Matrix');

// $results is an array of Titles
// The array will have aritst, title, and Discogsid available
// immediately, but any other data will have to be fetched from IMDb
```
