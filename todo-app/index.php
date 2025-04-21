<?php
require_once 'includes/header.php';
?>

<div class="bg-white shadow rounded-lg p-6">
    <!-- Add Task Form -->
    <form action="tasks/create.php" method="POST" class="mb-8">
        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Task Title</label>
            <input type="text" name="title" id="title" required
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                placeholder="Enter task title">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description (Optional)</label>
            <textarea name="description" id="description"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                rows="3" placeholder="Enter task description"></textarea>
        </div>
        <button type="submit"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            <i class="fas fa-plus mr-2"></i>Add Task
        </button>
    </form>

    <!-- Tasks List -->
    <div class="mt-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Your Tasks</h2>
        <?php
        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
        $tasks = $stmt->fetchAll();

        if (count($tasks) > 0):
        ?>
            <div class="space-y-4">
                <?php foreach ($tasks as $task): ?>
                    <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-between <?php echo $task['status'] === 'completed' ? 'opacity-75' : ''; ?>">
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900 <?php echo $task['status'] === 'completed' ? 'line-through' : ''; ?>">
                                <?php echo htmlspecialchars($task['title']); ?>
                            </h3>
                            <?php if ($task['description']): ?>
                                <p class="text-gray-600 mt-1 <?php echo $task['status'] === 'completed' ? 'line-through' : ''; ?>">
                                    <?php echo htmlspecialchars($task['description']); ?>
                                </p>
                            <?php endif; ?>
                            <p class="text-sm text-gray-500 mt-1">
                                Added <?php echo date('F j, Y, g:i a', strtotime($task['created_at'])); ?>
                            </p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <form action="tasks/update.php" method="POST" class="inline">
                                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                <input type="hidden" name="status" value="<?php echo $task['status'] === 'pending' ? 'completed' : 'pending'; ?>">
                                <button type="submit" class="text-sm px-3 py-1 rounded <?php echo $task['status'] === 'completed' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700'; ?>">
                                    <i class="fas <?php echo $task['status'] === 'completed' ? 'fa-rotate-left' : 'fa-check'; ?> mr-1"></i>
                                    <?php echo $task['status'] === 'completed' ? 'Mark Pending' : 'Complete'; ?>
                                </button>
                            </form>
                            <form action="tasks/delete.php" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                                <button type="submit" class="text-sm bg-red-100 text-red-700 px-3 py-1 rounded">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-8">No tasks yet. Add your first task above!</p>
        <?php endif; ?>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>
