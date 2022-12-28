<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: records.php
 *  Last Modified: 28.12.22 г., 2:48 ч.
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
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
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
$fk_domain = GETPOST('fk_domain', 'int');
$type = GETPOST('type', 'int');
$db_name = GETPOST('db_name', 'az09');
$url = GETPOST('url', 'az09');
$ftp_server = GETPOST('ftp_server', 'az09');
$username = GETPOST('username', 'az09');
$password = GETPOST('password', 'alpha');

//Set objects
$records = new records();
$domains = new domains();

//Actions
if ($action == 'confirm_edit') {
	$records->id = $id;
	if ($fk_domain) {
		$records->fk_domain = $fk_domain;
	}
	if ($type == 1) {
		$records->is_db = 1;
		$records->is_ftp = 0;
		$records->is_site = 0;
		$records->dbase_name = $url;
	} elseif ($type == 2) {
		$records->is_db = 0;
		$records->is_ftp = 0;
		$records->is_site = 1;
		$records->url = $url;
	} elseif ($type == 3) {
		$records->is_db = 0;
		$records->is_ftp = 1;
		$records->is_site = 0;
		$records->ftp_server = $url;
	}
	if ($username) {
		$records->username = $username;
	}
	if ($password) {
		$records->password = $password;
	}
	$result = $records->update();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		print $result;
	}
}
if ($action == 'delete') {
	$records->id = $id;
	$result = $records->delete();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		print $result;
	}
}
if ($action == 'create') {
	$records->fk_domain = $fk_domain;
	$records->fk_user = $user->id;
	if ($type == 1) {
		$records->is_db = 1;
		$records->is_ftp = 0;
		$records->is_site = 0;
		$records->dbase_name = $url;
	} elseif ($type == 2) {
		$records->is_db = 0;
		$records->is_ftp = 0;
		$records->is_site = 1;
		$records->url = $url;
	} elseif ($type == 3) {
		$records->is_db = 0;
		$records->is_ftp = 1;
		$records->is_site = 0;
		$records->ftp_server = $url;
	}
	$records->username = $username;
	$records->password = $password;
	$result = $records->create();
	if ($result > 0) {
		$url = htmlspecialchars($_SERVER['PHP_SELF']);
		header('Location:' . $url);
	} else {
		print $result;
	}
}
if ($action == 'logout') {
	$_SESSION = [];

	// Destroy the session.
	session_destroy();

	// Redirect to login page
	header('location: ' . MAIN_URL_ROOT . '/login.php');
	exit;
}

//View
pm_header();

pm_navbar();

if ($action == 'view') {
	?>
    <div class="container mt-5">
		<?php
		pm_error_block()
		?>
        <table class="table table-success table-striped">
            <thead>
            <tr>
                <th scope="col"><?= $langs->trans('Domain') ?></th>
                <th scope="col"><?= $langs->trans('Type') ?></th>
                <th scope="col"><?= $langs->trans('Link') ?></th>
                <th scope="col"><?= $langs->trans('Username') ?></th>
                <th scope="col"><?= $langs->trans('Password') ?></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
			<?php
			if ($fk_domain) {
				$res = $records->fetch($user->id, '', $fk_domain);
			} else {
				$res = $records->fetch($user->id);
			}
			if ($res > 0) {
				foreach ($res as $result) {
					print '<tr>';

					$obj = $domains->fetch($user->id, $result->fk_domain);
					foreach ($obj as $objtmp) {
						print '<td>' . $objtmp->label . '</td>';
					}
					if ($result->is_db) {
						print '<td>Database</td>';
						print '<td>' . $result->dbase_name . '</td>';
					} elseif ($result->is_site) {
						print '<td>Website</td>';
						print '<td>' . $result->url . '</td>';
					} elseif ($result->is_ftp) {
						print '<td>FTP</td>';
						print '<td>' . $result->ftp_server . '</td>';
					} else {
						print '<td></td>';
					}

					print '<td>' . $result->username . '</td>';
                    require_once('../docs/secret.key');
					$password = openssl_decrypt($result->pass_crypted, $ciphering, $decryption_key, $options, $decryption_iv);
					print '<td>' . $password . '</td>';

					print '<td>';
					print '<div class="d-grid gap-2 d-md-flex justify-content-md-end">';

					print '<form method="post">';
					print '<input type="hidden" name="id" value="' . $result->line_id . '" />';
					print '<input type="hidden" name="action" value="edit" />';
					print '<input class="btn btn-success btn-sm" type="submit" name="submit" value="'.$langs->trans('Edit').'"/>';
					print '</form>';

					print '<form method="post">';
					print '<input type="hidden" name="id" value="' . $result->line_id . '" />';
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
		pm_error_block()
		?>
        <form method="post">
            <table class="table table-success table-striped">
                <thead>
                <tr>
                    <th scope="col"><?= $langs->trans('Domain') ?></th>
                    <th scope="col"><?= $langs->trans('Type') ?></th>
                    <th scope="col"><?= $langs->trans('Link') ?></th>
                    <th scope="col"><?= $langs->trans('Username') ?></th>
                    <th scope="col"><?= $langs->trans('Password') ?></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
				<?php
				$res = $records->fetch($user->id, $id);
				if ($res > 0) {
					foreach ($res as $result) {
						print '<tr>';
						print '<input type="hidden" name="id" value="' . $result->line_id . '" />';
						print '<input type="hidden" name="action" value="confirm_edit" />';

						$obj = $domains->fetch($user->id);
						if ($obj) {
							print '<td><select name="fk_domain">';
							foreach ($obj as $objtmp) {
								if ($objtmp->id == $result->fk_domain) {
									print '<option value=' . $objtmp->id . ' selected>' . $objtmp->label . '</option>';
								} else {
									print '<option value=' . $objtmp->id . '>' . $objtmp->label . '</option>';
								}
							}
							print '</select></td>';
						}

						print '<td><select name="type">';
						print '<option value="1">DATABASE</option>';
						print '<option value="2">WEBSITE</option>';
						print '<option value="3">FTP_SERVER</option>';
						print '</select></td>';
						if ($result->is_db) {
							print '<td><input type="text" name="url" value="' . $result->dbase_name . '" /></td>';
						} elseif ($result->is_site) {
							print '<td><input type="text" name="url" value="' . $result->url . '" /></td>';
						} elseif ($result->is_ftp) {
							print '<td><input type="text" name="url" value="' . $result->ftp_server . '" /></td>';
						} else {
							print '<td></td>';
						}
						print '<td><input type="text" name="username" value="' . $result->username . '" /></td>';

						require_once('../docs/secret.key');
						$password = openssl_decrypt($result->pass_crypted, $ciphering, $decryption_key, $options, $decryption_iv);
						print '<td><input type="password" name="password" value="' . $password . '" /></td>';

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
		pm_error_block()
		?>
        <table class="table table-success table-striped">
            <thead>
            <tr>
                <th scope="col"><?= $langs->trans('Domain') ?></th>
                <th scope="col"><?= $langs->trans('Type') ?></th>
                <th scope="col"><?= $langs->trans('Link') ?></th>
                <th scope="col"><?= $langs->trans('Username') ?></th>
                <th scope="col"><?= $langs->trans('Password') ?></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
			<?php
			$res = $records->fetch($user->id, '', '', '', '', '', $search_string);
			if ($res > 0) {
				foreach ($res as $result) {
					print '<tr>';

					$obj = $domains->fetch($user->id, $result->fk_domain);
					foreach ($obj as $objtmp) {
						print '<td>' . $objtmp->label . '</td>';
					}

					if ($result->is_db) {
						print '<td>Database</td>';
						print '<td>' . $result->dbase_name . '</td>';
					} elseif ($result->is_site) {
						print '<td>Website</td>';
						print '<td>' . $result->url . '</td>';
					} elseif ($result->is_ftp) {
						print '<td>FTP</td>';
						print '<td>' . $result->ftp_server . '</td>';
					} else {
						print '<td></td>';
					}

					print '<td>' . $result->username . '</td>';
					require_once('../docs/secret.key');
					$password = openssl_decrypt($result->pass_crypted, $ciphering, $decryption_key, $options, $decryption_iv);
					print '<td>' . $password . '</td>';

					print '<td>';
					print '<div class="d-grid gap-2 d-md-flex justify-content-md-end">';

					print '<form method="post">';
					print '<input type="hidden" name="id" value="' . $result->line_id . '" />';
					print '<input type="hidden" name="action" value="edit" />';
					print '<input class="btn btn-success btn-sm" type="submit" name="submit" value="'.$langs->trans('Edit').'"/>';
					print '</form>';

					print '<form method="post">';
					print '<input type="hidden" name="id" value="' . $result->line_id . '" />';
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
} elseif ($action == 'add_record') {
	?>
    <div class="container mt-5">
		<?php
		pm_error_block()
		?>
        <form method="get">
            <input type="hidden" name="action" value="create"/>
            <table class="table table-success table-striped">
                <thead>
                <tr>
                    <th scope="col"><?= $langs->trans('Domain') ?></th>
                    <th scope="col"><?= $langs->trans('Type') ?></th>
                    <th scope="col"><?= $langs->trans('Link') ?></th>
                    <th scope="col"><?= $langs->trans('Username') ?></th>
                    <th scope="col"><?= $langs->trans('Password') ?></th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <tr>
					<?php
					$result = $domains->fetch($user->id);
					if ($result > 0) {
						print '<td><select name="fk_domain">';
						foreach ($result as $res) {
							print '<option value=' . $res->id . '>' . $res->label . '</option>';
						}
						print '</select></td>';
					} else {
						print 'Please first add domain';
						exit;
					}
					?>
                    <td>
                        <label>
                            <select name="type">
                                <option value="1">DATABASE</option>
                                <option value="2">WEBSITE</option>
                                <option value="3">FTP_SERVER</option>
                            </select>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="url"/>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="username"/>
                        </label>
                    </td>
                    <td>
                        <label>
                            <input type="password" name="password"/>
                        </label>
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
