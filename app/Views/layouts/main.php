<?php
$current = trim(uri_string(), '/');
$isActive = static function (string $path) use ($current): string {
    if ($path === '') {
        return $current === '' ? 'active' : '';
    }
    return str_starts_with($current, $path) ? 'active' : '';
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Tasks for Today') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@700;900&family=Cinzel:wght@500;700&family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --night: #140b0c;
            --wine: #2e0d14;
            --wine-2: #4a1420;
            --crimson: #8c2a35;
            --crimson-dark: #6e1b26;
            --gold: #c9a24b;
            --gold-light: #ecd28b;
            --parchment: #efe3c6;
            --parchment-2: #e3d2a6;
            --ink: #3b2a1e;
            --cream: #f4ead2;
            --pending: #b77b12;
            --progress: #c4571f;
            --done: #3b7d52;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: "Cormorant Garamond", Georgia, serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--cream);
            background:
                radial-gradient(ellipse at 50% 0%, rgba(140, 42, 53, 0.55), transparent 60%),
                radial-gradient(ellipse at 50% 120%, rgba(201, 162, 75, 0.2), transparent 55%),
                linear-gradient(180deg, var(--wine) 0%, var(--night) 100%);
            background-attachment: fixed;
            overflow-x: hidden;
        }

        /* ---------- BACKGROUND ORNAMENTS ---------- */
        /* sunburst rays from the top */
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background: repeating-conic-gradient(from 0deg at 50% -5%, rgba(201, 162, 75, 0.08) 0deg 4deg, transparent 4deg 12deg);
            -webkit-mask-image: linear-gradient(180deg, #000, transparent 75%);
            mask-image: linear-gradient(180deg, #000, transparent 75%);
        }

        /* gold stars */
        .stars {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background-image:
                radial-gradient(1.5px 1.5px at 7% 22%, var(--gold-light), transparent),
                radial-gradient(1px 1px at 16% 64%, var(--gold-light), transparent),
                radial-gradient(1.5px 1.5px at 27% 14%, var(--gold-light), transparent),
                radial-gradient(1px 1px at 38% 78%, var(--gold-light), transparent),
                radial-gradient(1.5px 1.5px at 61% 10%, var(--gold-light), transparent),
                radial-gradient(1px 1px at 72% 58%, var(--gold-light), transparent),
                radial-gradient(1.5px 1.5px at 83% 30%, var(--gold-light), transparent),
                radial-gradient(1px 1px at 93% 74%, var(--gold-light), transparent),
                radial-gradient(1px 1px at 48% 46%, var(--gold-light), transparent);
            animation: twinkle 5s ease-in-out infinite alternate;
        }
        @keyframes twinkle { from { opacity: 0.35; } to { opacity: 0.95; } }

        /* zodiac-style ring */
        .ring {
            position: fixed;
            top: -430px;
            left: 50%;
            width: 780px;
            height: 780px;
            margin-left: -390px;
            border-radius: 50%;
            border: 1px solid rgba(201, 162, 75, 0.35);
            background: repeating-radial-gradient(circle at center, transparent 0 60px, rgba(201, 162, 75, 0.14) 60px 61px);
            pointer-events: none;
            z-index: 0;
        }
        .ring::before {
            content: "";
            position: absolute;
            inset: 46px;
            border-radius: 50%;
            border: 2px dashed rgba(201, 162, 75, 0.4);
            animation: spin 160s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        .container { position: relative; z-index: 1; max-width: 1000px; margin: 0 auto; padding: 24px 20px 80px; }

        /* ---------- NAV ---------- */
        nav {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            padding: 12px 18px;
            margin-bottom: 48px;
            background: rgba(20, 11, 12, 0.82);
            border-top: 3px double var(--gold);
            border-bottom: 3px double var(--gold);
        }
        .brand {
            margin-right: auto;
            padding-right: 20px;
            font-family: "Cinzel Decorative", Georgia, serif;
            font-weight: 900;
            font-size: 19px;
            letter-spacing: 1px;
            color: var(--gold-light);
            text-decoration: none;
        }
        nav a.link {
            padding: 7px 16px;
            font-family: "Cinzel", Georgia, serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #cdbb8f;
            text-decoration: none;
            border: 1px solid transparent;
            transition: color 0.2s ease, border-color 0.2s ease;
        }
        nav a.link:hover { color: var(--gold-light); border-color: rgba(201, 162, 75, 0.5); }
        nav a.link.active { color: #2a1410; background: var(--gold); border-color: var(--gold); }
        nav a.link.auth { margin-left: 8px; color: var(--gold-light); border-color: var(--gold); }
        nav a.link.auth:hover { background: var(--wine-2); }

        /* ---------- TITLES ---------- */
        h1 {
            margin: 0 0 34px;
            font-family: "Cinzel Decorative", Georgia, serif;
            font-size: 38px;
            font-weight: 900;
            line-height: 1.2;
            letter-spacing: 1px;
            text-align: center;
            color: var(--gold-light);
        }
        h1::after {
            content: "— ✦ ◈ ✦ —";
            display: block;
            margin-top: 12px;
            font-family: "Cinzel", serif;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 8px;
            color: var(--gold);
        }
        main > p { max-width: 700px; margin: 12px auto; font-size: 20px; line-height: 1.7; text-align: center; color: var(--cream); }

        /* ---------- TAROT CARD PANELS ---------- */
        .card, main > form {
            position: relative;
            max-width: 460px;
            margin: 10px auto 0;
            padding: 42px 36px 38px;
            color: var(--ink);
            background: radial-gradient(ellipse at center, #f3e8cc, var(--parchment-2));
            border: 2px solid var(--gold);
            box-shadow:
                inset 0 0 0 7px var(--parchment),
                inset 0 0 0 8px var(--gold),
                0 18px 40px rgba(0, 0, 0, 0.6);
        }
        .card::before, main > form::before {
            content: "✦";
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            padding: 0 12px;
            font-size: 22px;
            line-height: 1;
            color: var(--gold);
            background: var(--night);
        }
        .card::after, main > form::after {
            content: "☾";
            position: absolute;
            bottom: -17px;
            left: 50%;
            transform: translateX(-50%);
            padding: 0 12px;
            font-size: 22px;
            line-height: 1;
            color: var(--gold);
            background: var(--night);
        }
        .card p { margin: 10px 0; font-size: 19px; color: var(--ink); }
        .card strong { font-family: "Cinzel", serif; font-size: 14px; letter-spacing: 1px; text-transform: uppercase; color: var(--crimson-dark); }

        /* ---------- TABLE (card spread) ---------- */
        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: separate;
            border-spacing: 0 12px;
            counter-reset: task;
        }
        th {
            padding: 4px 18px 8px;
            text-align: left;
            font-family: "Cinzel", Georgia, serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--gold);
            border-bottom: 1px solid rgba(201, 162, 75, 0.5);
        }
        tbody tr { counter-increment: task; }
        td {
            padding: 16px 18px;
            font-size: 18px;
            color: var(--ink);
            background: radial-gradient(ellipse at center, #f3e8cc, var(--parchment-2));
            border-top: 2px solid var(--gold);
            border-bottom: 2px solid var(--gold);
            transition: background 0.2s ease;
        }
        td:first-child { border-left: 6px solid var(--crimson); }
        td:last-child { border-right: 2px solid var(--gold); }
        tbody tr:hover td { background: #f8efd6; }
        td:nth-child(2)::before {
            content: counter(task, upper-roman) ".  ";
            font-family: "Cinzel", serif;
            font-size: 13px;
            font-weight: 700;
            color: var(--crimson);
        }

        td[class^="status-"] {
            font-family: "Cinzel", Georgia, serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        td[class^="status-"]::before { content: "◆ "; font-size: 10px; }
        .status-pending { color: var(--pending); }
        .status-completed { color: var(--done); }
        .status-in_progress, .status-in-progress { color: var(--progress); }

        /* ---------- FORMS ---------- */
        label {
            display: block;
            margin: 20px 0 6px;
            font-family: "Cinzel", Georgia, serif;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--crimson-dark);
        }
        label:first-of-type { margin-top: 0; }
        input[type=text], input[type=password], input[type=date], select {
            width: 100%;
            padding: 11px 14px;
            font-family: "Cormorant Garamond", Georgia, serif;
            font-size: 19px;
            font-weight: 700;
            color: var(--ink);
            background: #f8efd6;
            border: 1px solid #8a6b2f;
            border-radius: 0;
        }
        input:focus, select:focus {
            outline: none;
            border-color: var(--crimson);
            box-shadow: 0 0 0 2px rgba(201, 162, 75, 0.7);
        }

        /* ---------- BUTTONS ---------- */
        button, .btn {
            display: inline-block;
            padding: 10px 24px;
            font-family: "Cinzel", Georgia, serif;
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold-light);
            text-decoration: none;
            cursor: pointer;
            background: var(--wine-2);
            border: 1px solid var(--gold);
            border-radius: 0;
            outline: 1px solid rgba(201, 162, 75, 0.5);
            outline-offset: 3px;
            transition: background 0.2s ease, color 0.2s ease;
        }
        button:hover, .btn:hover { color: #2a1410; background: var(--gold); }
        .btn-danger { color: var(--cream); background: var(--crimson-dark); }
        .btn-danger:hover { color: #fff; background: #a3303c; }
        .actions { white-space: nowrap; }
        .actions form { display: inline; }
        .actions .btn, .actions button { margin: 0 6px 0 0; padding: 7px 14px; font-size: 11.5px; }
        main > form a { margin-left: 18px; font-family: "Cinzel", serif; font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--ink); text-decoration: none; }
        main > form a:hover { color: var(--crimson); }

        /* ---------- MESSAGES ---------- */
        .msg-success, .msg-error {
            max-width: 100%;
            margin: 0 0 26px;
            padding: 13px 20px;
            font-size: 19px;
            color: var(--ink);
            background: var(--parchment);
            border: 1px solid var(--gold);
            border-left: 7px solid;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }
        .msg-success { border-left-color: var(--done); }
        .msg-success::before { content: "✦  "; color: var(--done); }
        .msg-error { border-left-color: var(--crimson); }
        .msg-error::before { content: "✦  "; color: var(--crimson); }
        .msg-error div { margin-top: 4px; }

        /* ---------- FOOTER ---------- */
        footer {
            margin-top: 64px;
            text-align: center;
            font-family: "Cinzel", Georgia, serif;
            font-size: 12px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(201, 162, 75, 0.75);
        }

        @media (max-width: 700px) {
            .container { padding: 14px 12px 60px; }
            h1 { font-size: 26px; }
            .brand { width: 100%; padding-bottom: 6px; }
            .card, main > form { padding: 38px 22px 34px; }
            table { display: block; overflow-x: auto; }
            .ring { display: none; }
        }

        @media (prefers-reduced-motion: reduce) {
            .stars, .ring::before { animation: none; }
        }
    </style>
</head>
<body>

<div class="stars" aria-hidden="true"></div>
<div class="ring" aria-hidden="true"></div>

<div class="container">

    <nav>
        <a class="brand" href="<?= site_url('/'); ?>">✦ Tasks for Today</a>

        <a class="link <?= $isActive(''); ?>" href="<?= site_url('/'); ?>">Welcome</a>
        <a class="link <?= $isActive('about'); ?>" href="<?= site_url('about'); ?>">About</a>
        <a class="link <?= $isActive('tasks'); ?>" href="<?= site_url('tasks'); ?>">Tasks</a>
        <a class="link <?= $isActive('profile'); ?>" href="<?= site_url('profile'); ?>">Profile</a>

        <?php if (session('user_id')): ?>
            <a class="link auth" href="<?= site_url('logout'); ?>">Logout (<?= esc(session('username')); ?>)</a>
        <?php else: ?>
            <a class="link auth <?= $isActive('login'); ?>" href="<?= site_url('login'); ?>">Login</a>
        <?php endif; ?>
    </nav>

    <?php if (session('success')): ?><p class="msg-success"><?= esc(session('success')); ?></p><?php endif; ?>
    <?php if (session('error')): ?><p class="msg-error"><?= esc(session('error')); ?></p><?php endif; ?>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer>✦ &nbsp; Draw your task &nbsp;·&nbsp; Fulfill your fate &nbsp; ✦</footer>

</div>
</body>
</html>