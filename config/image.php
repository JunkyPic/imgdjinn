<?php

return [
  'path' => [
      'upload' => public_path('img/'),
      'link' => sprintf("%s://%s/callback",
          isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ?
              'https' : 'http',
          $_SERVER['SERVER_NAME']
      ) . 'img/',
  ]
];
