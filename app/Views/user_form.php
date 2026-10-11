<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= !empty($user) ? 'Edit User' : 'New User' ?></title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
    <h1><?= !empty($user) ? 'Edit User' : 'New User' ?></h1>

    <?php if (!empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php
        $isEdit = !empty($user);
        $formAction = $isEdit
            ? site_url('users/update/' . $user['id'])
            : site_url('users/create');
    ?>

    <form action="<?= $formAction ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <p>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"
                   maxlength="50"
                   value="<?= esc(old('username', $user['username'] ?? '')) ?>"
                   required>
        </p>

        <p>
            <label for="full_name">Full Name:</label><br>
            <input type="text" id="full_name" name="full_name"
                   maxlength="100"
                   value="<?= esc(old('full_name', $user['full_name'] ?? '')) ?>"
                   required>
        </p>

        <?php if ($isEdit): ?>
            <p>Current Avatar:</p>
            <img
                src="<?= base_url(
                    'uploads/avatars/' .
                    (!empty($user['avatar'])
                        ? $user['avatar']
                        : 'avatar-placeholder.png')
                ) ?>"
                alt="User avatar"
                width="100"
                height="100"
                style="object-fit: cover; border-radius: 50%;"
            >
        <?php endif; ?>

        <p>
            <label for="avatar">Profile Picture (JPG or PNG, maximum 2 MB):</label><br>
            <input type="file" id="avatar" name="avatar"
                   accept=".jpg,.jpeg,.png,image/jpeg,image/png">
        </p>

        <button type="submit">
            <?= $isEdit ? 'Update User' : 'Create User' ?>
        </button>

        <a href="<?= site_url('users') ?>">Cancel</a>
    </form>
</body>
</html>
