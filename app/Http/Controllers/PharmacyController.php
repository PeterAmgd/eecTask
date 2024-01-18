<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use App\Services\PharmacyService;
use App\Http\Resources\PharmacyResource;
use App\Http\Requests\StorePharmacyRequest;
use App\Http\Requests\UpdatePharmacyRequest;


class PharmacyController extends Controller
{

    protected $pharmacyService;

    public function __construct(PharmacyService $pharmacyService)
    {
        $this->pharmacyService = $pharmacyService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $searchTerm = $request->search;
        $pharmacies = $this->pharmacyService->searchPharmacies($searchTerm);

        if ($request->wantsJson()) {
            return PharmacyResource::collection($pharmacies);
        }

        return view('pharmacies.index')->with('pharmacies', $pharmacies);

    }
    public function getPharmacies(Request $request,Product $product)
{
    $searchTerm = $request->search;
    $pharmacies = $this->pharmacyService->searchPharmacies($searchTerm);
    if ($request->wantsJson()) {
        return PharmacyResource::collection($pharmacies);
    }

    return view('pharmacies.partials.pharmacies-list',compact('pharmacies', 'product'));

}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('pharmacies.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePharmacyRequest $request)
    {
        //
        $data = $request->all();
        $pharmacy = $this->pharmacyService->createPharmacy($data);

        if (!$pharmacy) {
            return redirect()->back()->with('error', __('product.error_creating'));
        }
        return redirect()->route('pharmacies.index')->with('success', __('product.success_creating'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Pharmacy $pharmacy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pharmacy $pharmacy)
    {
        //
        return view('pharmacies.edit')->with('pharmacy', $pharmacy);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePharmacyRequest $request, Pharmacy $pharmacy)
    {
        //
        $data = $request->validated();
        $pharmacy = $this->pharmacyService->updatePharmacy($data, $pharmacy);

        if (!$pharmacy) {
            return redirect()->back()->with('error', __('product.error_updating'));
        }
        return redirect()->route('pharmacies.index')->with('success', __('product.success_updating'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pharmacy $pharmacy)
    {
        //
        $pharmacy = $this->pharmacyService->deletePharmacy($pharmacy);

        return response()->json([
            'success' => true
        ]);
    }
}
