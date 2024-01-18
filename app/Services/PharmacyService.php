<?php
namespace App\Services;

use App\Repositories\PharmacyRepository;

class PharmacyService
{
    protected $pharmacyRepository;

    public function __construct(PharmacyRepository $pharmacyRepository)
    {
        $this->pharmacyRepository = $pharmacyRepository;
    }

    public function all()
    {
        $this->pharmacyRepository->all();
    }

    public function find($pharmacy)
    {
        return $pharmacy;
    }

    public function searchPharmacies($searchTerm, $perPage = 10)
    {
        return $this->pharmacyRepository->searchByName($searchTerm)->latest()->paginate($perPage);
    }

    public function createPharmacy(array $data)
    {
        return $this->pharmacyRepository->createPharmacy($data );
    }

    public function updatePharmacy(array $data , $pharmacy)
    {
        return $this->pharmacyRepository->updatePharmacy( $data,$pharmacy);
    }

    public function deletePharmacy($pharmacy)
    {
        return $this->pharmacyRepository->deletePharmacy($pharmacy);
    }

    public function attachProduct($pharmacy, array $product)
    {
        return $this->pharmacyRepository->attachProduct($pharmacy, $product);
    }
}
?>
