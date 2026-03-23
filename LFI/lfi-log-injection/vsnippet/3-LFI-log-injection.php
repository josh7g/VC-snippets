<?php
include_once('./ignore/design/design.php');
$title = 'Vsnippet #31 - Local File Inclusion (LFI)';
$design = Design(__FILE__, $title);

/**
 * YesWeHack - Vulnerable Code Snippet
 */
?>

<?php

// Secure the input from path traversal
function IncludeFilter($str) {
    while (True) {
        if ( strpos($str, "../") == false ) {
            break;
        }
        $str = str_replace("../", "", $str);
    }
    return $str;
}

// Normalize slash related to OS
function OSPath($str){
    if ( strtolower(PHP_OS) == "linux" ) {
        $str = str_replace("\\", "/", $str);
        
    } else {
        $str = str_replace("/", "\\", $str);
    }
    return $str;
}

// Log the given value to a the log file
function Logging($value) {
    file_put_contents("logs/log.txt", (date("[Y-m-d]") . "$value\n"), FILE_APPEND);
}

// Modified by Rezilant AI, 2024-12-22 10:30:00 GMT, Replaced vulnerable include logic with strict allowlist approach to prevent path traversal and LFI attacks
// Define allowed languages
$allowed_languages = [
    'en' => 'home/en.php',
    'fr' => 'home/fr.php',
    'es' => 'home/es.php',
    'de' => 'home/de.php'
];

// Get language parameter with default fallback
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Validate against allowlist
if (!array_key_exists($lang, $allowed_languages)) {
    $lang = 'en'; // Default to English if invalid
}

// Log the validated value
Logging($lang);

// Include the validated file
include($allowed_languages[$lang]);

// Original Code
// $lang = ( isset($_GET['lang']) ) ? $_GET['lang'] : "en";
// 
// Logging($lang);
// include(OSPath("home/" . IncludeFilter($lang)));

?>

<html>
<head>
<title><?= $title ?></title>
</head>
<body>
<div>
<?= $design ?>
</div>
<body>
</html>