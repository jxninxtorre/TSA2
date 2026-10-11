<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <?php $editing = !empty($task); ?>
    <h1><?= $editing ? 'Edit Task' : 'New Task'; ?></h1>

    <?php if (session('errors')): ?>
        <div class="msg-error">
            <?php foreach (session('errors') as $err): ?>
                <div><?= esc($err); ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= $editing ? site_url('tasks/' . $task['id'] . '/update') : site_url('tasks/create'); ?>">
        <?= csrf_field() ?>

        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?= esc(old('title', $task['title'] ?? '')); ?>">

        <label for="task_date">Task Date</label>
        <input type="date" id="task_date" name="task_date" value="<?= esc(old('task_date', $task['task_date'] ?? '')); ?>">

        <?php $st = old('status', $task['status'] ?? 'pending'); ?>
        <label for="status">Status</label>
        <select id="status" name="status">
            <option value="pending" <?= $st === 'pending' ? 'selected' : ''; ?>>Pending</option>
            <option value="in_progress" <?= $st === 'in_progress' ? 'selected' : ''; ?>>In Progress</option>
            <option value="completed" <?= $st === 'completed' ? 'selected' : ''; ?>>Completed</option>
        </select>

        <p>
            <button type="submit"><?= $editing ? 'Update' : 'Save'; ?></button>
            <a href="<?= site_url('tasks'); ?>">Cancel</a>
        </p>
    </form>

<?= $this->endSection() ?>