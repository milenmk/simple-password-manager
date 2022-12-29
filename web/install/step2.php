<?php /** @noinspection LongLine */

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: step2.php
 *  Last Modified: 28.12.22 г., 2:44 ч.
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

session_start();

/**
 * \file        install/step2.php
 */

?>
    <!DOCTYPE html>
    <html lang="en">
    <head><title>Install</title>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex,nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="blacktiehost.com">
		<?php

		$favicon = '../theme/default/img/favicon.png';
		print '<link rel="shortcut icon" type="image/x-icon" href="' . $favicon . '"/>' . "\n";

		$themepathcss = '../theme/default/css';
		$themeuricss = htmlspecialchars($_SERVER['REQUEST_SCHEME']) . '://' . htmlspecialchars($_SERVER['HTTP_HOST']) . htmlspecialchars($_SERVER['CONTEXT_PREFIX']) . '/theme/default/css';
		foreach (glob($themepathcss . '/*.css') as $css) {
			$file = str_replace($themepathcss, $themeuricss, $css);
			print '<link type="text/css" rel="stylesheet" href="' . htmlspecialchars($file) . '">' . "\n";
		}

		print '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>' . "\n";

		print "</head>\n";

		$error = '';
		$lockerror = '';

		$lockfile = '../../docs/install.lock';
		if (file_exists($lockfile)) {
			$lockerror = 'Install pages have been disabled for security (by the existence of a lock file <strong>install.lock</strong> in the docs directory).<br>';
			$lockerror .= 'If you always reach this page, you must remove install.lock file manually.<br>';
			$error++;
		}

		if (!$lockerror) {
			include_once('../conf/conf.php');

			global $db_host, $port, $db_name, $db_user, $db_pass, $main_db_character_set, $main_db_collation;

			$create_db = $_SESSION['create_database'];
			$root_user = $_SESSION['root_db_user'];
			$root_password = $_SESSION['root_db_pass'];

			$main_db_character_set = str_replace('-', '', $main_db_character_set);

			//Create database using root user
			if ($create_db && !$lockerror) {
				try {
					$conn = new PDO("mysql:host=$db_host;port=$port", $root_user, $root_password);
					$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

					$conn->exec(
						"CREATE DATABASE $db_name DEFAULT CHARACTER SET $main_db_character_set COLLATE $main_db_collation;
                CREATE USER $db_user@'localhost' IDENTIFIED BY '$db_pass';
                GRANT ALL ON $db_name.* TO $db_user@'localhost';
                FLUSH PRIVILEGES;"
					) or die(print_r($conn->errorInfo(), true));
				}
				catch (PDOException $e) {
					$error = 'Connection failed: ' . $e->getMessage();
				}
			}

			$conn = null;

			//Try connecting to database with normal user credentials
			if (!$error || !$lockerror) {
				try {
					$conn2 = new PDO("mysql:host=$db_host;dbname=$db_name;port=$port", $db_user, $db_pass);
					// set the PDO error mode to exception
					$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				}
				catch (PDOException $e) {
					$error = 'Connection failed: ' . $e->getMessage();
				}
			}
		}

		$requestnb = 0;

		//Start creating tables
		if (!$error || !$lockerror) {

			/***************************************************************************************
			 *
			 * Create database tables from *.sql files
			 * Must be done before *.key.sql files
			 *
			 ***************************************************************************************/

			$dir = 'tables/';
			$ok = 0;
			$handle = opendir($dir) or die ('Cannot open dir');
			$tablefound = 0;
			$tabledata = [];
			if (is_resource($handle)) {
				while (($file = readdir($handle)) !== false) {
					if (preg_match('/\.sql$/i', $file) && preg_match('/^pm_/i', $file) && !preg_match('/\.key\.sql$/i', $file)) {
						$tablefound++;
						$tabledata[] = $file;
					}
				}
				closedir($handle);
			}

			// Sort list of sql files on alphabetical order (load order is important)
			sort($tabledata);

			foreach ($tabledata as $file) {
				$name = substr($file, 0, strlen($file) - 4);
				$buffer = '';
				$fp = fopen($dir . $file, 'r');
				if ($fp) {
					while (!feof($fp)) {
						$buf = fgets($fp, 4096);
						if (substr($buf, 0, 2) <> '--') {
							$buf = preg_replace('/--(.+)*/', '', $buf);
							$buf = trim($buf, "\xEF\xBB\xBF");
							$buffer .= $buf;
						}
					}
					fclose($fp);

					$buffer = trim($buffer);

					// Replace the prefix tables
					if (MAIN_DB_PREFIX != 'pm_') {
						$buffer = preg_replace('/pm_/i', MAIN_DB_PREFIX, $buffer);
					}

					$buffer = preg_replace('/table_collation/i', $main_db_collation, $buffer);
					$buffer = preg_replace('/table_character_set/i', $main_db_character_set, $buffer);

					$requestnb++;

					if (!$conn2->inTransaction()) {
						$conn2->beginTransaction();
					}

					try {
						$conn2->exec($buffer);
					}
					catch (PDOException $e) {
						$error = 'Cannot create database tables from file ' . $file . '. ' . $e->getMessage();
					}
				} else {
					$error = 'Failed to open file ' . $file;
				}

				if ($tablefound) {
					if ($error == 0) {
						$ok = 1;
					}
				} else {
					$error = 'Failed to find files to create database in directory!';
				}
			}
			$buffer = '';

			if (!$error) {

				/***************************************************************************************
				 *
				 * Create database tables from *key.sql files
				 * Must be done after *.sql files
				 *
				 ***************************************************************************************/
				$ok = 0;
				$okkeys = 0;
				$handle = opendir($dir) or die ('Cannot open dir');
				$tablefound = 0;
				$tabledata = [];
				if (is_resource($handle)) {
					while (($file = readdir($handle)) !== false) {
						if (preg_match('/\.sql$/i', $file) && preg_match('/^pm_/i', $file) && preg_match('/\.key\.sql$/i', $file)) {
							$tablefound++;
							$tabledata[] = $file;
						}
					}
					closedir($handle);
				}

				// Sort list of sql files on alphabetical order (load order is important)
				sort($tabledata);
				foreach ($tabledata as $file) {
					$name = substr($file, 0, strlen($file) - 4);
					$buffer = '';
					$fp = fopen($dir . $file, 'r');
					if ($fp) {
						while (!feof($fp)) {
							$buf = fgets($fp, 4096);
							$buf = preg_replace('/--(.+)*/', '', $buf);
							$buf = trim($buf, "\xEF\xBB\xBF");
							$buffer .= $buf;
						}
						fclose($fp);

						$listesql = explode(';', $buffer);
						foreach ($listesql as $req) {
							$buffer = trim($req);
							if ($buffer) {
								// Replace the prefix tables
								if (MAIN_DB_PREFIX != 'pm_') {
									$buffer = preg_replace('/pm_/i', MAIN_DB_PREFIX, $buffer);
								}

								$buffer = preg_replace('/table_collation/i', $main_db_collation, $buffer);
								$buffer = preg_replace('/table_character_set/i', $main_db_character_set, $buffer);

								$requestnb++;

								if (!$conn2->inTransaction()) {
									$conn2->beginTransaction();
								}

								try {
									$conn2->exec($buffer);
								}
								catch (PDOException $e) {
									$error = 'Cannot create database tables from file ' . $file . '. ' . $e->getMessage();
								}
							}
						}
					} else {
						$error = 'Failed to open file ' . $file;
					}

					if ($tablefound) {
						if ($error == 0) {
							$ok = 1;
						}
					} else {
						$error = 'Failed to find files to create database in directory!';
					}
				}
			}
		}

		if (!$error) {
			$con2 = null;
		} elseif (!$lockerror) {
			$con2 = null;

			$_SESSION['error'] = $error;
			$file = '../conf/conf.php';
			if (isset($_SERVER['WINDIR'])) {
				// Host OS is Windows
				$file = str_replace('/', '\\', $file);
				unset($res);
				exec('attrib -R ' . escapeshellarg($file), $res);
				$res = $res[0];
			} else {
				// Host OS is *nix
				$res = chmod($file, 0755);
			}
			unlink($file);
			header('Location: index.php');
		}

		if (!$error || !$lockerror) {
			session_destroy();

			//create lock file to prevent access to install files
			$file = '../../docs/install.lock';
			touch($file);

			header('Location: ../register.php');
		}

		?>
    <body class="d-flex vh-100 flex-column">
    <div class="flex-grow-1">
        <nav class="navbar navbar-expand bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand" href="#">Install</a>
            </div>
        </nav>
        <div class="container mt-5">
			<?php
			if ($error && !is_int($error) && !is_numeric($error)) {
				print '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
				print '<strong>' . $error . '</strong>';
				print '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
				print '</div>';
			}
			if ($lockerror) {
				print '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
				print '<strong>' . $lockerror . '</strong>';
				print '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
				print '</div>';
				print '</div>';
				print '</div>';
				print '<footer class="text-center text-lg-start bg-light text-muted mt-5">';
				print '<div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">&copy; 2020 - 2022 All rights reserved.<a class="text-reset fw-bold" href="https://blacktiehost.com/">BlackTieHost.com</a>';
				print '</div>';
				print '</footer>';
				print '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>';
				print '</body>';
				print '</html>';
				exit();
			}
			?>
            <div class="alert alert-warning" role="alert">
                DO NOT close this windows. When database and tables creation is completed you will be redirected automatically.
            </div>
        </div>
    </div>
    <footer class="text-center text-lg-start bg-light text-muted mt-5">
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            &copy; 2020 - 2022 All rights reserved.
            <a class="text-reset fw-bold" href="https://blacktiehost.com/">BlackTieHost.com</a>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
            crossorigin="anonymous"></script>
    </body>
    </html>

<?php
$conn = null;
$conn2 = null;
