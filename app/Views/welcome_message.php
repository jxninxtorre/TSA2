<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <h1>Welcome! Today's Tasks (<?= esc($today); ?>)</h1>

    <?php if (!empty($tasks)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Task Date</th>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tasks scheduled for today.</p>
    <?php endif; ?>

<?= $this->endSection() ?>