<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Мобильные телефоны', 'code' => 'mobiles', 'description' => 'Описание мобильных телефонов'],
            ['name' => 'Портативная техника', 'code' => 'portable', 'description' => 'Описание для раздела портативной техники'],
            ['name' => 'Бытовая техника', 'code' => 'technics', 'description' => 'Раздел бытовой техники'],
        ]);
    }
}
