<?php

namespace App\Controllers;

class ProductController extends BaseController
{
    private $session;
    protected $productModel;
    protected $productOptionModel;
    public function __construct()
    {
        $this->session = session();
        $this->productModel = model("ProductModel");
        $this->productOptionModel =  model("ProductOptionModel");
    }
    public function list()
    {
        $products = $this->productModel->findAll();

        foreach ($products as &$product) {
            $productOptions = $this->productOptionModel->where('product_id', $product['product_id'])->findAll();
            $product['options'] = $productOptions;
        }

        return $this->response->setJSON($products);
    }
    public function getOneById($id = null)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return $this->response->setJSON(['message' => 'Không tìm thấy sản phẩm'])->setStatusCode(404);
        }

        $productOptions = $this->productOptionModel->where('product_id', $id)->findAll();
        $product['options'] = $productOptions;

        return $this->response->setJSON($product);
    }
}
