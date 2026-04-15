<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;



class ProductController extends BaseController
{
    
    protected $productModel;

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Call parent to init session, user, menu
        parent::initController($request, $response, $logger);

        // Load product model
        $this->productModel = new ProductModel();
    }

    

    // List all products
    public function index()
    {
        $data = $this->data; // from BaseController
        $data['products'] = $this->productModel->orderBy('created_at', 'DESC')->paginate(10);
        $data['pager']    = $this->productModel->pager;

        return view('products/index', $data);
    }

    // Show create form
    public function create()
    {
        $data = $this->data;
        return view('products/create', $data);
    }

    // Store new product
    public function store()
    {
        $data = $this->data;

        $validation = $this->validate([
            'name'  => 'required|min_length[3]|max_length[255]',
            'sku'   => 'required|is_unique[products.sku]',
            'price' => 'required|decimal',
            'stock' => 'required|integer'
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->save([
            'name'  => $this->request->getPost('name'),
            'sku'   => $this->request->getPost('sku'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock')
        ]);

        session()->setFlashdata('success', 'Product created successfully!');
        return redirect()->to('/products');
    }

    // Show edit form
    public function edit($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product not found");
        }

        $data = $this->data;
        $data['product'] = $product;

        return view('products/edit', $data);
    }

    // Update product
    public function update($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product not found");
        }

        $rules = [
            'name'  => 'required|min_length[3]',
            'sku'   => 'required',
            'price' => 'required|decimal',
            'stock' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            $data = $this->data;
            $data['product'] = $product;
            $data['validation'] = $this->validator;

            return view('products/edit', $data);
        }

        $this->productModel->update($id, [
            'name'  => $this->request->getPost('name'),
            'sku'   => $this->request->getPost('sku'),
            'price' => $this->request->getPost('price'),
            'stock' => $this->request->getPost('stock'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        session()->setFlashdata('success', 'Product updated successfully!');
        return redirect()->to('/products');
    }

    // Delete product
    public function delete($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            session()->setFlashdata('error', 'Product not found.');
            return redirect()->to('/products');
        }

        $this->productModel->delete($id);
        session()->setFlashdata('success', 'Product deleted successfully.');
        return redirect()->to('/products');
    }

    // Optional: show product details
    public function show($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Product not found");
        }

        $data = $this->data;
        $data['product'] = $product;

        return view('products/show', $data);
    }
}