<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index(Request $request)
    {
        return view('index');
    }

    public function uploadImage(Request $request)
    {
        $imgur = upload_to_imgur($request->file('image')->path());

        $src = $imgur['data']['link'];

        return "<img src='$src'>";
    }
}
