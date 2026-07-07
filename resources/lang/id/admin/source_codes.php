<?php

return [

    'label' => 'Source Code',
    'plural-label' => 'Source Code',

    'section' => [
        'title' => 'Detail Source Code',
        'description' => 'Ini akan ditampilkan ke user sebagai resource yang bisa di-download di dashboard mereka.',
    ],

    'fields' => [
        'title' => [
            'label' => 'Judul',
            'placeholder' => 'contoh: Harps-MD v3',
        ],
        'description' => [
            'label' => 'Deskripsi',
            'placeholder' => 'Deskripsi singkat source code ini...',
        ],
        'link' => [
            'label' => 'Link Download',
            'helper' => 'Link GitHub, MediaFire, atau link direct lainnya.',
        ],
        'category' => [
            'label' => 'Kategori / Tag',
            'helper' => 'Dipakai buat mengelompokkan dan memberi label entri ini.',
            'placeholder' => 'contoh: GitHub, MediaFire, Tools',
        ],
        'thumbnail' => [
            'label' => 'URL Gambar Thumbnail',
            'helper' => 'Tempel link gambar langsung untuk dipakai sebagai thumbnail.',
        ],
        'order' => [
            'label' => 'Urutan Tampilan',
            'helper' => 'Angka lebih kecil akan ditampilkan lebih dulu.',
        ],
        'is_active' => [
            'label' => 'Tampilkan ke User',
            'helper' => 'Nonaktifkan untuk menyembunyikan entri ini tanpa menghapusnya.',
        ],
    ],

    'table' => [
        'id' => 'ID',
        'thumbnail' => 'Thumbnail',
        'title' => 'Judul',
        'category' => 'Kategori',
        'link' => 'Link',
        'is_active' => 'Aktif',
        'order' => 'Urutan',
        'updated' => 'Diperbarui',
    ],

    'actions' => [
        'edit' => 'Edit',
        'delete' => 'Hapus',
    ],

];
