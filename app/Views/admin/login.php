<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Login</title></head>
<body>
    <h2>Login - Admin</h2>
    <?php if(session('error')): ?>
        <p style="color:red"><?= session('error') ?></p>
    <?php endif; ?>
    <form method="post" action="<?= site_url('admin/login') ?>">
        <?= csrf_field() ?>
        <div><input type="email" name="email" placeholder="Email" required value="<?= old('email') ?>"></div>
        <div><input type="password" name="password" placeholder="Password" required></div>
        <div><button type="submit">Entrar</button></div>
    </form>
</body>
</html>
