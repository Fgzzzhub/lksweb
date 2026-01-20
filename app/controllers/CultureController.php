<?php

class CultureController extends BaseController
{
    public function index()
    {
        $pageTitle = 'Budaya & Produk - Portal Tegal';

        $type = trim($_GET['type'] ?? '');
        $q = trim($_GET['q'] ?? '');

        $items = [
            [
                'name' => 'Batik Tegalan',
                'type' => 'Batik',
                'desc' => 'Motif pesisir dengan warna hangat yang khas dari perajin lokal.',
                'image' => 'batik.webp',
            ],
            [
                'name' => 'Kerajinan Gerabah',
                'type' => 'Kerajinan',
                'desc' => 'Produk tanah liat tradisional dari sentra UMKM Tegal.',
                'image' => 'batik-2.jpg',
            ],
            [
                'name' => 'Anyaman Bambu',
                'type' => 'Kerajinan',
                'desc' => 'Anyaman fungsional dan dekoratif dengan gaya modern.',
                'image' => 'batik-3.jpg',
            ],
            [
                'name' => 'Teh Poci Heritage',
                'type' => 'UMKM',
                'desc' => 'Produk teh lokal yang diracik dengan tradisi poci.',
                'image' => 'teh-poci.jpg',
            ],
            [
                'name' => 'Kain Lurik Tegal',
                'type' => 'Batik',
                'desc' => 'Kain lurik dengan sentuhan motif kontemporer khas Tegal.',
                'image' => 'batik-2.jpg',
            ],
            [
                'name' => 'Kopi Biji Pegunungan',
                'type' => 'UMKM',
                'desc' => 'Kopi lokal yang disangrai oleh komunitas kopi Tegal.',
                'image' => 'praban-lintang.jpg',
            ],
        ];

        $filtered = array_filter($items, function ($item) use ($type, $q) {
            $matchType = $type === '' || strcasecmp($item['type'], $type) === 0;
            $matchQuery = $q === '' || stripos($item['name'], $q) !== false || stripos($item['desc'], $q) !== false;
            return $matchType && $matchQuery;
        });

        $this->render('culture/index', compact('pageTitle', 'type', 'q', 'filtered'));
    }
}
