<?php
session_start();
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        if (empty($_POST['title'])) {
            throw new Exception('Task title is required');
        }

        // Sanitize input
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $description = !empty($_POST['description']) ? htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8') : null;

        // Prepare and execute the insert statement
        $stmt = $pdo->prepare("INSERT INTO tasks (title, description) VALUES (?, ?)");
        $stmt->execute([$title, $description]);

        $_SESSION['message'] = 'Task added successfully!';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}

// Redirect back to index page
header('Location: ../index.php');
exit;
