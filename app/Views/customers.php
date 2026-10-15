<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customers | Account Hub</title>
    <link rel="stylesheet" href="<?= base_url('style.css') ?>">
</head>
<body>
    <?= view('partials/navigation') ?>
    <main class="page-shell">
        <div class="page-heading">
            <div><p class="eyebrow">Directory</p><h1>Customers</h1></div>
            <a class="button" href="<?= site_url('customers/new') ?>">Add customer</a>
        </div>
        <?php if ($message = session()->getFlashdata('success')): ?>
            <p class="notice notice-success" role="status"><?= esc($message) ?></p>
        <?php endif; ?>
        <section class="content-card">
            <?php if (empty($customers)): ?>
                <p class="empty-state">No customers yet. Add a customer to get started.</p>
            <?php else: ?>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>ID</th><th>Full name</th><th>Email</th><th>Phone</th><th><span class="sr-only">Actions</span></th></tr></thead>
                        <tbody>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td><?= esc($customer['id']) ?></td>
                                <td class="primary-cell"><?= esc($customer['full_name']) ?></td>
                                <td><a href="mailto:<?= esc($customer['email'], 'attr') ?>"><?= esc($customer['email']) ?></a></td>
                                <td><?= esc($customer['phone'] ?? '') ?: '—' ?></td>
                                <td><a class="text-link" href="<?= site_url('customers/edit/' . $customer['id']) ?>">Edit</a></td>
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
