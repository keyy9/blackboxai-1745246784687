<?php
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        if (empty($_POST['id'])) {
            throw new Exception('Invalid request');
        }

        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

        // Delete the task
        $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->execute([$id]);

        $_SESSION['message'] = 'Task deleted successfully!';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}

// Redirect back to index page
header('Location: ../index.php');
exit;
