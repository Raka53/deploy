<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardAbsenController extends Controller
{
  public function index(){
    return view('absengps.dashboard');
}
}
