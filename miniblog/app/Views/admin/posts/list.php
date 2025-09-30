<!doctype html>
<html>
<head><meta charset="utf-8"><title>Posts</title></head>
<body>
    <h2>Posts</h2>
    <?php if(session()->getFlashdata('success')): ?>
        <p style="color:green"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <a href="<?= site_url('admin/posts/create') ?>">+ Nuevo post</a> | <a href="<?= site_url('admin/logout') ?>">Cerrar sesión</a>
    <table border="1" cellpadding="6" style="margin-top:10px;">
        <thead><tr><th>ID</th><th>Título</th><th>Categoría</th><th>Autor</th><th>Fecha</th><th>Acciones</th></tr></thead>
        <tbody>
        <?php if(empty($posts)): ?>
            <tr><td colspan="6">No hay posts</td></tr>
        <?php endif; ?>
        <?php foreach($posts as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= esc($p['title']) ?></td>
                <td><?= esc($p['category_id']) ?></td>
                <td><?= esc($p['author']) ?></td>
                <td><?= esc($p['created_at']) ?></td>
                <td>
                    <a href="<?= site_url('admin/posts/edit/'.$p['id']) ?>">Editar</a> |
                    <a href="<?= site_url('admin/posts/delete/'.$p['id']) ?>" onclick="return confirm('Borrar?')">Borrar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
