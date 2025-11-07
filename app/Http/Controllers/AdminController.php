<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Méthodes pour gérer la page admin
    public function index()
    {
        return view('admin.dashboard');
    }
}
