<?php

/**
 * Katalog demo WijayCart — 15 produk (5 per kategori), 10 supplier.
 * Gambar: public/images/products/*.webp
 *
 * @return array{suppliers: list<array<string, string>>, products: list<array<string, mixed>>}
 */
return [
    'suppliers' => [
        ['code' => 'SUP0001', 'name' => 'IKEA Living', 'contact_person' => 'Erik Johansson', 'phone' => '021-5551001', 'email' => 'contact@ikealiving.id'],
        ['code' => 'SUP0002', 'name' => 'Nordic Home', 'contact_person' => 'Anna Lindstrom', 'phone' => '021-5551002', 'email' => 'hello@nordichome.id'],
        ['code' => 'SUP0003', 'name' => 'Daily Coffee Supply', 'contact_person' => 'Marco Espresso', 'phone' => '021-5551003', 'email' => 'orders@dailycoffee.id'],
        ['code' => 'SUP0004', 'name' => 'Urban Stationery', 'contact_person' => 'Dewi Kartika', 'phone' => '021-5551004', 'email' => 'sales@urbanstationery.id'],
        ['code' => 'SUP0005', 'name' => 'Minimal House', 'contact_person' => 'Budi Santoso', 'phone' => '021-5551005', 'email' => 'info@minimalhouse.id'],
        ['code' => 'SUP0006', 'name' => 'Cozy Decor', 'contact_person' => 'Siti Rahayu', 'phone' => '021-5551006', 'email' => 'hello@cozydecor.id'],
        ['code' => 'SUP0007', 'name' => 'Morning Brew', 'contact_person' => 'Andi Pratama', 'phone' => '021-5551007', 'email' => 'team@morningbrew.id'],
        ['code' => 'SUP0008', 'name' => 'Pure Ceramic', 'contact_person' => 'Rina Wijaya', 'phone' => '021-5551008', 'email' => 'studio@pureceramic.id'],
        ['code' => 'SUP0009', 'name' => 'Plant Corner', 'contact_person' => 'Rizky Hidayat', 'phone' => '021-5551009', 'email' => 'grow@plantcorner.id'],
        ['code' => 'SUP0010', 'name' => 'Desk Essentials', 'contact_person' => 'Felix Tan', 'phone' => '021-5551010', 'email' => 'support@deskessentials.id'],
    ],
    'products' => [
        // Mug — mug keramik & drinkware
        ['name' => 'Floral Ceramic Mug', 'category' => 'mug', 'price' => 89000, 'featured' => true, 'image' => 'ceramic-minimalist-mug.webp'],
        ['name' => 'Matte Stoneware Mug Set', 'category' => 'mug', 'price' => 95000, 'featured' => false, 'image' => 'matte-stoneware-mug.webp'],
        ['name' => 'Glass Double Wall Coffee Mug', 'category' => 'mug', 'price' => 115000, 'featured' => true, 'image' => 'glass-double-wall-mug.webp'],
        ['name' => 'Sunflower Clay Mug', 'category' => 'mug', 'price' => 125000, 'featured' => false, 'image' => 'handcrafted-clay-mug.webp'],
        ['name' => 'Insulated Travel Mug Set', 'category' => 'mug', 'price' => 145000, 'featured' => true, 'image' => 'travel-mug-with-lid.webp'],
        // Home Living — tekstil, penyimpanan, pencahayaan
        ['name' => 'Bohemian Throw Pillow Set', 'category' => 'home-living', 'price' => 175000, 'featured' => true, 'image' => 'linen-throw-pillow.webp'],
        ['name' => 'Bamboo Kitchen Storage Rack', 'category' => 'home-living', 'price' => 135000, 'featured' => false, 'image' => 'glass-storage-jar-set.webp'],
        ['name' => 'Chunky Knit Throw Blanket', 'category' => 'home-living', 'price' => 285000, 'featured' => true, 'image' => 'cotton-bed-throw-blanket.webp'],
        ['name' => 'Woven Storage Basket Set', 'category' => 'home-living', 'price' => 155000, 'featured' => false, 'image' => 'woven-storage-basket.webp'],
        ['name' => 'Ceramic Table Lamp Set', 'category' => 'home-living', 'price' => 325000, 'featured' => true, 'image' => 'ceramic-table-lamp.webp'],
        // Home Decor — dekorasi & aksen rumah
        ['name' => 'Scented Soy Candle', 'category' => 'home-decor', 'price' => 110000, 'featured' => true, 'image' => 'scented-soy-candle.webp'],
        ['name' => 'Circular Wooden Wall Shelf', 'category' => 'home-decor', 'price' => 195000, 'featured' => false, 'image' => 'wall-shelf-floating.webp'],
        ['name' => 'Handmade Ceramic Vase Set', 'category' => 'home-decor', 'price' => 225000, 'featured' => true, 'image' => 'handmade-ceramic-vase.webp'],
        ['name' => 'Macrame Leaf Wall Hanging', 'category' => 'home-decor', 'price' => 175000, 'featured' => false, 'image' => 'macrame-wall-hanging.webp'],
        ['name' => 'Wooden Photo Frame Set', 'category' => 'home-decor', 'price' => 145000, 'featured' => true, 'image' => 'wooden-photo-frame-set.webp'],
    ],
];
