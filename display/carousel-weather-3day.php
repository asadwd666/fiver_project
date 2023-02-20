<!-- Weather API Setup -->
                <div>
                    <div class="large-4 columns">
                        <div class="slider-icon center wu-logo-container">
                            <i class="fa fa-thermometer" aria-hidden="true"></i>
                            <img src="https://condosites.com/img/AW_White_Small.png" alt="" class="wu-logo">
                        </div>
                    </div>
                    <div class="large-8 columns mvix-overflow-container-calendar-grid">
                        <div class="information forecast left">
                            <div id="calendar-wrap">
                                <div id="calendar">
                                    <ul class="days">
                                        <li class="day">
                                            <div class="weekdays">Today
                                                <?php echo (date('M d', strtotime('+ 0 DAY'))); ?>
                                            </div>
                                            <!-- Today Forcast API -->
                                            <div class="weather">
                                                <i class="weather-icon weather-icon-0"></i>
                                                <h4 class="weather-description-0"></h4>
                                                <div class="weather-temp-forecast-container">
                                                    <h4 class="weather-temp-forecast-label">High</h4>
                                                    <h3 class="weather-temp-max-0"></h3>
                                                </div>
                                                <div class="weather-temp-forecast-container">
                                                    <h4 class="weather-temp-forecast-label">Low</h4>
                                                    <h3 class="weather-temp-min-0"></h3>
                                                </div>
                                                <div class="weather-temp-forecast-container">
                                                    <h4 class="weather-temp-forecast-label">Precip</h4>
                                                    <h4 class="weather-humidity-0"></h4>
                                                </div>
                                            </div>

                                            <!-- END Today Forcast API -->
                                        </li>
                                        <li class="day">
                                            <div class="weekdays">Tomorrow
                                                <?php echo (date('M d', strtotime('+ 1 DAY'))); ?>
                                            </div>
                                            <!-- Tomorrow Forcast API -->
                                            <div class="weather">
                                                <i class="weather-icon weather-icon-1"></i>
                                                <h4 class="weather-description-1"></h4>
                                                <div class="weather-temp-forecast-container">
                                                    <h4 class="weather-temp-forecast-label">High</h4>
                                                    <h3 class="weather-temp-max-1"></h3>
                                                </div>
                                                <div class="weather-temp-forecast-container">
                                                    <h4 class="weather-temp-forecast-label">Low</h4>
                                                    <h3 class="weather-temp-min-1"></h3>
                                                </div>
                                                <div class="weather-temp-forecast-container">
                                                    <h4 class="weather-temp-forecast-label">Precip</h4>
                                                    <h4 class="weather-humidity-1"></h4>
                                                </div>
                                            </div>
                                            <!-- END Tomorrow Forcast API -->
                                        </li>
                                        <li class="day">
                                            <div class="weekdays">
                                                <?php echo (date('D M d', strtotime('+ 2 DAY'))); ?>
                                            </div>
                                            <!-- Day After Forcast API -->
                                            <div class="weather">
                                                <i class="weather-icon weather-icon-2"></i>
                                                <h4 class="weather-description-2"></h4>
                                                <div class="weather-temp-forecast-container">
                                                    <h4 class="weather-temp-forecast-label">High</h4>
                                                    <h3 class="weather-temp-max-2"></h3>
                                                </div>
                                                <div class="weather-temp-forecast-container">
                                                    <h4 class="weather-temp-forecast-label">Low</h4>
                                                    <h3 class="weather-temp-min-2"></h3>
                                                </div>
                                                <div class="weather-temp-forecast-container">
                                                    <h4 class="weather-temp-forecast-label">Precip</h4>
                                                    <h4 class="weather-humidity-2"></h4>
                                                </div>

                                            </div>
                                            <!-- END Day After Forcast API -->
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<!-- Weather API Setup -->