<?php
//Ignore the design setup below:
include_once('./ignore/design/design.php');
$title = 'Vsnippet #18 - Path Traversal - Regex bypass';
$design = Design(__FILE__, $title);

/*
* YesWeHack - Vulnerable Code Snippet
*/

?>

<?php
// Modified by Rezilant AI, 2026-03-23 17:50:12 GMT, Implemented whitelist-based approach with absolute path validation to prevent path traversal and SSRF attacks
function PathFilter($s) {
    /** Securely validate and filter file paths
     * Return safe absolute path or false
    */
    // Define allowed directory (use absolute path)
    $allowed_dir = realpath('/var/www/html/safe_files/');
    
    // Get the absolute path of the requested file
    $requested_path = realpath($allowed_dir . '/' . basename($s));
    
    // Verify the resolved path starts with the allowed directory
    if ($requested_path === false || strpos($requested_path, $allowed_dir) !== 0) {
        return false;
    }
    
    // Optional: Whitelist allowed file extensions
    $allowed_extensions = ['txt', 'md', 'log'];
    $ext = strtolower(pathinfo($requested_path, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_extensions)) {
        return false;
    }
    
    return $requested_path;
}

// Original Code
// function PathFilter($s) {
//     /** Filter 'Path Traversal' from the user provided file
//      * Return filtered value
//     */
//     $s = preg_replace("/(:\/\/)|\\\\/", "", $s);
//     while ( str_contains($s, "../") ) {
//         $s = str_replace("../", "", $s);
//     }
//     return $s;
// }

$content = 'Missing parameter "file", No file given.';

// Modified by Rezilant AI, 2026-03-23 17:50:12 GMT, Replaced direct file access with secure path validation and error handling
// Check user input for file:
if ( isset($_GET['file']) && $_GET['file'] != "" ) {
    $safe_path = PathFilter($_GET['file']);
    
    if ($safe_path === false) {
        $content = 'Invalid file request.';
    } elseif (is_file($safe_path)) {
        $content = file_get_contents($safe_path);
    } else {
        $content = 'File not found.';
    }
}

// Original Code
// if ( isset($_GET['file']) && $_GET['file'] != "" ) {
//     $file =  htmlspecialchars( PathFilter($_GET['file']) );
//     $content = file_get_contents( $file );
//
//     if ( strlen($content) <= 0 ) {
//         $content = 'Could not find file: ' . htmlentities($file);
//     }
// }
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
</head>
<body>
<h1><?= $title ?></h1>

<!-- Display the content from the file given by the user param "file" -->
<?= $content ?>

<div>
<?= $design ?>
</div>
<body>
</html>