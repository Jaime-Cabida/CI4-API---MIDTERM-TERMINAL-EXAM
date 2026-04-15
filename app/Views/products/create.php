<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Create Product</h2>

<?php if(session()->getFlashdata('errors')): ?>
<div class="alert alert-danger">
    <ul>
    <?php foreach(session()->getFlashdata('errors') as $error): ?>
        <li><?= esc($error) ?></li>
    <?php endforeach ?>
    </ul>
</div>
<?php endif; ?>

<form action="<?= base_url('/products/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="<?= old('name') ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>SKU</label>
        <input type="text" name="sku" value="<?= old('sku') ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?= old('price') ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" value="<?= old('stock') ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Create Product</button>
    <a href="<?= base_url('/products') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>