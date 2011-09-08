<?php

	//Pull the file and title boolean from the GET request
	$sFile      = $_GET['sFile'];	
	$noTitle	= $_GET['title'];
	if (!$noTitle){
		$noTitle = 0;
	}
	
	//Check to see that sFile actually has a value
	if (($sFile == '') || ($sFile == '/')) {
		$fileError =	"<h3>There is an error on the page. Most likely it is due to a malformed URL.</h3>" .
						"<p>The URL should be formed as follows:<br />" .
						"<ul>" . 
						"<li>http://deit.desales.edu/MediaPlayer/index.php?sFile=/faculty/[your last name]/[name of file]</li>" .
						"<li>Example: <a href='http://deit.desales.edu/MediaPlayer/index.php?sFile=/faculty/sturoscy/CSSversusTables.flv'>http://deit.desales.edu/MediaPlayer/index.php?sFile=/faculty/sturoscy/CSSversusTables.flv</a></li>" . 
						"</ul></p>" . 
						"<p>If you continue to experience issues, please contact DEIT at <a href='mailto:deit@desales.edu'>deit@desales.edu</a> or at 610.282.1100 x2290.</p>";
	} else {
		$fileError = "";
	}

	//For Flash enabled devices
	$fileOutput = "'file': '" . $sFile . "'";
	
	//For iOS devices
	$altFileOutput = "'file': '/media" . $sFile . "'";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" rel="stylesheet" href="stylesheets/grid.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="stylesheets/main.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="stylesheets/playlist.css" media="screen" />
		
		<!-- Let's get IE to play nice -->
		<!--[if lt IE 8]>
			<style type="text/css">
				#header {margin-bottom: 0px;}
				#main_player {margin-top: 0px;}
			</style>
		<![endif]-->
		
		<script src="http://www.google.com/jsapi?key=ABQIAAAAouTcR5pargXhEAtm4CODuhR1IgWQluDLEZuG6zC4jkkgj3hPMhT_DiGugOsQJmWOxV5nYZepBkPkxg" type="text/javascript"></script>
		<script type="text/javascript">
			google.load("jquery", "1");
			google.load("jqueryui", "1");
			google.load("swfobject", "2");
		</script>
		<script type="text/javascript" src="javascript/jwplayer.js"></script>
		<script type="text/javascript">

			//Load the playlist js file via an ajax call based on whether or not title is true/false/undefined
			google.setOnLoadCallback(function() {

				//Get Boolean value from PHP GET for conditional statement below
				var title = <?php echo($noTitle); ?>;

				//Get file type from PHP for conditional statement below
				var file  = "<?php echo($fileType); ?>";

				//Set the title, or not
				if(file == "xml") {
					$.getScript("javascript/jquery.playlist.js");
				}else if(title == 0) {
					$("#player_margin").css({"margin" : "auto", "width" : "640px"});
				} else if (title == 1) {
					$.getScript("javascript/jquery.playlist.js");
				}
			})

		</script>
		<script src="http://cdn.jquerytools.org/1.2.2/all/jquery.tools.min.js"></script>
		<title>DeSales University Media Player</title>
	</head>
	<body>
		<div class="container_12">
			<div id="header" class="grid_10">
				<!-- <img src="images/media_logo.png" alt="Media Player" title="Media Player" /> -->
			</div>
			<div class="clear"></div>
			
			<div id="flash_error" class="grid_10"></div>
			<div class="clear"></div>
			
			<div id="file_error" class="grid_12">
				<?php echo ($fileError); ?>
			</div>
			<div class="clear"></div>

			<div id="player_margin">
				<div id="main_player"></div>
			</div>
			<div class="clear"></div>
		</div>
	</body>
	<script type="text/javascript">
		
		//Embed the player
		//This is only called if the flash detection script is true
		function embed() {
			jwplayer('main_player').setup({
				'autostart':	'false',
				'bufferlength':	'5',
				'description':	'File: <?php echo($sFile); ?>',
				'id': 			'player1',
				'logo.file':	'http://deit.desales.edu/MediaPlayer/images/media_logo_watermark.png',
				'name':			'player1',
				'provider':		'rtmp',
				'skin':			'http://deit.desales.edu/MediaPlayer/skins/five/five.zip',
				'streamer':		'rtmp://mediasrv01.desales.edu/vod/',
				'title':		'DeSales University Media Player',
				'width': 		'640',
				'height': 		'480',
				<?php echo($fileOutput) ; ?>,
				'modes': [
					{type: 'flash', src: 'http://deit.desales.edu/MediaPlayer/includes/licensed/mediaplayer56/player.swf'},
					{
						type: 'html5',
						config: {
							<?php echo($altFileOutput) ; ?>,
							'provider': 'video'
						}
					},
					{
						type: 'download',
						config: {
							<?php echo($altFileOutput) ; ?>,
							'provider': 'video'
						}
					}
				],

				//Google plugin
				'plugins':					'gapro-1',
				'gapro.accountid':			'UA-15284864-3',
		    	'gapro.trackstarts':		'true',
				'gapro.trackpercentages':	'true', 
				'gapro.tracktime': 			'true',

				'allowfullscreen':		'true',
				'allowscriptaccess':	'always',
				'wmode':				'opaque'
			});
		};

		google.setOnLoadCallback(embed);
	</script>
</html>