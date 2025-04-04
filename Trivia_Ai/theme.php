<?php
// Set 5-day expiration time
$cookie_expiration = time() + (5 * 24 * 60 * 60);

// Fetch translations from cookie
if (isset($_COOKIE['translations'])) {   
    $translations = json_decode($_COOKIE['translations'], true);
    $language = $translations['language'];
    $manage_themes = $translations['manage_themes'];
    $theme_name_placeholder = $translations['theme_name_placeholder'];
    $add_theme = $translations['add_theme'];
    $current_themes = $translations['current_themes'];
    $delete = $translations['delete'];
    $returnbutton = $translations['return'];
    $name = $translations['name'];
}

$themes = isset($_COOKIE['user_themes']) ? json_decode($_COOKIE['user_themes'], true) : [];
// Handle form submission to add a theme
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["add_theme"])) {
        $theme_name = trim($_POST["theme_name"]);
        if (!empty($theme_name)) {
            $themes[] = $theme_name;
            setcookie("user_themes", json_encode($themes), $cookie_expiration, "/");
            header("Location: theme.php");
            exit();
        }
    }

    // Handle theme selection (store it in cookie)
    if (isset($_POST['select_theme'])) {
        $selected_theme = $_POST['selected_theme'];
        setcookie("selected_theme", $selected_theme, $cookie_expiration, "/");
        header("Location: theme.php");
        exit();
    }
}
// Handle theme deletion
if (isset($_GET['delete'])) {
    $theme_to_delete = $_GET['delete'];
    if (($key = array_search($theme_to_delete, $themes)) !== false) {
        unset($themes[$key]);
        $themes = array_values($themes); // Reindex the array
        setcookie("user_themes", json_encode($themes), $cookie_expiration, "/");
    }
    header("Location: theme.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $name; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container"> <!-- Adjust max-height as needed -->

    <div class="menu" id="themescroll">
        <h1><?php echo $manage_themes; ?></h1>
        <form method="post" action="theme.php">
            <input type="text" name="theme_name" placeholder="<?php echo $theme_name_placeholder; ?>" required>
            <button type="submit" name="add_theme"><?php echo $add_theme; ?></button>
        </form>
        <h2><?php echo $current_themes; ?></h2>
        <ul>
            <?php foreach ($themes as $theme): ?>
                <li>
                    <?php echo htmlspecialchars($theme); ?>
                    <a href="?delete=<?php echo urlencode($theme); ?>"><?php echo $delete; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <button id="returnbutton" class="return-button" onclick="MainPage()"><?php echo $returnbutton; ?></button>

</div>

</body>
<script>
    function MainPage() {
        window.location.href = 'Main_menu.php'; // Redirect to Main_menu.php
    }
</script>
</html>
