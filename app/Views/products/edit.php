<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Edit Product</h2>

<?php if(isset($validation)): ?>
<div class="alert alert-danger">
    <?= $validation->listErrors() ?>
</div>
<?php endif; ?>

<form action="<?= base_url("/products/update/{$product['id']}") ?>" method="POST">
    <?= csrf_field() ?>
    <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" value="<?= old('name', $product['name']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>SKU</label>
        <input type="text" name="sku" value="<?= old('sku', $product['sku']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?= old('price', $product['price']) ?>" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" value="<?= old('stock', $product['stock']) ?>" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Update Product</button>
    <a href="<?= base_url('/products') ?>" class="btn btn-secondary">Cancel</a>
</form>

<?= $this->endSection() ?>