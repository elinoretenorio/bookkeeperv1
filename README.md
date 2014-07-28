Bookkeeper
==========

This is a mobile-first app (HTML5), but it can also work with 3rd-party barcode scanner (Pic2shop PRO Barcode Scanner) on mobile phones. I created a small API that can be called to track when the ISBN was checked out (or appeared on search) so when a book is scanned/searched through Bookkeeper, it can show stats of the book (along with other info coming from GoodReads and WorldCat API)

Bookkeeper API
==============

Create the activities table by running the activities.sql file in your database. 
To track checkout and searches, use this API with the parameters below:

URL: api.php
HTTP method: GET 

Parameters
isbn: book's isbn (required)
uid: your user's id (required)
type: 1=checkout or 2=search (required)
date: date when the book was checked out or searched (optional - defaults to current date)

3rd-Party APIs
==============

You will need API keys/secrets for the following in order to use this app:

GoodReads
API Doc: https://www.goodreads.com/api#search.books

WorldCat
API Doc: https://platform.worldcat.org/api-explorer/xIDService

Update config.php once you have obtained keys and secrets for both.

Using Barcode Scanner
=====================

This works with Pic2shop PRO Barcode Scanner (https://play.google.com/store/apps/details?id=com.visionsmarts.pic2shoppro&hl=tl) if you want to be able to scan book's barcode instead of typing manually.

Once you install Pic2shop PRO, configure the Settings with the following:

Go to Settings -> Configure URL

Home page URL:
http://example.com/home.php?uid={user id}

Barcode/QR code lookup URL
http://example.com/home.php?uid={user id}&isbn=CODE&format=FORMAT

Replace "example.com" with your own domain URL and "{user id}" with your user's id who is using the Android app

Help/Support
============

Contact me at elinore.tenorio@gmail.com

