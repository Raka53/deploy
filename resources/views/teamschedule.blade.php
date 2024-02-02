@extends('template.main')
@section('content')
<div class="d-flex justify-content-between align-items-center">
  <h1 class="text-center cool-title">Team Schedule</h1>
</div>
<br>
  <div class="table-responsive col-lg-12">

    <!-- DataTable -->
    <table class="table" id="teamschedule-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Title</th>
                <th>Jobtitle</th>
                <th>province</th>
                <th>RS</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

    <!-- Modal -->
    <div class="modal fade" id="teamScheduleModal" tabindex="-1" role="dialog" aria-labelledby="teamScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="teamScheduleModalLabel">Team Schedule Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Display team schedule details here -->
                    <p><strong>Name:</strong> <span id="modal-name"></span></p>
                    <p><strong>Title:</strong> <span id="modal-title"></span></p>
                    <p><strong>Task:</strong> <span id="modal-task"></span></p>
                    <p><strong>Start Date:</strong> <span id="modal-start-date"></span></p>
                    <p><strong>End Date:</strong> <span id="modal-end-date"></span></p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTable script -->
    <script>
        $(function () {
            $('#teamschedule-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('teamschedule.teamschedule') !!}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'hrd.name', name: 'name' },
                    { data: 'title', name: 'title' },
                    { data: 'jobtitle', name: 'jobtitle' },
                    { data: 'province', name: 'province' },
                    { data: 'rs', name: 'rs' },
                    { data: 'start_date', name: 'start_date' },
                    { data: 'end_date', name: 'end_date' },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return '<button class="btn btn-primary btn-view" data-toggle="modal" data-target="#teamScheduleModal" data-name="' + full.hrd.name +
                                '" data-title="' + full.title +
                                '" data-task="' + full.task +
                                '" data-start-date="' + full.start_date +
                                '" data-end-date="' + full.end_date +

                                '">View</button>';
                        }
                    }
                ]
            });

            // Handle click event for the "View" button
            $('#teamschedule-table').on('click', '.btn-view', function () {
                var name = $(this).data('name');
                var title = $(this).data('title');
                var task = $(this).data('task');
                var startDate = $(this).data('start-date');
                var endDate = $(this).data('end-date');


                // Set modal content dynamically
                $('#modal-name').text(name);
                $('#modal-title').text(title);
                $('#modal-task').text(task);
                $('#modal-start-date').text(startDate);
                $('#modal-end-date').text(endDate);

            });
        });
    </script>

@endsection
