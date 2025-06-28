<?php
header("Content-Type: application/json");

if (isset($_POST['type'])) {
    $type = $_POST['type'];

    // Define JSON file paths inside the assets folder
    $districtFile = __DIR__ . 'assets/district.json';
    $talukFile = __DIR__ . 'assets/taluk.json';
    $pincodeFile = __DIR__ . 'assets/pincode.json';

    // Fetch Districts based on State
    if ($type == 'district') {
        $state = $_POST['state'];
        $districts = json_decode(file_get_contents($districtFile), true);
        $filteredDistricts = array_filter($districts, function ($d) use ($state) {
            return isset($d['StateName']) && $d['StateName'] == $state;
        });
        echo json_encode(array_values($filteredDistricts));
        exit;
    }

    // Fetch Taluks based on District
    if ($type == 'taluk') {
        $district = $_POST['district'];
        $taluks = json_decode(file_get_contents($talukFile), true);
        $filteredTaluks = array_filter($taluks, function ($t) use ($district) {
            return isset($t['Districtname']) && $t['Districtname'] == $district;
        });
        echo json_encode(array_values($filteredTaluks));
        exit;
    }

    // Fetch Pincodes based on Taluk
    if ($type == 'pincode') {
        $taluk = $_POST['taluk'];
        $pincodes = json_decode(file_get_contents($pincodeFile), true);
        $filteredPincodes = array_filter($pincodes, function ($p) use ($taluk) {
            return isset($p['Sub_distname']) && $p['Sub_distname'] == $taluk;
        });
        echo json_encode(array_values($filteredPincodes));
        exit;
    }

    // Fetch Weather Data from OpenWeatherMap API
    if ($type == 'weather') {
        $pincode = $_POST['pincode'];
        $apiKey = "0ced3736ef4a2561977aba39206d7462"; // Replace with your actual API key
        $apiUrl = "https://api.openweathermap.org/data/2.5/weather?zip={$pincode},IN&appid={$apiKey}&units=metric";

        $weatherData = file_get_contents($apiUrl);

        if ($weatherData) {
            $weatherArray = json_decode($weatherData, true);

            // Extract Required Data
            $temperature = $weatherArray['main']['temp'] ?? 'N/A';
            $humidity = $weatherArray['main']['humidity'] ?? 'N/A';
            $windSpeed = $weatherArray['wind']['speed'] ?? 'N/A';
            $windDirection = $weatherArray['wind']['deg'] ?? 'N/A';
            $rainfall = isset($weatherArray['rain']['1h']) ? $weatherArray['rain']['1h'] : 0; // Rainfall in mm (last 1 hour)

            // Return JSON Response
            echo json_encode([
                "Temperature" => "{$temperature}°C",
                "Humidity" => "{$humidity}%",
                "Wind Speed" => "{$windSpeed} m/s",
                "Wind Direction" => "{$windDirection}°",
                "Rainfall (Last Hour)" => "{$rainfall} mm"
            ]);
        } else {
            echo json_encode(["error" => "Unable to fetch weather data"]);
        }
    }
}
?>
