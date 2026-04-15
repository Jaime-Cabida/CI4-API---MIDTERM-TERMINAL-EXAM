<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<h2>Product Details</h2>

<table class="table table-striped">
    <tr><th>Name</th><td><?= esc($product['name']) ?></td></tr>
    <tr><th>SKU</th><td><?= esc($product['sku']) ?></td></tr>
    <tr><th>Price</th><td><?= esc($product['price']) ?></td></tr>
    <tr><th>Stock</th><td><?= esc($product['stock']) ?></td></tr>
    <tr><th>Created At</th><td><?= esc($product['created_at']) ?></td></tr>
    <tr><th>Updated At</th><td><?= esc($product['updated_at']) ?></td></tr>
</table>

<a href="<?= base_url('/products') ?>" class="btn btn-secondary">Back to Products</a>

<?= $this->endSection() ?>