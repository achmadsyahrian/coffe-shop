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
            'username' => 'driplycoffee',
            'name' => 'Driply Coffee',
            'password' => bcrypt('password'),
            'role_id' => 1,
            'phone' => '0895423336075'
        ]);
        
        Outlet::create([
            'user_id' => 1,
            'name' => "Driply Coffee",
            'address' => "Jl. Durung Komplek Durung Regency No.A4, Sidorejo Hilir, Kec. Medan Tembung, Kota Medan, Sumatera Utara 20222",
            'phone' => '085261663175',
            'description' => "Selamat datang di Driply Coffee, tempat di mana secangkir kopi menjadi teman terbaik untuk melepas penat. Kami menyajikan kopi terbaik dari biji kopi lokal pilihan, diracik dengan penuh cinta untuk menciptakan pengalaman ngopi yang santai dan memuaskan. Dengan suasana yang hangat dan nyaman, Driply Coffee menjadi tempat ideal untuk bersantai sendiri, berbincang bersama teman, atau mencari inspirasi baru.
            
            Selain kopi, kami juga menyediakan aneka makanan ringan yang menggugah selera untuk melengkapi momen santai Anda. Interior yang menenangkan, aroma kopi yang khas, dan layanan yang ramah akan membuat Anda betah berlama-lama. Nikmati waktu Anda, karena di Driply Coffee, setiap tegukan adalah momen yang berharga. ☕"
        ]);
    }
}
