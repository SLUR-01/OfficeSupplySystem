<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StocksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear the table first
        DB::table('stocks')->truncate();

        $stocks = [
            // Ballpens
            ['item_name' => 'Ballpen', 'variant_type' => 'color', 'variant_value' => 'red', 'quantity' => 100],
            ['item_name' => 'Ballpen', 'variant_type' => 'color', 'variant_value' => 'blue', 'quantity' => 150],
            ['item_name' => 'Ballpen', 'variant_type' => 'color', 'variant_value' => 'black', 'quantity' => 200],
            
            // Binder Clip
            ['item_name' => 'Binder Clip', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 50],
            
            // Bondpaper
            ['item_name' => 'Bondpaper', 'variant_type' => 'size', 'variant_value' => 'short', 'quantity' => 500],
            ['item_name' => 'Bondpaper', 'variant_type' => 'size', 'variant_value' => 'long', 'quantity' => 300],
            
            // Box Files
            ['item_name' => 'Box Files', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 30],
            
            // Brown Envelope
            ['item_name' => 'Brown Envelope', 'variant_type' => 'size', 'variant_value' => 'long', 'quantity' => 80],
            ['item_name' => 'Brown Envelope', 'variant_type' => 'size', 'variant_value' => 'short', 'quantity' => 120],
            
            // Construction Paper
            ['item_name' => 'Construction Paper', 'variant_type' => 'color', 'variant_value' => 'yellow', 'quantity' => 200],
            ['item_name' => 'Construction Paper', 'variant_type' => 'color', 'variant_value' => 'green', 'quantity' => 200],
            ['item_name' => 'Construction Paper', 'variant_type' => 'color', 'variant_value' => 'blue', 'quantity' => 200],
            
            // Correction Tape
            ['item_name' => 'Correction Tape', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 40],
            
            // Expanded Envelope
            ['item_name' => 'Expanded Envelope', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 25],
            ['item_name' => 'Expanded Envelope', 'variant_type' => 'color', 'variant_value' => 'green', 'quantity' => 30],
            ['item_name' => 'Expanded Envelope', 'variant_type' => 'color', 'variant_value' => 'blue', 'quantity' => 30],
            ['item_name' => 'Expanded Envelope', 'variant_type' => 'color', 'variant_value' => 'yellow', 'quantity' => 30],
            
            // Fastener
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'blue', 'quantity' => 60],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'yellow', 'quantity' => 60],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'red', 'quantity' => 60],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'white', 'quantity' => 60],
            ['item_name' => 'Fastener', 'variant_type' => 'color', 'variant_value' => 'green', 'quantity' => 60],
            
            // Folder
            ['item_name' => 'Folder', 'variant_type' => 'size', 'variant_value' => 'long', 'quantity' => 75],
            ['item_name' => 'Folder', 'variant_type' => 'size', 'variant_value' => 'short', 'quantity' => 90],
            ['item_name' => 'Folder', 'variant_type' => 'color', 'variant_value' => 'green', 'quantity' => 50],
            ['item_name' => 'Folder', 'variant_type' => 'color', 'variant_value' => 'blue', 'quantity' => 50],
            ['item_name' => 'Folder', 'variant_type' => 'color', 'variant_value' => 'yellow', 'quantity' => 50],
            
            // Marker
            ['item_name' => 'Marker', 'variant_type' => 'color', 'variant_value' => 'red', 'quantity' => 40],
            ['item_name' => 'Marker', 'variant_type' => 'color', 'variant_value' => 'blue', 'quantity' => 40],
            ['item_name' => 'Marker', 'variant_type' => 'color', 'variant_value' => 'black', 'quantity' => 40],
            
            // Paper Organizer
            ['item_name' => 'Paper Organizer', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 15],
            
            // Pencil
            ['item_name' => 'Pencil', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 200],
            
            // Plastic Envelope
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'size', 'variant_value' => 'long', 'quantity' => 45],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'size', 'variant_value' => 'short', 'quantity' => 60],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'color', 'variant_value' => 'yellow', 'quantity' => 35],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'color', 'variant_value' => 'blue', 'quantity' => 35],
            ['item_name' => 'Plastic Envelope', 'variant_type' => 'color', 'variant_value' => 'green', 'quantity' => 35],
            
            // Plastic Folder
            ['item_name' => 'Plastic Folder', 'variant_type' => 'size', 'variant_value' => 'long', 'quantity' => 50],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'size', 'variant_value' => 'short', 'quantity' => 70],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'color', 'variant_value' => 'yellow', 'quantity' => 40],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'color', 'variant_value' => 'green', 'quantity' => 40],
            ['item_name' => 'Plastic Folder', 'variant_type' => 'color', 'variant_value' => 'blue', 'quantity' => 40],
            
            // Post-it
            ['item_name' => 'Post-it', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 25],
            
            // Puncher
            ['item_name' => 'Puncher', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 10],
            
            // Scissor
            ['item_name' => 'Scissor', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 12],
            
            // Staple Wire
            ['item_name' => 'Staple Wire', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 30],
            
            // Stapler
            ['item_name' => 'Stapler', 'variant_type' => 'type', 'variant_value' => 'standard', 'quantity' => 8],
            
            // Vellum
            ['item_name' => 'Vellum', 'variant_type' => 'size', 'variant_value' => 'long', 'quantity' => 40],
            ['item_name' => 'Vellum', 'variant_type' => 'size', 'variant_value' => 'short', 'quantity' => 60],
        ];

        // Insert the data
        DB::table('stocks')->insert($stocks);
    }
}