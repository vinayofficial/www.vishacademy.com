</section>
<!-- Placed js at the end of the document so the pages load faster -->
<!--Core js-->
<script src="<?php echo SITE_PATH ?>assets/js/jquery.js"></script>
<script src="<?php echo SITE_PATH ?>assets/bs3/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="<?php echo SITE_PATH ?>assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="<?php echo SITE_PATH ?>assets/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo SITE_PATH ?>assets/js/jQuery-slimScroll-1.3.0/jquery.slimscroll.js"></script>
<script src="<?php echo SITE_PATH ?>assets/js/jquery.nicescroll.js"></script>
<!--Easy Pie Chart-->
<script src="<?php echo SITE_PATH ?>assets/js/easypiechart/jquery.easypiechart.js"></script>
<!--Sparkline Chart-->
<script src="<?php echo SITE_PATH ?>assets/js/sparkline/jquery.sparkline.js"></script>
<!--jQuery Flot Chart-->
<script src="<?php echo SITE_PATH ?>assets/js/flot-chart/jquery.flot.js"></script>
<script src="<?php echo SITE_PATH ?>assets/js/flot-chart/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo SITE_PATH ?>assets/js/flot-chart/jquery.flot.resize.js"></script>
<script src="<?php echo SITE_PATH ?>assets/js/flot-chart/jquery.flot.pie.resize.js"></script>
<!------------Switch Radio button------------>
<script src="<?php echo SITE_PATH ?>assets/js/bootstrap-switch.js"></script>
<script src="<?php echo SITE_PATH ?>assets/js/toggle-init.js"></script>
<!-------Custom js------------------>
<script src="<?php echo SITE_PATH ?>assets/js/custom/custom.js"></script>
<!--------File uploader------------>
<script src="<?php echo SITE_PATH ?>assets/js/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<!--common script init for all pages-->
  <script src="<?php echo SITE_PATH ?>assets/js/scripts.js"></script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
  $('[data-call="tooltip"]').tooltip()
});

// refresh page
setInterval(function() {
				var randomnumber = Math.floor(Math.random() * 100);
				$('#show').text(
						'I am getting refreshed every 3 seconds..! Random Number ==> '
								+ randomnumber);
			}, 3000);
</script>
</body>
</html>