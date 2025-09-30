<!doctype html>
<html>
<head><meta charset="utf-8"><title><?= isset($post) ? 'Editar' : 'Nuevo' ?> Post</title></head>
<body>
    <h2><?= isset($post) ? 'Editar' : 'Crear' ?> Post</h2>
    <?php if(session('errors')): $errs = session('errors'); ?>
        <div style="color:red">
            <?php foreach($errs as $e): ?><div><?= $e ?></div><?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= isset($post) ? site_url('admin/posts/update/'.$post['id']) : site_url('admin/posts/store') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div>
            <label>Título *</label><br>
            <input type="text" name="title" required value="<?= old('title', $post['title'] ?? '') ?>">
        </div>

        <div>
            <label>Fecha de creación *</label><br>
            <input type="datetime-local" name="created_at" required value="<?= old('created_at', isset($post['created_at']) ? date('Y-m-d\TH:i', strtotime($post['created_at'])) : '') ?>">
        </div>

        <div>
            <label>Categoría *</label><br>
            <select name="category_id" required>
                <option value="">-- Selecciona --</option>
                <?php foreach($categories as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= (old('category_id', $post['category_id'] ?? '') == $c['id']) ? 'selected' : '' ?>><?= esc($c['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label>Resumen *</label><br>
            <textarea name="summary" required><?= old('summary', $post['summary'] ?? '') ?></textarea>
        </div>

        <div>
            <label>Contenido</label><br>
            <textarea name="content"><?= old('content', $post['content'] ?? '') ?></textarea>
        </div>

        <div>
            <label>Imagen <?= isset($post) ? '(opcional para reemplazar)' : '*' ?></label><br>
            <?php if(isset($post['image']) && $post['image']): ?>
                <div><img src="<?= $post['image'] ?>" alt="" width="140"></div>
            <?php endif; ?>
            <input type="file" name="image" <?= isset($post) ? '' : 'required' ?> accept="image/png,image/jpeg,image/webp">
        </div>

        <div><button type="submit">Guardar</button> | <a href="<?= site_url('admin/posts') ?>">Cancelar</a></div>
    </form>
</body>
</html>
