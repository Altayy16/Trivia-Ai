# Trivia Game Website

This repository contains a Trivia Game Website that uses Gemini to generate trivia questions dynamically, supports multiple languages, and allows users to customize the appearance with themes.

## Required
- You nee to install php
- In Xampp php.ini file you need to enable:
  extension=curl,
  extension=pdo_pgsql,
  extension=pgsql
- install composer
  https://getcomposer.org/download/
- install gemini-api-php
  https://github.com/gemini-api-php/client?tab=readme-ov-file#basic-text-generation ( i followed this to install it)


## Technologies Used

**Frontend:**
- HTML
- CSS
- JavaScript
- AJAX
- JSON

**Backend:**
- PHP
- Gemini API

## Key Features

### Dynamic Question Generation
- Gemini generates trivia questions in real-time.
- Reduces the need for a static question database, ensuring that content is always fresh and varied.

### Main Menu
- **Play Game:** Launches the trivia game.
- **Change Language:** Select and switch between multiple languages.
- **Add Theme:** Customize the appearance of the game by adding or changing themes.

### Language Support
- **Dynamic Language Switching:** Users can change the website language dynamically without refreshing the page.
- **Predefined Translations:** Supports multiple languages, including:
  - Turkish
  - English
  - French
  - German
  - Spanish
  - Italian

#### Language Selection Implementation:
- Users can select their preferred language from a dropdown menu.
- An **AJAX request** is sent to `language.php` to fetch the selected language’s translations in JSON format.
- The page elements (buttons, titles, etc.) are updated with the new language.
- The selected language is stored in the cookie through another AJAX request (`store_translations.php`).
- The user is redirected to the appropriate page (e.g., game or theme management) to view the updates.

### Theme Management
- **View Themes:** Displays the current list of themes dynamically by reading from the Theme cookie ensuring that the theme is different for every user.
- **Add Theme:** Users can add new themes via a form, which appends the theme to the cookie.
- **Delete Theme:** Users can delete themes, which updates the cookie accordingly.
- **Real-Time Updates:** The page reflects changes made to the theme file without needing a database.

#### Theme Management Implementation:
- Themes are stored in a cookie
- Adding and deleting themes updates the cookie directly.
- The interface dynamically updates the theme list without requiring page reloads.

### Play Game Mechanism
- **Start Game:** Users initiate the game, which triggers a request to generate a trivia question from Gemini using API.
- **Generate Question:** The AI service creates a question with multiple-choice answers.
- **Handle Response:** The question and answers are parsed, and the correct answer is extracted.
- **Display Question:** The question and choices are displayed for the user to answer.
- **Error Handling:** In case of a request timeout, the system retries up to three times to generate the question.

#### Play Game Implementation:
- When the game starts, a request is sent to Mistral AI to generate a trivia question.
- The response is parsed to extract the question and answers.
- The question and choices are displayed on the page.
- The system retries up to three times if the AI request fails to ensure reliable question generation.
