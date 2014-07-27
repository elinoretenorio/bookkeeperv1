<?php 
$page = 'home';
include 'header.php';

$isbn = (isset($_GET['isbn'])) ? filter_var($_GET['isbn'], FILTER_SANITIZE_NUMBER_INT) : 0;
$uid = (isset($_GET['uid'])) ? filter_var($_GET['uid'], FILTER_SANITIZE_NUMBER_INT) : 1;
$format = (isset($_GET['format'])) ? filter_var($_GET['format'], FILTER_SANITIZE_STRING) : '';

// extract boook data
if ($isbn != '') {
  
  $json = file_get_contents($config['worldcat_url'] . "/isbn/{$isbn}?method=getMetadata&format=json&fl=*");
  $book = json_decode($json,TRUE);
  $info = $book['list'][0];

  $xml = simplexml_load_string(file_get_contents($config['goodreads_url'] . "/search.xml?q={$isbn}&key={$config['goodreads_key']}"));
  $gr_json = json_encode($xml);
  $gr_book = json_decode($gr_json, TRUE);

}
?>
<input type="hidden" id="isbn" value="<?php echo $isbn; ?>">
<input type="hidden" id="uid" value="<?php echo $uid; ?>">
<?php
if (isset($book) && is_array($book) && $book['stat'] == 'ok') :
?>
<h1><?php echo ucwords($book['list'][0]['title']); ?> <small><em>by</em> <?php echo $gr_book["search"]["results"]["work"]["best_book"]["author"]["name"]; ?></small></h1>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="active"><a href="#home" role="tab" data-toggle="tab">Basic Info</a></li>
  <li><a href="#goodreads" role="tab" data-toggle="tab">Goodreads Reviews</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="home">
    <p>&nbsp;</p>

    <div class="media">
    <a class="pull-left thumbnail">
      <img class="media-object" src="<?php echo $gr_book["search"]["results"]["work"]["best_book"]["image_url"]; ?>" alt="<?php echo ucwords($info['title']); ?>">
    </a>
    <div class="media-body">
      
      <table class="table table-striped">
      <tr>
        <td width="20%"><label>ISBN</label></td>
        <td><?php echo $isbn; ?></td>
      </tr>
      <tr>
        <td><label>Title</label></td>
        <td><?php echo ucwords($info['title']); ?></td>
      </tr>
      <tr>
        <td><label>Author</label></td>
        <td><?php echo $gr_book["search"]["results"]["work"]["best_book"]["author"]["name"]; ?></td>
      </tr>
      <tr>
        <td><label>Publisher</label></td>
        <td><?php echo $info['publisher']; ?></td>
      </tr>
      <tr>
        <td><label>Year</label></td>
        <td><?php echo $info['year']; ?></td>
      </tr>
      <?php if (isset($info['ed'])) : ?>
      <tr>
        <td><label>Edition</label></td>
        <td><?php echo $info['ed']; ?></td>
      </tr>
      <?php endif; ?>
      <tr>
        <td><label>Language</label></td>
        <td><?php echo ucwords($info['lang']); ?></td>
      </tr>
      <tr>
        <td><label>City</label></td>
        <td><?php echo $info['city']; ?></td>
      </tr>
    </table>

    </div>
  </div>

  <div class="row well">
    <div class="col-md-7 col-md-offset-2">
      <form class="form-inline" role="form">
      <div class="form-group">
        <label>Change Trend Period</label> 
        <select id="period" class="form-control">
          <option value="3">3 months</option>
          <option value="6">6 months</option>
          <option value="12">1 year</option>
          <option value="36">3 years</option>
        </select>
        <select id="chart_type" class="form-control">
          <option value="column">column</option>
          <option value="line">line</option>
          <option value="spline">spline</option>
        </select>
        <button type="button" class="btn btn-primary" id="refresh-trend">Go</button>
      </div>
      </form>
    </div>
  </div>

  <div id="chart" style="height: 400px; margin: 0 auto"></div>

  </div>

  <div class="tab-pane" id="goodreads">
    <p>&nbsp;</p>
    <iframe src="https://www.goodreads.com/api/reviews_widget_iframe?isbn=<?php echo $isbn; ?>" width="100%" height="400" frameborder="0"></iframe>
    
  </div>

</div>

<p class="lead" id="blurb"></p>

<?php else: ?>

  <div class="row">
    <div class="col-md-6 col-md-offset-4">
      <form class="form-inline" role="form" method="get" action="home.php">
      <div class="form-group">
        <label>Enter ISBN</label>
        <input type="text" class="form-control" name="isbn" id="isbn">
        <input type="submit" class="btn btn-primary" value="Go" />
      </div>
      </form>
    </div>
  </div>

<?php endif; ?>

<p>&nbsp;</p>
<?php include 'footer.php'; ?>
