<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function all()
    {
        return Product::all();
    }

    public function find($product)
    {
        return $product;
    }
    public function searchByName($title)
    {
        return Product::where('title', 'LIKE', "%{$title}%");
    }
    public function createProduct(array $data, $image)
    {
        $data['image'] = $image;
        return Product::create($data);
    }

    public function updateProduct(array $data, $product, $image)
    {
        $data['image'] = $image;
        $product->update($data);
        return $product;
    }

    public function deleteProduct($product)
    {
        $product->delete();
        return $product;
    }

    public function attachProduct($product, array $pharmaciesWithPrices)
    {
        foreach ($pharmaciesWithPrices as $data) {
            $pharmacyId = $data['id'];
            $price = $data['price'];

            $product->pharmacies()->attach($pharmacyId, ['price' => $price]);
        }
    }
}
