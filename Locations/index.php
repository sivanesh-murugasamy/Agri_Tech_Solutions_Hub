<?php
// Read state data from assets/state.json
$stateFile = __DIR__ . '/assets/state.json';

// Check if the file exists before reading it
if (file_exists($stateFile)) {
    $stateData = file_get_contents($stateFile);
    $states = json_decode($stateData, true);
} else {
    $states = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles.css"> <!-- Link to styles.css -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Select Your Location & Get Weather</h2>
    <form>
        <!-- State Dropdown -->
        <div class="mb-3">
            <label for="state" class="form-label">Select State:</label>
            <select id="state" class="form-select">
                <option value="">-- Select State --</option>
                <?php foreach ($states as $state) { ?>
                    <option value="<?= htmlspecialchars($state['StateName']); ?>">
                        <?= htmlspecialchars($state['StateName']); ?>
                    </option>
                <?php } ?>
            </select>
        </div>

        <!-- District Dropdown -->
        <div class="mb-3">
            <label for="district" class="form-label">Select District:</label>
            <select id="district" class="form-select">
                <option value="">-- Select District --</option>
            </select>
        </div>

        <!-- Taluk Dropdown -->
        <div class="mb-3">
            <label for="taluk" class="form-label">Select Taluk:</label>
            <select id="taluk" class="form-select">
                <option value="">-- Select Taluk --</option>
            </select>
        </div>

        <!-- Pincode Dropdown -->
        <div class="mb-3" id="pincode-section" style="display: none;">
            <label for="pincode" class="form-label">Select Pincode:</label>
            <select id="pincode" class="form-select">
                <option value="">-- Select Pincode --</option>
            </select>
        </div>

        <!-- Submit Button -->
        <div class="mb-3" id="submit-section" style="display: none;">
            <button type="button" id="get-weather" class="btn btn-primary">Get Weather</button>
        </div>

        <!-- Weather Prediction Section -->
        <div class="weather-card" id="weather-section" style="display: none;">
            <h3 class="weather-title">🌦 Weather Forecast</h3>
            <div id="weather-info" class="alert alert-info">
                <p><strong>🌡 Temperature:</strong> <span id="temperature"></span></p>
                <p><strong>💧 Humidity:</strong> <span id="humidity"></span></p>
                <p><strong>🌬 Wind Speed:</strong> <span id="wind-speed"></span></p>
                <p><strong>🧭 Wind Direction:</strong> <span id="wind-direction"></span></p>
                <p><strong>🌧 Rainfall (Last Hour):</strong> <span id="rainfall"></span></p>
            </div>
        </div>
    </form>
</div>

<script>
$(document).ready(function () {
    // Fetch Districts based on State Selection
    $("#state").change(function () {
        let state = $(this).val();
        if (state) {
            $.post("fetch.php", { type: "district", state: state }, function (data) {
                let options = '<option value="">-- Select District --</option>';
                $.each(data, function (i, district) {
                    options += `<option value="${district.Districtname}">${district.Districtname}</option>`;
                });
                $("#district").html(options);
            }, "json");
        }
    });

    // Fetch Taluks based on District Selection
    $("#district").change(function () {
        let district = $(this).val();
        if (district) {
            $.post("fetch.php", { type: "taluk", district: district }, function (data) {
                let options = '<option value="">-- Select Taluk --</option>';
                $.each(data, function (i, taluk) {
                    options += `<option value="${taluk.Sub_distname}">${taluk.Sub_distname}</option>`;
                });
                $("#taluk").html(options);
            }, "json");
        }
    });

    // Fetch Pincodes based on Taluk Selection
    $("#taluk").change(function () {
        let taluk = $(this).val();
        if (taluk) {
            $.post("fetch.php", { type: "pincode", taluk: taluk }, function (data) {
                let options = '<option value="">-- Select Pincode --</option>';
                $.each(data, function (i, pincode) {
                    options += `<option value="${pincode.Pincode}">${pincode.Pincode}</option>`;
                });
                $("#pincode").html(options);
                $("#pincode-section").show();
                $("#submit-section").show();
            }, "json");
        }
    });

    // Fetch Weather Data based on Pincode
    $("#get-weather").click(function () {
        let pincode = $("#pincode").val();
        if (pincode) {
            $.post("fetch.php", { type: "weather", pincode: pincode }, function (data) {
                $("#temperature").text(data.Temperature);
                $("#humidity").text(data.Humidity);
                $("#wind-speed").text(data["Wind Speed"]);
                $("#wind-direction").text(data["Wind Direction"]);
                $("#rainfall").text(data["Rainfall (Last Hour)"]);
                $("#weather-section").fadeIn();
            }, "json");
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
