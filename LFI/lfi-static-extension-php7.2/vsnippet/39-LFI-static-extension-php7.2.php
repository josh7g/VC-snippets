<?php
//Ignore the design setup below:
include_once('./ignore/design/design.php');
$design = Design(__FILE__);

/*
* YesWeHack - Vulnerable Code Snippet
*/

?>

<?php
/*
* - [ GOAL ] -
* Use the Local File Inclusion (LFI) vulnerability to archive a remote code execution (RCE)
*/

#Load a page (view) provided by the application:
// Modified by Rezilant AI, 2026-03-23 17:45:47 GMT, Implemented allowlist validation to prevent LFI/RCE vulnerability
// Define allowlist of valid pages
$allowed_pages = [
    'home',
    'about',
    'contact',
    'products',
    'services'
];

// Get and sanitize user input
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Validate against allowlist
if (!in_array($page, $allowed_pages, true)) {
    // Default to home page or show error
    $page = 'home';
    // Optionally log the invalid attempt
    error_log("Invalid page request: " . $_GET['page']);
}

// Now safely include the file
include($_SERVER['DOCUMENT_ROOT'] . '/views/' . $page . '.php');
// Original Code - Vulnerable to LFI/RCE
// if ( isset($_GET['page']) ) {
//     include($_SERVER['DOCUMENT_ROOT'] . '/views/' . $_GET['page'] . '.php');
// } else {
//     echo '<h1>I want a page!</h1>';
// }
?>

<html>
<head>
    <title>Vsnippet #39 - PHP - Local file inclusion (LFI) to remote code execution (RCE)</title>
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>
<body>
<!-- Navigation Bar -->
<ul class="navbar">
    <a href="./?page=home">Home</a>
    <a href="./?page=about">About</a>
    <a href="./?page=contact">Contact</a>
</ul>
<div>
<?= $design ?>
</div>
<body>
</html>