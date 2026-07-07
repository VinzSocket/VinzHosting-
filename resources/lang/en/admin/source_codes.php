<?php

return [

    'label' => 'Source Code',
    'plural-label' => 'Source Codes',

    'section' => [
        'title' => 'Source Code Details',
        'description' => 'This will be shown to users as a downloadable resource on their dashboard.',
    ],

    'fields' => [
        'title' => [
            'label' => 'Title',
            'placeholder' => 'e.g. Harps-MD v3',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'A short description of this source code...',
        ],
        'link' => [
            'label' => 'Download Link',
            'helper' => 'A GitHub, MediaFire, or any other direct link.',
        ],
        'category' => [
            'label' => 'Category / Tag',
            'helper' => 'Used to group and label this entry.',
            'placeholder' => 'e.g. GitHub, MediaFire, Tools',
        ],
        'thumbnail' => [
            'label' => 'Thumbnail Image URL',
            'helper' => 'Paste a direct image URL to show as the thumbnail.',
        ],
        'order' => [
            'label' => 'Display Order',
            'helper' => 'Lower numbers are shown first.',
        ],
        'is_active' => [
            'label' => 'Visible to Users',
            'helper' => 'Disable to hide this entry without deleting it.',
        ],
    ],

    'table' => [
        'id' => 'ID',
        'thumbnail' => 'Thumbnail',
        'title' => 'Title',
        'category' => 'Category',
        'link' => 'Link',
        'is_active' => 'Active',
        'order' => 'Order',
        'updated' => 'Updated',
    ],

    'actions' => [
        'edit' => 'Edit',
        'delete' => 'Delete',
    ],

];
