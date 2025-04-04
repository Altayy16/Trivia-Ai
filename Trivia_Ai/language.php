<?php
if (isset($_POST['language'])) {
    $language = $_POST['language'];

    // Define your translations
    $translations = [
        'tr' => [
            'lang' => 'tr',
            'language' => 'Türkçe',
            'game' => 'Oyuna Başla',
            'theme' => 'TEMALAR',
            'sound' => 'SESI KAPAT',
            'add_theme' => 'Tema Ekle',
            'theme_name_placeholder' => 'Tema Adı',
            'manage_themes' => 'Temaları Yönet',
            'current_themes' => 'Mevcut Temalar',
            'delete' => 'Sil',
            'return' => 'Geri Dön',
            'select_language' => 'Dil Seçiniz', // Added "Dil Seçiniz" option
            'name'=>'Kim Milyoner Olmak Ister?'
        ],
        'en' => [
            'lang' => 'en',
            'language' => 'English',
            'game' => 'Start Game',
            'theme' => 'THEMES',
            'sound' => 'TURN OFF SOUND',
            'add_theme' => 'Add Theme',
            'theme_name_placeholder' => 'Theme Name',
            'manage_themes' => 'Manage Themes',
            'current_themes' => 'Current Themes',
            'delete' => 'Delete',
            'return' => 'Return',
            'select_language' => 'Select Language', // Added "Select Language" option
            'name'=>'Who Wants to Be a Millionaire?'
        ],
        'fr' => [
            'lang' => 'fr',
            'language' => 'Français',
            'game' => 'Commencer le jeu',
            'theme' => 'THÈMES',
            'sound' => 'ÉTEINDRE LE SON',
            'add_theme' => 'Ajouter un thème',
            'theme_name_placeholder' => 'Nom du thème',
            'manage_themes' => 'Gérer les thèmes',
            'current_themes' => 'Thèmes actuels',
            'delete' => 'Supprimer',
            'return' => 'Retour',
            'select_language' => 'Sélectionner la langue', // Added "Sélectionner la langue" option
            'name'=>'Qui veut gagner des millions?'
        ],
        'de' => [
            'lang' => 'de',
            'language' => 'Deutsch',
            'game' => 'Spiel starten',
            'theme' => 'THEMEN',
            'sound' => 'TON AUSSCHALTEN',
            'add_theme' => 'Thema hinzufügen',
            'theme_name_placeholder' => 'Themenname',
            'manage_themes' => 'Themen verwalten',
            'current_themes' => 'Aktuelle Themen',
            'delete' => 'Löschen',
            'return' => 'Zurück',
            'select_language' => 'Sprache auswählen', // Added "Sprache auswählen" option
            'name'=>'Wer wird Millionär?'
        ],
        'es' => [
            'lang' => 'es',
            'language' => 'Espagnol',
            'game' => 'Iniciar juego',
            'theme' => 'TEMAS',
            'sound' => 'APAGAR SONIDO',
            'add_theme' => 'Agregar tema',
            'theme_name_placeholder' => 'Nombre del tema',
            'manage_themes' => 'Administrar temas',
            'current_themes' => 'Temas actuales',
            'delete' => 'Eliminar',
            'return' => 'Volver',
            'select_language' => 'Seleccionar idioma', // Added "Seleccionar idioma" option
            'name'=>'¿Quién quiere ser millonario?'
        ],
        'it' => [
            'lang' => 'it',
            'language' => 'Italiano',
            'game' => 'Inizia il gioco',
            'theme' => 'TEMI',
            'sound' => 'SPEGNI SUONO',
            'add_theme' => 'Aggiungi tema',
            'theme_name_placeholder' => 'Nome del tema',
            'manage_themes' => 'Gestisci temi',
            'current_themes' => 'Temi attuali',
            'delete' => 'Elimina',
            'return' => 'Torna indietro',
            'select_language' => 'Seleziona lingua', // Added "Seleziona lingua" option
            'name'=>'Chi vuol essere milionario?'
        ]
        // Add more translations as needed
    ];

    $response = $translations[$language] ?? $translations['tr']; // Default to Turkish if not found

    echo json_encode($response);
}
?>
