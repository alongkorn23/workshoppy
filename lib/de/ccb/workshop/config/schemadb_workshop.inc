'default' => [
    'description' => 'workshop',
    'fields'      => [
        'title' => [
            'title' => 'Title',
            'storage' => 'title',
            'required' => true,
            'type' => 'text',
            'widget' => 'text',
        ],
        'agenda' => [
            'title' => 'Agenda',
            'storage' => 'agenda',
            'type' => 'text',
            'widget' => 'tinymce',
        ],
    ],
],
