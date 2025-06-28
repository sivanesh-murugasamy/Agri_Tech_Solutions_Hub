$(document).ready(function () {
    $('#state').change(function () {
        let state = $(this).val();
        $('#district').html('<option value="">-- Select District --</option>');
        $('#taluk').html('<option value="">-- Select Taluk --</option>');
        $('#pincode-section, #submit-section, #weather-section').hide();

        if (state) {
            $.post('fetch.php', { type: 'district', state: state }, function (data) {
                let districts = JSON.parse(data);
                districts.forEach(d => {
                    $('#district').append(`<option value="${d.Districtname}">${d.Districtname}</option>`);
                });
            });
        }
    });

    $('#district').change(function () {
        let district = $(this).val();
        $('#taluk').html('<option value="">-- Select Taluk --</option>');
        $('#pincode-section, #submit-section, #weather-section').hide();

        if (district) {
            $.post('fetch.php', { type: 'taluk', district: district }, function (data) {
                let taluks = JSON.parse(data);
                taluks.forEach(t => {
                    $('#taluk').append(`<option value="${t.Sub_distname}">${t.Sub_distname}</option>`);
                });
            });
        }
    });

    $('#taluk').change(function () {
        let taluk = $(this).val();
        $('#pincode-section, #submit-section, #weather-section').hide();
        $('#pincode').html('<option value="">-- Select Pincode --</option>');

        if (taluk) {
            $.post('fetch.php', { type: 'pincode', taluk: taluk }, function (data) {
                let pincodes = JSON.parse(data);
                pincodes.forEach(p => {
                    $('#pincode').append(`<option value="${p.Pincode}">${p.Pincode}</option>`);
                });
                $('#pincode-section').show();
                $('#submit-section').show();
            });
        }
    });

    $('#get-weather').click(function () {
        let pincode = $('#pincode').val();
        if (pincode) {
            $.post('fetch.php', { type: 'weather', pincode: pincode }, function (data) {
                let weather = JSON.parse(data);
                $('#weather-info').html(`<p>🌡️ Temp: ${weather.list[0].main.temp}°C</p>`);
                $('#weather-section').show();
            });
        }
    });
});
