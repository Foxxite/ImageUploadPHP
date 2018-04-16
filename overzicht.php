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
<title>Overview</title>
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
		<button class="btn btn-secondary" onClick="window.location.replace('indexxite.php');">Upload een afbeelding</button>
		<br />
		<h1>Uploaded Images</h1>
		<div>
			<?php
				require('../config.php');

				$query = "SELECT * FROM `Imagesxite`";
				if($result = mysqli_query($mysqli, $query))
				{
					if(mysqli_num_rows($result) > 0)
					{
						$i = 0;
						$c = 4;
						while($rij = mysqli_fetch_array($result))
						{
							if($i <= $c)
							{
								echo '<a href="detail.php?id=' . $rij['ID'] . '"><img class="thumbnail img-responsive" src="./uploads/thumbnails/' . $rij['ID']. '.' .$rij['FileNameFoxxite'] . '"></a>&nbsp;';
								$i += 1;
							}
							else
							{
								echo '</div>';
								echo '<br>';
								echo '<div>';
								echo '<a href="detail.php?id=' . $rij['ID'] . '"><img class="thumbnail img-responsive" src="./uploads/thumbnailsFoxxo/' . $rij['ID']. '.' .$rij['FileName'] . '"></a>&nbsp;';
								$c = 3;
								$i = 0;
							}
						}
					}
				}

			?>
		</div>
	</div>
</body>
</html>
