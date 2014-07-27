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
	'goodreads_key' => '0ttV4D8h4u0BPyCctUlfTQ',
	'goodreads_secret' => 'GuH7qExAwuSfu7SYSjIRXytH7HMkFTHSdrjksfqw',
	'worldcat_url' => 'http://xisbn.worldcat.org/webservices/xid',
	'worldcat_key' => 'knLijgoIMr8z9EFgQbOvWVTe8ksXsjWAvyolPYPBmLGXcI8lFGEZZt7VOsa8JpUli6Dj4W9IFNv1SHGt',
	'worldcat_secret' => 'N7J+JQwwdA5DN9+ka4+MRA==',
	);

require 'rb/rb.php';
R::setup("mysql:host={$config['db_host']};dbname={$config['db_name']}",$config['db_user'],$config['db_pass']);