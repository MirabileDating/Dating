<?php

class I18N {
    const SESSION_LANGUAGE_PREFERENCE = 'i18n_language_preference';

    public static function init($domain, $directory, $defaultLanguage, $mappings = array()) {
        if (!self::isSessionActive()) {
			error_log("SESSION START: ". serialize($_POST). "\n", 3, "/home/html/love/facebook.log");
            throw new Exception('You must call session_start() before you can use the I18N class');
        }
        if (isset($_SESSION[self::SESSION_LANGUAGE_PREFERENCE])) {
            $language = $_SESSION[self::SESSION_LANGUAGE_PREFERENCE];
        }
        else {
            $language = self::getAutoDetectedLanguage($defaultLanguage, $mappings);
            $_SESSION[self::SESSION_LANGUAGE_PREFERENCE] = $language;
        }
        putenv('LANG='.$language.'.utf8');
        setlocale(LC_MESSAGES, $language.'.utf8');
        bindtextdomain($domain, $directory);
        bind_textdomain_codeset($domain, 'UTF-8');
        textdomain($domain);
        header('Vary: Accept-Language');
    }

    public static function changeLanguage($newLanguageIdentifier) {
        $_SESSION[self::SESSION_LANGUAGE_PREFERENCE] = htmlspecialchars(trim($newLanguageIdentifier));
    }
    private static function getAutoDetectedLanguage($defaultLanguage, $mappings) {
        // get the preferred language from the browser
        $browserLanguage = self::getBrowserLanguage();
        // if a preferred language has been detected
			
        if (isset($browserLanguage)) {
            // try to find a matching language identifier for the browser language in the given mappings
            foreach ($mappings as $acceptLanguageRegex => $languageIdentifier) {
                if (preg_match($acceptLanguageRegex, $browserLanguage)) {
				
				
                    return $languageIdentifier;
                }
            }
        }
       
        return $defaultLanguage;
    }

    public static function getBrowserLanguage() {
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        }
        else {
            return NULL;
        }
    }
    private static function isSessionActive() {
        if (version_compare(phpversion(), '5.4.0', '>=')) {
            return session_status() === PHP_SESSION_ACTIVE;
        }
        else {
            return session_id() !== '';
        }
    }
}

function __($str) {
    $args = func_get_args();
    $args[0] = _($str);
    return call_user_func_array('sprintf', $args);
}