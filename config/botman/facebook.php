<?php
return [
    'facebook' => [
        'token' => env('FACEBOOK_TOKEN'),
    ],
    'start_button_payload' => env('START_BUTTON_PAYLOAD'),
    'greeting_text' => [
        "greeting" => array([
            "locale" => "default",
            "text" => env('GREETING_TEXT')
        ])
    ],
    'persistent_menu' => array([
        "locale" => "default",
        "composer_input_disabled" => "false",
        "call_to_actions" => array([
            "title" => "Ver cursos",
            "type" => "postback",
            "payload" => "cursos"
        ], [
            "title" => "Pesquisa de satisfação",
            "type" => "postback",
            "payload" => "iniciar_pesquisa"
        ], [
            "title" => "Visitar site",
            "type" => "web_url",
            "url" => "http://www.hub4dev.com.br",
            "webview_height_ratio" => "full"
        ]
        )
    ])

];

