
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Accounts</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
    <h1>User Accounts</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <p style="color: green;">
            <?= esc(session()->getFlashdata('success')) ?>
        </p>
    <?php endif; ?>

    <p>
        <a href="<?= site_url('users/new') ?>">+ Add New User</a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <?php
                        $avatar = !empty($user['avatar'])
                            ? $user['avatar']
                            : 'Face1.jpeg';
                    ?>
                    <tr>
                        <td>
                            <img
                                src="<?= base_url('uploads/avatars/' . rawurlencode($avatar)) ?>"
                                alt="Avatar for <?= esc($user['full_name']) ?>"
                                width="55"
                                height="55"
                                style="object-fit: cover; border-radius: 50%;"
                            >
                        </td>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['username']) ?></td>
                        <td><?= esc($user['full_name']) ?></td>
                        <td>
                            <a href="<?= site_url('users/edit/' . $user['id']) ?>">
                                Edit
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No user accounts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
