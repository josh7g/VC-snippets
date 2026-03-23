<?php
//Ignore the design setup below:
include_once('./ignore/design/design.php');
$design = Design(__FILE__, 'Vsnippet #38 - PHP Code Injection');

/*
* YesWeHack - Vulnerable Code Snippet
*/
?>

<?php

// Modified by Rezilant AI, 2026-03-23 17:49:52 GMT, Added secure file path validation to prevent SSRF via file name input
// Define allowed base directory
define('ALLOWED_TODO_DIR', './todos/');

// Validate and sanitize the filename
function getSafeFilePath($userInput) {
    // Remove any path traversal attempts
    $filename = basename($userInput);
    
    // Whitelist allowed characters (alphanumeric, dash, underscore only)
    if (!preg_match('/^[a-zA-Z0-9_-]+\.txt$/', $filename)) {
        throw new Exception('Invalid filename format');
    }
    
    // Construct full path
    $fullPath = ALLOWED_TODO_DIR . $filename;
    
    // Verify the resolved path is still within allowed directory
    $realPath = realpath(dirname($fullPath));
    $allowedPath = realpath(ALLOWED_TODO_DIR);
    
    if ($realPath === false || strpos($realPath, $allowedPath) !== 0) {
        throw new Exception('Invalid file path');
    }
    
    return $fullPath;
}

// Original Code
// $file = "todo.txt";
// if ( isset($_GET['fileTodo']) && strlen($_GET['fileTodo']) > 0 ) {
//   $file = $_GET['fileTodo'];
// }
// 
// $fileTodo = fopen($file, "a");

// Modified by Rezilant AI, 2026-03-23 17:49:52 GMT, Replaced direct file input with validated file path
try {
    $file = "todo.txt";
    if ( isset($_GET['fileTodo']) && strlen($_GET['fileTodo']) > 0 ) {
        $file = getSafeFilePath($_GET['fileTodo']);
    } else {
        $file = ALLOWED_TODO_DIR . $file;
    }
    
    $fileTodo = fopen($file, "a");
    
    if ( isset($_GET['add']) ) {
        // Modified by Rezilant AI, 2026-03-23 17:49:52 GMT, Added htmlspecialchars to prevent XSS
        $todo = '<input type="checkbox"><b>'. htmlspecialchars($_GET['add'], ENT_QUOTES, 'UTF-8') .'</b><br>';
        fwrite($fileTodo, $todo);
    }
    fclose($fileTodo);
} catch (Exception $e) {
    error_log($e->getMessage());
    die('Invalid file access attempt');
}

?>

<div style="font-size:18px;">
  <?= file_get_contents($file); ?>
</div>

<div id="todo">
<form action="" method="GET">
  <label>Add a new todo to your file!</label>
  <input type="textarea" name="add">
  <input type="hidden" name="fileTodo" value="todo.txt">
</form>
</div>

<div>
<?= $design ?>
</div>
<body>
</html>