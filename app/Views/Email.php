<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email | Account Hub</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
    <?= view('partials/navigation') ?>
    <main class="page-shell">
        <section class="content-card">
            <p class="eyebrow">Contact directory</p>
            <h1>Email addresses</h1>
            <p class="muted">Select an address to start a message.</p>
            <?php if (empty($emails)): ?>
                <p class="empty-state">No email addresses are available.</p>
            <?php else: ?>
                <ul class="email-list">
                    <?php foreach ($emails as $email): ?>
                        <li><a href="mailto:<?= esc($email, 'attr') ?>"><?= esc($email) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
