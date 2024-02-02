<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class TeamScheduleDataTable extends Controller
{

  public function index()
  {
    return view('teamschedule');
  }
  public function teamschedule()
  {
    $data = Event::with('hrd')->get();

    return DataTables::of($data)
    ->addIndexColumn()


    ->Make(true);
  }
}

