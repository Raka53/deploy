<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\hrd;
use Illuminate\Http\Request;

class EventController extends Controller
{
  public function index()
  {
    $events = Event::with('hrd')->get()->map(function ($booking) {
      return [
          'id' => $booking->id,
          'name' => optional($booking->hrd)->name, // Use optional() to avoid null error
          'title' => $booking->title,
          'province' => $booking->province,
          'rs' => $booking->rs,
          'department' => $booking->department,
          'task' => $booking->task,
          'start' => $booking->start_date,
          'end' => $booking->end_date,
          'color' => $booking->title == 'Test' ? '#924ACE' : ($booking->title == 'Test 1' ? '#68B01A' : ''),
      ];
  });
  $data = Hrd::all(); // Fetch Hrd data
      return view('event', compact('events', 'data'));
  }

  public function getJobTitle(Request $request)
  {
      try {
          $employeeId = $request->input('hrd_id');
          $employee = Hrd::find($employeeId);

          if ($employee) {
              return response()->json([
                  'jobtitle' => $employee->jobtitle,
                  'hrd_id' => $employee->id_hrd, // Include id_hrd in the response
              ]);
          }

          return response()->json(['jobtitle' => null, 'hrd_id' => null]);
      } catch (\Exception $e) {
          // Print error message to console
          dd($e->getMessage());
      }
  }



  public function store(Request $request)
  {
      // Validate the incoming request data
      $request->validate([
          'hrd_id' => 'integer',
          'title' => 'string|max:255',
          'start_date' => 'date_format:Y-m-d H:i:s',
          'end_date' => 'date_format:Y-m-d H:i:s|after_or_equal:start_date',
          'jobtitle' => 'string|max:255',
          'rs' => 'string',
          'createRs' => 'string',
          'department' => 'string',
          'task' => 'string|max:255',
      ]);

      // Find the employee by their ID (hrd_id)
      $employee = Hrd::find($request->hrd_id);

      if (!$employee) {
          // Handle case where the employee is not found
          return response()->json(['error' => 'Employee not found'], 404);
      }

      $color = null;
      if ($request->createTitle == 'Test') {
          $color = '#924ACE';
      }

      // Create a new Event instance
      $event = Event::create([
          'title' => $request->title,
          'hrd_id' => $request->hrd_id,
          'jobtitle' => $employee->jobtitle,
          'province' => $request->province,
          'rs' => $request->rs,
          'department' => $request->department,
          'task' => $request->task,
          'start_date' => $request->start_date,
          'end_date' => $request->end_date,
      ]);

      return response()->json([
          'id' => $event->id,
          'hrd_id' => $event->hrd_id,
          'jobtitle' => $event->jobtitle,
          'start' => $event->start_date,
          'end' => $event->end_date,
          'title' => $event->title,
          'province' => $event->province,
          'rs' => $event->rs,
          'department' => $event->department,
          'task' => $event->task,
          'color' => $color ?: '',
      ]);
  }


public function show($id)
{
  try {
    $event = Event::findOrFail($id);

      return response()->json($event);
  } catch (\Exception $e) {
      return response()->json(['error' => 'Unable to locate the event'], 404);
  }
}


  public function update(Request $request ,$id)
  {
    $booking = Event::find($id);

    if (!$booking) {
        return response()->json([
            'error' => 'Unable to locate the event'
        ], 404);
    }

    $request->validate([

        'hrd_id' => ['string','sometimes'],

        'title' => ['string','sometimes'],
        'province' => ['string','sometimes'],
        'rs' => ['string','sometimes'],
        'department' => ['string','sometimes'],
        'task' => ['string','sometimes'],
        'start_date' => 'date_format:Y-m-d H:i:s',
        'end_date' => 'date_format:Y-m-d H:i:s|after_or_equal:start_date'
    ]);

    $booking->update([
        'id' => $request->id,
        'title' => $request->title,
        'province' => $request->province,
        'rs' => $request->rs,
        'department' => $request->department,
        'task' => $request->task,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);

    return response()->json(['message' => 'Event updated']);
}
public function getScheduleList()
{
       $scheduleList = Event::join('hrd', 'events.hrd_id', '=', 'hrd.id')
        ->select('events.hrd_id', 'hrd.name as hrd_name', 'events.task', 'events.start_date', 'events.end_date')
        ->get();

    return response()->json($scheduleList);
}
  public function destroy($id)
  {
      $booking = event::find($id);
      if(! $booking) {
          return response()->json([
              'error' => 'Unable to locate the event'
          ], 404);
      }
      $booking->delete();
      return $id;
  }
}
