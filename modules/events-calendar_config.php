<?php

$calendar_vars = array (

	'testing' => false,
	'db_tablename' => 'calendar',
	'column_names' => 'stime,title,event,date,detailsmini,location,`int1`',
	'event_view_template' => '<li class="event__%event%">
	        <div align="left" class="show-for-large event-desc">%stime% <a href="events-single.php?choice=%int1%&conn=%conn%" title="%title%">%title%</a></div>
	        <div align="left" class="show-for-medium-only event-desc">%stime% <a href="events-single.php?choice=%int1%" title="%title%">%title%</a></div>
	        <div align="left" class="show-for-small-only smallscreen-rotate-note event-desc"><a href="events-single.php?choice=%int1%" title="%title%">%title%</a></div>
	        <div align="left" class="show-for-small-only event-desc"><a href="events-single.php?choice=%int1%" title="%title%">%stime%</a></div>
	    </li>',
	'event_time_format' => 'g:i a'
);

?>
