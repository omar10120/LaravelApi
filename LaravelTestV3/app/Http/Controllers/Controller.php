<?php

namespace App\Http\Controllers;
use OpenApi\Attributtes as OA;
#[
OA\Info(version: "1.0.0",description:"Fusion Center Documentations" , title:"Fusion Center Documentations"),
OA\Server(url: 'http://172.0.0.1:8000/api',description: "local server" ),
OA\Server(url: 'http://staging.example.com',description: "staging server" ),
OA\Server(url: 'http://example.com',description: "production server" ),
OA\SecurityScheme(SecurityScheme: 'bearerAuth',type:"http",name:"Authorization",in:"header", scheme:"bearer"),
]

abstract class Controller
{
    //
}
