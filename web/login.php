<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: login.php
 *  Last Modified: 28.12.22 г., 1:05 ч.
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
 * \file        login.php
 */

//Include main files
include_once('main.inc.php');

global $user, $langs;

// Check if the user is already logged in, if yes then redirect him to welcome page
if ($user->id > 0) {
	header('location: ' . MAIN_URL_ROOT);
	exit;
}

//Initiate POSt parameters
$theme = GETPOST('theme', 'alpha') ? GETPOST('theme', 'alpha') : 'default';
$action = GETPOST('action', 'alpha') ? GETPOST('action', 'alpha') : 'view';

// Define variables and initialize with empty values
$username = GETPOST('email', 'az09');
$password = GETPOST('password', 'az09');
$confirm_password = GETPOST('confirm_password', 'az09');
$username_err = GETPOST('username_err', 'az09');
$password_err = GETPOST('password_err', 'az09');
$login_err = GETPOST('login_err', 'alpha');

//Actions
if ($action == 'login_user') {

	// Check if username is empty
	if (empty(trim($username))) {
		$username_err = 'Please enter username.';
	} else {
		$username = trim($username);
	}

	// Check if password is empty
	if (empty(trim($password))) {
		$password_err = 'Please enter your password.';
	} else {
		$password = trim($password);
	}

	if (empty($username_err) && empty($password_err)) {
		$result = $user->fetch('', '', '', '', $username);
		if ($result > 0) {
			if (password_verify($password, $user->password)) {
				// Password is correct, so start a new session
				session_start();

				// Store data in session variables
				$_SESSION['loggedin'] = true;
				$_SESSION['id'] = $user->id;
				$_SESSION['username'] = $username;

				// Redirect user to welcome page
				header('location: ' . MAIN_URL_ROOT);
			} else {
				// Password is not valid, display a generic error message
				$login_err = 'Invalid username or password.';
			}
		} else {
			// Username doesn't exist, display a generic error message
			$login_err = 'Invalid username or password.';
		}
	}
}

//View
pm_header();

pm_navbar();

?>
    <div class="container-fluid h-custom mt-5">
		<?php
		pm_error_block()
		?>
        <div class="container text-center">
            <div class="row">
                <div class="col"></div>
                <div class="col">
					<?php
					if ($username_err || $password_err || $login_err) {
						print '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
						if ($username_err) {
							print '<strong>' . $username_err . '</strong>';
						} elseif ($password_err) {
							print '<strong>' . $password_err . '</strong>';
						} elseif ($login_err) {
							print '<strong>' . $login_err . '</strong>';
						}
						print '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
						print '</div>';
					}
					?>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5">
                <img src="<?= MAIN_URL_ROOT ?>/theme/<?= $theme ?>/img/draw2.webp" class="img-fluid" alt="login image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <form method="post">
                    <input type="hidden" name="action" value="login_user"/>
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input name="email" type="email" id="form3Example3" class="form-control form-control-lg" placeholder="Enter a valid email address"/>
                        <label class="form-label" for="form3Example3"><?= $langs->trans('EmailAddress') ?></label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-3">
                        <input name="password" type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password"/>
                        <label class="form-label" for="form3Example4"><?= $langs->trans('Password') ?></label>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <input class="btn btn-primary btn-lg" type="submit" name="submit" value="<?= $langs->trans('Login') ?>" style="padding-left: 2.5rem; padding-right: 2.5rem;"/>
                    </div>

                    <div class="text-center text-lg-start mt-4 pt-2">
                        <p class="small fw-bold mt-2 pt-1 mb-0"><?= $langs->trans('NoAccountQuestion') ?>? <a href="register.php" class="link-danger"><?= $langs->trans('Register') ?></a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>
<?php

pm_footer();

$conn = null;