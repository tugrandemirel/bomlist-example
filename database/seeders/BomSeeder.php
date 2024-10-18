<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Ana BOM verileri
        $carBom = DB::table('boms')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Araba',
            'description' => "Araç BOM'u",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $engineBom = DB::table('boms')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Motor',
            'description' => "Motor BOM'u",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $chassisBom = DB::table('boms')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Şasi',
            'description' => "Araç Şasi BOM'u",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $wheelBom = DB::table('boms')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Tekerlek',
            'description' => "Tekerlek BOM'u",
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Kapı BOM'u ekleniyor
        $doorBom = DB::table('boms')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Kapı',
            'description' => 'Arabanın kapısı',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Kapı Alt BOM (Kilit) ekleniyor
        $lockBom = DB::table('boms')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Kilit',
            'description' => 'Kapının kilidi',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Parça verileri
        $pistonPart = DB::table('parts')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Piston',
            'description' => 'Motorun parçası',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $crankPart = DB::table('parts')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Krank',
            'description' => 'Motorun parçası',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $doorPart = DB::table('parts')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Kapı',
            'description' => 'Arabanın kapısı',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $tirePart = DB::table('parts')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Lastik',
            'description' => 'Tekerlek parçası',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $lockPart = DB::table('parts')->insertGetId([
            'uuid' => Str::uuid(),
            'name' => 'Kilit',
            'description' => 'Kapının kilidi',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // BOM-Children ilişkileri
        DB::table('bom_childrens')->insert([
            'uuid' => Str::uuid(),
            'parent_bom_id' => $carBom,
            'child_bom_id' => $engineBom,
            'quantity' => 1, // Araba için 1 adet Motor
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('bom_childrens')->insert([
            'uuid' => Str::uuid(),
            'parent_bom_id' => $carBom,
            'child_bom_id' => $chassisBom,
            'quantity' => 1, // Araba için 1 adet Şasi
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('bom_childrens')->insert([
            'uuid' => Str::uuid(),
            'parent_bom_id' => $carBom,
            'child_bom_id' => $wheelBom,
            'quantity' => 4, // Araba için 4 adet Tekerlek
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Şasi BOM'una Kapı ekleniyor
        DB::table('bom_childrens')->insert([
            'uuid' => Str::uuid(),
            'parent_bom_id' => $chassisBom,
            'child_bom_id' => $doorBom,
            'quantity' => 4, // Şasi için 4 adet Kapı
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Kapı BOM'una Kilit ekleniyor
        DB::table('bom_childrens')->insert([
            'uuid' => Str::uuid(),
            'parent_bom_id' => $doorBom,
            'child_bom_id' => $lockBom,
            'quantity' => 1, // Kapı için 1 adet Kilit
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Motor BOM'una parçalar ekleniyor
        DB::table('bom_parts')->insert([
            'uuid' => Str::uuid(),
            'bom_id' => $engineBom,
            'part_id' => $pistonPart,
            'quantity' => 4, // Motor BOM'unda 4 adet Piston
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('bom_parts')->insert([
            'uuid' => Str::uuid(),
            'bom_id' => $engineBom,
            'part_id' => $crankPart,
            'quantity' => 1, // Motor BOM'unda 1 adet Krank
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Kapı BOM'una parçalar ekleniyor
        DB::table('bom_parts')->insert([
            'uuid' => Str::uuid(),
            'bom_id' => $doorBom,
            'part_id' => $doorPart,
            'quantity' => 4, // Kapı BOM'unda 4 adet Kapı
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Tekerlek BOM'una parçalar ekleniyor
        DB::table('bom_parts')->insert([
            'uuid' => Str::uuid(),
            'bom_id' => $wheelBom,
            'part_id' => $tirePart,
            'quantity' => 4, // Tekerlek BOM'unda 4 adet Lastik
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Kilit BOM'una parçalar ekleniyor
        DB::table('bom_parts')->insert([
            'uuid' => Str::uuid(),
            'bom_id' => $lockBom,
            'part_id' => $lockPart,
            'quantity' => 1, // Kilit BOM'unda 1 adet Kilit
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
