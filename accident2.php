<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #2F3238 ;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
	
	<link href="_include/css/bootstrap.min.css" rel="stylesheet">

<!-- Main Style -->
<link href="_include/css/main.css" rel="stylesheet">

<!-- Supersized -->
<link href="_include/css/supersized.css" rel="stylesheet">
<link href="_include/css/supersized.shutter.css" rel="stylesheet">

<!-- FancyBox -->
<link href="_include/css/fancybox/jquery.fancybox.css" rel="stylesheet">

<!-- Font Icons -->
<link href="_include/css/fonts.css" rel="stylesheet">

<!-- Shortcodes -->
<link href="_include/css/shortcodes.css" rel="stylesheet">

<!-- Responsive -->
<link href="_include/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="_include/css/responsive.css" rel="stylesheet">

<!-- Google Font -->
<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'>

<!-- Fav Icon -->
<link rel="shortcut icon" href="#">

<link rel="apple-touch-icon" href="#">
<link rel="apple-touch-icon" sizes="114x114" href="#">
<link rel="apple-touch-icon" sizes="72x72" href="#">
<link rel="apple-touch-icon" sizes="144x144" href="#">

<!-- Modernizr -->
<script src="_include/js/modernizr.js"></script>

    <!--
    Include the maps javascript with sensor=true because this code is using a
    sensor (a GPS locator) to determine the user's location.
    See: https://developers.google.com/maps/documentation/javascript/tutorial#Loading_the_Maps_API
    -->
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>

    <script>
// Note: This example requires that you consent to location sharing when
// prompted by your browser. If you see a blank space instead of the map, this
// is probably because you have denied permission for location sharing.

var map;

function initialize() {
  geocoder = new google.maps.Geocoder();
  var mapOptions = {
    zoom: 12
  };
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  // Try HTML5 geolocation
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var pos = new google.maps.LatLng(position.coords.latitude,
                                       position.coords.longitude);
									   var elem = document.getElementById("lati");
									    var elem2 = document.getElementById("longi");
elem.value =pos.lat();
elem2.value =pos.lng();
									   

      var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
		 zoom: 11,
        content: 'Vous etes ici'
      });

      map.setCenter(pos);
    }, function() {
      handleNoGeolocation(true);
    });
  } else {
    // Browser doesn't support Geolocation
    handleNoGeolocation(false);
  }
}

function handleNoGeolocation(errorFlag) {
  if (errorFlag) {
    var content = 'Error: The Geolocation service failed.';
  } else {
    var content = 'Error: Your browser doesn\'t support geolocation.';
  }

  var options = {
    map: map,
    position: new google.maps.LatLng(60, 105),
    content: content
  };

  var infowindow = new google.maps.InfoWindow(options);
  map.setCenter(options.position);
}
function codeLatLng() {
 
  var lat = document.getElementById('lati').value;
  var lng = document.getElementById('longi').value;
  var latlng = new google.maps.LatLng(lat, lng);
  geocoder.geocode({'latLng': latlng}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[1]) {
        map.setZoom(20);
        marker = new google.maps.Marker({
            position: latlng,
            map: map
        });
		var elem = document.getElementById("adr");
elem.value = results[1].formatted_address;
        infowindow.setContent(results[1].formatted_address);
        infowindow.open(map, marker);
      } else {
        alert('No results found');
      }
    } else {
      alert('Geocoder failed due to: ' + status);
    }
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
  <div id="panel">
  <div class="row">
        	<!-- Start Buttons -->
        	<div class="span6">
  
  <form enctype="multipart/form-data"  name="changer" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" >
		<div align="center"><br><p> Vous souhaitez déclarer:</p>
<input type="radio" name="rad" value="Accident" checked> Accident
<input type="radio" name="rad" value="signalistion" > Problème de signalisation

<input type="radio" name="rad" value="bouchon"> Bouchon
<input type="radio" name="rad" value="transformation"> Transformation
<input type="radio" name="rad" value="autre"> Autre
<br>
</div>
</div></div>
		
		  Description:<input type="textarea" name="desc" id="desc" style="width: 200px; height: 50px;  color: #2F3238 ;"   >
		 <input type="hidden" name="lati" id="lati">
<input type="hidden" name="longi" id="longi">
		  Adresse :<input type="textarea" name="adr" id="adr" style="width: 200px; height: 50px;  color: #2F3238 ;" >

      <br><input type="button" value="afficher mon adresse" onclick="codeLatLng()">
	  <input name="MAX_FILE_SIZE" value="102400" type="hidden">
<input name="image" accept="image/jpeg" type="file">
	  
		<input type="submit" name="submit" value="valider">
	
		 <nav class="icons-example">
            
                        <a href="first.php"><span class="font-icon-arrow-round-left"></span></a>
						
		
                </nav>
				
		</form>
      
	 
	
    </div>
	
    <div id="map-canvas"></div>
	<?php
$username = "root";
$password = "";
$hostname = "127.0.0.1"; 

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
  or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

$selected = mysql_select_db("myDB",$dbhandle)
  or die("Could not select myDB");
  
 
if (isset($_POST['submit'])) {


if(isset($_POST['desc'])){ $desc = $_POST['desc'];  }
if(isset($_POST['lati'])){ $lat = $_POST['lati']; $Rlat=round($lat,4);   } 
if(isset($_POST['longi'])){ $lon = $_POST['longi']; $Rlon=round($lon,4); } 
if(isset($_POST['rad'])){ $rad = $_POST['rad']; } 
if(isset($_POST['adr'])){ $adr = $_POST['adr']; } 
 

 echo '<div id="copyright"><p><H3> votre alerte est :'.$desc.'</H3>'  ;
$sql1 = 'SELECT * FROM `newform`  WHERE( ROUND(lat,4)='.$Rlat.' AND ROUND(lon,4)='.$Rlon.' AND elmt='.$desc.') '; 
   $result = mysql_query($sql1); 
 
   if(mysql_num_rows($result) > 0) {
   while($row = mysql_fetch_array($result)) { $c=$row['conf']; ++$c; }
    
      $sql = 'UPDATE newform SET conf='.$c.' WHERE (ROUND(lat,4)='.$Rlat.' AND ROUND(lon,4)='.$Rlon.') '; 
   
} else {
  $sql = 'INSERT INTO newform VALUES ("", NOW(), "'.$rad.'", "'.$desc.'", "'.$lat.'","'.$lon.'","'.$adr .'","")'; 
}


echo 'Votre alerte a bien ete enregistre!!</div> '; }
 
// on insere le tuple (mysql_query) et au cas où, on écrira un petit message d'erreur si la requête ne se passe pas bien (or die)
mysql_query ($sql) or die ('Erreur SQL !'.$sql.'<br />'.mysql_error());  

 
 mysql_close($dbhandle);
  
  
?>
<?php
// Create MySQL login values and 
// set them to your login information.
$username = "root";
$password = "";
$host = "127.0.0.1"; 
$database = "mydb";

// Make the connect to MySQL or die
// and display an error.
$link = mysql_connect($host, $username, $password);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

// Select your database
mysql_select_db ($database); 

// Make sure the user actually 
// selected and uploaded a file
if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) { 

      // Temporary file name stored on the server
      $tmpName  = $_FILES['image']['tmp_name'];  
       
      // Read the file 
      $fp      = fopen($tmpName, 'r');
      $data = fread($fp, filesize($tmpName));
      $data = addslashes($data);
      fclose($fp);
      

      // Create the query and insert
      // into our database.
      $query = "INSERT INTO tabimg ";
      $query .= "(image) VALUES ('$data')";
      $results = mysql_query($query, $link);
      
      // Print results
      print "Thank you, your file has been uploaded.";
      
}else{
   print "No image selected/uploaded";
}

// Close our MySQL Link
mysql_close($link);
?>  
<!-- Js -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> <!-- jQuery Core -->
<script src="_include/js/bootstrap.min.js"></script> <!-- Bootstrap -->
<script src="_include/js/supersized.3.2.7.min.js"></script> <!-- Slider -->
<script src="_include/js/waypoints.js"></script> <!-- WayPoints -->
<script src="_include/js/waypoints-sticky.js"></script> <!-- Waypoints for Header -->
<script src="_include/js/jquery.isotope.js"></script> <!-- Isotope Filter -->
<script src="_include/js/jquery.fancybox.pack.js"></script> <!-- Fancybox -->
<script src="_include/js/jquery.fancybox-media.js"></script> <!-- Fancybox for Media -->
<script src="_include/js/jquery.tweet.js"></script> <!-- Tweet -->
<script src="_include/js/plugins.js"></script> <!-- Contains: jPreloader, jQuery Easing, jQuery ScrollTo, jQuery One Page Navi -->
<script src="_include/js/main.js"></script> <!-- Default JS -->
<!-- End Js -->
  </body>
</html>
