<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users | Account Hub</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
    <?= view('partials/navigation') ?>
    <main class="page-shell">
        <div class="page-heading">
            <div><p class="eyebrow">Directory</p><h1>Users</h1></div>
            <a class="button" href="<?= site_url('users/new') ?>">Add user</a>
        </div>
        <?php if ($message = session()->getFlashdata('success')): ?>
            <p class="notice notice-success" role="status"><?= esc($message) ?></p>
        <?php endif; ?>
        <section class="content-card">
            <?php if (empty($users)): ?>
                <p class="empty-state">No user accounts yet. Add a user to get started.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Avatar</th><th>ID</th><th>Username</th><th>Full name</th><th><span class="sr-only">Actions</span></th></tr></thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <?php $avatar = ! empty($user['avatar']) ? $user['avatar'] : 'avatar-placeholder.png'; ?>
                            <tr>
                                <td><img class="avatar" src="<?= base_url('uploads/avatars/' . rawurlencode($avatar)) ?>" alt="Avatar for <?= esc($user['full_name']) ?>"></td>
                                <td><?= esc($user['id']) ?></td>
                                <td><?= esc($user['username']) ?></td>
                                <td class="primary-cell"><?= esc($user['full_name']) ?></td>
                                <td><a class="text-link" href="<?= site_url('users/edit/' . $user['id']) ?>">Edit</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>
