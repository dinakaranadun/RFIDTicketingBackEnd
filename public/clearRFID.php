<?php
    // Path to UIDContainer.php
    $file = __DIR__ . '/../storage/app/UIDContainer.php'; // Adjust the path as needed

    if (file_exists($file)) {
        // Clear the file by writing an empty string
        file_put_contents($file, '');

        echo 'RFID file cleared successfully.';
    } else {
        echo 'RFID file not found.';
    }
?>
