<?php 
include 'config.php'; 

$isbn = (isset($_GET['isbn'])) ? filter_var($_GET['isbn'], FILTER_SANITIZE_NUMBER_INT) : 0;
$uid = (isset($_GET['uid'])) ? filter_var($_GET['uid'], FILTER_SANITIZE_NUMBER_INT) : 0;
$type = (isset($_GET['type'])) ? filter_var($_GET['type'], FILTER_SANITIZE_NUMBER_INT) : 0;
$date = (isset($_GET['date'])) ? filter_var($_GET['date'], FILTER_SANITIZE_STRING) : '';

if ($isbn > 0 && $uid > 0 && ($type > 0 && $type <=2)) {
	$resource = R::dispense('activities');
	$resource->isbn = $isbn;
	$resource->type = $type;
	$resource->user_id = $uid;
	$resource->date = ($date != '') ? $date : R::isoDateTime() ;
	$id = R::store($resource);
}

if (isset($id) && $id > 0) {
	echo 1;
} else {
	echo 0;
}
exit();
?>
