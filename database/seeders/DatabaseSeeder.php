<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Outlet;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Owner'
        ]);
        Role::create([
            'name' => 'Staff'
        ]);
        Role::create([
            'name' => 'Customer'
        ]);

        User::create([
            'username' => 'seduhsantai',
            'name' => 'Achmad Syahrian',
            'password' => bcrypt('password'),
            'role_id' => 1,
            'phone' => '0895423336075'
        ]);
        
        Outlet::create([
            'user_id' => 1,
            'name' => "Seduh Santai",
            'address' => "Jln. Kol Yos Sudarso No.16, Medan",
            'phone' => '089528126200',
            'description' => "Selamat datang di Seduh Santai, tempat di mana secangkir kopi menjadi teman terbaik untuk melepas penat. Kami menyajikan kopi terbaik dari biji kopi lokal pilihan, diracik dengan penuh cinta untuk menciptakan pengalaman ngopi yang santai dan memuaskan. Dengan suasana yang hangat dan nyaman, Seduh Santai menjadi tempat ideal untuk bersantai sendiri, berbincang bersama teman, atau mencari inspirasi baru.
            
            Selain kopi, kami juga menyediakan aneka makanan ringan yang menggugah selera untuk melengkapi momen santai Anda. Interior yang menenangkan, aroma kopi yang khas, dan layanan yang ramah akan membuat Anda betah berlama-lama. Nikmati waktu Anda, karena di Seduh Santai, setiap tegukan adalah momen yang berharga. ☕"
        ]);
    }
}
