<?php
session_start();
if (isset($_SESSION['translations'])) {
    $translations = $_SESSION['translations'];

    // Now you can use $translations array to access translated strings
    $language = $_SESSION['language'];
    $name = $translations['name'];
}
require_once 'vendor/autoload.php';

use ModelflowAi\Ollama\Ollama;
use Symfony\Component\HttpClient\Exception\TimeoutException;

// Function to handle retries
function retry($retries, $callback) {
    $attempts = 0;
    while ($attempts < $retries) {
        try {
            return $callback();
        } catch (TimeoutException $e) {
            $attempts++;
            if ($attempts === $retries) {
                throw $e;
            }
        }
    }
}

// Create a client instance with a longer timeout
$client = Ollama::client('http://127.0.0.1:11434/api/generate', ['timeout' => 180]); // Set timeout to 180 seconds

// Use the client
$chat = $client->chat();
$completion = $client->completion();
$embeddings = $client->embeddings();

try {
    // Example usage of chat with retry mechanism
    $chatResponse = retry(3, function() use ($chat) {
        return $chat->create([
            'model' => 'mistral',
            'messages' => [[
                'role' => 'user', 
                'content' => 'Ecris une question pour question pour un champion avec 4 choix (je veux que les choix soit ecrtis absolument dans ce format => A.,B.,C.,D.. Ecris la reponse a la fin des choix entre paranthese comme ceci{ (Response:!La lettre de la reponse(entre 2 point d exclamation! et la tu mets la reponse et son explication dans la meme paranthese)}
                Langue de la question: anglais
                niveau: hard
                Les Thèmes possible: histoire, géographie,pop culture, Culture Generale'
            ]],
        ]);
    }); 
} catch (TimeoutException $e) {
    echo "The request timed out after multiple attempts.";
    exit;
}

$responseContent = $chatResponse->message->content;

// Extract the question, choices, and response using regular expressions
preg_match_all('/[A-D]\.\s.*\n/', $responseContent, $choicesMatch);
preg_match('/\(Response:\s*(.*)$/s', $responseContent, $responseMatch);

$choices = $choicesMatch[0];
$response = $responseMatch[1] ;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($name); ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <div class="question-box">
            <p id="question">
                <?php 
                // Afficher la question (sans les choix)
                echo nl2br(htmlspecialchars(trim(preg_replace('/[A-D]\.\s.*/', '', $responseContent))));
                ?>
            </p>
        </div>

        <div class="answers">
            <?php foreach ($choices as $index => $choice): ?>
                <button class="answer-btn" onclick="checkAnswer('<?php echo $index; ?>', '<?php echo htmlspecialchars($response); ?>')">
                    <?php echo htmlspecialchars($choice); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <h2>Response</h2>
        <p><?php echo htmlspecialchars($response); ?></p>
    </div>

    <script>
        // Choices array to map index to the actual choice
        const choices = <?php echo json_encode($choices); ?>;

        function checkAnswer(index, response) {
            // Get the letter corresponding to the choice (A, B, C, D)
            const choiceLetter = String.fromCharCode(65 + index); // 65 = 'A' in ASCII

            // Extract the correct answer letter from the response using regex
            const correctAnswerMatch = response.match(/!([A-D])!/);

            if (correctAnswerMatch && correctAnswerMatch[1] === choiceLetter) {
                alert("Bonne réponse: " + choices[index]);
            } else {
                alert("Mauvaise réponse: " + choices[index]);
            }
        }
    </script>

</body>
</html>