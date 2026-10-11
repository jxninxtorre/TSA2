<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

    <h1>Login</h1>

    <form method="post" action="<?= site_url('login'); ?>">
        <?= csrf_field() ?>

        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?= esc(old('username')); ?>" autocomplete="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" autocomplete="current-password" required>

        <p>
            <button type="submit">Log in</button>
        </p>
    </form>

<?= $this->endSection() ?>