<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\FamilyRelationship;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create family members
        $grandfather = Family::create([
            'name' => 'Ahmad Wijaya',
            'gender' => 'Laki-laki',
            'birth_date' => '1945-03-15',
            'status' => 'Hidup',
            'address' => 'Jl. Merdeka No. 10, Jakarta',
            'phone' => '08123456789',
        ]);

        $grandmother = Family::create([
            'name' => 'Siti Nurhaliza',
            'gender' => 'Perempuan',
            'birth_date' => '1948-07-22',
            'status' => 'Hidup',
            'address' => 'Jl. Merdeka No. 10, Jakarta',
            'phone' => '08234567890',
        ]);

        // Second generation
        $father = Family::create([
            'name' => 'Budi Wijaya',
            'gender' => 'Laki-laki',
            'birth_date' => '1970-05-12',
            'status' => 'Hidup',
            'address' => 'Jl. Sudirman No. 25, Jakarta',
            'phone' => '08345678901',
        ]);

        $mother = Family::create([
            'name' => 'Ani Kusuma',
            'gender' => 'Perempuan',
            'birth_date' => '1972-08-18',
            'status' => 'Hidup',
            'address' => 'Jl. Sudirman No. 25, Jakarta',
            'phone' => '08456789012',
        ]);

        $uncle = Family::create([
            'name' => 'Citra Wijaya',
            'gender' => 'Perempuan',
            'birth_date' => '1968-02-10',
            'status' => 'Hidup',
            'address' => 'Jl. Gatot Subroto No. 50, Jakarta',
            'phone' => '08567890123',
        ]);

        // Third generation
        $son = Family::create([
            'name' => 'Rendra Wijaya',
            'gender' => 'Laki-laki',
            'birth_date' => '1995-11-30',
            'status' => 'Hidup',
            'address' => 'Jl. Sudirman No. 25, Jakarta',
            'phone' => '08678901234',
        ]);

        $daughter = Family::create([
            'name' => 'Dewi Wijaya',
            'gender' => 'Perempuan',
            'birth_date' => '1998-04-25',
            'status' => 'Hidup',
            'address' => 'Jl. Sudirman No. 25, Jakarta',
            'phone' => '08789012345',
        ]);

        $cousin = Family::create([
            'name' => 'Eka Kusuma',
            'gender' => 'Perempuan',
            'birth_date' => '2000-09-08',
            'status' => 'Hidup',
            'address' => 'Jl. Gatot Subroto No. 50, Jakarta',
            'phone' => '08890123456',
        ]);

        // Create relationships
        // Grandfather -> Father (Ayah)
        FamilyRelationship::create([
            'parent_id' => $grandfather->id,
            'child_id' => $father->id,
            'relationship_type' => 'Ayah',
        ]);

        // Grandmother -> Father (Ibu)
        FamilyRelationship::create([
            'parent_id' => $grandmother->id,
            'child_id' => $father->id,
            'relationship_type' => 'Ibu',
        ]);

        // Grandfather -> Aunt (Ayah)
        FamilyRelationship::create([
            'parent_id' => $grandfather->id,
            'child_id' => $uncle->id,
            'relationship_type' => 'Ayah',
        ]);

        // Grandmother -> Aunt (Ibu)
        FamilyRelationship::create([
            'parent_id' => $grandmother->id,
            'child_id' => $uncle->id,
            'relationship_type' => 'Ibu',
        ]);

        // Father -> Son (Ayah)
        FamilyRelationship::create([
            'parent_id' => $father->id,
            'child_id' => $son->id,
            'relationship_type' => 'Ayah',
        ]);

        // Mother -> Son (Ibu)
        FamilyRelationship::create([
            'parent_id' => $mother->id,
            'child_id' => $son->id,
            'relationship_type' => 'Ibu',
        ]);

        // Father -> Daughter (Ayah)
        FamilyRelationship::create([
            'parent_id' => $father->id,
            'child_id' => $daughter->id,
            'relationship_type' => 'Ayah',
        ]);

        // Mother -> Daughter (Ibu)
        FamilyRelationship::create([
            'parent_id' => $mother->id,
            'child_id' => $daughter->id,
            'relationship_type' => 'Ibu',
        ]);

        // Uncle -> Cousin
        FamilyRelationship::create([
            'parent_id' => $uncle->id,
            'child_id' => $cousin->id,
            'relationship_type' => 'Ibu',
        ]);
    }
}
