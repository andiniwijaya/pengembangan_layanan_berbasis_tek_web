<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Supplier;
use App\Models\User;
use App\Support\ImageAssets;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'Admin WijayCart',
            'email' => 'admin@wijaycart.com',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Customer Demo',
            'email' => 'customer@wijaycart.com',
            'password' => bcrypt('password'),
        ]);

        User::factory(8)->create();

        $categories = [
            ['name' => 'Home Living', 'slug' => 'home-living', 'description' => 'Produk untuk mempercantik rumah Anda dengan gaya minimalis dan hangat.'],
            ['name' => 'Stationery', 'slug' => 'stationery', 'description' => 'Alat tulis dan perlengkapan kantor estetik untuk produktivitas.'],
            ['name' => 'Coffee', 'slug' => 'coffee', 'description' => 'Perlengkapan kopi premium untuk pengalaman brewing terbaik.'],
            ['name' => 'Organizer', 'slug' => 'organizer', 'description' => 'Solusi penyimpanan rapi untuk ruang kerja dan rumah.'],
            ['name' => 'Home Decor', 'slug' => 'home-decor', 'description' => 'Dekorasi rumah modern dengan nuansa warm minimalist.'],
            ['name' => 'Tumbler', 'slug' => 'tumbler', 'description' => 'Tumbler stylish untuk gaya hidup aktif sehari-hari.'],
            ['name' => 'Mug', 'slug' => 'mug', 'description' => 'Mug keramik premium dengan desain elegan.'],
            ['name' => 'Planner', 'slug' => 'planner', 'description' => 'Planner dan journal untuk merencanakan hari dengan lebih baik.'],
            ['name' => 'Notebook', 'slug' => 'notebook', 'description' => 'Notebook berkualitas untuk menulis ide dan catatan.'],
            ['name' => 'Mini Plant', 'slug' => 'mini-plant', 'description' => 'Tanaman mini dan pot dekoratif untuk ruangan.'],
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                ...$categoryData,
                'is_active' => true,
            ]);
        }

        /** @var array{suppliers: list<array<string, string>>, products: list<array<string, mixed>>} $catalog */
        $catalog = require database_path('seeders/data/catalog.php');

        $suppliers = collect();
        foreach ($catalog['suppliers'] as $record) {
            $suppliers->push(Supplier::create([
                ...$record,
                'address' => 'Jakarta, Indonesia',
                'notes' => 'Supplier premium WijayCart',
                'status' => 'active',
            ]));
        }

        $barcodeCounter = 1;
        foreach ($catalog['products'] as $index => $data) {
            $category = Category::where('slug', $data['category'])->first();

            $product = Product::create([
                'category_id' => $category->id,
                'supplier_id' => $suppliers[$index % $suppliers->count()]->id,
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => "Produk lifestyle premium {$data['name']} dari WijayCart. Dirancang dengan estetika Scandinavian modern minimalis, nuansa butter yellow yang hangat, dan kualitas premium untuk gaya hidup sehari-hari.",
                'price' => $data['price'],
                'stock' => rand(10, 80),
                'barcode' => 'PRD'.str_pad((string) $barcodeCounter, 6, '0', STR_PAD_LEFT),
                'status' => 'active',
                'is_featured' => $data['featured'],
            ]);

            $product->images()->create([
                'image_path' => ImageAssets::productPath($data['image']),
                'is_primary' => true,
                'sort_order' => 0,
            ]);

            $barcodeCounter++;
        }

        User::where('role', 'customer')->each(function (User $user) {
            Cart::create(['user_id' => $user->id]);
        });

        $customer = User::where('email', 'customer@wijaycart.com')->first();
        $products = Product::take(3)->get();

        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'WC-'.date('Ymd').'-0001',
            'status' => 'delivered',
            'subtotal' => $products->sum('price'),
            'shipping_cost' => 15000,
            'total' => $products->sum('price') + 15000,
            'shipping_name' => $customer->name,
            'shipping_phone' => $customer->phone ?? '081234567890',
            'shipping_address' => $customer->address ?? 'Jl. Contoh No. 123, Jakarta',
        ]);

        foreach ($products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_barcode' => $product->barcode,
                'price' => $product->price,
                'quantity' => 1,
                'subtotal' => $product->price,
            ]);
        }

        Payment::create([
            'order_id' => $order->id,
            'method' => 'bank_transfer',
            'status' => 'paid',
            'amount' => $order->total,
            'paid_at' => now()->subDays(2),
        ]);

        Setting::set('store_name', 'WijayCart');
        Setting::set('store_email', 'hello@wijaycart.com');
        Setting::set('store_phone', '+62 812-3456-7890');
        Setting::set('store_address', 'Jl. Lifestyle No. 88, Jakarta Selatan');
        Setting::set('shipping_cost', '15000');
        Setting::set('store_description', 'WijayCart — destinasi lifestyle modern dengan nuansa warm minimalist.');

        $this->call(DemoDataSeeder::class);
    }
}
