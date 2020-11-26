<?php

// config
$imageDir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'images';
$coverImgFileName = '00.jpg';
$txtFileName = 'title.txt';
$coverListFile = $imageDir . DIRECTORY_SEPARATOR . 'covers.json';

// cover image list
$covers = array(
    //[
    //  'image' => '', // Cover image url without filename
    //  'title' => '', // one line text
    //  'count' => 0,  // number of photo files
    //], ...
);

// check modified time of cover list file
$lastUpdated = is_file($coverListFile) ? filemtime($coverListFile) : 0;
if (time() - $lastUpdated > 3600) { // elapsed 1 hour ~
    // Scan image directory, read title text
    $items = scandir($imageDir);
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        // validate directory
        $fullPath = $imageDir . DIRECTORY_SEPARATOR . $item;
        $imgFilePath = $fullPath . DIRECTORY_SEPARATOR . $coverImgFileName;
        $titleFilePath = $fullPath . DIRECTORY_SEPARATOR . $txtFileName;
        if (!is_dir($fullPath)
            || !is_file($imgFilePath)
            || !is_file($titleFilePath)
        ) {
            continue;
        }

        // read title text
        $title = file_get_contents($titleFilePath);
        $count = count(glob($fullPath . DIRECTORY_SEPARATOR . '*.jpg'));

        $covers[] = array(
            'image'   => 'images/' . $item . '/' . $coverImgFileName,
            'title' => $title,
            'count' => $count
        );
    }

    // Write cover images list into file
    file_put_contents($coverListFile, json_encode($covers));
} else {
    // load cover list
    $coverListJson = file_get_contents($coverListFile);
    $covers = json_decode($coverListJson, true);
}

// Shuffle array
shuffle($covers);
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
        /* https://hongkiat.github.io/css3-image-captions/ */
        .dnWaterfall .waterfall-area {
            border: 5px solid #fff;
            cursor: pointer;
            overflow: hidden;

            -webkit-box-shadow: 1px 1px 1px 1px #ccc;
            -moz-box-shadow: 1px 1px 1px 1px #ccc;
            box-shadow: 1px 1px 1px 1px #ccc;
        }

        .dnWaterfall .waterfall-area .waterfall-pic {
            border: 0;
        }

        .dnWaterfall .waterfall-area img {
            -webkit-transition: all 300ms ease-out;
            -moz-transition: all 300ms ease-out;
            -o-transition: all 300ms ease-out;
            -ms-transition: all 300ms ease-out;
            transition: all 300ms ease-out;
        }

        .dnWaterfall .waterfall-area .simple-caption {
            height: 30px;
            width: 100%;
            display: block;
            bottom: -30px;
            line-height: 25pt;
            text-align: center;
        }
        .dnWaterfall .waterfall-area .caption {
            background-color: rgba(0,0,0,0.8);
            position: absolute;
            color: #fff;
            z-index: 100;
            -webkit-transition: all 300ms ease-out;
            -moz-transition: all 300ms ease-out;
            -o-transition: all 300ms ease-out;
            -ms-transition: all 300ms ease-out;
            transition: all 300ms ease-out;
            left: 0;
        }

        .dnWaterfall .waterfall-area:hover .simple-caption {
            -moz-transform: translateY(-100%);
            -o-transform: translateY(-100%);
            -webkit-transform: translateY(-100%);
            opacity: 1;
            transform: translateY(-100%);
        }
	</style>
</head>
<body>

	<!-- Your HTML content goes here -->
	<div class="dnWaterfall">
		<!--<a data-fancybox="gallery" href="photos/1.jpg" data-caption="Caption #1"><img src="photos/1.jpg"></a>
		<a data-fancybox="gallery" href="photos/2.jpg" data-caption="Caption #2"><img src="photos/2.jpg"></a>-->
        <?php foreach ($covers as $cover) : ?>
		<img class="waterfall-img" lazy-src="<?php echo $cover['image'] ?>" title="<?php echo $cover['title'] ?>" />
        <?php endforeach; ?>
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
        
        // cover list
        let tmpCovers = <?php echo json_encode($covers); ?>;
        let g_covers = {};
        for (let i = 0; i < tmpCovers.length; i++) {
            g_covers[tmpCovers[i].image] = tmpCovers[i];
        }

        // Slideshow with photos in selected directory
        function startSlideShow(coverImg) {
            if (!g_covers[coverImg]) {
                return;
            }
            let coverInfo = g_covers[coverImg]; // image, title, count
            let baseUrl = coverImg.substr(0, coverImg.length - 6); // 00.jpg

            // build photo list
            let photos = [], photoFileName;
            for (let i = 0; i < coverInfo.count; i++) {
                photoFileName = baseUrl + (i > 9 ? i : "0" + i) + ".jpg";
                photos.push({
                    src: photoFileName
                });
            }

            $.fancybox.destroy();
            $.fancybox.open(photos, {
                loop : true
            });
        }
	</script>
</body>
</html>