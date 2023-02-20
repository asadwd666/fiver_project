        <tr>
            <td>
                <div class="small-12 medium-12 large-8 columns">
                    <a href="<?php echo "{$row['url']}"; ?>" <?php if ($row['window'] !== '') { ?><?php echo "{$row['window']}"; ?><?php }; ?> <?php if ($row['window'] == '') { ?>target="_blank"<?php }; ?> onclick="javascript:pageTracker._trackPageview('ColumnLink/<?php echo "{$row['title']}"; ?>'); "><?php echo "{$row['image']}"; ?> <?php echo "{$row['title']}"; ?></a>
                    <?php if ($row['rednote'] !== ''){ ?><br><span class="note-red"><?php echo "{$row['rednote']}"; ?></span><?php }; ?>
                </div>
                <div class="small-6 medium-6 large-2 columns">
	                <?php if ($_SESSION['webmaster'] == '0'){ ?>
                    <?php if ($row['liaison'] == 'Y'){ ?>
	                <?php if (($row['owner'] == 'X') && ($row['lease'] == 'X') && ($row['realtor'] == 'X')){ } else { ?>
	                <form name="TabEdit" method="POST" action="tabs-edit.php">
	                    <input type="hidden" name="action" value="edit">
	                    <input type="hidden" name="module" value="<?php echo "{$module}"; ?>">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Edit" class="submit" type="submit">
	                </form>
	                <?php }; ?>
                    <?php }; ?>
	                <?php }; ?>
	                <?php if ($row['liaison'] != 'Y' && $_SESSION['webmaster'] == '0'){ ?>
	                <span class="note-red">Contact CondoSites to edit this item.</span>
	                <?php }; ?>
	                <?php if ($_SESSION['webmaster'] != '0'){ ?>
	                <form name="TabEdit" method="POST" action="tabs-edit.php">
	                    <input type="hidden" name="action" value="edit">
	                    <input type="hidden" name="module" value="<?php echo "{$module}"; ?>">
	                    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
	                    <input name="submit" value="Edit" class="submit" type="submit">
	                </form>
	                <?php }; ?>
                </div>
                <div class="small-6 medium-6 large-2 columns">
					<?php if ($row['liaison'] == 'Y' AND $row['int1'] >= '500' AND $row['int1'] <= '699'){ ?>
					<form name="TabDelete" method="POST" action="3rd.php" onclick="return confirm('Are you sure you want to delete the module: <?php echo "{$row['title']}"; ?>?');">
					    <input type="hidden" name="action" value="delete">
					    <input type="hidden" name="module" value="<?php echo "{$module}"; ?>">
					    <input type="hidden" name="int1" value="<?php echo "{$row['int1']}"; ?>">
					    <input name="submit" value="Delete" class="submit" type="submit">
					</form>
					<?php }; ?>
				</div>
            </td>
            <td><?php echo "{$row['int1']}"; ?></td>
            <td><span class="text"><?php echo "{$row['tabname']}"; ?></span></td>
            <td align="center" width="10" <?php if ($row['owner'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['owner'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['owner'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['owner'] !== 'X'){ ?><?php echo "{$row['owner']}"; ?><?php }; ?></td>
            <td align="center" width="10" <?php if ($row['lease'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['lease'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['lease'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['lease'] !== 'X'){ ?><?php echo "{$row['lease']}"; ?><?php }; ?></td>
            <td align="center" width="10" <?php if ($row['realtor'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['realtor'] !== 'Y'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['realtor'] !== 'N'){ ?>bgcolor="#ccffcc"<?php }; ?>><?php if ($row['realtor'] !== 'X'){ ?><?php echo "{$row['realtor']}"; ?><?php }; ?></td>
            <td align="center" width="10" <?php if ($row['public'] == 'X'){ ?>bgcolor="#ededed"<?php }; ?><?php if ($row['public'] == 'N'){ ?>bgcolor="#ffcccc"<?php }; ?><?php if ($row['public'] == 'Y'){ ?>bgcolor="#ccffcc"<?php }; ?><?php if ($row['public'] == 'H'){ ?>bgcolor="#caecec"<?php }; ?>><?php if ($row['public'] !== 'X'){ ?><?php echo "{$row['public']}"; ?><?php }; ?></td>
        </tr>
