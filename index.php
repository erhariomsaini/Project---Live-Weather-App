<?php
    if(isset($_POST['submit'])){
        if(isset($_POST['city'])){
            $city = trim(strtolower($_POST['city']));
            if($_POST['temp']=='fahrenheit'){
                $url = "https://api.openweathermap.org/data/2.5/weather?q=".$city."&appid=7418b7bb477cf71edbb6c9b916d8c68e&units=imperial";

                $forcast = "api.openweathermap.org/data/2.5/forecast/daily?q=".$city."&cnt=5&appid=7418b7bb477cf71edbb6c9b916d8c68e&units=imperial";
            }else{
                $url = "https://api.openweathermap.org/data/2.5/weather?q=".$city."&appid=7418b7bb477cf71edbb6c9b916d8c68e&units=metric";
                
                $forcast = "api.openweathermap.org/data/2.5/forecast/daily?q=".$city."&cnt=5&appid=7418b7bb477cf71edbb6c9b916d8c68e&units=metric";
            }
            $api = curl_init();
            curl_setopt($api,CURLOPT_URL,$url);
            curl_setopt($api,CURLOPT_RETURNTRANSFER,true);
            $result = curl_exec($api);
            curl_close($api);
            $data= json_decode($result,true);

            $forcast_api = curl_init();
            curl_setopt($forcast_api,CURLOPT_URL,$forcast);
            curl_setopt($forcast_api,CURLOPT_RETURNTRANSFER,true);
            $forcast_result = curl_exec($forcast_api);
            curl_close($forcast_api);
            $forcast_data= json_decode($forcast_result,true);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Weather</title>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
</head>
<body>

<form action="" method="POST" class="text-center mt-5">
    <input type="text" class="form-control-sm" placeholder="Enter City Name" name="city" value="<?php if(isset($data)){echo $_POST['city'];}?>">
    <button type="submit" class="btn btn-success btn-sm" name="submit">Get Weather</button>
    <select name="temp" id="temp" class="btn btn-secondary btn-sm">
        <option value="celsius" <?php if(isset($data) && $_POST['temp']=='celsius'){echo "selected";}?>>&deg;C</option>
        <option value="fahrenheit" <?php if(isset($data) && $_POST['temp']=='fahrenheit'){echo "selected";}?>>&deg;F</option>
    </select>
</form>
<?php if(isset($data)){
    if($data['cod']==200){?>
<div class="frame">
  <h4 class="text-center mt-2"><?php echo $data['name']; ?> | <?php echo date('d M,Y',$data['dt']);?></h4>
  <?php $img=$data['weather'][0]['icon'];
  $imgsrc= "https://openweathermap.org/img/wn/$img@4x.png"?>
  <img src=<?php echo $imgsrc;?> alt="weather">
	
  <div class="front">
		<div>
			<div class="temperature">
				<?php echo round($data['main']['temp']); 
                if($_POST['temp']=='fahrenheit')
                {echo "&deg;F";}
                else
                {echo "&deg;C";}?>
			</div>
			<div>
				<div class="info">
					Speed: <?php echo $data['wind']['speed'];
                    if($_POST['temp']=='fahrenheit')
                    {echo " miles/hr";}
                    else
                    {echo " meter/sec";}?> 
                <br>Humidity: <?php echo $data['main']['humidity'];?>%<br>
                    Weather: <?php echo $data['weather'][0]['main'];?>
				</div>
				<table class="preview">
					<tbody>
						<tr>
							<td>23 Feb</td>
							<td>21° | Rainy</td>
						</tr>
						<tr>
							<td>24 Feb</td>
							<td>23° | Sunny</td>
						</tr>
						<tr>
							<td>25 Feb</td>
							<td>27° | Windy</td>
						</tr>
						<tr>
							<td>26 Feb</td>
							<td>26° | Sunny</td>
						</tr>
						<tr>
							<td>27 Feb</td>
							<td>24° | Rainy</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php }else{
    echo "<h3 class='text-center mt-5'>No data found.Please enter correct city name.</h3>";
}?>
<?php }else{
echo "<h3 class='text-center mt-5'>Enter city name to get weather data</h3>";
} ?>

</body>
</html>