<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: index.php
 *  Last Modified: 28.12.22 г., 2:47 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0
 * @version       1.0
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 **/

declare(strict_types = 1);

//Include main files
include_once('main.inc.php');

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
	header('location: ' . MAIN_URL_ROOT . '/login.php');
	exit;
}

global $user, $langs, $theme;

$error = '';

//Initiate POSt parameters
$action = GETPOST('action', 'alpha') ? GETPOST('action', 'alpha') : 'view';
$id = GETPOST('id', 'int');
$label = GETPOST('label', 'az09');
$search_string = GETPOST('search_string', 'az09');

//Set objects
$domain = new domains();

//Actions
if ($action == 'confirm_edit') {
	$domain->id = $id;
	$domain->label = $label;
	$result = $domain->update();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		$error = $domain->error;
	}
}
if ($action == 'delete') {
	$domain->id = $id;
	$result = $domain->delete();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		$error = $domain->error;
	}
}
if ($action == 'create') {
	$domain->fk_user = $user->id;
	$domain->label = $label;
	$result = $domain->create();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		$error = $domain->error;
	}
}
if ($action == 'view_records') {
	header('Location:' . MAIN_URL_ROOT . '/records.php?action=view&fk_domain=' . $id);
}

pm_logout_block();

//View
$error = '';

pm_header();

pm_navbar();

if ($action == 'view') {
	?>
    <div class="container mt-5">
		<?php
		pm_message_block()
		?>
        <table class="table table-success table-striped">
            <thead>
            <tr>
                <th scope="col"><?= $langs->trans('Label') ?></th>
                <th scope="col"><?= $langs->trans('HasWebsite') ?></th>
                <th scope="col"><?= $langs->trans('HasFTP') ?></th>
                <th scope="col"><?= $langs->trans('HasDatabase') ?></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
			<?php
			$res = $domain->fetch($user->id);
			if ($res > 0) {
				foreach ($res as $result) {
					print '<tr>';
					print '<td>' . $result->label . '</td>';
					if ($result->website) {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/yes.png" alt="yes.png" /></td>';
					} else {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/no.png" alt="no.png" /></td>';
					}
					if ($result->ftp) {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/yes.png" alt="yes.png" /></td>';
					} else {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/no.png" alt="no.png" /></td>';
					}
					if ($result->data_base) {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/yes.png" alt="yes.png" /></td>';
					} else {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/no.png" alt="no.png" /></td>';
					}
					print '<td>';
					print '<div class="d-grid gap-2 d-md-flex justify-content-md-end">';

					print '<form method="post">';
					print '<input type="hidden" name="id" value="' . $result->id . '" />';
					print '<input type="hidden" name="action" value="view_records" />';
					print '<input class="btn btn-primary btn-sm" type="submit" name="submit" value="'.$langs->trans('ViewRecords').'"/>';
					print '</form>';

					print '<form method="post">';
					print '<input type="hidden" name="id" value="' . $result->id . '" />';
					print '<input type="hidden" name="action" value="edit" />';
					print '<input class="btn btn-success btn-sm" type="submit" name="submit" value="'.$langs->trans('Edit').'"/>';
					print '</form>';

					print '<form method="post">';
					print '<input type="hidden" name="id" value="' . $result->id . '" />';
					print '<input type="hidden" name="action" value="delete" />';
					print '<input class="btn btn-danger btn-sm" type="submit" name="submit" value="'.$langs->trans('Delete').'"/>';
					print '</form>';

					print '</div>';
					print'</td>';
					print '</tr>';
				}
			}
			?>
            </tbody>
        </table>
    </div>
	<?php
} elseif ($action == 'edit') {
	?>
    <div class="container mt-5">
		<?php
		pm_message_block()
		?>
        <form method="post">
            <table class="table table-success table-striped">
                <thead>
                <tr>
                    <th scope="col"><?= $langs->trans('Label') ?></th>
                    <th scope="col"><?= $langs->trans('HasWebsite') ?></th>
                    <th scope="col"><?= $langs->trans('HasFTP') ?></th>
                    <th scope="col"><?= $langs->trans('HasDatabase') ?></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
				<?php
				$res = $domain->fetch($user->id, $id);
				if ($res > 0) {
					foreach ($res as $result) {
						print '<tr>';
						print '<input type="hidden" name="id" value="' . $result->id . '" />';
						print '<input type="hidden" name="action" value="confirm_edit" />';
						print '<td><input type="text" name="label" value="' . $result->label . '" /></td>';
						if ($result->website) {
							print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/yes.png" alt="yes.png" /></td>';
						} else {
							print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/no.png" alt="no.png" /></td>';
						}
						if ($result->ftp) {
							print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/yes.png" alt="yes.png" /></td>';
						} else {
							print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/no.png" alt="no.png" /></td>';
						}
						if ($result->data_base) {
							print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/yes.png" alt="yes.png" /></td>';
						} else {
							print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/no.png" alt="no.png" /></td>';
						}
						print '<td>';
						print '<div class="d-grid gap-2 d-md-flex justify-content-md-end">';
						print '<input class="btn btn-info" type="submit" name="submit" value="'.$langs->trans('Confirm').'"/>';
                        print '<input type="button" class="btn btn-danger" value="'.$langs->trans('Cancel').'" onclick="javascript:history.go(-1)">';
						print '</div>';
						print'</td>';
						print '</tr>';
					}
				}
				?>
                </tbody>
            </table>
        </form>
    </div>
	<?php
} elseif ($action == 'search') {
	?>
    <div class="container mt-5">
		<?php
		pm_message_block()
		?>
        <table class="table table-success table-striped">
            <thead>
            <tr>
                <th scope="col"><?= $langs->trans('Label') ?></th>
                <th scope="col"><?= $langs->trans('HasWebsite') ?></th>
                <th scope="col"><?= $langs->trans('HasFTP') ?></th>
                <th scope="col"><?= $langs->trans('HasDatabase') ?></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
			<?php
			$res = $domain->fetch($user->id, '', '', '', '', $search_string);
			if ($res > 0) {
				foreach ($res as $result) {
					print '<tr>';
					print '<td>' . $result->label . '</td>';
					if ($result->website) {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/yes.png" alt="yes.png" /></td>';
					} else {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/no.png" alt="no.png" /></td>';
					}
					if ($result->ftp) {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/yes.png" alt="yes.png" /></td>';
					} else {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/no.png" alt="no.png" /></td>';
					}
					if ($result->data_base) {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/yes.png" alt="yes.png" /></td>';
					} else {
						print '<td><img src="' . MAIN_URL_ROOT . '/theme/' . $theme . '/img/no.png" alt="no.png" /></td>';
					}
					print '<td>';
					print '<div class="d-grid gap-2 d-md-flex justify-content-md-end">';

					print '<form method="post">';
					print '<input type="hidden" name="id" value="' . $result->id . '" />';
					print '<input type="hidden" name="action" value="view_records" />';
					print '<input class="btn btn-primary btn-sm" type="submit" name="submit" value="'.$langs->trans('ViewRecords').'"/>';
					print '</form>';

					print '<form method="post">';
					print '<input type="hidden" name="id" value="' . $result->id . '" />';
					print '<input type="hidden" name="action" value="edit" />';
					print '<input class="btn btn-success btn-sm" type="submit" name="submit" value="'.$langs->trans('Edit').'"/>';
					print '</form>';

					print '<form method="post">';
					print '<input type="hidden" name="id" value="' . $result->id . '" />';
					print '<input type="hidden" name="action" value="delete" />';
					print '<input class="btn btn-danger btn-sm" type="submit" name="submit" value="'.$langs->trans('Delete').'"/>';
					print '</form>';

					print '</div>';
					print'</td>';
					print '</tr>';
				}
			}
			?>
            </tbody>
        </table>
    </div>
	<?php
} elseif ($action == 'add_domain') {
	?>
    <div class="container mt-5">
		<?php
		pm_message_block()
		?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="<?= MAIN_URL_ROOT ?>/theme/<?= $theme ?>/js/focus.input.js"></script>
        <form method="get">
            <input type="hidden" name="action" value="create"/>
            <table class="table table-success table-striped">
                <thead>
                <tr>
                    <th scope="col"><?= $langs->trans('Label') ?></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <label for="label"></label>
                        <input type="text" name="label" id="label"/>
                    </td>
                    <td>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <input class="btn btn-info" type="submit" name="submit" value="<?= $langs->trans('Confirm') ?>"/>
                            <input type="button" class="btn btn-danger" value="<?= $langs->trans('Cancel') ?>" onclick="javascript:history.go(-1)">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
	<?php
}

pm_footer();

$conn = null;