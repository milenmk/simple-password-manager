<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: step1.php
 *  Last Modified: 2.01.23 г., 1:26 ч.
 *
 * @link          https://blacktiehost.com
 * @since         1.0.0
 * @version       2.1.1
 * @author        Milen Karaganski <milen@blacktiehost.com>
 *
 * @license       GPL-3.0+
 * @license       http://www.gnu.org/licenses/gpl-3.0.txt
 * @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/** @noinspection LongLine */

declare(strict_types = 1);

session_start();

/**
 * \file        install/step1.php
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
        $favicon = '../themes/default/img/favicon.png';
        print '<link rel="shortcut icon" type="image/x-icon" href="' . $favicon . '"/>' . "\n";

        $themepathcss = '../themes/default/css';
        $themeuricss = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['CONTEXT_PREFIX'] . '/themes/default/css';
        foreach (glob($themepathcss . '/*.css') as $css) {
            $file = str_replace($themepathcss, $themeuricss, $css);
            print '<link type="text/css" rel="stylesheet" href="' . $file . '">' . "\n";
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

        if (!$error || !$lockerror) {
            $main_url_root = $_SESSION['main_url_root'];
            $main_document_root = $_SESSION['main_document_root'];
            $server = $_SESSION['db_host'];
            $port = $_SESSION['db_port'];
            $db_prefix = $_SESSION['db_prefix'];
            $db = $_SESSION['db_name'];
            $username = $_SESSION['db_user'];
            $password = $_SESSION['db_pass'];
            $charset = $_SESSION['db_character_set'];
            $collation = $_SESSION['db_collation'];
            $create_db = $_SESSION['create_database'];
            $root_user = $_SESSION['root_db_user'];
            $root_password = $_SESSION['root_db_pass'];
            $application_title = $_SESSION['application_title'];

            $file = '../conf/conf.php';
            if (!file_exists($file)) {
                touch($file);
            } else {
                $error = 'Config file already exists';
                $_SESSION['error'] = $error;
                header('Location: ../login.php');
            }

            if (!$error || !$lockerror) {
                $new_file = fopen($file, 'w') or die("can't open/create config file");

                fputs($new_file, '<?php' . "\n");
                fputs($new_file, "\n");
                fputs($new_file, 'declare(strict_types = 1);' . "\n");
                fputs($new_file, "\n");
                fputs($new_file, '/**' . "\n");
                fputs($new_file, ' * \file        conf/conf.php' . "\n");
                fputs($new_file, ' */' . "\n");
                fputs($new_file, "\n");

                fputs($new_file, '$main_url_root=\'' . $main_url_root . '\';');
                fputs($new_file, "\n");
                fputs($new_file, '$main_document_root=\'' . $main_document_root . '\';');
                fputs($new_file, "\n");

                fputs($new_file, '$db_host=\'' . $server . '\';');
                fputs($new_file, "\n");

                fputs($new_file, '$db_port=\'' . $port . '\';');
                fputs($new_file, "\n");

                fputs($new_file, '$db_name=\'' . $db . '\';');
                fputs($new_file, "\n");

                fputs($new_file, '$db_prefix=\'' . $db_prefix . '\';');
                fputs($new_file, "\n");

                fputs($new_file, '$db_user=\'' . $username . '\';');
                fputs($new_file, "\n");
                fputs($new_file, '$db_pass=\'' . $password . '\';');
                fputs($new_file, "\n");

                fputs($new_file, '$main_db_character_set=\'' . $charset . '\';');
                fputs($new_file, "\n");

                fputs($new_file, '$main_db_collation=\'' . $collation . '\';');
                fputs($new_file, "\n");

                fputs($new_file, '$main_application_title=\'' . $application_title . '\';');
                fputs($new_file, "\n");

                fputs($new_file, 'define(\'MAIN_DOCUMENT_ROOT\', $main_document_root);');
                fputs($new_file, "\n");

                fputs($new_file, 'define(\'MAIN_URL_ROOT\', $main_url_root);');
                fputs($new_file, "\n");

                fputs($new_file, 'define(\'MAIN_DB_PREFIX\', $db_prefix);');
                fputs($new_file, "\n");

                fputs($new_file, 'define(\'MAIN_APPLICATION_TITLE\', $main_application_title);');
                fputs($new_file, "\n");

                fclose($new_file);

                if (isset($_SERVER['WINDIR'])) {
                    // Host OS is Windows
                    $file = str_replace('/', '\\', $file);
                    unset($res);
                    exec('attrib +R ' . escapeshellarg($file), $res);
                    $res = $res[0];
                } else {
                    // Host OS is *nix
                    $res = chmod($file, 0444);
                }

                header('Location: step2.php');
            }
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
                DO NOT close this windows. When config file creation is completed you will be redirected automatically.
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
