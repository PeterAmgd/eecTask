<?php
namespace App\Repositories;


use App\Models\Pharmacy;
class PharmacyRepository
{
    public function all()
    {
        return Pharmacy::all();
    }

    public function find($pharmacy)
    {
        return $pharmacy;
    }
    public function searchByName($name)
    {
        return Pharmacy::where('name', 'LIKE', "%{$name}%");
    }
    public function createPharmacy(array $data)
    {
        return Pharmacy::create($data);
    }

    public function updatePharmacy(array $data , $pharmacy)
    {
        $pharmacy->update($data);
        return $pharmacy;
    }

    public function deletePharmacy($pharmacy)
    {
        $pharmacy->delete();
        return $pharmacy;
    }

    public function attachProduct($pharmacy,array $product)
    {
        $pharmacy->products()->attach($product);
    }
}

?>
