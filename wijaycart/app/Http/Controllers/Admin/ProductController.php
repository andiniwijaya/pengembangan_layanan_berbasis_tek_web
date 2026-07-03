<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Supplier;
use App\Services\BarcodeService;
use App\Support\ImageAssets;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;

class ProductController extends Controller
{
    public function __construct(private BarcodeService $barcodeService) {}

    public function index(Request $request): View
    {
        $query = Product::with(['category', 'supplier']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::where('is_active', true)->get();
        $suppliers = Supplier::where('status', 'active')->orderBy('name')->get();
        $barcode = $this->barcodeService->generateUnique();

        return view('admin.products.create', compact('categories', 'suppliers', 'barcode'));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['barcode'] = $data['barcode'] ?? $this->barcodeService->generateUnique();
        $data['is_featured'] = $request->boolean('is_featured');

        $product = Product::create($data);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'images', 'supplier']);
        $barcodeSvg = DNS1D::getBarcodeSVG($product->barcode, 'C128', 2, 60);

        return view('admin.products.show', compact('product', 'barcodeSvg'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::where('is_active', true)->get();
        $suppliers = Supplier::where('status', 'active')->orderBy('name')->get();
        $product->load('images');

        return view('admin.products.edit', compact('product', 'categories', 'suppliers'));
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $data['is_featured'] = $request->boolean('is_featured');

        $product->update($data);

        if ($request->hasFile('images')) {
            $maxSort = $product->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $product->images()->count() === 0 && $index === 0,
                    'sort_order' => $maxSort + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            if (ImageAssets::isStoragePath($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function destroyImage(ProductImage $productImage): RedirectResponse
    {
        if (! str_starts_with($productImage->image_path, 'http')) {
            Storage::disk('public')->delete($productImage->image_path);
        }

        $productImage->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
