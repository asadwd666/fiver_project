<script>

    // Weather Icons map
    var wuMap = {
        // "Windy": "fwi-wu-chanceflurries wi wi-snow-wind snow-wind",
        // "Rain": "wi-wu-chancerain rain",
        // "chancesleat": "wi-wu-chancesleat sleet",
        // "chancesnow": "wi-wu-chancesnow snow",
        // "chancetstorms": "wi-wu-chancetstorms thunderstorm",
        // "Clear": "wi-wu-clear day-sunny",
        // "Mostly clear": "wi-wu-clear day-sunny",
        // "Cloudy": "wi-wu-cloudy day-cloudy",
        // "Hazy moonlight": "wi-wu-cloudy day-cloudy",
        // "Intermittent clouds": "wi-wu-cloudy day-cloudy",
        // "Hazy sunshine": "wi-wu-hazy day-haze",
        // "Dreary": "wi-wu-hazy day-haze",
        // "Fog": "wi-wu-hazy day-haze",
        // "Flurries": "wi-wu-flurries snow-wind",
        // "Freezing rain": "wi-wu-chancesleat sleet",
        // "Rain and snow": "wi-wu-chancesleat sleet",
        // "Hazy": "wi-wu-hazy day-haze",
        // "Mostly cloudy": "wi wi-day-cloudy",
        // "Mostly sunny": "wi-wu-mostlysunny day-sunny",
        // "Partly cloudy": "wi-wu-partlycloudy day-cloudy",
        // "Partly sunny": "wi-wu-partlysunny day-sunny",
        // "Showers": "wi-wu-rain showers",
        // "Sleat": "wi-wu-sleat sleet",
        // "Ice": "wi-wu-sleat sleet",
        // "Snow": "wi-wu-snow snow",
        // "Sunny": "wi-wu-sunny day-sunny",
        // "Hot": "wi-wu-hot day-hot",
        // "Cold": "wi-wu-clear day-sunny",
        // "T-storms": "wi-wu-tstorms thunderstorm",
        // "unknown": " wi-wu-unknown day-sunny",
        // "Mostly cloudy with showers": "wi-wu-chancerain rain",
        // "Partly sunny with showers": "wi-wu-chancerain rain",
        // "Partly cloudy with showers": "wi-wu-cloudy day-cloudy",
        // "Partly cloudy with t-storms": "wi-wu-cloudy day-cloudy",
        // "Mostly cloudy with t-storms": "wi-wu-chancetstorms thunderstorm",
        // "Partly sunny with t-storms": "wi-wu-chancetstorms thunderstorm",
        // "Mostly cloudy with flurries": "wi-wu-flurries snow-wind",
        // "Partly sunny with flurries": "wi-wu-flurries snow-wind",
        // "Mostly cloudy with snow": "wi-wu-chancesnow snow",
        "Windy": "wi wi-day-windy",
        "Rain": "wi wi-rain",
        "Light rain": "wi-rain",
        "Clear": "wi-wu-clear day-sunny",
        "Mostly clear": "wi-wu-clear day-sunny",
        "Cloudy": "wi-wu-cloudy day-cloudy",
        "Hazy moonlight": "wi-night-fog",
        "Intermittent clouds": "wi-wu-cloudy day-cloudy",
        "Hazy sunshine": "wi-wu-hazy day-haze",
        "Dreary": "wi-wu-hazy day-haze",
        "Fog": "wi-wu-hazy day-haze",
        "Flurries": "wi-wu-flurries snow-wind",
        "Freezing rain": "wi-wu-chancesleat sleet",
        "Rain and snow": "wi wi-day-rain-mix",
        "Hazy": "wi-wu-hazy day-haze",
        "Mostly cloudy": "wi wi-day-cloudy",
        "Mostly sunny": "wi-wu-mostlysunny day-sunny",
        "Partly cloudy": "wi-wu-partlycloudy day-cloudy",
        "Partly sunny": "wi-wu-partlysunny day-sunny",
        "Showers": "wi-wu-rain showers",
        "Sleat": "wi-wu-sleat sleet",
        "Ice": "wi-wu-sleat sleet",
        "Snow": "wi-wu-snow snow",
        "Sunny": "wi-wu-sunny day-sunny",
        "Hot": "wi-wu-hot day-hot",
        "Cold": "wi wi-snowflake-cold",
        "Thunderstorms": "wi-wu-tstorms thunderstorm",
        "Mostly cloudy w/ showers": "wi-wu-chancerain rain",
        "Partly sunny w/ showers": "wi-wu-chancerain rain",
        "Partly cloudy w/ showers": "wi-wu-chancerain rain",
        "Partly cloudy w/ t-storms": "wi-wu-chancetstorms thunderstorm",
        "Mostly cloudy w/ t-storms": "wi-wu-chancetstorms thunderstorm",
        "Partly sunny w/ t-storms": "wi-wu-chancetstorms thunderstorm",
        "Mostly cloudy w/ flurries": "wi-wu-flurries snow-wind",
        "Partly sunny w/ flurries": "wi-wu-flurries snow-wind",
        "Mostly cloudy w/ snow": "wi-wu-chancesnow snow"
    }
    "use strict";

    $(document).ready(function () {
        
<?php include('../my-documents/accuweather-api-key.txt'); ?>
        
        $.ajax({
            url: "https://dataservice.accuweather.com/currentconditions/v1/" + location + "?apikey=" + key,
            dataType: "jsonp",
            success: function (data) {
                displayCurrentObservation(data);
            }
        });

        function displayCurrentObservation(data) {
                console.log(data);

                // CURRENT OBSERVATION
                
                    // create variables and store info from json
                    var current_temp_f = data[0].Temperature.Imperial.Value + "\xB0";
                    var current_description = data[0].WeatherText;

                    // map the weather icon to weather underground name
                    // var icon = data['current_observation']['icon'];
                    var newIcon = "wi " + wuMap[current_description];

                    // append weather data and icon to html
                    $("#weather").text(current_temp_f);
                    $("#description").text(current_description);
                    $("#icon").addClass(newIcon);

                // END CURRENT OBSERVATION
                   getForecastData(); 

        }

        function getForecastData(){
            $.ajax({
            url: "https://dataservice.accuweather.com/forecasts/v1/daily/5day/" + location + "?apikey=" + key + "&details=true",
            dataType: "jsonp",
            success: function (data) {
                displayForecastData(data);
            }
        });
        
        function displayForecastData(data) {
            console.log(data);
                  // 3 DAY FORECAST 

                    // Create new object and arrays to store weather data in
                    var forecast = {};
                    forecast.description = [];
                    forecast.tempMin = [];
                    forecast.tempMax = [];
                    forecast.precipitationProbability = [];
                    forecast.icons = [];

                    // loop through the forecast object for each of the 3 days we need data
                    var i;
                    for (i = 0; i < 3; i++) {
                            forecast.description[i] = data.DailyForecasts[i].Day.IconPhrase;
                            forecast.tempMin[i] = data.DailyForecasts[i].Temperature.Minimum.Value + "\xB0";
                            forecast.tempMax[i] = data.DailyForecasts[i].Temperature.Maximum.Value + "\xB0";
                            forecast.precipitationProbability[i] = data.DailyForecasts[i].Day.PrecipitationProbability + "%";

                    //     // Set the slider weather forecast
                        $(".weather-temp-min-" + i).text(forecast.tempMin[i]);
                        $(".weather-temp-max-" + i).text(forecast.tempMax[i]);
                        $(".weather-description-" + i).text(forecast.description[i]);
                        $(".weather-humidity-" + i).text(forecast.precipitationProbability[i]);
                        $(".weather-icon-" + i).addClass("wi " + wuMap[forecast.description[i]]);
                    }
                // END 3 DAY FORECAST
        }
        }
    });

                  
</script>