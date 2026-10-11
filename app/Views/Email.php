<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Users</title></head>
<link rel="stylesheet" href="<?= base_url('style.css') ?>">
<body>
<h1>Email Addresses</h1>
<ul>
    <?php foreach ($emails as $email): ?>
        <li><?= esc($email) ?></li>
    <?php endforeach; ?>
</ul>
</body>
</html>