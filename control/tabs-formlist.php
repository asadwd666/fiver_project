        <tr>
            <td>
                <div class="small-12 medium-12 large-8 columns">
                    <a href="<?php echo "{$row['url']}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> <?php if ($row['window'] == '') { ?>target="_blank"<?php }; ?> onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?> <?php echo "{$row['title']}"; ?></a>
                    <?php if ($row['rednote'] !== ''){ ?><br><span class="note-red"><?php echo "{$row['rednote']}"; ?></span><?php }; ?>
                </div>
                <div class="small-6 medium-6 large-2 columns">
                    <form name="TabEdit" method="POST" action="tabs-edit.php">
	                    <input type="hidden" name="action" value="edit">
	                    <input type="hidden" name="module" value="<?php echo "{$module}"; ?>">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Edit" class="submit" type="submit">
	                </form>
                </div>
                <div class="small-6 medium-6 large-2 columns">
                    <form name="TabEdit" method="POST" action="forms-edit.php">
	                    <input type="hidden" name="action" value="edit">
	                    <input type="hidden" name="module" value="<?php echo "{$module}"; ?>">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Customize" class="submit" type="submit">
                    </form>
                </div>
            </td>
            <td><?php echo "{$row['int1']}"; ?></td>
            <td><?php echo "{$row['tabname']}"; ?></td>
<?php if ($row['int1'] <= '449' ){ ?>
<?php
	$int1FORM    = $row['int1'];
	$queryFORM  = "SELECT email FROM forms WHERE `int1` = '$int1FORM'";
	$resultFORM = mysqli_query($conn,$queryFORM);

	while($rowFORM = $resultFORM->fetch_array(MYSQLI_ASSOC))
	{
?>
            <td><?php echo "{$rowFORM['email']}"; ?></td>
<?php
	}
?>
<?php }; ?>
<?php if ($row['int1'] >= '475' ){ ?>
<?php
	$int1FORM    = $row['int1'];
	$queryFORM  = "SELECT email FROM forms WHERE `int1` = '$int1FORM'";
	$resultFORM = mysqli_query($conn,$queryFORM);

	while($rowFORM = $resultFORM->fetch_array(MYSQLI_ASSOC))
	{
?>
            <td><?php echo "{$rowFORM['email']}"; ?></td>
<?php
	}
?>
<?php }; ?>
            <td align="center" width="10" <?php if ($row['owner'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['owner'] !== 'X'){ ?><?php echo "{$row['owner']}"; ?><?php }; ?></td>
            <td align="center" width="10" <?php if ($row['lease'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['lease'] !== 'X'){ ?><?php echo "{$row['lease']}"; ?><?php }; ?></td>
            <td align="center" width="10" <?php if ($row['realtor'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['realtor'] !== 'X'){ ?><?php echo "{$row['realtor']}"; ?><?php }; ?></td>
        </tr>
