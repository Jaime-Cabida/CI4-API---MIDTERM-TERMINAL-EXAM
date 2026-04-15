<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Products</h2>

<?php if(session()->getFlashdata('success')): ?>
<div class="alert alert-success">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<a href="<?= base_url('/products/create') ?>" class="btn btn-primary mb-3">Create New Product</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($products)): ?>
            <?php $i = 1 + ($pager->getCurrentPage() - 1) * $pager->getPerPage(); ?>
            <?php foreach($products as $product): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><a href="<?= base_url("/products/show/{$product['id']}") ?>"><?= esc($product['name']) ?></a></td>
                <td><?= esc($product['sku']) ?></td>
                <td><?= esc($product['price']) ?></td>
                <td><?= esc($product['stock']) ?></td>
                <td>
                    <a href="<?= base_url("/products/edit/{$product['id']}") ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= base_url("/products/delete/{$product['id']}") ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="text-center">No products found</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<?php if($pager): ?>
<div class="mt-3">
    <?= $pager->links() ?>
</div>
<?php endif; ?>

<?= $this->endSection() ?>