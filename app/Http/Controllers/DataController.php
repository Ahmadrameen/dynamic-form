<?php

namespace App\Http\Controllers;

class DataController extends Controller
{
    public function __invoke()
    {
        $json = file_get_contents('json/form_data.json'); # This will get data from public folder.
        $data = json_decode($json, true);
        return view('welcome', compact('data'));
    }
}
