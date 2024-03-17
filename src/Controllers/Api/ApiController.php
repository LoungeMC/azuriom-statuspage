<?php

namespace Azuriom\Plugin\StatusPage\Controllers\Api;

use Azuriom\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Show the plugin API default page.
     */
    public function index()
    {
        return response()->json('Hello World!');
    }
}
