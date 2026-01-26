<?php

return [
    [
        'name' => 'Mitras',
        'flag' => 'mitra.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'mitra.create',
        'parent_flag' => 'mitra.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'mitra.edit',
        'parent_flag' => 'mitra.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'mitra.destroy',
        'parent_flag' => 'mitra.index',
    ],
];
