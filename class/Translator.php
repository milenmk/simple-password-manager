<?php

/**
 *
 * Simple password manager written in PHP with Bootstrap and PDO database connections
 *
 *  File name: Translator.php
 *  Last Modified: 10.01.23 г., 20:17 ч.
 *
 *  @link          https://blacktiehost.com
 *  @since         1.0.0
 *  @version       2.4.0
 *  @author        Milen Karaganski <milen@blacktiehost.com>
 *
 *  @license       GPL-3.0+
 *  @license       http://www.gnu.org/licenses/gpl-3.0.txt
 *  @copyright     Copyright (c)  2020 - 2022 blacktiehost.com
 *
 */

/**
 * \file        class/translator.php
 * \ingroup     Password Manager
 * \brief       Class to manage translations to different languages
 */

declare(strict_types=1);

namespace PasswordManager;

use Exception;

/**
 * Class for translator
 */
class Translator
{
    public string $dir;
    public string $defaultlang;
    public string $origlang;
    public string $shortlang;
    public array $tab_translate = [];
    // Array of all translations key=>value
    public string $charset_output = 'UTF-8';
    // Array to store result after loading each language file
    public string $error;
    private array $tab_loaded = [];

    /**
     * @param string $dir Force directory other than /langs subdirectory.
     */
    public function __construct(string $dir)
    {

        if ($dir) {
            $this->dir = $dir;
        } else {
            $this->dir = PM_MAIN_APP_ROOT;
        }
    }

    /**
     * @param int $mode 0 = long language code (en_US, de_DE, etc.), 1 = short language code (en, de, etc.)
     *
     * @return false|string
     */
    public function getDefaultLang(int $mode = 0)
    {

        if (empty($mode)) {
            return $this->defaultlang;
        } else {
            return substr($this->defaultlang, 0, 2);
        }
    }

    /**
     *  Set accessor for this->defaultlang
     *
     * @param string $srclang Language to use. If '' or 'auto', we use browser lang.
     *
     * @return    void
     * @throws Exception
     */
    public function setDefaultLang(string $srclang = 'en_US')
    {

        $this->origlang = $srclang;
        if (empty($srclang) || $srclang == 'auto') {
            $langpref = empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? '' : $_SERVER['HTTP_ACCEPT_LANGUAGE'];
            $langpref = preg_replace('/;([^,]*)/i', '', $langpref);
            // Remove the 'q=x.y,' part
            $langpref = str_replace('-', '_', $langpref);
            $langlist = preg_split('/[;,]/', $langpref);
            $codetouse = preg_replace('/[^_a-zA-Z]/', '', $langlist[0]);
        } else {
            $codetouse = $srclang;
        }

        // We redefine $srclang
        $langpart = explode('_', $codetouse);
        if (!empty($langpart[1])) {
            // If it's for a codetouse that is a long code xx_YY
            // Array force long code from first part, even if long code is defined
            $longforshort = ['ar' => 'ar_SA'];
            $longforshortexcep = ['ar_EG'];
            if (isset($longforshort[strtolower($langpart[0])]) && !in_array($codetouse, $longforshortexcep)) {
                $srclang = $longforshort[strtolower($langpart[0])];
            } elseif (!is_numeric($langpart[1])) {
                // Second part YY may be a numeric with some Chrome browser
                $srclang = strtolower($langpart[0]) . '_' . strtoupper($langpart[1]);
                $longforlong = ['no_nb' => 'nb_NO'];
                if (isset($longforlong[strtolower($srclang)])) {
                    $srclang = $longforlong[strtolower($srclang)];
                }
            } else {
                $srclang = strtolower($langpart[0]) . '_' . strtoupper($langpart[0]);
            }
        } else {
            $longforshort = [
                'am' => 'am_ET', 'ar' => 'ar_SA', 'bn' => 'bn_DB', 'el' => 'el_GR', 'ca' => 'ca_ES', 'cs' => 'cs_CZ', 'en' => 'en_US', 'fa' => 'fa_IR',
                'gl' => 'gl_ES', 'he' => 'he_IL', 'hi' => 'hi_IN', 'ja' => 'ja_JP',
                'ka' => 'ka_GE', 'km' => 'km_KH', 'kn' => 'kn_IN', 'ko' => 'ko_KR', 'lo' => 'lo_LA', 'nb' => 'nb_NO', 'no' => 'nb_NO', 'ne' => 'ne_NP',
                'sl' => 'sl_SI', 'sq' => 'sq_AL', 'sr' => 'sr_RS', 'sv' => 'sv_SE', 'uk' => 'uk_UA', 'vi' => 'vi_VN', 'zh' => 'zh_CN',
            ];
            if (isset($longforshort[strtolower($langpart[0])])) {
                $srclang = $longforshort[strtolower($langpart[0])];
            } elseif (!empty($langpart[0])) {
                $srclang = strtolower($langpart[0]) . '_' . strtoupper($langpart[0]);
            } else {
                $srclang = 'en_US';
            }
        }

        $this->defaultlang = $srclang;
        $this->shortlang = substr($srclang, 0, 2);
    }

    /**
     * @param array $domains Array of files to load
     *
     * @return void less than 0 if KO, 0 if already loaded or loading not required, >0 if OK
     * @throws Exception
     */
    public function loadLangs(array $domains)
    {

        foreach ($domains as $domain) {
            $this->load($domain);
        }
    }

    /**
     *  Load translation key-value for a particular file, into a memory array.
     *  If data for file already loaded, do nothing.
     *    All data in translation array are stored in UTF-8 format.
     *  tab_loaded is completed with $domain key.
     *  rule "we keep first entry found with we keep last entry found" so it is probably not what you want to do.
     *
     *  Value for hash are: 1:Loaded from disk, 2:Not found, 3:Loaded from cache
     *
     * @param string $domain             File name to load (.lang file). Must be "file"
     * @param int    $alt                0 (try xx_ZZ then 1), 1 (try xx_XX then 2), 2 (try en_US)
     * @param int    $stopafterdirection Stop when the DIRECTION tag is found (optimize speed)
     * @param int    $forcelangdir       To force a different lang directory
     *
     * @return    int                    less than 0 if KO, 0 if already loaded or loading not required, >0 if OK
     * @throws Exception
     * @see loadLangs()
     */
    public function load(string $domain, int $alt = 0, int $stopafterdirection = 0, $forcelangdir = '')
    {

        // Check parameters
        if (empty($domain)) {
            $this->error = 'No file selected';

            return -1;
        }
        if ($this->defaultlang === 'none_NONE') {
            return 0;
        }

        $newdomain = $domain;
        $fileread = 0;
        $langofdir = (empty($forcelangdir) ? $this->defaultlang : $forcelangdir);
        // Redefine alt
        $langarray = explode('_', $langofdir);
        if ($alt < 1 && isset($langarray[1]) && (strtolower($langarray[0]) == strtolower($langarray[1]) || strtolower($langofdir) == 'el_gr')) {
            $alt = 1;
        }
        if ($alt < 2 && strtolower($langofdir) == 'en_us') {
            $alt = 2;
        }

        if (empty($langofdir)) {
            if (empty(DISABLE_SYSLOG)) {
                pm_syslog(
                    'Error: ' . get_class($this) . '::load was called for domain=' . $domain . ' 
			but language was not set yet with langs->setDefaultLang(). Nothing will be loaded.',
                    PM_LOG_WARNING
                );
            }

            return -1;
        }

        // Directory of translation files
        $file_lang = $this->dir . '/langs/' . $langofdir . '/' . $newdomain . '.lang';
        $file_lang_osencoded = get_osencode($file_lang);
        $filelangexists = is_file($file_lang_osencoded);
        if ($filelangexists) {
            if ($fp = fopen($file_lang, 'rt')) {
                /**
                 * Read each lines until a '=' (with any combination of spaces around it)
                 * and split the rest until a line feed.
                 * This is more efficient than fgets + explode + trim by a factor of ~2.
                 */
                while ($line = fscanf($fp, "%[^= ]%*[ =]%[^\n\r]")) {
                    if (isset($line[1])) {
                        [$key, $value] = $line;
                        if (empty($this->tab_translate[$key])) {
                            if ($key == 'DIRECTION') {
                                // This is to declare direction of language
                                if ($alt < 2 || empty($this->tab_translate[$key])) {
                                    // We load direction only for primary files or if not yet loaded
                                    $this->tab_translate[$key] = $value;
                                    if ($stopafterdirection) {
                                        break;
                                    }
                                }
                            } elseif ($key[0] == '#') {
                                continue;
                            } else {
                                $this->tab_translate[$key] = str_replace(['\\n', '\\\\s'], ["\n", '\s'], $value);
                            }
                        }
                    }
                }
                fclose($fp);
                $fileread = 1;
            }
        }

        if ($alt == 0) {
            $langofdir = strtolower($langarray[0]) . '_' . strtoupper($langarray[0]);
            $this->load($domain, $alt + 1, $stopafterdirection, $langofdir);
        }

        if ($alt == 1) {
            $langofdir = 'en_US';
            $this->load($domain, $alt + 1, $stopafterdirection, $langofdir);
        }

        if ($alt == 2) {
            if ($fileread) {
                $this->tab_loaded[$newdomain] = 1;
                // Set domain file as found so loaded
            }

            if (empty($this->tab_loaded[$newdomain])) {
                $this->tab_loaded[$newdomain] = 2; // Set this file as not found
            }
        }

        if (
            !empty($this->tab_translate['SeparatorDecimal']) && !empty($this->tab_translate['SeparatorThousand'])
            && $this->tab_translate['SeparatorDecimal'] == $this->tab_translate['SeparatorThousand']
        ) {
            $this->tab_translate['SeparatorThousand'] = '';
        }

        return 1;
    }

    /**
     *  Return text translated of text received as parameter (and encode it into HTML)
     *  If there is no match for this text, we look in alternative file and if still not found, it is returned as it is.
     *  The parameters of this method should not contain HTML tags. If there is, they will be htmlencoded to have no effect.
     *
     * @param string $key    Key to translate
     * @param string $param1 param1 string
     * @param string $param2 param2 string
     * @param string $param3 param3 string
     * @param string $param4 param4 string
     *
     * @return string            Translated string (encoded into HTML entities and UTF8)
     * @throws Exception
     */
    public function trans(string $key, string $param1 = '', string $param2 = '', string $param3 = '', string $param4 = '')
    {

        if (!empty($this->tab_translate[$key])) {
            $str = $this->tab_translate[$key];
            $str = str_replace(
                [
                    '"', '<b>', '</b>', '<u>', '</u>', '<i', '</i>',
                    '<strong>', '</strong>', '<a ', '</a>', '<br>',
                    '<span', '</span>', '< ', '>',
                ],
                [
                    '__quot__', '__tagb__', '__tagbend__', '__tagu__', '__taguend__',
                    '__tagi__', '__tagiend__', '__tagb__', '__tagbend__', '__taga__', '__tagaend__',
                    '__tagbr__', '__tagspan__', '__tagspanend__', '__ltspace__', '__gt__',
                ],
                $str
            );
            if (strpos($key, 'Format') !== 0) {
                $str = sprintf($str, $param1, $param2, $param3, $param4);
                // Replace %s and %d except for FormatXXX strings.
            }

            $str = htmlentities($str, ENT_COMPAT, $this->charset_output);

            // Do not convert simple quotes in translation

            return str_replace(
                [
                    '__quot__', '__tagb__', '__tagbend__', '__tagu__', '__taguend__',
                    '__tagi__', '__tagiend__', '__taga__', '__tagaend__', '__tagbr__',
                    '__tagspan__', '__tagspanend__', '__ltspace__', '__gt__',
                ],
                [
                    '"', '<b>', '</b>', '<u>', '</u>', '<i', '</i>',
                    '<a ', '</a>', '<br>', '<span', '</span>', '< ', '>',
                ],
                $str
            );
        } else {
            return 'NoTranslationYet';
        }
    }
}
