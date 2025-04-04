<?php
// Check if the cookies exist and retrieve them
if (isset($_COOKIE['translations'])) {
    $translations = json_decode($_COOKIE['translations'], true);
    $language = $translations['language'];
}
if (isset($_POST['translations'])) {
    // Set the cookie to expire in 5 days
    setcookie('translations', json_encode($_POST['translations']), time() + (5 * 24 * 60 * 60), "/");
}


?>
