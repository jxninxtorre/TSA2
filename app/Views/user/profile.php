<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <h1>User Profile</h1>

    <?php if (!empty($user)): ?>
        <div class="card">
            <p><strong>ID:</strong> <?= esc($user['id']); ?></p>
            <p><strong>Username:</strong> <?= esc($user['username']); ?></p>
            <p><strong>Full Name:</strong> <?= esc($user['full_name']); ?></p>
            <p><strong>Email:</strong> <?= esc($user['email']); ?></p>
            <p><strong>Created At:</strong> <?= esc($user['created_at']); ?></p>
        </div>
    <?php else: ?>
        <p>No user profile found.</p>
    <?php endif; ?>

<?= $this->endSection() ?>