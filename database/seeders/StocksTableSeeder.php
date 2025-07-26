<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StocksTableSeeder extends Seeder
{
    public function run()
    {
        // Clear the table first
        DB::table('stocks')->truncate();

        $stocks = [
            ['item_name' => 'Ballpen', 'variant_type' => 'color', 'variant_value' => 'red', 'stock_quantity' => 100, 'reorderpoint' => 50],
            ['item_name' => 'Ballpen', 'variant_type' => 'color', 'variant_value' => 'blue', 'stock_quantity' => 150, 'reorderpoint' => 60],
            ['item_name' => 'Ballpen', 'variant_type' => 'color', 'variant_value' => 'black', 'stock_quantity' => 200, 'reorderpoint' => 70],

            ['item_name' => 'Binder Clip', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 50, 'reorderpoint' => 25],

            ['item_name' => 'Bondpaper', 'variant_type' => 'size', 'variant_value' => 'short', 'stock_quantity' => 500, 'reorderpoint' => 100],
            ['item_name' => 'Bondpaper', 'variant_type' => 'size', 'variant_value' => 'long', 'stock_quantity' => 300, 'reorderpoint' => 100],

            ['item_name' => 'Box Files', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 30, 'reorderpoint' => 20],

            ['item_name' => 'Brown Envelope', 'variant_type' => 'size', 'variant_value' => 'long', 'stock_quantity' => 80, 'reorderpoint' => 40],
            ['item_name' => 'Brown Envelope', 'variant_type' => 'size', 'variant_value' => 'short', 'stock_quantity' => 120, 'reorderpoint' => 50],

            ['item_name' => 'Construction Paper', 'variant_type' => 'color', 'variant_value' => 'yellow', 'stock_quantity' => 200, 'reorderpoint' => 60],
            ['item_name' => 'Construction Paper', 'variant_type' => 'color', 'variant_value' => 'green', 'stock_quantity' => 200, 'reorderpoint' => 60],
            ['item_name' => 'Construction Paper', 'variant_type' => 'color', 'variant_value' => 'blue', 'stock_quantity' => 200, 'reorderpoint' => 60],

            ['item_name' => 'Correction Tape', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 40, 'reorderpoint' => 20],

            ['item_name' => 'Expanded Envelope', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 25, 'reorderpoint' => 15],
            ['item_name' => 'Expanded Envelope', 'variant_type' => 'color', 'variant_value' => 'green', 'stock_quantity' => 30, 'reorderpoint' => 15],
            ['item_name' => 'Expanded Envelope', 'variant_type' => 'color', 'variant_value' => 'blue', 'stock_quantity' => 30, 'reorderpoint' => 15],
            ['item_name' => 'Expanded Envelope', 'variant_type' => 'color', 'variant_value' => 'yellow', 'stock_quantity' => 30, 'reorderpoint' => 15],

            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'blue', 'stock_quantity' => 60, 'reorderpoint' => 30],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'yellow', 'stock_quantity' => 60, 'reorderpoint' => 30],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'red', 'stock_quantity' => 60, 'reorderpoint' => 30],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'white', 'stock_quantity' => 60, 'reorderpoint' => 30],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'green', 'stock_quantity' => 60, 'reorderpoint' => 30],

            ['item_name' => 'Folder', 'variant_type' => 'size', 'variant_value' => 'long', 'stock_quantity' => 75, 'reorderpoint' => 30],
            ['item_name' => 'Folder', 'variant_type' => 'size', 'variant_value' => 'short', 'stock_quantity' => 90, 'reorderpoint' => 35],
            ['item_name' => 'Folder', 'variant_type' => 'color', 'variant_value' => 'green', 'stock_quantity' => 50, 'reorderpoint' => 25],
            ['item_name' => 'Folder', 'variant_type' => 'color', 'variant_value' => 'blue', 'stock_quantity' => 50, 'reorderpoint' => 25],
            ['item_name' => 'Folder', 'variant_type' => 'color', 'variant_value' => 'yellow', 'stock_quantity' => 50, 'reorderpoint' => 25],

            ['item_name' => 'Marker', 'variant_type' => 'color', 'variant_value' => 'red', 'stock_quantity' => 40, 'reorderpoint' => 20],
            ['item_name' => 'Marker', 'variant_type' => 'color', 'variant_value' => 'blue', 'stock_quantity' => 40, 'reorderpoint' => 20],
            ['item_name' => 'Marker', 'variant_type' => 'color', 'variant_value' => 'black', 'stock_quantity' => 40, 'reorderpoint' => 20],

            ['item_name' => 'Paper Organizer', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 15, 'reorderpoint' => 10],

            ['item_name' => 'Pencil', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 200, 'reorderpoint' => 100],

            ['item_name' => 'Plastic Envelope', 'variant_type' => 'size', 'variant_value' => 'long', 'stock_quantity' => 45, 'reorderpoint' => 25],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'size', 'variant_value' => 'short', 'stock_quantity' => 60, 'reorderpoint' => 30],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'color', 'variant_value' => 'yellow', 'stock_quantity' => 35, 'reorderpoint' => 20],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'color', 'variant_value' => 'blue', 'stock_quantity' => 35, 'reorderpoint' => 20],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'color', 'variant_value' => 'green', 'stock_quantity' => 35, 'reorderpoint' => 20],

            ['item_name' => 'Plastic Folder', 'variant_type' => 'size', 'variant_value' => 'long', 'stock_quantity' => 50, 'reorderpoint' => 25],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'size', 'variant_value' => 'short', 'stock_quantity' => 70, 'reorderpoint' => 30],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'color', 'variant_value' => 'yellow', 'stock_quantity' => 40, 'reorderpoint' => 20],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'color', 'variant_value' => 'green', 'stock_quantity' => 40, 'reorderpoint' => 20],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'color', 'variant_value' => 'blue', 'stock_quantity' => 40, 'reorderpoint' => 20],

            ['item_name' => 'Post-it', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 25, 'reorderpoint' => 10],

            ['item_name' => 'Puncher', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 10, 'reorderpoint' => 5],

            ['item_name' => 'Scissor', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 12, 'reorderpoint' => 6],

            ['item_name' => 'Staple Wire', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 30, 'reorderpoint' => 15],

            ['item_name' => 'Stapler', 'variant_type' => 'type', 'variant_value' => 'standard', 'stock_quantity' => 8, 'reorderpoint' => 4],

            ['item_name' => 'Vellum', 'variant_type' => 'size', 'variant_value' => 'long', 'stock_quantity' => 40, 'reorderpoint' => 20],
            ['item_name' => 'Vellum', 'variant_type' => 'size', 'variant_value' => 'short', 'stock_quantity' => 60, 'reorderpoint' => 30],
        ];

        DB::table('stocks')->insert($stocks);
    }
}
