<?php 
	$sFile      = $_GET['sFile'];
	$xmlpattern = "/\.xml/";
	$flvpattern = "/\.flv/";
	$movpattern = "/\.mov/";
	$mp3pattern = "/\.mp3/";
	$m4vpattern = "/\.m4v/";
	$mp4pattern = "/\.mp4/";
	
	$xml = false;
	$flv = false;
	$mov = false;
	$m4v = false;
	$mp3 = false;
	$mp4 = false;
	
	//Get file type
	if (preg_match($xmlpattern, $sFile, $matches)){
		$xml = true;
		$fileType = "xml";
	} elseif (preg_match($flvpattern, $sFile, $matches)) {
		$flv = true;
		$fileType = "flv";
	} elseif (preg_match($movpattern, $sFile, $matches)) {
		$mov = true;
		$fileType = "mov";
	} elseif (preg_match($mp3pattern, $sFile, $matches)) {
		$mp3 = true;
		$fileType = "mp3";
	} elseif (preg_match($m4vpattern, $sFile, $matches)) {
		$m4v = true;
		$fileType = "m4v";
	} elseif (preg_match($mp4pattern, $sFile, $matches)) {
		$mp4 = true;
		$fileType = "mp4";
	}

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
		</script>
		<script type="text/javascript" src="javascript/swfobject.js"></script>
		<script type="text/javascript" src="javascript/flash-detect-min.js"></script>
		<script type="text/javascript" src="javascript/jquery.playlist.js"></script>
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

			<div id="main_player"></div>
			<div class="clear"></div>
		</div>
	</body>
	<script type="text/javascript">
	
		//Flash Detection
		google.setOnLoadCallback(function() {
			
			//Flash detection script
			if(!FlashDetect.installed) {
				//Flash is not installed
				var flashError = "<h3>You do not have Flash Player installed. <br /><br />Please visit <a href='http://get.adobe.com/flashplayer/' target='_window'>http://get.adobe.com/flashplayer/</a>" + 
								 " to download and install the newest version of Flash.</h3>";
				$("#flash_error").html(flashError);
				$("#main_player").css({display : 'none'});
			} else {
				if (FlashDetect.versionAtLeast(10)){
					//Flash is installed
					//Call the embed function below
					embed();
				} else {
					//Outdated version of Flash
					var flashError = "<h3>You need to update your version of Flash. <br /><br />Please visit <a href='http://get.adobe.com/flashplayer/' target='_window'>http://get.adobe.com/flashplayer/</a>" + 
									 " to download and install the newest version of Flash.</h3>";
					$("#flash_error").html(flashError);
					$("#main_player").css({display : 'none'});
				}
			}
		})	
	</script>
	<script type="text/javascript">
		
		//Embed the player
		//This is only called if the flash detection script is true
		function embed() {
		    
		    //File type
		    var fileType    = "<?php echo($fileType); ?>";
		    var defaultSkin = "skins/five/five.zip";

		    //Embed the player
			var so = new SWFObject('includes/licensed/player-licensed.swf', 'player', '640', '480', '9');
			so.addParam('allowfullscreen','true');
			so.addParam('allowscriptaccess','always');
			so.addParam('wmode','opaque');
			if (fileType == "xml"){
				so.addVariable('playlistfile', '<?php echo($sFile); ?>&skin=' + defaultSkin);
			} else {
				so.addVariable('file','<?php echo($sFile); ?>&skin=' + defaultSkin);
				so.addVariable('title', 'DeSales University Media Player');
				so.addVariable('description', 'File: <?php echo($sFile); ?>');
			}
			so.addVariable('bufferlength', '5');
			so.addVariable('logo.file', 'http://deit.desales.edu/MediaPlayer/images/media_logo_watermark.png');
			so.addVariable('streamer','rtmp://mediasrv01.desales.edu/vod');
			so.addVariable('plugins', 'gapro-1');
			so.addVariable('gapro.accountid', 'UA-15284864-3');
			so.addVariable('gapro.trackstarts', 'true');
			so.addVariable('gapro.trackpercentages', 'true');
			so.addVariable('gapro.tracktime', 'true');
			so.write('main_player');
		};

		google.setOnLoadCallback(embed);
	</script>
</html>