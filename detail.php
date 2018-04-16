<!--
©
   ▄████████  ▄██████▄  ▀████    ▐████▀ ▀████    ▐████▀  ▄█      ███        ▄████████ 
  ███    ███ ███    ███   ███▌   ████▀    ███▌   ████▀  ███  ▀█████████▄   ███    ███ 
  ███    █▀  ███    ███    ███  ▐███       ███  ▐███    ███▌    ▀███▀▀██   ███    █▀  
 ▄███▄▄▄     ███    ███    ▀███▄███▀       ▀███▄███▀    ███▌     ███   ▀  ▄███▄▄▄     
▀▀███▀▀▀     ███    ███    ████▀██▄        ████▀██▄     ███▌     ███     ▀▀███▀▀▀     
  ███        ███    ███   ▐███  ▀███      ▐███  ▀███    ███      ███       ███    █▄  
  ███        ███    ███  ▄███     ███▄   ▄███     ███▄  ███      ███       ███    ███ 
  ███         ▀██████▀  ████       ███▄ ████       ███▄ █▀      ▄████▀     ██████████ 
                                                                                      
-->
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Details | <?php echo $_GET['id'] ?></title>
<script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
	<br />
	<div class="container-fluid">
		<button class="btn btn-secondary" onClick="window.location.replace('overzicht.php');">View all images</button>
		<br />
		<h1>Image: <?php echo $_GET['id'] ?></h1>
		<div>
			<?php
				require('../config.php');

				$query = "SELECT * FROM `MPHP7_img` where ID = '" . $_GET['id'] . "'";
				if($result = mysqli_query($mysqli, $query))
				{
					if(mysqli_num_rows($result) > 0)
					{
						while($rij = mysqli_fetch_array($result))
						{
							echo '<img class="thumbnail img-responsive" src="./uploads/watermerk/' . $rij['ID']. '.' .$rij['FileName'] . '" height="500px">&nbsp;';
							$i += 1;
							echo "<br>";
							echo "<p>Titel: " . $rij['Naam'] ."</p>";
							echo "<p>Beschrijving: " . $rij['Descript'] ."</p>";
							echo "<h6>IP Uploader: " . $rij['IP'] ."</h6>";
						}
					}
				}

			?>
		</div>
	</div>
</body>
</html>
