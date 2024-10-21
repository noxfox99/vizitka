<?php
// File: update-links.php

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get the raw POST data (JSON)
    $jsonData = file_get_contents('php://input');
    
    // Decode the JSON data to a PHP array
    $data = json_decode($jsonData, true);

    // Check if 'links' data is present in the request
    if (isset($data['links'])) {
        $links = $data['links'];

        // Create an array to hold the formatted file content
        $fileContent = [];

        // Format each link as a <div> tag
        foreach ($links as $link) {
            $fileContent[] = '<div id="' . htmlspecialchars($link['side']) . '" class="' . htmlspecialchars($link['class']) . '">' . htmlspecialchars($link['url']) . '</div>';
        }

        // Join the formatted lines into a string
        $fileContentStr = implode("\n", $fileContent);

        // Write the content back to links.txt
        if (file_put_contents('links.txt', $fileContentStr)) {
            // Return success response
            http_response_code(200);
            echo 'File updated successfully';
        } else {
            // Return error response if file writing fails
            http_response_code(500);
            echo 'Failed to write to file';
        }
    } else {
        // Invalid request data
        http_response_code(400);
        echo 'Invalid request data';
    }
} else {
    // Method not allowed for non-POST requests
    http_response_code(405);
    echo 'Method Not Allowed';
}
?>
