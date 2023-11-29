<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {

        // return view('admin.dashboard'); // Assuming you have a view file named 'home.blade.php' in the 'resources/views/admin' directory
        echo'Welcome Home';
    }
}
