<?php
//Tell PHP to log errors
ini_set('log_errors', 'On');
//Tell PHP to not display errors
ini_set('display_errors', 'Off');
//Set error_reporting to E_ALL
ini_set('error_reporting', E_ALL );
// Weather API URL
function process_form() {
    include "config.php";
    $zipcode = $_POST["zip"];
    if(preg_match('/^[A-Za-z]+$/', $zipcode)){
      echo "Zip Code entered contains letters. Please enter a valid zip code.";
    } else {
        $api_url = 'http://api.openweathermap.org/data/2.5/weather?zip=' . $zipcode . ',us&appid=' . $api_key;

        //Gets the file contents from the API URL
        $weather_data = json_decode(@file_get_contents($api_url),true);

        // Current Weather Information
        $temperature_current_weather = $weather_data['weather'][0]['main'];
        $temperature_current_weather_description = $weather_data['weather'][0]['description'];
        $temperature_current_weather_icon = $weather_data['weather'][0]['icon'];

        // Temperature Information
        $temperature = $weather_data['main']['temp'];
        $temperature_in_celsius = $temperature - 273.35;
        $temperature_in_fah = ($temperature_in_celsius * 1.8) + 32.00;
        $negative_num = '-460';
        if(round($temperature_in_fah) == '-460'){
          echo "<img src='cross.png' height='150' width='150' /><br />";
          echo "Invalid zip code. Please enter a valid US zip code";
        } else if(round($temperature_in_fah) !== '-460'){
          echo "<img src='http://openweathermap.org/img/wn/".$temperature_current_weather_icon."@2x.png' /><br />";
          echo "The temperature at the zip code <b>" . $zipcode . "</b> is: " . round($temperature_in_fah) . "&#8457;.<br/>";
        }
      }
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Process Form</title>
		<meta name="author" value="Andrea Jarich" />
		<link rel="stylesheet" href="style.css" />
	</head>
	<body>
		<main>
      <div class="container">
        <?php
        if( isset($_POST['submit'])){
          process_form();
        }
       ?>
        <br />
        <h3>Enter a valid 5 digit US zip code to see the current temperature</h3>
  			<form name="contact" method="POST">
  				<div>
  					<label for="name">Zip Code:</label>
  					<input type="text" name="zip" placeholder="Please enter zip code" />
  				</div>
          <br />
  				<div class="button"><input type="submit" name="submit" value="Submit Zip" /></div>
  			</form>
      </div>
		</main>
	</body>
</html>
