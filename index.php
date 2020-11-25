<?php

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Photo Gallery</title>

	<!-- https://fancyapps.com/fancybox/3/docs/#modules -->

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="libs/fancybox/3.5.7/jquery.fancybox.min.css">
	<link rel="stylesheet" type="text/css" href="libs/dnWaterfall/css/style.css">
	<style>
		
	</style>
</head>
<body>

	<!-- Your HTML content goes here -->
	<div class="dnWaterfall">
		<!--<a data-fancybox="gallery" href="photos/1.jpg" data-caption="Caption #1"><img src="photos/1.jpg"></a>
		<a data-fancybox="gallery" href="photos/2.jpg" data-caption="Caption #2"><img src="photos/2.jpg"></a>-->
		<img class="waterfall-img" lazy-src="images/01/00.jpg" />
		<img class="waterfall-img" lazy-src="images/02/00.jpg" />
		<img class="waterfall-img" lazy-src="images/03/00.jpg" />
		<img class="waterfall-img" lazy-src="images/04/00.jpg" />
		<img class="waterfall-img" lazy-src="images/05/00.jpg" />
		<img class="waterfall-img" lazy-src="images/06/00.jpg" />
		<img class="waterfall-img" lazy-src="images/07/00.jpg" />
		<img class="waterfall-img" lazy-src="images/08/00.jpg" />
	</div>

	<!-- JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="libs/dnWaterfall/js/dnWaterfall.js"></script>
	<script src="libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
	<script>
		//$('[data-fancybox="gallery"]').fancybox({
		//	// Options will go here
		//});
		document.oncontextmenu = function () {return false;}
		$(window).on('load', function() {
			$("img").on('contextmenu', function(e) {
				return false;
			});

			$(".dnWaterfall").dnWaterfall();        
		});
	</script>
</body>
</html>