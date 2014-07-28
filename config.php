<?php
$config = array(
	'title' => 'Bookkeeper App',
	'db_name' => 'bookkeeper',
	'db_user' => 'root',
	'db_pass' => '',
	'db_host' => 'localhost',
	'nav' => array('home'),
	'types' => array('checkout' => 'Checkout', 'search' => 'Search'),
	'goodreads_url' => 'https://www.goodreads.com',
	'goodreads_key' => '',
	'goodreads_secret' => '',
	'worldcat_url' => 'http://xisbn.worldcat.org/webservices/xid',
	'worldcat_key' => '',
	'worldcat_secret' => '',
	);

require 'rb/rb.php';
R::setup("mysql:host={$config['db_host']};dbname={$config['db_name']}",$config['db_user'],$config['db_pass']);
