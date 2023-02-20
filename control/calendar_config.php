<?php

$calendar_vars = array (

	'testing' => false,
	'db_tablename' => 'calendar',
	'column_names' => 'stime,title,event,date,`int1`', `parent_int1`,
	'event_view_template' => '
	    <li class="event__%event%">
	        <div align="left" class="show-for-large">%stime% %title%<br>
                <div style="float:left; padding:2px;">
                    <form name="CalDup" method="POST" action="calendar-duplicate.php">
                        <input type="hidden" name="action" value="duplicate">
                        <input type="hidden" name="int1" value="%int1%">
                        <input name="submit" value="Copy" class="submit" type="submit">
                    </form>
                </div>
                <div style="float:left; padding:2px;">
                    <form name="CalEdit" method="POST" action="calendar-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="int1" value="%int1%">
                        <input name="submit" value="Edit" class="submit" type="submit">
                    </form>
                </div>
                <div style="float:left; padding:2px;">
                    <form name="CalDelete" method="POST" action="calendar.php" onclick="return confirm(`Are you sure you want to delete %title% on %date%`);">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="int1" value="%int1%">
                        <input name="submit" value="Del" class="submit" type="submit">
                    </form>
                </div>
                <div style="float:left; padding:2px;display:%showdel%">
                    <form name="CalDeleteAll" method="POST" action="calendar.php" onclick="return confirm(`Are you sure you want to delete all occurances of %title%` from this date forward);">
                        <input type="hidden" name="action" value="delete_all">
                        <input type="hidden" name="int1" value="%int1%">
                        <input type="hidden" name="parent_int1" value="%parent_int1%">
                        <input name="submit" value="Del Srs" class="submit" type="submit">
                    </form>
                </div>
                
                <br>
                <br>
	        </div>
	        <div align="left" class="show-for-medium-only">%stime% %title%<br>
                <div style="float:left; padding:2px;">
                    <form name="CalDup" method="POST" action="calendar-duplicate.php">
                        <input type="hidden" name="action" value="duplicate">
                        <input type="hidden" name="int1" value="%int1%">
                        <input name="submit" value="C" class="submit" type="submit">
                    </form>
                </div>
                <div style="float:left; padding:2px;">
                    <form name="CalEdit" method="POST" action="calendar-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="int1" value="%int1%">
                        <input name="submit" value="E" class="submit" type="submit">
                    </form>
                </div>
                <div style="float:left; padding:2px;">
                    <form name="CalDelete" method="POST" action="calendar.php" onclick="return confirm(`Are you sure you want to delete %title% on %date%`);">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="int1" value="%int1%">
                        <input name="submit" value="D" class="submit" type="submit">
                    </form>
                </div>
                <div style="float:left; padding:2px;display:%showdel%">
                    <form name="CalDeleteAll" method="POST" action="calendar.php" onclick="return confirm(`Are you sure you want to delete all occurances of %title%`);">
                        <input type="hidden" name="action" value="delete_all">
                        <input type="hidden" name="int1" value="%int1%">
                        <input type="hidden" name="parent_int1" value="%parent_int1%">
                        <input name="submit" value="DS" class="submit" type="submit">
                    </form>
                </div>
                <br>
                <br>
	        </div>
	        <div align="left" class="show-for-small-only smallscreen-rotate-note">%stime% %title%<br>
                <div style="float:left; padding:2px;">
                    <form name="CalDup" method="POST" action="calendar-duplicate.php">
                        <input type="hidden" name="action" value="duplicate">
                        <input type="hidden" name="int1" value="%int1%">
                        <input name="submit" value="C" class="submit" type="submit">
                    </form>
                </div>
                <div style="float:left; padding:2px;">
                    <form name="CalEdit" method="POST" action="calendar-edit.php">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="int1" value="%int1%">
                        <input name="submit" value="E" class="submit" type="submit">
                    </form>
                </div>
                <div style="float:left; padding:2px;">
                    <form name="CalDelete" method="POST" action="calendar.php" onclick="return confirm(`Are you sure you want to delete %title% on %date%`);">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="int1" value="%int1%">
                        <input name="submit" value="D" class="submit" type="submit">
                    </form>
                </div>
                <div style="float:left; padding:2px;display:%showdel%">
                    <form name="CalDeleteAll" method="POST" action="calendar.php" onclick="return confirm(`Are you sure you want to delete all occurances of %title%` from this date forward);">
                        <input type="hidden" name="action" value="delete_all">
                        <input type="hidden" name="int1" value="%int1%">
                        <input type="hidden" name="parent_int1" value="%parent_int1%">
                        <input name="submit" value="DS" class="submit" type="submit">
                    </form>
                </div>
                <br>
                <br>
	        </div>
	        <div align="left" class="show-for-small-only">%stime%</div>
	    </li>
    ',
	'event_time_format' => 'g:i a'
);

?>
