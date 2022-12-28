<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: register.php
 *  Last Modified: 28.12.22 г., 1:06 ч.
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
 * \file        register.php
 */

//Include main files
include_once('main.inc.php');

global $user, $langs;

$error = '';

$langs->loadLangs(['errors']);

// Check if the user is already logged in, if yes then redirect him to welcome page
if ($user->id > 0) {
	header('location: ' . MAIN_URL_ROOT);
	exit;
}

//Initiate POSt parameters
$theme = GETPOST('theme', 'alpha') ? GETPOST('theme', 'alpha') : 'default';
$action = GETPOST('action', 'alpha') ? GETPOST('action', 'alpha') : 'view';

// Define variables and initialize with empty values
$first_name = GETPOST('first_name', 'alpha');
$last_name = GETPOST('last_name', 'alpha');
$username = GETPOST('email', 'az09');
$password = GETPOST('password', 'az09');
$confirm_password = GETPOST('confirm_password', 'az09');

//Actions
if ($action == 'create_user') {

	//Validate firstname
	if ($first_name) {
		if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($first_name))) {
			$error = $langs->trans('FirstNameContentError');
		}
	}

	//Validate last name
	if ($last_name) {
		if (!preg_match('/^[a-zA-Z0-9_]+$/', trim($last_name))) {
			$error = $langs->trans('LastNameContentError');
		}
	}

	// Validate password
	if (empty(trim($password))) {
		$error = $langs->trans('PasswordEmpty');
	} elseif (strlen(trim($password)) < 6) {
		$error = $langs->trans('PasswordLengthError');
	}

	// Validate confirm password
	if (empty(trim($confirm_password))) {
		$error = $langs->trans('PasswordConfirmEmpty');
	} else {
		$confirm_password = trim($confirm_password);
		if (empty($password_err) && ($password != $confirm_password)) {
			$error = $langs->trans('PasswordsDidNotMatch');
		}
	}

	if (empty(trim($username))) {
		$username_err = $langs->trans('PleaseEnterUsername');
	} elseif (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', trim($username))) {
		$error = $langs->trans('UsernameContentError');
	}
	if (!$error) {
		$result = $user->fetch('', '', '', '', $username);

		if ($user->num > 0) {
			$error = $langs->trans('UserNameTaken');
		} elseif ((empty($user->num) || $result < 0) && empty($error)) {
			$usertmp = new user();
			$usertmp->first_name = $first_name;
			$usertmp->last_name = $last_name;
			$usertmp->username = $username;
			$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
			$usertmp->password = $param_password;
			$res = $usertmp->create();

			if ($res > 0) {
				header('Location: ' . MAIN_URL_ROOT . '/login.php');
			} else {
				$error = $langs->trans('GeneralError');
			}
		} else {
			$error = $langs->trans('GeneralError');
		}
	}
}

//View
pm_header();

pm_navbar();
?>
    <div class="container-fluid h-custom mt-5">
		<?php
		pm_message_block()
		?>
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="<?= MAIN_URL_ROOT ?>/theme/<?= $theme ?>/img/draw2.webp" class="img-fluid" alt="login image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="post">
                    <input type="hidden" name="action" value="create_user"/>

                    <!-- First name input -->
                    <div class="form-outline mb-4">
                        <input name="first_name" type="text" id="form3Example3" class="form-control form-control-lg" placeholder="<?= $langs->trans('FirstName') ?>"/>
                        <label class="form-label" for="form3Example3"><?= $langs->trans('FirstName') ?></label>
                    </div>

                    <!-- Last name input -->
                    <div class="form-outline mb-4">
                        <input name="last_name" type="text" id="form3Example3" class="form-control form-control-lg" placeholder="<?= $langs->trans('LastName') ?>"/>
                        <label class="form-label" for="form3Example3"><?= $langs->trans('LastName') ?></label>
                    </div>

                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input name="email" type="email" id="form3Example3" class="form-control form-control-lg" placeholder="<?= $langs->trans('EnterValidEmail') ?>"/>
                        <label class="form-label" for="form3Example3"><?= $langs->trans('EmailAddress') ?></label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <input name="password" type="password" id="form3Example4" class="form-control form-control-lg" placeholder="<?= $langs->trans('EnterPassword') ?>"/>
                        <label class="form-label" for="form3Example4"><?= $langs->trans('Password') ?></label>
                    </div>

                    <!-- Confirm Password input -->
                    <div class="form-outline mb-3">
                        <input name="confirm_password" type="password" id="form3Example4" class="form-control form-control-lg" placeholder="<?= $langs->trans('ConfirmPassword') ?>"/>
                        <label class="form-label" for="form3Example4"><?= $langs->trans('ConfirmPassword') ?></label>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <input class="btn btn-primary btn-lg" type="submit" name="submit" value="<?= $langs->trans('Register') ?>" style="padding-left: 2.5rem; padding-right: 2.5rem;"/>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php

pm_footer();

$conn = null;