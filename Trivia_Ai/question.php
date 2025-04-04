<?php

require "vendor/autoload.php";
use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

// Set expiration time for cookies (5 days)
$cookie_expiration = time() + (5 * 24 * 60 * 60);

// Fetch translations and language from cookies
if (isset($_COOKIE['translations'])) {
  $translations = json_decode($_COOKIE['translations'], true);
  $language = $translations['language'];
  $name = $translations['name'];
    // Fetch themes from cookie or set a default
    if (isset($_COOKIE['user_themes'])) {
      $themes = json_decode($_COOKIE['user_themes'], true);
  } else {
      $themes = ["culture general, histoire, geographie"];
  }
}

// Create the Gemini client instance
$client = new Client("AIzaSyDhWtWZmfSE_tDZyKUyu5iWm8h5JMbEO48");

// Prepare the themes string
$themes_str = implode(", ", $themes); // Convert the themes array to a comma-separated string

// Create the prompt with dynamic language and themes
$prompt = "Ecris une question pour question pour un champion avec 4 choix (je veux que les choix soit écrits absolument dans ce format => A., B., C., D.. Ecris la réponse à la fin des choix entre parenthèses comme ceci (Response:!La lettre de la réponse(entre 2 points d'exclamation! et ensuite une explication). Langue de la question : $language, niveau : moyen, thèmes : $themes_str.";

$response = $client->geminiPro15()->generateContent(
    new TextPart($prompt)
);

$responseContent = $response->text() ?? 'No response received.';

// ✅ Extract the correct answer letter between !A!, !B!, etc.
preg_match('/!([A-D])!/', $responseContent, $correctAnswerMatch);
$correctAnswer = $correctAnswerMatch[1] ?? 'A';

// ✅ Extract only the question (everything before A. ...)
preg_match('/^(.*?)(?=\s*A\.\s)/s', $responseContent, $questionMatch);
$question = trim($questionMatch[1]);

// ✅ Extract choices (A., B., C., D.)
preg_match_all('/[A-D]\.\s.*(\n|$)/', $responseContent, $choicesMatch);
$choices = array_map('trim', $choicesMatch[0] ?? []);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Game</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <div class="question-box">
            <p id="question">
                <?php 
                // Display the question (without the choices and response explanation)
                echo nl2br(htmlspecialchars($question));
                ?>
            </p>
        </div>

        <div class="answers">
            <?php foreach ($choices as $index => $choice): ?>
                <button class="answer-btn" onclick="checkAnswer('<?php echo chr(65 + $index); ?>')">
                    <?php echo htmlspecialchars(trim($choice)); ?>
                </button>
            <?php endforeach; ?>
        </div>

    </div>

    <script>
        function checkAnswer(selectedAnswer) {
            var correctAnswer = "<?php echo $correctAnswer; ?>";
            
            if (selectedAnswer === correctAnswer) {
                alert("Correct! Vous avez choisi la bonne réponse.");
            } else {
                alert("Incorrect. La bonne réponse était " + correctAnswer);
            }
            location.reload();
        }
    </script>

</body>
</html>
