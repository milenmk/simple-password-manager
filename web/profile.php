<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: profile.php
 *  Last Modified: 28.12.22 г., 17:15 ч.
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

/**
 * \file        profile.php
 */

//Include main files
include_once('main.inc.php');

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
	header('location: ' . MAIN_URL_ROOT . '/login.php');
	exit;
}

global $user, $langs;

$error = '';
$message = '';

$langs->loadLangs(['errors']);

//Initiate POSt parameters
$theme = $user->theme ? : 'default';
$action = GETPOST('action', 'alpha');
$id = GETPOST('id', 'int');

$first_name = GETPOST('first_name', 'alpha');
$last_name = GETPOST('last_name', 'alpha');
$username = GETPOST('email', 'az09');
$old_password = GETPOST('old_password', 'az09');
$new_password = GETPOST('new_password', 'az09');
$confirm_password = GETPOST('confirm_password', 'az09');
$user_theme = GETPOST('user_theme', 'alpha');
$user_language = GETPOST('user_language', 'alpha');

//Action
if ($action == 'update_user') {

	$user->first_name = $first_name;
	$user->last_name = $last_name;
	$user->username = $username;
	$user->theme = $user_theme;
	$user->language = $user_language;

	$result = $user->update();
	if ($result > 0) {
		$action = 'view';
		header('Location: profile.php');
	} else {
		$error = $user->error;
		$action = 'view';
	}
}
if ($action == 'change_password') {

	// Check if input fields are is empty
	if (empty(trim($old_password))) {
		$error = $langs->trans('PasswordEmpty');
	} else {
		$old_password = trim($old_password);
	}
	if (empty(trim($new_password))) {
		$error = $langs->trans('PasswordNewEmpty');
	} else {
		$new_password = trim($new_password);
	}
	if (empty(trim($confirm_password))) {
		$error = $langs->trans('PasswordNewConfirmEmpty');
	} else {
		$confirm_password = trim($confirm_password);
	}
	if (!password_verify($old_password, $user->password)) {
		$error = $langs->trans('WrongPassword');
	}
	if ($new_password != $confirm_password) {
		$error = $langs->trans('PasswordsDidNotMatch');
	}

	if (!$error) {
		$param_password = password_hash($new_password, PASSWORD_DEFAULT); // Creates a password hash
		$user->password = $param_password;

		$result = $user->update();

		if ($result > 0) {
			$message = $langs->trans('PassUpdateSuccess');
		} else {
			$error = $user->error;
		}
	}
	$action = 'edit_password';
}

pm_logout_block();

//View
pm_header();

pm_navbar();

if ($action == 'view' || empty($action)) {
	?>
    <div class="container mt-5">
		<?php
		pm_message_block()
		?>
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="<?= MAIN_URL_ROOT ?>/theme/<?= $theme ?>/img/profile.png" class="img-fluid" alt="profile image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="post" id="update_user">
                    <input type="hidden" name="action" value="update_user"/>
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example3"><?= $langs->trans('FirstName') ?>
                            <input name="first_name" type="text" id="form3Example3" class="form-control form-control-lg" value="<?= $user->first_name ?>"/>
                        </label>
                    </div>

                    <!-- Last name input -->
                    <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example3"><?= $langs->trans('LastName') ?>
                            <input name="last_name" type="text" id="form3Example3" class="form-control form-control-lg" value="<?= $user->last_name ?>"/>
                        </label>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="form3Example3"><?= $langs->trans('EmailAddress') ?>
                            <input name="email" type="email" id="form3Example3" class="form-control form-control-lg" value="<?= $user->username ?>"/>
                        </label>
                    </div>

                    <!-- Theme select -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="form3Example3"><?= $langs->trans('Theme') ?>
                            <select class="form-select" name="user_theme">
								<?php
								$folders = array_filter(glob(MAIN_DOCUMENT_ROOT . '/theme/*'), 'is_dir');
								foreach ($folders as $folder) {
									$folder = substr(strrchr($folder, '/'), 1);
									if ($folder == $user->theme) {
										print '<option value="' . $user->theme . '" selected>' . $user->theme . '</option>';
									} else {
										print '<option value="' . $folder . '">' . $folder . '</option>';
									}
								}
								?>
                            </select>
                        </label>
                    </div>

                    <!-- Language select -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="form3Example3"><?= $langs->trans('Language') ?>
                            <select class="form-select" name="user_language">
								<?php
								$folders = array_filter(glob(MAIN_DOCUMENT_ROOT . '/langs/*'), 'is_dir');
								foreach ($folders as $folder) {
									$folder = substr(strrchr($folder, '/'), 1);
									if ($folder == $user->language) {
										print '<option value="' . $user->language . '" selected>' . $langs->trans($user->language) . '</option>';
									} else {
										print '<option value="' . $folder . '">' . $langs->trans($folder) . '</option>';
									}
								}
								?>
                            </select>
                        </label>
                    </div>

                    <div class="text-center text-lg-start mt-3 pt-2">
                        <input class="btn btn-primary btn-lg pe-3 ps-3" type="submit" name="submit" value="<?= $langs->trans('Confirm') ?>"/>
                    </div>
                </form>
                <form method="post" id="edit_password">
                    <input type="hidden" name="action" value="edit_password"/>
                    <input class="btn btn-primary btn-lg mt-3 pe-3 ps-3" type="submit" name="submit" value="<?= $langs->trans('ChangePassword') ?>"/>
                </form>
            </div>
        </div>
    </div>
	<?php
} elseif ($action == 'edit_password') {
	?>
    <div class="container mt-5">
		<?php
		pm_message_block()
		?>
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="<?= MAIN_URL_ROOT ?>/theme/<?= $theme ?>/img/profile.png" class="img-fluid" alt="profile image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="post">
                    <input type="hidden" name="action" value="change_password"/>

                    <!-- Old password input -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="old_password"><?= $langs->trans('CurrentPassword') ?>
                            <input name="old_password" type="password" id="old_password" class="form-control form-control-lg" placeholder="<?= $langs->trans('EnterPassword') ?>"/>
                        </label>
                    </div>

                    <!-- New input -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="new_password"><?= $langs->trans('NewPassword') ?>
                            <input name="new_password" type="password" id="new_password" class="form-control form-control-lg" placeholder="<?= $langs->trans('EnterPassword') ?>"/>
                        </label>
                    </div>

                    <!-- Confirm New Password input -->
                    <div class="form-outline mb-3">
                        <label class="form-label" for="confirm_password"><?= $langs->trans('ConfirmNewPassword') ?>
                            <input name="confirm_password" type="password" id="confirm_password" class="form-control form-control-lg"
                                   placeholder="<?= $langs->trans('ConfirmPassword') ?>"/>
                        </label>
                    </div>

                    <div class="text-center text-lg-start mt-3 pt-2">
                        <input class="btn btn-primary btn-lg me-3 pe-3 ps-3" type="submit" name="submit" value="<?= $langs->trans('Confirm') ?>"/>
                    </div>

                </form>
            </div>
        </div>
    </div>
	<?php
}
pm_footer();

$conn = null;