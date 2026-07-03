<?php

/**
 * Katalog demo WijayCart — 50 produk (5 per kategori), 10 supplier.
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
        // Mug (5)
        ['name' => 'Ceramic Minimalist Mug', 'category' => 'mug', 'price' => 89000, 'featured' => true, 'image' => 'ceramic-minimalist-mug.jpg'],
        ['name' => 'Matte Stoneware Mug', 'category' => 'mug', 'price' => 95000, 'featured' => false, 'image' => 'matte-stoneware-mug.jpg'],
        ['name' => 'Glass Double Wall Mug', 'category' => 'mug', 'price' => 115000, 'featured' => true, 'image' => 'glass-double-wall-mug.jpg'],
        ['name' => 'Handcrafted Clay Mug', 'category' => 'mug', 'price' => 125000, 'featured' => false, 'image' => 'handcrafted-clay-mug.jpg'],
        ['name' => 'Travel Mug with Lid', 'category' => 'mug', 'price' => 145000, 'featured' => true, 'image' => 'travel-mug-with-lid.jpg'],
        // Organizer (5)
        ['name' => 'Bamboo Desk Organizer', 'category' => 'organizer', 'price' => 145000, 'featured' => true, 'image' => 'bamboo-desk-organizer.jpg'],
        ['name' => 'Desk Caddy Multi Slot', 'category' => 'organizer', 'price' => 99000, 'featured' => false, 'image' => 'desk-caddy-multi-slot.jpg'],
        ['name' => 'Drawer Divider Set', 'category' => 'organizer', 'price' => 75000, 'featured' => false, 'image' => 'drawer-divider-set.jpg'],
        ['name' => 'Cable Management Box', 'category' => 'organizer', 'price' => 85000, 'featured' => true, 'image' => 'cable-management-box.jpg'],
        ['name' => 'Wall Hook Organizer', 'category' => 'organizer', 'price' => 65000, 'featured' => false, 'image' => 'wall-hook-organizer.jpg'],
        // Home Living (5)
        ['name' => 'Linen Throw Pillow', 'category' => 'home-living', 'price' => 175000, 'featured' => true, 'image' => 'linen-throw-pillow.jpg'],
        ['name' => 'Glass Storage Jar Set', 'category' => 'home-living', 'price' => 135000, 'featured' => false, 'image' => 'glass-storage-jar-set.jpg'],
        ['name' => 'Cotton Bed Throw Blanket', 'category' => 'home-living', 'price' => 285000, 'featured' => true, 'image' => 'cotton-bed-throw-blanket.jpg'],
        ['name' => 'Woven Storage Basket', 'category' => 'home-living', 'price' => 155000, 'featured' => false, 'image' => 'woven-storage-basket.jpg'],
        ['name' => 'Ceramic Table Lamp', 'category' => 'home-living', 'price' => 325000, 'featured' => true, 'image' => 'ceramic-table-lamp.jpg'],
        // Coffee (5)
        ['name' => 'Pour Over Coffee Set', 'category' => 'coffee', 'price' => 320000, 'featured' => true, 'image' => 'pour-over-coffee-set.jpg'],
        ['name' => 'French Press Coffee Maker', 'category' => 'coffee', 'price' => 245000, 'featured' => false, 'image' => 'french-press-coffee-maker.jpg'],
        ['name' => 'Manual Coffee Grinder', 'category' => 'coffee', 'price' => 195000, 'featured' => true, 'image' => 'manual-coffee-grinder.jpg'],
        ['name' => 'Espresso Cup Set', 'category' => 'coffee', 'price' => 165000, 'featured' => false, 'image' => 'espresso-cup-set.jpg'],
        ['name' => 'Bamboo Coffee Stirrer Set', 'category' => 'coffee', 'price' => 45000, 'featured' => false, 'image' => 'bamboo-coffee-stirrer-set.jpg'],
        // Planner (5)
        ['name' => 'A5 Leather Planner 2026', 'category' => 'planner', 'price' => 125000, 'featured' => true, 'image' => 'a5-leather-planner-2026.jpg'],
        ['name' => 'Weekly Planner Pad', 'category' => 'planner', 'price' => 48000, 'featured' => false, 'image' => 'weekly-planner-pad.jpg'],
        ['name' => 'Daily Desk Planner', 'category' => 'planner', 'price' => 72000, 'featured' => true, 'image' => 'daily-desk-planner.jpg'],
        ['name' => 'Bullet Journal A6', 'category' => 'planner', 'price' => 88000, 'featured' => false, 'image' => 'bullet-journal-a6.jpg'],
        ['name' => 'Monthly Wall Planner', 'category' => 'planner', 'price' => 95000, 'featured' => false, 'image' => 'monthly-wall-planner.jpg'],
        // Tumbler (5)
        ['name' => 'Insulated Steel Tumbler', 'category' => 'tumbler', 'price' => 165000, 'featured' => true, 'image' => 'insulated-steel-tumbler.jpg'],
        ['name' => 'Travel Tumbler 500ml', 'category' => 'tumbler', 'price' => 185000, 'featured' => false, 'image' => 'travel-tumbler-500ml.jpg'],
        ['name' => 'Glass Tumbler with Straw', 'category' => 'tumbler', 'price' => 125000, 'featured' => true, 'image' => 'glass-tumbler-with-straw.jpg'],
        ['name' => 'Bamboo Tumbler Eco', 'category' => 'tumbler', 'price' => 135000, 'featured' => false, 'image' => 'bamboo-tumbler-eco.jpg'],
        ['name' => 'Slim Fit Water Bottle', 'category' => 'tumbler', 'price' => 155000, 'featured' => true, 'image' => 'slim-fit-water-bottle.jpg'],
        // Notebook (5)
        ['name' => 'Dot Grid Notebook', 'category' => 'notebook', 'price' => 65000, 'featured' => true, 'image' => 'dot-grid-notebook.jpg'],
        ['name' => 'Hardcover Journal Cream', 'category' => 'notebook', 'price' => 78000, 'featured' => false, 'image' => 'hardcover-journal-cream.jpg'],
        ['name' => 'Spiral Notebook Kraft', 'category' => 'notebook', 'price' => 55000, 'featured' => false, 'image' => 'spiral-notebook-kraft.jpg'],
        ['name' => 'Leather Bound Notebook', 'category' => 'notebook', 'price' => 145000, 'featured' => true, 'image' => 'leather-bound-notebook.jpg'],
        ['name' => 'Sketchbook A5', 'category' => 'notebook', 'price' => 68000, 'featured' => false, 'image' => 'sketchbook-a5.jpg'],
        // Mini Plant (5)
        ['name' => 'Succulent Mini Pot Set', 'category' => 'mini-plant', 'price' => 95000, 'featured' => true, 'image' => 'succulent-mini-pot-set.jpg'],
        ['name' => 'Monstera Mini Plant', 'category' => 'mini-plant', 'price' => 85000, 'featured' => false, 'image' => 'monstera-mini-plant.jpg'],
        ['name' => 'Cactus Terrarium Kit', 'category' => 'mini-plant', 'price' => 115000, 'featured' => true, 'image' => 'cactus-terrarium-kit.jpg'],
        ['name' => 'Snake Plant Pot', 'category' => 'mini-plant', 'price' => 105000, 'featured' => false, 'image' => 'snake-plant-pot.jpg'],
        ['name' => 'Herb Garden Starter', 'category' => 'mini-plant', 'price' => 125000, 'featured' => true, 'image' => 'herb-garden-starter.jpg'],
        // Stationery (5)
        ['name' => 'Washi Tape Collection', 'category' => 'stationery', 'price' => 45000, 'featured' => false, 'image' => 'washi-tape-collection.jpg'],
        ['name' => 'Gel Pen Set Pastel', 'category' => 'stationery', 'price' => 55000, 'featured' => false, 'image' => 'gel-pen-set-pastel.jpg'],
        ['name' => 'Sticky Notes Pastel Pack', 'category' => 'stationery', 'price' => 38000, 'featured' => true, 'image' => 'sticky-notes-pastel-pack.jpg'],
        ['name' => 'Desk Calendar Minimal', 'category' => 'stationery', 'price' => 62000, 'featured' => false, 'image' => 'desk-calendar-minimal.jpg'],
        ['name' => 'Binder Clip Set Gold', 'category' => 'stationery', 'price' => 42000, 'featured' => false, 'image' => 'binder-clip-set-gold.jpg'],
        // Home Decor (5)
        ['name' => 'Scented Soy Candle', 'category' => 'home-decor', 'price' => 110000, 'featured' => true, 'image' => 'scented-soy-candle.jpg'],
        ['name' => 'Wall Shelf Floating', 'category' => 'home-decor', 'price' => 195000, 'featured' => false, 'image' => 'wall-shelf-floating.jpg'],
        ['name' => 'Handmade Ceramic Vase', 'category' => 'home-decor', 'price' => 225000, 'featured' => true, 'image' => 'handmade-ceramic-vase.jpg'],
        ['name' => 'Macrame Wall Hanging', 'category' => 'home-decor', 'price' => 175000, 'featured' => false, 'image' => 'macrame-wall-hanging.jpg'],
        ['name' => 'Wooden Photo Frame Set', 'category' => 'home-decor', 'price' => 145000, 'featured' => true, 'image' => 'wooden-photo-frame-set.jpg'],
    ],
];
