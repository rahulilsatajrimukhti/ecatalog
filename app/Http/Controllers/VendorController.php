<?php

namespace App\Http\Controllers;

use App\DTO\VendorDTO;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Services\VendorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VendorController extends Controller
{
    protected VendorService $service;

    public function __construct(VendorService $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        $data = $this->service->getAll();

        return view('vendors.index', compact('data'));
    }

    public function create(): View
    {
        return view('vendors.create');
    }

    public function store(StoreVendorRequest $request): RedirectResponse
    {
        $dto = new VendorDTO($request->validated());

        $this->service->store($dto);

        return redirect()
            ->route('vendors.index')
            ->with('success', 'Vendor Berhasil Ditambahkan!');
    }

    public function show($id): View
    {
        $data = $this->service->find($id);

        return view('vendors.show', compact('data'));
    }

    public function edit($id): View
    {
        $data = $this->service->find($id);

        return view('vendors.edit', compact('data'));
    }

    public function update(
        UpdateVendorRequest $request,
        $id
    ): RedirectResponse {
        $dto = new VendorDTO($request->validated());

        $this->service->update($id, $dto);

        return redirect()
            ->route('vendors.index')
            ->with('success', 'Vendor Berhasil Diperbarui!');
    }

    public function destroy($id): RedirectResponse
    {
        $this->service->delete($id);

        return redirect()
            ->route('vendors.index')
            ->with('success', 'Vendor Berhasil Dihapus!');
    }
}
