<?php

$calendar_vars = array (

	'testing' => false,
	'db_tablename' => 'calendar',
	'column_names' => 'stime,title,event,date,detailsmini,location,`int1`',
	'event_view_template' => '<li class="event__%event%">
	        <div align="left" class="show-for-large event-desc">%stime% %title%</div>
	    </li>',
	'event_time_format' => 'g:i a'
);

?>
