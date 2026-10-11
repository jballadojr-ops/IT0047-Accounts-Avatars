
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($customer['id']) ? 'Edit Customer' : 'New Customer' ?></title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
    <h1><?= isset($customer['id']) ? 'Edit Customer' : 'New Customer' ?></h1>

    <?php if (! empty($errors)): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post"
          action="<?= isset($customer['id'])
              ? site_url('customers/update/' . $customer['id'])
              : site_url('customers/create') ?>">

        <?= csrf_field() ?>

        <label for="full_name">Full Name:</label>
        <input
            type="text"
            id="full_name"
            name="full_name"
            maxlength="100"
            value="<?= esc(old('full_name', $customer['full_name'] ?? '')) ?>"
            required
        >

        <br><br>

        <label for="email">Email:</label>
        <input
            type="email"
            id="email"
            name="email"
            maxlength="100"
            value="<?= esc(old('email', $customer['email'] ?? '')) ?>"
            required
        >

        <br><br>

        <label for="phone">Phone:</label>
        <input
            type="text"
            id="phone"
            name="phone"
            maxlength="20"
            value="<?= esc(old('phone', $customer['phone'] ?? '')) ?>"
        >

        <br><br>

        <button type="submit">
            <?= isset($customer['id']) ? 'Update Customer' : 'Create Customer' ?>
        </button>

        <a href="<?= site_url('customers') ?>">Cancel</a>
    </form>
</body>
</html>
