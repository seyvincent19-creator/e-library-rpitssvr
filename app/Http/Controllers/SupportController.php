<?php

namespace App\Http\Controllers;

class SupportController extends Controller
{
    public function index()
    {
        return view('layout.admin.content.support.index');
    }
}
