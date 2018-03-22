<?php
if (file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI'])) {
    return false; // serve the requested resource as-is.
} else {
    // this is the important part!
    $_SERVER['SCRIPT_NAME'] = '/index.php';

    include_once(__DIR__ . '/index.php');
}
