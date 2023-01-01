<?php
/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: index.php
 *  Last Modified: 1.01.23 г., 21:06 ч.
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

/**
 * \file        install/index.php
 */

if (file_exists('../../conf/conf.php')) {
    header('Location: ../index.php');
}

session_start();
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

        print '<script src="../themes/default/js/validation.js"></script>' . "\n";
        print '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>' . "\n";
        print '<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>' . "\n";
        ?>

<?php
print "</head>\n";

$error = '';
$lockerror = '';
$lockfile = '../../docs/install.lock';
if (file_exists($lockfile)) {
    $lockerror = 'Install pages have been disabled for security (by the existence of a lock file <strong>install.lock</strong> in the docs directory).<br>';
    $lockerror .= 'If you always reach this page, you must remove install.lock file manually.<br>';
    $error++;
}

$action = $_POST['action'] ? : 'view';
$session_error = $_SESSION['error'];

//Actions
if ($action == 'check_connection' && (!$error || !$lockerror)) {
    $db_prefix = $_POST['db_prefix'];

    if (strlen($db_prefix) > 5) {
        $error = 'Table prefix cannot be more than 5 characters';
    }

    if (!$error) {
        $main_url_root = $_POST['main_url_root'];
        $main_document_root = $_POST['main_document_root'];
        $server = $_POST['db_host'];
        $port = $_POST['db_port'];
        $db = $_POST['db_name'];
        $username = $_POST['db_user'];
        $password = $_POST['db_pass'];
        $charset = $_POST['db_character_set'];
        $collation = $_POST['db_collation'];
        $create_db = $_POST['create_database'];
        $root_user = $_POST['root_db_user'];
        $root_password = $_POST['root_db_pass'];
        $application_title = $_POST['application_title'];

        $_SESSION['main_url_root'] = $main_url_root;
        $_SESSION['main_document_root'] = $main_document_root;
        $_SESSION['db_host'] = $server;
        $_SESSION['db_port'] = $port;
        $_SESSION['db_prefix'] = $db_prefix;
        $_SESSION['db_name'] = $db;
        $_SESSION['db_user'] = $username;
        $_SESSION['db_pass'] = $password;
        $_SESSION['db_character_set'] = $charset;
        $_SESSION['db_collation'] = $collation;
        $_SESSION['create_database'] = $create_db;
        $_SESSION['root_db_user'] = $root_user;
        $_SESSION['root_db_pass'] = $root_password;
        $_SESSION['application_title'] = $application_title;
        try {
            $conn = new PDO("mysql:host=$server;dbname=$db;port=$port", $username, $password);
            $conn->exec('set names ' . $charset);
        } catch (PDOException $e) {
            $error = 'Connection failed: ' . $e->getMessage();
            $action = 'view';
        }
        if ($error) {
            $error = '';
            try {
                $conn = new PDO("mysql:host=$server;port=$port", $root_user, $root_password);
                $conn->exec('set names ' . $charset);
            } catch (PDOException $e) {
                $error = 'Connection failed: ' . $e->getMessage();
                $action = 'view';
            }
        }
        if (!$error) {
            header('Location: step1.php');
        }
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
                print '<strong>' . $session_error . '</strong>';
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
            <form class="needs-validation mb-5" method="post">
                <input type="hidden" name="action" value="check_connection"/>
                <div class="mb-3 row">
                    <label for="main_url_root" class="col-sm-3 col-form-label">Server address</label>
                    <div class="col-sm-9">
                        <label for="mainUrlRoot"></label>
                        <input type="text" name="main_url_root" class="form-control" id="mainUrlRoot"
                                                                value="<?= $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['CONTEXT_PREFIX'] ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="main_document_root" class="col-sm-3 col-form-label">Main install folder</label>
                    <div class="col-sm-9">
                        <input type="text" name="main_document_root" class="form-control" id="main_document_root" value="<?= $_SERVER['CONTEXT_DOCUMENT_ROOT'] ?>" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="db_host" class="col-sm-3 col-form-label">Database server address</label>
                    <div class="col-sm-9">
                        <input type="text" name="db_host" class="form-control" id="db_host" value="localhost" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="db_port" class="col-sm-3 col-form-label">Database server port</label>
                    <div class="col-sm-9">
                        <input type="text" name="db_port" class="form-control" id="db_port" value="3306" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="db_prefix" class="col-sm-3 col-form-label">Database tables prefix</label>
                    <div class="col-sm-9">
                        <input type="text" name="db_prefix" class="form-control" id="db_prefix" value="pm_" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="db_name" class="col-sm-3 col-form-label">Database name</label>
                    <div class="col-sm-9">
                        <input type="text" name="db_name" class="form-control" id="db_name" value="passman" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="db_user" class="col-sm-3 col-form-label">Database user</label>
                    <div class="col-sm-9">
                        <input type="text" name="db_user" class="form-control" id="db_user" required>
                    </div>
                </div>
                <div class="mb-3 row">

                    <label for="validationPassword" class="col-sm-3 col-form-label">Database user password</label>
                    <div class="col-sm-9 mb-3">
                        <input type="password" name="db_pass" class="form-control" id="validationPassword" minlength="8" required>
                    </div>
                    <div class="progress" style="height: 5px;">
                        <div id="progressbar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 10%;" aria-valuenow="70"
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        Your password must be 8-20 characters long, must contain one (or more) of following special characters: !@#$%&*_?/, numbers, lower and upper letters only.
                    </small>
                    <div id="feedbackin" class="valid-feedback">
                        Strong Password!
                    </div>
                    <div id="feedbackirn" class="invalid-feedback">
                        Atleast 8 characters containing number, special character, capital letter and small letter
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="db_character_set" class="col-sm-3 col-form-label">Database character set</label>
                    <div class="col-sm-9">
                        <select required class="form-select" id="db_character_set" name="db_character_set">
                            <option value="iso-8859-1">
                                iso-8859-1
                            </option>
                            <option value="iso-8859-2">
                                iso-8859-2
                            </option>
                            <option value="iso-8859-3">
                                iso-8859-3
                            </option>
                            <option value="iso-8859-4">
                                iso-8859-4
                            </option>
                            <option value="iso-8859-5">
                                iso-8859-5
                            </option>
                            <option value="iso-8859-6">
                                iso-8859-6
                            </option>
                            <option value="iso-8859-7">
                                iso-8859-7
                            </option>
                            <option value="iso-8859-8">
                                iso-8859-8
                            </option>
                            <option value="iso-8859-9">
                                iso-8859-9
                            </option>
                            <option value="iso-8859-10">
                                iso-8859-10
                            </option>
                            <option value="iso-8859-11">
                                iso-8859-11
                            </option>
                            <option value="iso-8859-12">
                                iso-8859-12
                            </option>
                            <option value="iso-8859-13">
                                iso-8859-13
                            </option>
                            <option value="iso-8859-14">
                                iso-8859-14
                            </option>
                            <option value="iso-8859-15">
                                iso-8859-15
                            </option>
                            <option value="windows-1250">
                                windows-1250
                            </option>
                            <option value="windows-1251">
                                windows-1251
                            </option>
                            <option value="windows-1252">
                                windows-1252
                            </option>
                            <option value="windows-1256">
                                windows-1256
                            </option>
                            <option value="windows-1257">
                                windows-1257
                            </option>
                            <option value="koi8-r">
                                koi8-r
                            </option>
                            <option value="big5">
                                big5
                            </option>
                            <option value="gb2312">
                                gb2312
                            </option>
                            <option value="utf-16">
                                utf-16
                            </option>
                            <option value="utf-8">
                                utf-8
                            </option>
                            <option value="utf8mb4" selected="selected">
                                utf8mb4
                            </option>
                            <option value="utf-7">
                                utf-7
                            </option>
                            <option value="x-user-defined">
                                x-user-defined
                            </option>
                            <option value="euc-jp">
                                euc-jp
                            </option>
                            <option value="ks_c_5601-1987">
                                ks_c_5601-1987
                            </option>
                            <option value="tis-620">
                                tis-620
                            </option>
                            <option value="SHIFT_JIS">
                                SHIFT_JIS
                            </option>
                            <option value="SJIS">
                                SJIS
                            </option>
                            <option value="SJIS-win">
                                SJIS-win
                            </option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="db_collation" class="col-sm-3 col-form-label">Database collation</label>
                    <div class="col-sm-9">
                        <select required class="form-select" id="db_collation" name="db_collation">
                            <option value="">Колация</option>
                            <option value=""></option>
                            <optgroup label="armscii8">
                                <option value="armscii8_bin">armscii8_bin</option>
                                <option value="armscii8_general_ci">armscii8_general_ci</option>
                                <option value="armscii8_general_nopad_ci">armscii8_general_nopad_ci</option>
                                <option value="armscii8_nopad_bin">armscii8_nopad_bin</option>
                            </optgroup>
                            <optgroup label="ascii">
                                <option value="ascii_bin">ascii_bin</option>
                                <option value="ascii_general_ci">ascii_general_ci</option>
                                <option value="ascii_general_nopad_ci">ascii_general_nopad_ci</option>
                                <option value="ascii_nopad_bin">ascii_nopad_bin</option>
                            </optgroup>
                            <optgroup label="big5">
                                <option value="big5_bin">big5_bin</option>
                                <option value="big5_chinese_ci">big5_chinese_ci</option>
                                <option value="big5_chinese_nopad_ci">big5_chinese_nopad_ci</option>
                                <option value="big5_nopad_bin">big5_nopad_bin</option>
                            </optgroup>
                            <optgroup label="binary">
                                <option value="binary">binary</option>
                            </optgroup>
                            <optgroup label="cp1250">
                                <option value="cp1250_bin">cp1250_bin</option>
                                <option value="cp1250_croatian_ci">cp1250_croatian_ci</option>
                                <option value="cp1250_czech_cs">cp1250_czech_cs</option>
                                <option value="cp1250_general_ci">cp1250_general_ci</option>
                                <option value="cp1250_general_nopad_ci">cp1250_general_nopad_ci</option>
                                <option value="cp1250_nopad_bin">cp1250_nopad_bin</option>
                                <option value="cp1250_polish_ci">cp1250_polish_ci</option>
                            </optgroup>
                            <optgroup label="cp1251">
                                <option value="cp1251_bin">cp1251_bin</option>
                                <option value="cp1251_bulgarian_ci">cp1251_bulgarian_ci</option>
                                <option value="cp1251_general_ci">cp1251_general_ci</option>
                                <option value="cp1251_general_cs">cp1251_general_cs</option>
                                <option value="cp1251_general_nopad_ci">cp1251_general_nopad_ci</option>
                                <option value="cp1251_nopad_bin">cp1251_nopad_bin</option>
                                <option value="cp1251_ukrainian_ci">cp1251_ukrainian_ci</option>
                            </optgroup>
                            <optgroup label="cp1256">
                                <option value="cp1256_bin">cp1256_bin</option>
                                <option value="cp1256_general_ci">cp1256_general_ci</option>
                                <option value="cp1256_general_nopad_ci">cp1256_general_nopad_ci</option>
                                <option value="cp1256_nopad_bin">cp1256_nopad_bin</option>
                            </optgroup>
                            <optgroup label="cp1257">
                                <option value="cp1257_bin">cp1257_bin</option>
                                <option value="cp1257_general_ci">cp1257_general_ci</option>
                                <option value="cp1257_general_nopad_ci">cp1257_general_nopad_ci</option>
                                <option value="cp1257_lithuanian_ci">cp1257_lithuanian_ci</option>
                                <option value="cp1257_nopad_bin">cp1257_nopad_bin</option>
                            </optgroup>
                            <optgroup label="cp850">
                                <option value="cp850_bin">cp850_bin</option>
                                <option value="cp850_general_ci">cp850_general_ci</option>
                                <option value="cp850_general_nopad_ci">cp850_general_nopad_ci</option>
                                <option value="cp850_nopad_bin">cp850_nopad_bin</option>
                            </optgroup>
                            <optgroup label="cp852">
                                <option value="cp852_bin">cp852_bin</option>
                                <option value="cp852_general_ci">cp852_general_ci</option>
                                <option value="cp852_general_nopad_ci">cp852_general_nopad_ci</option>
                                <option value="cp852_nopad_bin">cp852_nopad_bin</option>
                            </optgroup>
                            <optgroup label="cp866">
                                <option value="cp866_bin">cp866_bin</option>
                                <option value="cp866_general_ci">cp866_general_ci</option>
                                <option value="cp866_general_nopad_ci">cp866_general_nopad_ci</option>
                                <option value="cp866_nopad_bin">cp866_nopad_bin</option>
                            </optgroup>
                            <optgroup label="cp932">
                                <option value="cp932_bin">cp932_bin</option>
                                <option value="cp932_japanese_ci">cp932_japanese_ci</option>
                                <option value="cp932_japanese_nopad_ci">cp932_japanese_nopad_ci</option>
                                <option value="cp932_nopad_bin">cp932_nopad_bin</option>
                            </optgroup>
                            <optgroup label="dec8">
                                <option value="dec8_bin">dec8_bin</option>
                                <option value="dec8_nopad_bin">dec8_nopad_bin</option>
                                <option value="dec8_swedish_ci">dec8_swedish_ci</option>
                                <option value="dec8_swedish_nopad_ci">dec8_swedish_nopad_ci</option>
                            </optgroup>
                            <optgroup label="eucjpms">
                                <option value="eucjpms_bin">eucjpms_bin</option>
                                <option value="eucjpms_japanese_ci">eucjpms_japanese_ci</option>
                                <option value="eucjpms_japanese_nopad_ci">eucjpms_japanese_nopad_ci</option>
                                <option value="eucjpms_nopad_bin">eucjpms_nopad_bin</option>
                            </optgroup>
                            <optgroup label="euckr">
                                <option value="euckr_bin">euckr_bin</option>
                                <option value="euckr_korean_ci">euckr_korean_ci</option>
                                <option value="euckr_korean_nopad_ci">euckr_korean_nopad_ci</option>
                                <option value="euckr_nopad_bin">euckr_nopad_bin</option>
                            </optgroup>
                            <optgroup label="gb2312">
                                <option value="gb2312_bin">gb2312_bin</option>
                                <option value="gb2312_chinese_ci">gb2312_chinese_ci</option>
                                <option value="gb2312_chinese_nopad_ci">gb2312_chinese_nopad_ci</option>
                                <option value="gb2312_nopad_bin">gb2312_nopad_bin</option>
                            </optgroup>
                            <optgroup label="gbk">
                                <option value="gbk_bin">gbk_bin</option>
                                <option value="gbk_chinese_ci">gbk_chinese_ci</option>
                                <option value="gbk_chinese_nopad_ci">gbk_chinese_nopad_ci</option>
                                <option value="gbk_nopad_bin">gbk_nopad_bin</option>
                            </optgroup>
                            <optgroup label="geostd8">
                                <option value="geostd8_bin">geostd8_bin</option>
                                <option value="geostd8_general_ci">geostd8_general_ci</option>
                                <option value="geostd8_general_nopad_ci">geostd8_general_nopad_ci</option>
                                <option value="geostd8_nopad_bin">geostd8_nopad_bin</option>
                            </optgroup>
                            <optgroup label="greek">
                                <option value="greek_bin">greek_bin</option>
                                <option value="greek_general_ci">greek_general_ci</option>
                                <option value="greek_general_nopad_ci">greek_general_nopad_ci</option>
                                <option value="greek_nopad_bin">greek_nopad_bin</option>
                            </optgroup>
                            <optgroup label="hebrew">
                                <option value="hebrew_bin">hebrew_bin</option>
                                <option value="hebrew_general_ci">hebrew_general_ci</option>
                                <option value="hebrew_general_nopad_ci">hebrew_general_nopad_ci</option>
                                <option value="hebrew_nopad_bin">hebrew_nopad_bin</option>
                            </optgroup>
                            <optgroup label="hp8">
                                <option value="hp8_bin">hp8_bin</option>
                                <option value="hp8_english_ci">hp8_english_ci</option>
                                <option value="hp8_english_nopad_ci">hp8_english_nopad_ci</option>
                                <option value="hp8_nopad_bin">hp8_nopad_bin</option>
                            </optgroup>
                            <optgroup label="keybcs2">
                                <option value="keybcs2_bin">keybcs2_bin</option>
                                <option value="keybcs2_general_ci">keybcs2_general_ci</option>
                                <option value="keybcs2_general_nopad_ci">keybcs2_general_nopad_ci</option>
                                <option value="keybcs2_nopad_bin">keybcs2_nopad_bin</option>
                            </optgroup>
                            <optgroup label="koi8r">
                                <option value="koi8r_bin">koi8r_bin</option>
                                <option value="koi8r_general_ci">koi8r_general_ci</option>
                                <option value="koi8r_general_nopad_ci">koi8r_general_nopad_ci</option>
                                <option value="koi8r_nopad_bin">koi8r_nopad_bin</option>
                            </optgroup>
                            <optgroup label="koi8u">
                                <option value="koi8u_bin">koi8u_bin</option>
                                <option value="koi8u_general_ci">koi8u_general_ci</option>
                                <option value="koi8u_general_nopad_ci">koi8u_general_nopad_ci</option>
                                <option value="koi8u_nopad_bin">koi8u_nopad_bin</option>
                            </optgroup>
                            <optgroup label="latin1">
                                <option value="latin1_bin">latin1_bin</option>
                                <option value="latin1_danish_ci">latin1_danish_ci</option>
                                <option value="latin1_general_ci">latin1_general_ci</option>
                                <option value="latin1_general_cs">latin1_general_cs</option>
                                <option value="latin1_german1_ci">latin1_german1_ci</option>
                                <option value="latin1_german2_ci">latin1_german2_ci</option>
                                <option value="latin1_nopad_bin">latin1_nopad_bin</option>
                                <option value="latin1_spanish_ci">latin1_spanish_ci</option>
                                <option value="latin1_swedish_ci">latin1_swedish_ci</option>
                                <option value="latin1_swedish_nopad_ci">latin1_swedish_nopad_ci</option>
                            </optgroup>
                            <optgroup label="latin2">
                                <option value="latin2_bin">latin2_bin</option>
                                <option value="latin2_croatian_ci">latin2_croatian_ci</option>
                                <option value="latin2_czech_cs">latin2_czech_cs</option>
                                <option value="latin2_general_ci">latin2_general_ci</option>
                                <option value="latin2_general_nopad_ci">latin2_general_nopad_ci</option>
                                <option value="latin2_hungarian_ci">latin2_hungarian_ci</option>
                                <option value="latin2_nopad_bin">latin2_nopad_bin</option>
                            </optgroup>
                            <optgroup label="latin5">
                                <option value="latin5_bin">latin5_bin</option>
                                <option value="latin5_nopad_bin">latin5_nopad_bin</option>
                                <option value="latin5_turkish_ci">latin5_turkish_ci</option>
                                <option value="latin5_turkish_nopad_ci">latin5_turkish_nopad_ci</option>
                            </optgroup>
                            <optgroup label="latin7">
                                <option value="latin7_bin">latin7_bin</option>
                                <option value="latin7_estonian_cs">latin7_estonian_cs</option>
                                <option value="latin7_general_ci">latin7_general_ci</option>
                                <option value="latin7_general_cs">latin7_general_cs</option>
                                <option value="latin7_general_nopad_ci">latin7_general_nopad_ci</option>
                                <option value="latin7_nopad_bin">latin7_nopad_bin</option>
                            </optgroup>
                            <optgroup label="macce">
                                <option value="macce_bin">macce_bin</option>
                                <option value="macce_general_ci">macce_general_ci</option>
                                <option value="macce_general_nopad_ci">macce_general_nopad_ci</option>
                                <option value="macce_nopad_bin">macce_nopad_bin</option>
                            </optgroup>
                            <optgroup label="macroman">
                                <option value="macroman_bin">macroman_bin</option>
                                <option value="macroman_general_ci">macroman_general_ci</option>
                                <option value="macroman_general_nopad_ci">macroman_general_nopad_ci</option>
                                <option value="macroman_nopad_bin">macroman_nopad_bin</option>
                            </optgroup>
                            <optgroup label="sjis">
                                <option value="sjis_bin">sjis_bin</option>
                                <option value="sjis_japanese_ci">sjis_japanese_ci</option>
                                <option value="sjis_japanese_nopad_ci">sjis_japanese_nopad_ci</option>
                                <option value="sjis_nopad_bin">sjis_nopad_bin</option>
                            </optgroup>
                            <optgroup label="swe7">
                                <option value="swe7_bin">swe7_bin</option>
                                <option value="swe7_nopad_bin">swe7_nopad_bin</option>
                                <option value="swe7_swedish_ci">swe7_swedish_ci</option>
                                <option value="swe7_swedish_nopad_ci">swe7_swedish_nopad_ci</option>
                            </optgroup>
                            <optgroup label="tis620">
                                <option value="tis620_bin">tis620_bin</option>
                                <option value="tis620_nopad_bin">tis620_nopad_bin</option>
                                <option value="tis620_thai_ci">tis620_thai_ci</option>
                                <option value="tis620_thai_nopad_ci">tis620_thai_nopad_ci</option>
                            </optgroup>
                            <optgroup label="ucs2">
                                <option value="ucs2_bin">ucs2_bin</option>
                                <option value="ucs2_croatian_ci">ucs2_croatian_ci</option>
                                <option value="ucs2_croatian_mysql561_ci">ucs2_croatian_mysql561_ci</option>
                                <option value="ucs2_czech_ci">ucs2_czech_ci</option>
                                <option value="ucs2_danish_ci">ucs2_danish_ci</option>
                                <option value="ucs2_esperanto_ci">ucs2_esperanto_ci</option>
                                <option value="ucs2_estonian_ci">ucs2_estonian_ci</option>
                                <option value="ucs2_general_ci">ucs2_general_ci</option>
                                <option value="ucs2_general_mysql500_ci">ucs2_general_mysql500_ci</option>
                                <option value="ucs2_general_nopad_ci">ucs2_general_nopad_ci</option>
                                <option value="ucs2_german2_ci">ucs2_german2_ci</option>
                                <option value="ucs2_hungarian_ci">ucs2_hungarian_ci</option>
                                <option value="ucs2_icelandic_ci">ucs2_icelandic_ci</option>
                                <option value="ucs2_latvian_ci">ucs2_latvian_ci</option>
                                <option value="ucs2_lithuanian_ci">ucs2_lithuanian_ci</option>
                                <option value="ucs2_myanmar_ci">ucs2_myanmar_ci</option>
                                <option value="ucs2_nopad_bin">ucs2_nopad_bin</option>
                                <option value="ucs2_persian_ci">ucs2_persian_ci</option>
                                <option value="ucs2_polish_ci">ucs2_polish_ci</option>
                                <option value="ucs2_roman_ci">ucs2_roman_ci</option>
                                <option value="ucs2_romanian_ci">ucs2_romanian_ci</option>
                                <option value="ucs2_sinhala_ci">ucs2_sinhala_ci</option>
                                <option value="ucs2_slovak_ci">ucs2_slovak_ci</option>
                                <option value="ucs2_slovenian_ci">ucs2_slovenian_ci</option>
                                <option value="ucs2_spanish2_ci">ucs2_spanish2_ci</option>
                                <option value="ucs2_spanish_ci">ucs2_spanish_ci</option>
                                <option value="ucs2_swedish_ci">ucs2_swedish_ci</option>
                                <option value="ucs2_thai_520_w2">ucs2_thai_520_w2</option>
                                <option value="ucs2_turkish_ci">ucs2_turkish_ci</option>
                                <option value="ucs2_unicode_520_ci">ucs2_unicode_520_ci</option>
                                <option value="ucs2_unicode_520_nopad_ci">ucs2_unicode_520_nopad_ci</option>
                                <option value="ucs2_unicode_ci">ucs2_unicode_ci</option>
                                <option value="ucs2_unicode_nopad_ci">ucs2_unicode_nopad_ci</option>
                                <option value="ucs2_vietnamese_ci">ucs2_vietnamese_ci</option>
                            </optgroup>
                            <optgroup label="ujis">
                                <option value="ujis_bin">ujis_bin</option>
                                <option value="ujis_japanese_ci">ujis_japanese_ci</option>
                                <option value="ujis_japanese_nopad_ci">ujis_japanese_nopad_ci</option>
                                <option value="ujis_nopad_bin">ujis_nopad_bin</option>
                            </optgroup>
                            <optgroup label="utf16">
                                <option value="utf16_bin">utf16_bin</option>
                                <option value="utf16_croatian_ci">utf16_croatian_ci</option>
                                <option value="utf16_croatian_mysql561_ci">utf16_croatian_mysql561_ci</option>
                                <option value="utf16_czech_ci">utf16_czech_ci</option>
                                <option value="utf16_danish_ci">utf16_danish_ci</option>
                                <option value="utf16_esperanto_ci">utf16_esperanto_ci</option>
                                <option value="utf16_estonian_ci">utf16_estonian_ci</option>
                                <option value="utf16_general_ci">utf16_general_ci</option>
                                <option value="utf16_general_nopad_ci">utf16_general_nopad_ci</option>
                                <option value="utf16_german2_ci">utf16_german2_ci</option>
                                <option value="utf16_hungarian_ci">utf16_hungarian_ci</option>
                                <option value="utf16_icelandic_ci">utf16_icelandic_ci</option>
                                <option value="utf16_latvian_ci">utf16_latvian_ci</option>
                                <option value="utf16_lithuanian_ci">utf16_lithuanian_ci</option>
                                <option value="utf16_myanmar_ci">utf16_myanmar_ci</option>
                                <option value="utf16_nopad_bin">utf16_nopad_bin</option>
                                <option value="utf16_persian_ci">utf16_persian_ci</option>
                                <option value="utf16_polish_ci">utf16_polish_ci</option>
                                <option value="utf16_roman_ci">utf16_roman_ci</option>
                                <option value="utf16_romanian_ci">utf16_romanian_ci</option>
                                <option value="utf16_sinhala_ci">utf16_sinhala_ci</option>
                                <option value="utf16_slovak_ci">utf16_slovak_ci</option>
                                <option value="utf16_slovenian_ci">utf16_slovenian_ci</option>
                                <option value="utf16_spanish2_ci">utf16_spanish2_ci</option>
                                <option value="utf16_spanish_ci">utf16_spanish_ci</option>
                                <option value="utf16_swedish_ci">utf16_swedish_ci</option>
                                <option value="utf16_thai_520_w2">utf16_thai_520_w2</option>
                                <option value="utf16_turkish_ci">utf16_turkish_ci</option>
                                <option value="utf16_unicode_520_ci">utf16_unicode_520_ci</option>
                                <option value="utf16_unicode_520_nopad_ci">utf16_unicode_520_nopad_ci</option>
                                <option value="utf16_unicode_ci">utf16_unicode_ci</option>
                                <option value="utf16_unicode_nopad_ci">utf16_unicode_nopad_ci</option>
                                <option value="utf16_vietnamese_ci">utf16_vietnamese_ci</option>
                            </optgroup>
                            <optgroup label="utf16le">
                                <option value="utf16le_bin">utf16le_bin</option>
                                <option value="utf16le_general_ci">utf16le_general_ci</option>
                                <option value="utf16le_general_nopad_ci">utf16le_general_nopad_ci</option>
                                <option value="utf16le_nopad_bin">utf16le_nopad_bin</option>
                            </optgroup>
                            <optgroup label="utf32">
                                <option value="utf32_bin">utf32_bin</option>
                                <option value="utf32_croatian_ci">utf32_croatian_ci</option>
                                <option value="utf32_croatian_mysql561_ci">utf32_croatian_mysql561_ci</option>
                                <option value="utf32_czech_ci">utf32_czech_ci</option>
                                <option value="utf32_danish_ci">utf32_danish_ci</option>
                                <option value="utf32_esperanto_ci">utf32_esperanto_ci</option>
                                <option value="utf32_estonian_ci">utf32_estonian_ci</option>
                                <option value="utf32_general_ci">utf32_general_ci</option>
                                <option value="utf32_general_nopad_ci">utf32_general_nopad_ci</option>
                                <option value="utf32_german2_ci">utf32_german2_ci</option>
                                <option value="utf32_hungarian_ci">utf32_hungarian_ci</option>
                                <option value="utf32_icelandic_ci">utf32_icelandic_ci</option>
                                <option value="utf32_latvian_ci">utf32_latvian_ci</option>
                                <option value="utf32_lithuanian_ci">utf32_lithuanian_ci</option>
                                <option value="utf32_myanmar_ci">utf32_myanmar_ci</option>
                                <option value="utf32_nopad_bin">utf32_nopad_bin</option>
                                <option value="utf32_persian_ci">utf32_persian_ci</option>
                                <option value="utf32_polish_ci">utf32_polish_ci</option>
                                <option value="utf32_roman_ci">utf32_roman_ci</option>
                                <option value="utf32_romanian_ci">utf32_romanian_ci</option>
                                <option value="utf32_sinhala_ci">utf32_sinhala_ci</option>
                                <option value="utf32_slovak_ci">utf32_slovak_ci</option>
                                <option value="utf32_slovenian_ci">utf32_slovenian_ci</option>
                                <option value="utf32_spanish2_ci">utf32_spanish2_ci</option>
                                <option value="utf32_spanish_ci">utf32_spanish_ci</option>
                                <option value="utf32_swedish_ci">utf32_swedish_ci</option>
                                <option value="utf32_thai_520_w2">utf32_thai_520_w2</option>
                                <option value="utf32_turkish_ci">utf32_turkish_ci</option>
                                <option value="utf32_unicode_520_ci">utf32_unicode_520_ci</option>
                                <option value="utf32_unicode_520_nopad_ci">utf32_unicode_520_nopad_ci</option>
                                <option value="utf32_unicode_ci">utf32_unicode_ci</option>
                                <option value="utf32_unicode_nopad_ci">utf32_unicode_nopad_ci</option>
                                <option value="utf32_vietnamese_ci">utf32_vietnamese_ci</option>
                            </optgroup>
                            <optgroup label="utf8">
                                <option value="utf8_bin">utf8_bin</option>
                                <option value="utf8_croatian_ci">utf8_croatian_ci</option>
                                <option value="utf8_croatian_mysql561_ci">utf8_croatian_mysql561_ci</option>
                                <option value="utf8_czech_ci">utf8_czech_ci</option>
                                <option value="utf8_danish_ci">utf8_danish_ci</option>
                                <option value="utf8_esperanto_ci">utf8_esperanto_ci</option>
                                <option value="utf8_estonian_ci">utf8_estonian_ci</option>
                                <option value="utf8_general_ci">utf8_general_ci</option>
                                <option value="utf8_general_mysql500_ci">utf8_general_mysql500_ci</option>
                                <option value="utf8_general_nopad_ci">utf8_general_nopad_ci</option>
                                <option value="utf8_german2_ci">utf8_german2_ci</option>
                                <option value="utf8_hungarian_ci">utf8_hungarian_ci</option>
                                <option value="utf8_icelandic_ci">utf8_icelandic_ci</option>
                                <option value="utf8_latvian_ci">utf8_latvian_ci</option>
                                <option value="utf8_lithuanian_ci">utf8_lithuanian_ci</option>
                                <option value="utf8_myanmar_ci">utf8_myanmar_ci</option>
                                <option value="utf8_nopad_bin">utf8_nopad_bin</option>
                                <option value="utf8_persian_ci">utf8_persian_ci</option>
                                <option value="utf8_polish_ci">utf8_polish_ci</option>
                                <option value="utf8_roman_ci">utf8_roman_ci</option>
                                <option value="utf8_romanian_ci">utf8_romanian_ci</option>
                                <option value="utf8_sinhala_ci">utf8_sinhala_ci</option>
                                <option value="utf8_slovak_ci">utf8_slovak_ci</option>
                                <option value="utf8_slovenian_ci">utf8_slovenian_ci</option>
                                <option value="utf8_spanish2_ci">utf8_spanish2_ci</option>
                                <option value="utf8_spanish_ci">utf8_spanish_ci</option>
                                <option value="utf8_swedish_ci">utf8_swedish_ci</option>
                                <option value="utf8_thai_520_w2">utf8_thai_520_w2</option>
                                <option value="utf8_turkish_ci">utf8_turkish_ci</option>
                                <option value="utf8_unicode_520_ci">utf8_unicode_520_ci</option>
                                <option value="utf8_unicode_520_nopad_ci">utf8_unicode_520_nopad_ci</option>
                                <option value="utf8_unicode_ci">utf8_unicode_ci</option>
                                <option value="utf8_unicode_nopad_ci">utf8_unicode_nopad_ci</option>
                                <option value="utf8_vietnamese_ci">utf8_vietnamese_ci</option>
                            </optgroup>
                            <optgroup label="utf8mb4">
                                <option value="utf8mb4_bin">utf8mb4_bin</option>
                                <option value="utf8mb4_croatian_ci">utf8mb4_croatian_ci</option>
                                <option value="utf8mb4_croatian_mysql561_ci">utf8mb4_croatian_mysql561_ci</option>
                                <option value="utf8mb4_czech_ci">utf8mb4_czech_ci</option>
                                <option value="utf8mb4_danish_ci">utf8mb4_danish_ci</option>
                                <option value="utf8mb4_esperanto_ci">utf8mb4_esperanto_ci</option>
                                <option value="utf8mb4_estonian_ci">utf8mb4_estonian_ci</option>
                                <option value="utf8mb4_general_ci">utf8mb4_general_ci</option>
                                <option value="utf8mb4_general_nopad_ci">utf8mb4_general_nopad_ci</option>
                                <option value="utf8mb4_german2_ci">utf8mb4_german2_ci</option>
                                <option value="utf8mb4_hungarian_ci">utf8mb4_hungarian_ci</option>
                                <option value="utf8mb4_icelandic_ci">utf8mb4_icelandic_ci</option>
                                <option value="utf8mb4_latvian_ci">utf8mb4_latvian_ci</option>
                                <option value="utf8mb4_lithuanian_ci">utf8mb4_lithuanian_ci</option>
                                <option value="utf8mb4_myanmar_ci">utf8mb4_myanmar_ci</option>
                                <option value="utf8mb4_nopad_bin">utf8mb4_nopad_bin</option>
                                <option value="utf8mb4_persian_ci">utf8mb4_persian_ci</option>
                                <option value="utf8mb4_polish_ci">utf8mb4_polish_ci</option>
                                <option value="utf8mb4_roman_ci">utf8mb4_roman_ci</option>
                                <option value="utf8mb4_romanian_ci">utf8mb4_romanian_ci</option>
                                <option value="utf8mb4_sinhala_ci">utf8mb4_sinhala_ci</option>
                                <option value="utf8mb4_slovak_ci">utf8mb4_slovak_ci</option>
                                <option value="utf8mb4_slovenian_ci">utf8mb4_slovenian_ci</option>
                                <option value="utf8mb4_spanish2_ci">utf8mb4_spanish2_ci</option>
                                <option value="utf8mb4_spanish_ci">utf8mb4_spanish_ci</option>
                                <option value="utf8mb4_swedish_ci">utf8mb4_swedish_ci</option>
                                <option value="utf8mb4_thai_520_w2">utf8mb4_thai_520_w2</option>
                                <option value="utf8mb4_turkish_ci">utf8mb4_turkish_ci</option>
                                <option value="utf8mb4_unicode_520_ci">utf8mb4_unicode_520_ci</option>
                                <option value="utf8mb4_unicode_520_nopad_ci">utf8mb4_unicode_520_nopad_ci</option>
                                <option value="utf8mb4_unicode_ci" selected>utf8mb4_unicode_ci</option>
                                <option value="utf8mb4_unicode_nopad_ci">utf8mb4_unicode_nopad_ci</option>
                                <option value="utf8mb4_vietnamese_ci">utf8mb4_vietnamese_ci</option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="application_title" class="col-sm-3 col-form-label">Main install folder<br>
                        <small><i>What name you want to see in navigation bar</i></small>
                    </label>
                    <div class="col-sm-9">
                        <input type="text" name="application_title" class="form-control" id="application_title" value="PassMan" required>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-3 form-check-label" for="create_database">Create database?</label>
                    <div class="col-sm-9">
                        <input class="form-check-input" name="create_database" type="checkbox" value="1" id="create_database">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="root_db_user" class="col-sm-3 col-form-label">Root database user (to create database)</label>
                    <div class="col-sm-9">
                        <input type="text" name="root_db_user" class="form-control" id="root_db_user">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="root_db_pass" class="col-sm-3 col-form-label">Root user password</label>
                    <div class="col-sm-9">
                        <input type="password" name="root_db_pass" class="form-control" id="root_db_pass">
                    </div>
                </div>
                <div class="mb-3 row">
                    <input class="btn btn-info" type="submit" name="submit" value="Continue"/>
                </div>
            </form>
        </div>
    </div>
    <footer class="text-center text-lg-start bg-light text-muted mt-5">
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            &copy; 2020 - 2022 All rights reserved.
            <a class="text-reset fw-bold" href="https://blacktiehost.com/">BlackTieHost.com</a>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
            integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
    </body>
    </html>

<?php
$conn = null;
