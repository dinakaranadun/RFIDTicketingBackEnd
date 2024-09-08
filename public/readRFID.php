<?php
    // Define the direct path to the UIDContainer.php file
    $file = __DIR__ . '/../storage/app/UIDContainer.php'; // Adjust the path if needed

    if (file_exists($file)) {
        // Extract RFID from the file
        // $UIDresult = include($file);
        $UIDresult= file_get_contents($file);

        // Output the RFID if it's not empty
        if (!empty($UIDresult)) {
            echo $UIDresult;
        } else {
            echo ''; // No RFID in the file
        }

        // Output the result
        // echo $UIDresult;
    } else {
        echo 'No RFID found';
    }
?>
