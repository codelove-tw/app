<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use AppCore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.index');
    }
}
