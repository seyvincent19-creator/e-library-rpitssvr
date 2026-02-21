<?php

namespace App\Http\Controllers;

class SettingController extends Controller
{
    public function index()
    {
        return view('layout.admin.content.setting.index');
    }
}
