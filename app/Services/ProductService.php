<?php
namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function all()
    {
        $this->productRepository->all();
    }

    public function find($product)
    {
        return $product;
    }

    public function searchProducts($searchTerm, $perPage = 10)
    {
        return $this->productRepository->searchByName($searchTerm)->latest()->paginate($perPage);
    }

    public function createProduct(array $data, $image)
    {
        return $this->productRepository->createProduct($data , $image);
    }

    public function updateProduct(array $data , $product,$image)
    {
        return $this->productRepository->updateProduct( $data , $product,$image);
    }

    public function deleteProduct($product)
    {
        return $this->productRepository->deleteProduct($product);
    }

    public function attachProduct( $product,array  $pharmaciesWithPrices)
    {
        return $this->productRepository->attachProduct($product, $pharmaciesWithPrices);
    }
}
?>
