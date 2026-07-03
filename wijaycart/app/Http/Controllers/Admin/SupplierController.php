<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SupplierRequest;
use App\Models\Supplier;
use App\Services\SupplierCodeService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct(private SupplierCodeService $supplierCodeService) {}

    public function index(Request $request): View
    {
        $query = Supplier::withCount('products');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('contact_person', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        $code = $this->supplierCodeService->generateUnique();

        return view('admin.suppliers.create', compact('code'));
    }

    public function store(SupplierRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['code'] = $data['code'] ?? $this->supplierCodeService->generateUnique();

        Supplier::create($data);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function show(Supplier $supplier): View
    {
        $supplier->load(['products' => fn ($q) => $q->with('category')->latest()->take(10)]);

        return view('admin.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier): View
    {
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(SupplierRequest $request, Supplier $supplier): RedirectResponse
    {
        $supplier->update($request->validated());

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        if ($supplier->products()->exists()) {
            return back()->with('error', 'Supplier masih memiliki produk terkait.');
        }

        $supplier->delete();

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier berhasil dihapus.');
    }
}
