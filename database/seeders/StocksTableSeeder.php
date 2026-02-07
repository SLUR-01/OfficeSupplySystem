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
            ['item_name' => 'Ballpen', 'variant_type' => 'color', 'variant_value' => 'red', 'current_stock' => 100, 'remaining_stocks' => 100, 'reorderpoint' => 50],
            ['item_name' => 'Ballpen', 'variant_type' => 'color', 'variant_value' => 'blue', 'current_stock' => 150, 'remaining_stocks' => 150, 'reorderpoint' => 60],
            ['item_name' => 'Ballpen', 'variant_type' => 'color', 'variant_value' => 'black', 'current_stock' => 200, 'remaining_stocks' => 200, 'reorderpoint' => 70],

            ['item_name' => 'Binder Clip', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 50, 'remaining_stocks' => 50, 'reorderpoint' => 25],

            ['item_name' => 'Bondpaper', 'variant_type' => 'size', 'variant_value' => 'short', 'current_stock' => 500, 'remaining_stocks' => 500, 'reorderpoint' => 100],
            ['item_name' => 'Bondpaper', 'variant_type' => 'size', 'variant_value' => 'long', 'current_stock' => 300, 'remaining_stocks' => 300, 'reorderpoint' => 100],

            ['item_name' => 'Box Files', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 30, 'remaining_stocks' => 30, 'reorderpoint' => 20],

            ['item_name' => 'Brown Envelope', 'variant_type' => 'size', 'variant_value' => 'long', 'current_stock' => 80, 'remaining_stocks' => 80, 'reorderpoint' => 40],
            ['item_name' => 'Brown Envelope', 'variant_type' => 'size', 'variant_value' => 'short', 'current_stock' => 120, 'remaining_stocks' => 120, 'reorderpoint' => 50],

            ['item_name' => 'Construction Paper', 'variant_type' => 'color', 'variant_value' => 'yellow', 'current_stock' => 200, 'remaining_stocks' => 200, 'reorderpoint' => 60],
            ['item_name' => 'Construction Paper', 'variant_type' => 'color', 'variant_value' => 'green', 'current_stock' => 200, 'remaining_stocks' => 200, 'reorderpoint' => 60],
            ['item_name' => 'Construction Paper', 'variant_type' => 'color', 'variant_value' => 'blue', 'current_stock' => 200, 'remaining_stocks' => 200, 'reorderpoint' => 60],

            ['item_name' => 'Correction Tape', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 40, 'remaining_stocks' => 40, 'reorderpoint' => 20],

            ['item_name' => 'Expanded Envelope', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 25, 'remaining_stocks' => 25, 'reorderpoint' => 15],
            ['item_name' => 'Expanded Envelope', 'variant_type' => 'color', 'variant_value' => 'green', 'current_stock' => 30, 'remaining_stocks' => 30, 'reorderpoint' => 15],
            ['item_name' => 'Expanded Envelope', 'variant_type' => 'color', 'variant_value' => 'blue', 'current_stock' => 30, 'remaining_stocks' => 30, 'reorderpoint' => 15],
            ['item_name' => 'Expanded Envelope', 'variant_type' => 'color', 'variant_value' => 'yellow', 'current_stock' => 30, 'remaining_stocks' => 30, 'reorderpoint' => 15],

            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'blue', 'current_stock' => 60, 'remaining_stocks' => 60, 'reorderpoint' => 30],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'yellow', 'current_stock' => 60, 'remaining_stocks' => 60, 'reorderpoint' => 30],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'red', 'current_stock' => 60, 'remaining_stocks' => 60, 'reorderpoint' => 30],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'white', 'current_stock' => 60, 'remaining_stocks' => 60, 'reorderpoint' => 30],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'green', 'current_stock' => 60, 'remaining_stocks' => 60, 'reorderpoint' => 30],

            ['item_name' => 'Folder', 'variant_type' => 'size', 'variant_value' => 'long', 'current_stock' => 75, 'remaining_stocks' => 75, 'reorderpoint' => 30],
            ['item_name' => 'Folder', 'variant_type' => 'size', 'variant_value' => 'short', 'current_stock' => 90, 'remaining_stocks' => 90, 'reorderpoint' => 35],
            ['item_name' => 'Folder', 'variant_type' => 'color', 'variant_value' => 'green', 'current_stock' => 50, 'remaining_stocks' => 50, 'reorderpoint' => 25],
            ['item_name' => 'Folder', 'variant_type' => 'color', 'variant_value' => 'blue', 'current_stock' => 50, 'remaining_stocks' => 50, 'reorderpoint' => 25],
            ['item_name' => 'Folder', 'variant_type' => 'color', 'variant_value' => 'yellow', 'current_stock' => 50, 'remaining_stocks' => 50, 'reorderpoint' => 25],

            ['item_name' => 'Marker', 'variant_type' => 'color', 'variant_value' => 'red', 'current_stock' => 40, 'remaining_stocks' => 40, 'reorderpoint' => 20],
            ['item_name' => 'Marker', 'variant_type' => 'color', 'variant_value' => 'blue', 'current_stock' => 40, 'remaining_stocks' => 40, 'reorderpoint' => 20],
            ['item_name' => 'Marker', 'variant_type' => 'color', 'variant_value' => 'black', 'current_stock' => 40, 'remaining_stocks' => 40, 'reorderpoint' => 20],

            ['item_name' => 'Paper Organizer', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 15, 'remaining_stocks' => 15, 'reorderpoint' => 10],

            ['item_name' => 'Pencil', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 200, 'remaining_stocks' => 200, 'reorderpoint' => 100],

            ['item_name' => 'Plastic Envelope', 'variant_type' => 'size', 'variant_value' => 'long', 'current_stock' => 45, 'remaining_stocks' => 45, 'reorderpoint' => 25],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'size', 'variant_value' => 'short', 'current_stock' => 60, 'remaining_stocks' => 60, 'reorderpoint' => 30],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'color', 'variant_value' => 'yellow', 'current_stock' => 35, 'remaining_stocks' => 35, 'reorderpoint' => 20],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'color', 'variant_value' => 'blue', 'current_stock' => 35, 'remaining_stocks' => 35, 'reorderpoint' => 20],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'color', 'variant_value' => 'green', 'current_stock' => 35, 'remaining_stocks' => 35, 'reorderpoint' => 20],

            ['item_name' => 'Plastic Folder', 'variant_type' => 'size', 'variant_value' => 'long', 'current_stock' => 50, 'remaining_stocks' => 50, 'reorderpoint' => 25],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'size', 'variant_value' => 'short', 'current_stock' => 70, 'remaining_stocks' => 70, 'reorderpoint' => 30],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'color', 'variant_value' => 'yellow', 'current_stock' => 40, 'remaining_stocks' => 40, 'reorderpoint' => 20],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'color', 'variant_value' => 'green', 'current_stock' => 40, 'remaining_stocks' => 40, 'reorderpoint' => 20],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'color', 'variant_value' => 'blue', 'current_stock' => 40, 'remaining_stocks' => 40, 'reorderpoint' => 20],

            ['item_name' => 'Post-it', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 25, 'remaining_stocks' => 25, 'reorderpoint' => 10],

            ['item_name' => 'Puncher', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 10, 'remaining_stocks' => 10, 'reorderpoint' => 5],

            ['item_name' => 'Scissor', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 12, 'remaining_stocks' => 12, 'reorderpoint' => 6],

            ['item_name' => 'Staple Wire', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 30, 'remaining_stocks' => 30, 'reorderpoint' => 15],

            ['item_name' => 'Stapler', 'variant_type' => 'type', 'variant_value' => 'standard', 'current_stock' => 8, 'remaining_stocks' => 8, 'reorderpoint' => 4],

            ['item_name' => 'Vellum', 'variant_type' => 'size', 'variant_value' => 'long', 'current_stock' => 40, 'remaining_stocks' => 40, 'reorderpoint' => 20],
            ['item_name' => 'Vellum', 'variant_type' => 'size', 'variant_value' => 'short', 'current_stock' => 60, 'remaining_stocks' => 60, 'reorderpoint' => 30],
        ];
        DB::table('stocks')->insert($stocks);
    }
}
