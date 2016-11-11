<?php
/*
Template Name Posts: Snarfer
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<!--
		Supersized - Fullscreen Slideshow jQuery Plugin
		Version : 3.2.4
		Site	: www.buildinternet.com/project/supersized

		Author	: Sam Dunn
		Company : One Mighty Roar (www.onemightyroar.com)
		License : MIT License / GPL License
	-->

	<head>

		<title> <?php echo get_the_title(); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/css/supersized.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri();?>/header.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/theme/supersized.shutter.css" type="text/css" media="screen" />

		<script type="text/javascript">
		//define path to supersized files
		var sup_dir_base = "<?php echo get_stylesheet_directory_uri() . "/";?>";</script>



		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/js/jquery.easing.min.js"></script>

		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/js/supersized.3.2.4.min.js"></script>
		<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri() ?>/theme/supersized.shutter.min.js"></script>

		<script type="text/javascript">

			jQuery(function($){
				<?php if ($_REQUEST[img]) {
				echo "$(document).ready(function(){ api.goTo(" . $_REQUEST[img] .");});";

				}?>
				$.supersized({

					// Functionality
					slideshow               :   1,			// Slideshow on/off
					autoplay				:	0,			// Slideshow starts playing automatically
					start_slide             :   1,			// Start slide (0 is random)
					stop_loop				:	0,			// Pauses slideshow on last slide
					random					: 	0,			// Randomize slide order (Ignores start slide)
					slide_interval          :   3000,		// Length between transitions
					transition              :   6, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
					transition_speed		:	1000,		// Speed of transition
					new_window				:	1,			// Image links open in new window/tab
					pause_hover             :   0,			// Pause slideshow on hover
					keyboard_nav            :   1,			// Keyboard navigation on/off
					performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
					image_protect			:	1,			// Disables image dragging and right click with Javascript

					// Size & Position
					min_width		        :   0,			// Min width allowed (in pixels)
					min_height		        :   0,			// Min height allowed (in pixels)
					vertical_center         :   1,			// Vertically center background
					horizontal_center       :   1,			// Horizontally center background
					fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
					fit_portrait         	:   1,			// Portrait images will not exceed browser height
					fit_landscape			:   0,			// Landscape images will not exceed browser width

					// Components
					slide_links				:	false,	// Individual links for each slide (Options: false, 'number', 'name', 'blank')
					thumb_links				:	1,			// Individual thumb links for each slide
					thumbnail_navigation    :   0,			// Thumbnail navigation
					slides 					:  	[			// Slideshow Images

<?php
if ( $images = get_posts(array(
		'post_parent' => $post->ID,
		'post_type' => 'attachment',
		'numberposts' => -1,
		'orderby' => 'menu_order',
    		'order'           => 'ASC',
		'post_mime_type' => 'image',)))
	{
		foreach( $images as $image ) {
			//GET IMAGE METADATA
			$attachmenturl=get_attachment_link($image->ID);
			$attachmentimage=wp_get_attachment_image_src( $image->ID, full );
			$attachmentthumbnail=wp_get_attachment_image_src( $image->ID, thumbnail );
			$imageDescription = json_encode(wpdb::_real_escape(apply_filters( 'the_description' , $image->post_content ) . $image->post_excerpt));
			$imageTitle = apply_filters( 'the_title' , $image->post_title );

			//GET COMMENT METADATA FOR IMAGE
			$comments = get_comments( array(
			   'post_id' => $image->ID,
			   'orderby' => 'comment_date_gmt',
			   'status' => 'approve',
			 ) );
			 if(!empty($comments)){
			   $commentcount = count($comments);
			 }
			 else {$commentcount = "No";}

			//GET TAGS FOR IMAGE
			$tagname=''; //reset variable
			$tags = wp_get_post_terms($image->ID, 'media-tags');
			foreach ($tags as $tag) {
			$tagname.= $tag->name . ", ";

			}
			$tagname = json_encode(wpdb::_real_escape(rtrim($tagname, ", "))); //scrub data, remove final comma
			//echo $tagname."\n";
		//print_r($tags);

			//WRITE OUT JSON OR WHATEVER
			echo "{image : '" . $attachmentimage[0] . "', title : '" . $imageDescription . "', thumb : '" . $attachmentthumbnail[0] . "', commentlink : '" . $attachmenturl ."', comments : '". $commentcount . " comments. Click here to view or leave a comment. ', tags : '". $tagname ."'}," . "\n";
		}
	} else {
		echo "No Image";
	}
?>

//{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/shaden-3.jpg', title : 'Image Credit: Brooke Shaden', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/shaden-3.jpg', url : 'http://www.nonsensesociety.com/2011/06/brooke-shaden/'}
												],

					// Theme Options
					progress_bar			:	1,			// Timer for each slide
					mouse_scrub				:	0

				});
		    });

		</script>


<script language="javascript">
function showiframe() {
	var comments = document.getElementById("comments");
	var commentiframe = document.getElementById("commentiframe");
	var closebutton = document.getElementById("close-button");
    		comments.style.display = "none";
		commentiframe.style.display = "inline";
		closebutton.style.display = "inline";
}
function hideiframe() {
	var comments = document.getElementById("comments");
	var commentiframe = document.getElementById("commentiframe");
	var closebutton = document.getElementById("close-button");
    		comments.style.display = "block";
		commentiframe.style.display = "none";
		closebutton.style.display = "none";
}
</script>

<style type="text/css">
div#demo-block{ margin:0; height: 30px; right: 0; top:0; position: fixed; }
			div#demo-block div{ margin:0 0 10px 0; padding:10px; display:inline; float:left; color:#aaa; background:url('<?php echo get_stylesheet_directory_uri();?>/img/bg-black.png'); font:11px Helvetica, Arial, sans-serif; display: inline;}
			div#demo-block div a{ color:#eee; font-weight:bold;}
			#tags{left:0; position: fixed;}
			#tags, #comments, #commentiframe, #close-button{display: none;}
			#commentiframe {
			border: 0;
			width: 40em;
			min-width: 200px;
			height: 40em;
			min-height: 300px;
			}
			#close-button {
			opacity: 0.7;
			vertical-align: top;

			}
</style>

	</head>


<body>
<!-- this is the dummy content for social media link sharing -->
<div style="display: none !important" id="content-facebook-excerpt"> <?php  $content_post = get_post($post->ID);
$content = $content_post->post_content;  $content = strstr( $content, '<!--', true); echo $content; ?></div>


	<!--Demo styles (you can delete this block)-->
	<div id="menu">
		<h1 id="menuleft">
			<a id="red" href="/">iaatb</a>
			<a id="black" href="/">ıaatb</a>
		</h1>
		<div id="menuright">
		<ul id="menulist">
			<li class="menuli"><a href="/blog2">BLOG</a></li>
			<li class="menuli"><a href="/style">STYLE</a></li>
			<li class="menuli"><a href="/pics">PICS</a></li>
		</ul>
		</div>
	</div>

	<div id="demo-block">
		<div id="tags" >&nbsp;</div><div id="comments" onclick="showiframe()">&nbsp;</div><img id="close-button" src="<?php echo get_stylesheet_directory_uri();?>/img/close-button.png" onclick="hideiframe()"/><iframe id="commentiframe" src="http://iaatb.net/pics/october-2011-brooklyn-manhattan/002_0/" >&nbsp;</iframe>
	</div>


  <div style="
top: 0; left: 0; width: 100%; height: 100%;
    position: absolute; display: table; z-index: -1000; opacity:.4; font-family: 'Helvetica Neue', Helvetica, Arial sans-serif; font-weight: 600; color: white;
">
   <p style="
display: table-cell; vertical-align: middle; text-align: center;
">Loading<img
    alt="<?php echo get_the_title(); ?>" style="
display: block; margin: 1em auto;
"
    src="<?php $image=wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'small-feature'); echo $image[0];?>"> <?php echo get_the_title(); ?></p>
  </div>




	<!--End of styles-->

	<!--Thumbnail Navigation-->
	<div id="prevthumb"></div>
	<div id="nextthumb"></div>

	<!--Arrow Navigation-->
	<a id="prevslide" class="load-item"></a>
	<a id="nextslide" class="load-item"></a>

	<div id="thumb-tray" class="load-item">
		<div id="thumb-back"></div>
		<div id="thumb-forward"></div>
	</div>

	<!--Time Bar-->
	<div id="progress-back" class="load-item">
		<div id="progress-bar"></div>
	</div>

	<!--Control Bar-->
	<div id="controls-wrapper" class="load-item">
		<div id="controls">

			<a id="play-button"><img id="pauseplay" src="<?php echo get_stylesheet_directory_uri();?>/img/pause.png"/></a>

			<!--Slide counter-->
			<div id="slidecounter">
				<span class="slidenumber"></span> / <span class="totalslides"></span>
			</div>

			<!--Slide captions displayed here-->
			<div id="slidecaption"></div>

			<!--Thumb Tray button-->
			<a id="tray-button"><img id="tray-arrow" src="<?php echo get_stylesheet_directory_uri();?>/img/button-tray-up.png"/></a>

			<!--Navigation-->
			<ul id="slide-list"></ul>

		</div>
	</div>
<!--
<?php
if ( $images = get_posts(array(
		'post_parent' => $post->ID,
		'post_type' => 'attachment',
		'numberposts' => -1,
		'post_mime_type' => 'image',)))
	{
		foreach( $images as $image ) {
			$attachmenturl=wp_get_attachment_url($image->ID);
			$attachmentimage=wp_get_attachment_image_src( $image->ID, full );
			$imageDescription = apply_filters( 'the_description' , $image->post_content );
			$imageTitle = apply_filters( 'the_title' , $image->post_title );

			if (!empty($imageDescription)) {
    echo '<a href="'.$imageDescription .'"><img src="' . $attachmentimage[0] . '" alt=""  /></a>';
} else { echo '<img src="' . $attachmentimage[0] . '" alt="" />'; }
		}
	} else {
		echo "No Image";
	}
?>
-->
</body>
</html>
