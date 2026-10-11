<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <h1>All Tasks (Ordered by Date)</h1>

    <?php if (session('user_id')): ?>
        <p><a class="btn" href="<?= site_url('tasks/new'); ?>">+ New Task</a></p>
    <?php endif; ?>

    <?php if (!empty($tasks)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Task Date</th>
                    <th>Created At</th>
                    <?php if (session('user_id')): ?><th>Actions</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= esc($task['id']); ?></td>
                        <td><?= esc($task['title']); ?></td>
                        <td class="status-<?= strtolower(esc($task['status'])); ?>">
                            <?= esc(ucwords(str_replace('_', ' ', $task['status']))); ?>
                        </td>
                        <td><?= esc($task['task_date']); ?></td>
                        <td><?= esc($task['created_at']); ?></td>
                        <?php if (session('user_id')): ?>
                            <td class="actions">
                                <a class="btn" href="<?= site_url('tasks/' . $task['id'] . '/edit'); ?>">Edit</a>
                                <form method="post" action="<?= site_url('tasks/' . $task['id'] . '/delete'); ?>"
                                      onsubmit="return confirm('Archive this task?');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn-danger">Delete</button>
                                </form>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>

<?= $this->endSection() ?>