<?php 
include 'config.php';

$isbn = (isset($_GET['isbn'])) ? filter_var($_GET['isbn'], FILTER_SANITIZE_NUMBER_INT) : 0;
$uid = (isset($_GET['uid'])) ? filter_var($_GET['uid'], FILTER_SANITIZE_NUMBER_INT) : 0;
$type = (isset($_GET['type'])) ? filter_var($_GET['type'], FILTER_SANITIZE_NUMBER_INT) : 0;
$period = (isset($_GET['period'])) ? filter_var($_GET['period'], FILTER_SANITIZE_STRING) : 3;
$mode = ($period <= 12) ? 'month' : 'year';

$date_to = date('Y-m-d 23:59:59');
$date_from = date('Y-m-01 00:00:00', strtotime($date_to . "-{$period} Months"));

if ($mode == 'month') { // monthly
	$sql = "SELECT DATE_FORMAT(`date`, '%b %Y') AS `ts`, type, 
			IFNULL(COUNT(id),0) AS total FROM activities
		WHERE (`date` BETWEEN :date_from AND :date_to) AND isbn=:isbn AND user_id=:uid
		GROUP BY type, MONTH(`date`), YEAR(`date`) ORDER BY `date` ASC";
} elseif ($mode == 'year') {
	$sql = "SELECT YEAR(`date`) AS `ts`, type, 
			IFNULL(COUNT(id),0) AS total FROM activities
		WHERE (`date` BETWEEN :date_from AND :date_to) AND isbn=:isbn AND user_id=:uid
		GROUP BY type, YEAR(`date`) ORDER BY `date` ASC";
}
$stats = R::getAll($sql, [':date_from' => $date_from, ':date_to' => $date_to, ':isbn' => $isbn, ':uid' => $uid]);

$data['checkout'] = array();
$data['searches'] = array();

foreach ($stats as $stat) {
	$cats[] = $stat['ts'];

	if ($stat['type'] == 1) { // checkout
		$data['checkout'][] = $stat['total'];
	} elseif ($stat['type'] == 2) { //searches
		$data['searches'][] = $stat['total'];
	}
}

$data['total']['checkout'] = array_sum($data['checkout']);
$data['total']['searches'] = array_sum($data['searches']);
$data['title'] = 'Checkout and Searches Trend Chart';
$data['cats'] = array_values(array_unique($cats));

echo json_encode($data, JSON_NUMERIC_CHECK);
exit();
?>