<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::create([
            'question' => 'Bagaimana cara memulai percakapan?',
            'answer' => 'Klik pada nama pengguna di daftar kontak untuk memulai percakapan.',
        ]);

        Faq::create([
            'question' => 'Bagaimana cara mengunggah file?',
            'answer' => 'Gunakan tombol lampiran di jendela chat untuk mengunggah file.',
        ]);
    }
}
