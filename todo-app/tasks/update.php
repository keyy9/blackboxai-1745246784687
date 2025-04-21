<?php
require_once '../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate input
        if (empty($_POST['id']) || !isset($_POST['status'])) {
            throw new Exception('Invalid request');
        }

        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        $status = $_POST['status'] === 'completed' ? 'completed' : 'pending';

        // Update task status
        $stmt = $pdo->prepare("UPDATE tasks SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);

        $_SESSION['message'] = 'Task updated successfully!';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Error: ' . $e->getMessage();
    }
}

// Redirect back to index page
header('Location: ../index.php');
exit;
