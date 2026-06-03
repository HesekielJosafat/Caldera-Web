<?php

namespace App\Http\Controllers\Branding;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        $companyInfo = [
            'name' => 'Caldera Resto and Pool',
            'established' => 2020,
            'vision' => 'Menjadi destinasi kuliner dan rekreasi terbaik di Indonesia',
            'mission' => [
                'Menyediakan makanan berkualitas dengan harga terjangkau',
                'Memberikan pelayanan terbaik kepada pelanggan',
                'Menciptakan suasana yang nyaman dan menyenangkan',
                'Mengembangkan inovasi menu dan fasilitas secara berkelanjutan'
            ],
            'values' => [
                'Kualitas' => 'Mengutamakan kualitas dalam setiap produk dan layanan',
                'Kenyamanan' => 'Menciptakan suasana yang nyaman untuk semua pengunjung',
                'Inovasi' => 'Terus berinovasi untuk memberikan pengalaman terbaik',
                'Kepuasan' => 'Kepuasan pelanggan adalah prioritas utama'
            ],
            'history' => 'Caldera Resto and Pool berdiri sejak tahun 2020 dengan konsep restoran keluarga yang dilengkapi fasilitas kolam renang. Berawal dari keinginan menciptakan tempat berkumpul yang nyaman untuk keluarga dan teman, Caldera kini telah menjadi salah satu destinasi favorit di kota.',
            'team' => [
                ['name' => 'Budi Santoso', 'position' => 'Founder & CEO', 'avatar' => null],
                ['name' => 'Siti Aminah', 'position' => 'Head Chef', 'avatar' => null],
                ['name' => 'Ahmad Rizki', 'position' => 'Operations Manager', 'avatar' => null],
            ]
        ];
        
        return view('pages.about', compact('companyInfo'));
    }

    
}