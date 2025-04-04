<?php
// Fetch the translations from cookie
if (isset($_COOKIE['translations'])) {
    $translations = json_decode($_COOKIE['translations'], true);
    $language = $translations['lang'];
    // Now you can use $translations array to access translated strings
    $game = $translations['game'];
    $theme = $translations['theme'];
    $select_language = $translations['select_language'];
    $soundbutton = $translations['sound'];
    $name = $translations['name'];
} else {
    // Fallback to default values
    $game = "START GAME";
    $theme = "THEMES";
    $language="en";
    $select_language = "Select Language";
    $soundbutton = "TURN OFF SOUND";
    $name = "Who Wants to Be a Millionaire?";
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id='title'><?php echo $name;?></title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body >
    <div class="container">
        <div class="menu">
            <button id="gameButton" onclick="goToGames()"><?php echo $game?></button>
            <div class="dropdown-container" style="background-color: #6a0dad;">
            <select id="languageSelect" onchange="changeLanguage()">
                <option value="" disabled <?php echo empty($language) ? 'selected' : ''; ?>><?php echo $select_language ?></option>
                <option value="tr" <?php echo ($language === 'tr') ? 'selected' : ''; ?>>Türkçe</option>
                <option value="en" <?php echo ($language === 'en') ? 'selected' : ''; ?>>English</option>
                <option value="fr" <?php echo ($language === 'fr') ? 'selected' : ''; ?>>Français</option>
                <option value="de" <?php echo ($language === 'de') ? 'selected' : ''; ?>>Deutsch</option>
                <option value="es" <?php echo ($language === 'es') ? 'selected' : ''; ?>>Español</option>
                <option value="it" <?php echo ($language === 'it') ? 'selected' : ''; ?>>Italiano</option>
            </select>
            </div>
            <button id="themeButton" onclick="goToThemes()"><?php echo $theme?></button>
        </div>
        <button id="soundButton" class="sound-button" onclick="toggleSound()"><?php echo $soundbutton?></button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize Select2 on the languageSelect element
            $('#languageSelect').select2({
                placeholder: '<?php echo $select_language ?>'
            });
        });

        function startGame() {
            alert('Oyuna Başla tıklandı');
        }

        function changeLanguage() {
            var language = document.getElementById("languageSelect").value;
            
            // AJAX request to change the language
            $.ajax({
                url: "language.php",
                type: "POST",
                data: { language: language },
                success: function(response) {
                    var translations = JSON.parse(response);
                    // Update the game button text
                    document.getElementById("title").innerHTML = translations.name;
                    document.getElementById("gameButton").innerHTML = translations.game;
                    // Update the theme button text
                    document.getElementById("themeButton").innerHTML = translations.theme;
                    // Update the sound button text
                    document.getElementById("soundButton").innerHTML = translations.sound;
                },
                error: function(xhr, status, error) {
                    console.error("Dil değiştirilemedi: " + error);
                }
            });
        }

        function info() {
            alert('Bilgiler tıklandı');
        }
        function goToGames() {
                var language = document.getElementById("languageSelect").value;
                // AJAX request to change the language
                $.ajax({
                    url: "language.php",
                    type: "POST",
                    data: { language: language },
                    success: function(response) {
                        var translations = JSON.parse(response);
                        // AJAX request to store translations in session
                        $.ajax({
                            url: 'store_translations.php', // Create a PHP file to handle storing translations in session
                            type: 'POST',
                            data: { translations: translations },
                            success: function() {
                                window.location.href = 'question.php'; // Redirect to theme.php after storing translations
                            },
                            error: function(xhr, status, error) {
                                console.error("Failed to store translations in session: " + error);
                            }
                        });
                    },

                    error: function(xhr, status, error) {
                        console.error("Dil değiştirilemedi: " + error);
                    }
                });
            }



            function goToThemes() {
                var language = document.getElementById("languageSelect").value;
                // AJAX request to change the language
                $.ajax({
                    url: "language.php",
                    type: "POST",
                    data: { language: language },
                    success: function(response) {
                        var translations = JSON.parse(response);
                        // AJAX request to store translations in session
                        $.ajax({
                            url: 'store_translations.php', // Create a PHP file to handle storing translations in cookies
                            type: 'POST',
                            data: { translations: translations },
                            success: function() {
                                window.location.href = 'theme.php'; // Redirect to theme.php after storing translations
                            },
                            error: function(xhr, status, error) {
                                console.error("Failed to store translations in session: " + error);
                            }
                        });
                    },

                    error: function(xhr, status, error) {
                        console.error("Dil değiştirilemedi: " + error);
                    }
                });
            }

        function toggleSound() {
            alert('Ses Kapalı');
        }
    </script>
</body>
</html>
