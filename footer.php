	<div class="footer">
        <p>&copy; Bookkeeper // AngelHackMNL 2014</p>
	</div>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="//code.highcharts.com/highcharts.js"></script>

	<script>
    $(function() {
        $('.date-picker').datepicker({
            dateFormat: 'M dd yy',
        });
    });
    </script>

    <?php if ($page == 'home') : ?>
    <script>
	$(document).ready(function() {
        
        Highcharts.setOptions({
            credits: { enabled: false }
        });

        loadTrends();
        $('#refresh-trend').on('click', function() {
            $('#chart').empty();
            loadTrends();
        });

        function loadTrends() {
            var isbn = $('#isbn').val();
            var uid = $('#uid').val();
            var period = $('#period').val();
            var chart = $('#chart_type').val();

            $.getJSON('stats.php', {isbn: isbn, period: period-1, uid: uid, chart: chart}, function(json) {
                var options = {
                    chart: { renderTo: 'chart' }, 
                    title: { text: json['title'] },
                    xAxis: { categories: json['cats'] },
                    series: [{
                        name: 'Checkouts',
                        type: chart,
                        data: json['checkout']
                    }, {
                        name: 'Searches',
                        type: chart,
                        data: json['searches']
                    }]
                };
                var trend_chart = new Highcharts.Chart(options);
                $('#blurb').empty().append('This book has been checked out <strong>'+ json['total']['checkout'] +'</strong> times and searched for <strong>'+ json['total']['searches'] +'</strong> times in the last '+ period +' months.')
                });
        }
		
	});
	</script>

    <?php endif; ?>

  </body>
</html>