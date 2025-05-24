<?php

if (isset($_POST['Upload'])) {
    // Allowed MIME types for upload
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

    // File info
    $file_tmp = $_FILES['uploaded']['tmp_name'];
    $file_name = $_FILES['uploaded']['name'];
    $file_type = mime_content_type($file_tmp);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validate MIME type and extension
    if (!in_array($file_type, $allowed_types) || !in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        $html .= '<pre>Invalid file type. Only JPG, PNG, and GIF are allowed.</pre>';
    } else {
        // Create a secure random filename
        $safe_filename = uniqid('img_', true) . '.' . $file_ext;

        // Define a safe upload directory (outside web root if possible)
        $upload_dir = __DIR__ . '/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $target_path = $upload_dir . $safe_filename;

        // Move the file securely
        if (move_uploaded_file($file_tmp, $target_path)) {
            $html .= "<pre>File successfully uploaded as {$safe_filename}</pre>";
        } else {
            $html .= '<pre>Your image was not uploaded.</pre>';
        }
    }
}
?>
