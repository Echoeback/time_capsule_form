<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];
    $echoeback_time = $_POST['echoeback_time'];
    $coffee = $_POST['coffee'];

    $file = $_FILES['file'];
    $file_name = basename($file['name']);
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $valid_extensions = array('mp4', 'mov', 'avi', 'jpg', 'jpeg', 'png', 'gif');

    if ($file_size > 1073741824) { // 1GB in bytes
        echo "File size exceeds 1GB limit.";
    } elseif (!in_array($file_ext, $valid_extensions)) {
        echo "Invalid file type. Only MP4, MOV, AVI, JPG, JPEG, PNG, and GIF files are allowed.";
    } else {
        $file_dest = $upload_dir . $file_name;
        if (move_uploaded_file($file_tmp, $file_dest)) {
            // Save form data to a file or database (this is just an example)
            $data = "Name: $name\nEmail: $email\nMessage: $message\nEchoeBack Time: $echoeback_time\nCoffee: $coffee\nFile: $file_dest\n\n";
            file_put_contents('submissions.txt', $data, FILE_APPEND);

            echo "<script>alert('YOUR CAPSULE IS ON THE WAY.'); window.location.href = 'time_capsule_form.html';</script>";
        } else {
            echo "Error uploading file.";
        }
    }
} else {
    echo "Invalid request.";
}
?>
