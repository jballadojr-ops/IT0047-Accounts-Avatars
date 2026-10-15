<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Hub</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
    <?= view('partials/navigation') ?>
    <main class="page-shell">
        <section class="hero-card">
            <p class="eyebrow">Account management</p>
            <h1>Account Hub</h1>
            <p>Manage customer records, user profiles, and contact details in one place.</p>
            <div class="action-row">
                <a class="button" href="<?= site_url('customers') ?>">View customers</a>
                <a class="button button-secondary" href="<?= site_url('users') ?>">View users</a>
            </div>
        </section>
    </main>
</body>
</html>
