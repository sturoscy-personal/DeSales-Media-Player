<?php $sFile = $_GET['sFile']; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link type="text/css" rel="stylesheet" href="stylesheets/grid.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="stylesheets/main.css" media="screen" />
		<link type="text/css" rel="stylesheet" href="stylesheets/playlist.css" media="screen" />
		<script type="text/javascript" src="http://www.google.com/jsapi"></script>
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
				<img src="images/media_logo.png" alt="Media Player" title="Media Player" />	
			</div>
			<div class="clear"></div>
			
			<div id="flash_error" class="grid_10"></div>
			<div class="clear"></div>

			<div id="main_player"></div>

			<div id="toggle" class="grid_2 alpha">
				<a href="">Hide/Show Header</a>
			</div>
			
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
				if (FlashDetect.versionAtLeast(9)){
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

			//Toggle header
			$("#toggle").click(function(e){
				e.preventDefault();
				$("#header").toggle();
			});
		})	
	</script>
	<script type="text/javascript">
		//Initialize some variables
		var player = null;
		/* External js file handeling the ITEM state
		var currentItem = -1;
		*/
	
		//Embed the player
		//This is only called if the flash detection script is true
		function embed() {
			//Embed the player
		    var s1 = new SWFObject('includes/player.swf', 'player', '640', '480' , '9.0.0', '#FFFFFF');
		    s1.addParam('allowfullscreen', 'true');
		    s1.addParam('allowscriptaccess', 'always');
		    s1.addParam('flashvars', 'playerready=playerReadyCallback&stretching=uniform&fullscreen=true&bufferlength=5&file=<?php echo($sFile); ?>&wmode=transparent&streamer=rtmp://mediasrv01.desales.edu/vod');
		    s1.write('main_player');
		};
	
		//Function to check the state of the player
		function playerReadyCallback(obj) {
			player = document.getElementById(obj['id']);
			player.addModelListener("STATE", "checkState");
			
			/* External js file is handeling the ITEM state
			player.addControllerListener("ITEM", "itemMonitor");
			*/
		};
		
		//Toggle expose
		//This will not work in IE (z-index and relative positioning bug)!!!
		//I have not found a work-around for this in IE yet :(
		function checkState(obj) {
			if (obj.newstate == "PLAYING") {
				$("#main_player").expose({
					color: "#789",
					closeOnClick: false
				});
			} else if (obj.newstate == "PAUSED") {
				$.mask.close();
			}
		};
		
		//Playlist item monitoring
		/* External js file handeling the itemMonitor function
		function itemMonitor(obj) {
			var playItem  = null;
			    playItem  = player.getPlaylist();

			//Number of items in playlist
			//Used to size the playlist area dynamically
			var countItem   = 0;
			var playSize    = 0;
			var defaultSize = 0;
			
			for (var i in playItem) {
				countItem = countItem + 1;
				playSize  = playSize + 60;
			}
			defaultSize = 480 + playSize;
			
			if (obj.index != currentItem) {
				title       = playItem[obj.index].title;
				description = playItem[obj.index].description;
			}
			currentItem = obj.index;
		};
		*/

	</script>
</html>