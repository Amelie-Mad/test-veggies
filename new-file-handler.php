<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Extract data from the form
    $file = $_FILES['file'];

    // Validate form data
    if (empty($plant)) {
        header("Location: index.php");
        exit();
    }
    
} else {
    header("Location: index.php");
}
