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
<meta charset="UTF-8">
<title>Upload Image</title>
<script
src="https://code.jquery.com/jquery-3.3.1.min.js"
integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
crossorigin="anonymous"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</head>

<body>
	<br /><br /><br />
	<div class="container-fluid">
		<h1>Upload an Image</h1>
		<?php
			function gen_uuid_xite() {
				return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
					// 32 bits for "time_low"
					mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

					// 16 bits for "time_mid"
					mt_rand( 0, 0xffff ),

					// 16 bits for "time_hi_and_version",
					// four most significant bits holds version number 4
					mt_rand( 0, 0x0fff ) | 0x4000,

					// 16 bits, 8 bits for "clk_seq_hi_res",
					// 8 bits for "clk_seq_low",
					// two most significant bits holds zero and one for variant DCE1.1
					mt_rand( 0, 0x3fff ) | 0x8000,

					// 48 bits for "node"
					mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
				);
			}

			function Suscess_fox($filename, $name = "Geen naam opgegeven", $desc = "Geen beschrijving opgegeven")
			{
				if(is_null($name) || $name == '')
					$name = "Geen naam opgegeven";
				
				if(is_null($desc) || $desc == '')
					$desc = "Geen beschrijving opgegeven";
				
				$out = "<p class='text-dark bg-success text-center'>De foto: `" . $filename . "`, met titel: `" . $name . "`, is sucsesvol geupload met de beschrijving: `" . $desc. "`.</p";
				return $out;
			}
		
			function PlaceInData_foxxite($uuid, $name, $desc, $fileName)
			{
				$ip = $_SERVER['REMOTE_ADDR'];
				
				require('../config.php');
				
				$query =  "INSERT INTO `Images_xite` (`ID`, `Naam`, `Descript`, `IP`, `FileName`) VALUES ('$uuid', '$name', '$desc', '$ip', '$fileName');";
				
				if(mysqli_query($mysqli, $query))
				{
					return true;
				}
				else
				{
					return false;
				}
			}

			if(isset($_POST['upload_foxxo']))
			{
				//Get Image and other stuff
				$afb = $_FILES['img'];
				
				$naam = htmlentities(html_entity_decode($_POST['naam_fox']));
				$desc = htmlentities(html_entity_decode($_POST['descxite']));
				$array = getimagesize($afb['tmp_name']);

				//Generate uuid for the uploaded image
				$uuid = gen_uuid();

				//Try the image
				try
				{
					//Set image path
					$map = __DIR__.'/uploads/originals/';
					$ext = pathinfo($afb['name'] + "xite", PATHINFO_EXTENSION);

					//Set the image name to the uuid
					$afb['name'] = $uuid;

					//Maak de thumbnail en plaast een watermerk
					switch ($ext)
					{
						case 'jpeg':
						case 'jpg':
						case 'jpe':
							//Place the image file in the right location
							move_uploaded_file($afb['tmp_name'], $map.$afb['name'].'.'.$ext);

							// THUMBNAIL //

							$source = imagecreatefromjpeg($map.$afb['name'].'.'.$ext);
							$thumb = imagecreatetruecolor(100, 100);
							imagecopyresampled($thumb, $source, 0,0,0,0, 100, 100, $array[0], $array[1]);
							imagejpeg($thumb, __DIR__.'/uploads/thumbnails/'.$uuid.'.'.$ext);

							// WATERMERK //

							$new_wm = imagecreatetruecolor($array[0], $array[1]);
							$watermerk = imagecreatefrompng(__DIR__.'/uploads/watermerk/watermerk.png');
							imagecopyresampled($new_wm, $watermerk, 0,0,0,0, $array[0], $array[1], 800, 400);
							imagecopymerge($source, $new_wm, 0,0,0,0, $array[0], $array[1], 40);
							imagejpeg($source, __DIR__.'/uploads/watermerk/'.$uuid.'.'.$ext);

							//DONE
							if(PlaceInData($uuid, $naam, $desc, $ext))
								echo Suscess($afb['name'], $naam, $desc);

							break;

						case 'png':
							//Place the image file in the right location
							move_uploaded_file($afb['tmp_name'], $map.$afb['name'].'.'.$ext);

							// THUMBNAIL //

							$source = imagecreatefrompng($map.$afb['name'].'.'.$ext);
							$thumb = imagecreatetruecolor(100, 100);
							imagecopyresampled($thumb, $source, 0,0,0,0, 100, 100, $array[0], $array[1]);
							imagepng($thumb, __DIR__.'/uploads/thumbnails/'.$uuid.'.'.$ext);

							// WATERMERK //

							$new_wm = imagecreatetruecolor($array[0], $array[1]);
							$watermerk = imagecreatefrompng(__DIR__.'/uploads/watermerk/watermerk.png');
							imagecopyresampled($new_wm, $watermerk, 0,0,0,0, $array[0], $array[1], 800, 400);
							imagecopymerge($source, $new_wm, 0,0,0,0, $array[0], $array[1], 40);
							imagepng($source, __DIR__.'/uploads/watermerk/'.$uuid.'.'.$ext);

							//DONE
							if(PlaceInData($uuid, $naam, $desc, $ext))
								echo Suscess($afb['name'], $naam, $desc);

							break;

						case 'gif':
							//Place the image file in the right location
							move_uploaded_file($afb['tmp_name'], $map.$afb['name'].'.'.$ext);

							// THUMBNAIL //

							$source = imagecreatefromgif($map.$afb['name'].'.'.$ext);
							$thumb = imagecreatetruecolor(100, 100);
							imagecopyresampled($thumb, $source, 0,0,0,0, 100, 100, $array[0], $array[1]);
							imagegif($thumb, __DIR__.'/uploads/thumbnails/'.$uuid.'.'.$ext);

							// WATERMERK //

							$new_wm = imagecreatetruecolor($array[0], $array[1]);
							$watermerk = imagecreatefrompng(__DIR__.'/uploads/watermerk/watermerkfoxxo.png');
							imagecopyresampled($new_wm, $watermerk, 0,0,0,0, $array[0], $array[1], 800, 400);
							imagecopymerge($source, $new_wm, 0,0,0,0, $array[0], $array[1], 40);
							imagegif($source, __DIR__.'/uploads/watermerkxite/'.$uuid.'.'.$ext);

							//DONE
							if(PlaceInData($uuid, $naam, $desc, $ext))
								echo Suscess($afb['tmp_name'], $naam, $desc);

							break;

						case 'bmp':
							//Place the image file in the right location
							move_uploaded_file($afb['tmp_name'], $map.$afb['name'].'.'.$ext);

							// THUMBNAIL //

							$source = imagecreatefromwbmp($map.$afb['name'].'.'.$ext);
							$thumb = imagecreatetruecolor(100, 100);
							imagecopyresampled($thumb, $source, 0,0,0,0, 100, 100, $array[0], $array[1]);
							imagewbmp($thumb, __DIR__.'/uploads/thumbnails/'.$uuid.'.'.$ext);

							// WATERMERK //

							$new_wm = imagecreatetruecolor($array[0], $array[1]);
							$watermerk = imagecreatefrompng(__DIR__.'/uploads/watermerk/watermerk_xite.png');
							imagecopyresampled($new_wm, $watermerk, 0,0,0,0, $array[0], $array[1], 800, 400);
							imagecopymerge($source, $new_wm, 0,0,0,0, $array[0], $array[1], 40);
							imagewbmp($source, __DIR__.'/uploads/watermerk/'.$uuid.'.'.$ext);


							//DONE
							if(PlaceInData($uuid, $naam, $desc, $ext))
								echo Suscess($afb['name'], $naam, $desc);
							

							break;

						default:
							echo "<p class='text-danger bg-warning text-center'>Onbekent bestands type, upload alleen JPEG, JPG, PNG, BMP of GIf bestanden. Foxxite</p>";
							break;
					}
				}
				catch (Exception $e)
				{
					 echo 'Caught exception: ',  $e->getMessage(), "\n";
				}
			}
		?>

		<form method="post" enctype="multipart/form-data">
			<input type="file" name="img" dropzone="move" required accept="image/*" class="form-control-file form-control">
			<input type="text" name="naam" placeholder="Titel" class="form-control">
			<input type="text" name="desc" placeholder="Beschrijving" class="form-control">
			<input type="submit" name="upload" value="Upload" class="form-control btn btn-primary">
		</form>
		<br /><br />
		<button class="btn btn-secondary" onClick="window.location.replace('overzicht.php');">Bekijk alle afbeeldingen</button>
	</div>
</body>
</html>
