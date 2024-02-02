@extends('template.main')
@section('content')
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">View/Update Event</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <input type="hidden" id="eventId">
              <div class="mb-3">
                  <label for="title" class="form-label">Event Title</label>
                  <input type="text" class="form-control" id="title" placeholder="Event Title">
                  <span id="titleError" class="text-danger"></span>
              </div>


              <div class="mb-3">
                  <label for="province" class="form-label">Province</label>
                  <select class="form-control" id="province">
                    <option value="1">Province 1</option>
                    <option value="2">Province 2</option>
                    <!-- Add more options as needed -->
                </select>

              </div>
              <div class="mb-3">
                  <label for="rs" class="form-label">RS</label>
                  <select class="form-control" id="rs">
                      <option value="1">RS 1</option>
                      <option value="2">RS 2</option>
                      <!-- Add more options as needed -->
                  </select>
              </div>
              <div class="mb-3">
                  <label for="department" class="form-label">Department</label>
                  <select class="form-control" id="department">
                      <option value="1">Department 1</option>
                      <option value="2">Department 2</option>
                      <!-- Add more options as needed -->
                  </select>
              </div>
              <div class="mb-3">
                  <label for="task" class="form-label">Task</label>
                  <input type="text" class="form-control" id="task" placeholder="Task">
              </div>
              <div class="mb-3">
                  <label for="startDate" class="form-label">Start Date</label>
                  <input type="datetime-local" class="form-control" id="startDate" placeholder="Start Date">
              </div>
              <div class="mb-3">
                  <label for="endDate" class="form-label">End Date</label>
                  <input type="datetime-local" class="form-control" id="endDate" placeholder="End Date">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" id="updateBtn" class="btn btn-primary">Update Event</button>
          </div>
      </div>
  </div>
</div>

<!-- Colab Button -->
<div class="col-md-12 mb-4">
<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
  Create Schedule
</button>

</div>


<!-- Create Event Form Container -->
<div class="col-md-11 offset-1 mt-5 mb-5">
    <div class="row border p-4 mb-4 collapse" id="collapseExample" >
        <div class="col-md-12 text-center mb-4">
            <h4>Create Schedule</h4>
        </div>
        <div class="col-md-6">
        <div class="mb-3">
            <form id="createEventForm">
              <div class="form-group">
                <label for="hrd_id">Nama Karyawan</label>
                <select name="hrd_id" id="hrd_id" class="form-control">
                    <option value="">Pilih Karyawan</option>
                    @foreach ($data as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('hrd_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
                <div class="mb-3">
                    <label for="createTitle" class="form-label">Event Title</label>
                    <input type="text" class="form-control" id="createTitle" placeholder="Event Title">
                    <span id="createTitleError" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="createStartDate" class="form-label">Start Date</label>
                    <input type="datetime-local" class="form-control" id="createStartDate" placeholder="Start Date">
                </div>
                <div class="mb-3">
                    <label for="createEndDate" class="form-label">End Date</label>
                    <input type="datetime-local" class="form-control" id="createEndDate" placeholder="End Date">
                </div>
            </form>
        </div>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="jobtitle" class="form-label">jobtitle</label>
            <input type="text" class="form-control" id="jobtitle" readonly>

        </div>

            <div class="mb-3">
                <label for="createProvince" class="form-label">Province</label>
                <br>
                <select class="form-control" id="createProvince">
                    <option value="1">Province 1</option>
                    <option value="2">Province 2</option>
                    <!-- Add more options as needed -->
                </select>
            </div>

            <div class="mb-3">
                <label for="createRs" class="form-label">RS</label>
                <br>
                <select class="form-control" id="createRs">
                    <option value="1">RS 1</option>
                    <option value="2">RS 2</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
            <div class="mb-3">
                <label for="createDepartment" class="form-label">Department</label>
                <br>
                <select class="form-control" id="createDepartment">
                    <option value="1">Department 1</option>
                    <option value="2">Department 2</option>
                    <!-- Add more options as needed -->
                </select>
            </div>
        </div>
        <div class="col-md-12 text-center mb-4">
            <label for="createTask" class="form-label">Task</label>
            <input type="text" class="form-control" id="createTask" placeholder="Task" style="height: 50px;">
        </div>
        <div class="col-md-12 text-center mb-4">
            <button type="button" id="createBtn" class="btn btn-primary">Create</button>
        </div>
    </div>
</div>

<div class="row">
    <!-- Calendar Container -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Event Calendar</h5>
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Schedule List Container -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Schedule List</h5>


              <!-- Schedule List -->
              <ul id="scheduleList" class="list-group mt-4">
                  <!-- Event items will be dynamically added here -->
              </ul>
            </div>
        </div>
    </div>

</div>

<!-- Your existing JavaScript code here... -->


<script>
  $(document).ready(function () {

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });



      var booking = @json($events);

      $('#calendar').fullCalendar({
          header: {
              left: 'prev, next today',
              center: 'title',
              right: 'month,listWeek',
          },
          buttonText: {
            month : 'Schedule Month',
            listWeek : 'Schedule Week',
          },

          events: booking,
          selectable: true,
          selectHelper: true,
          editable: true, // Enable drag and drop
          eventResize: function (event, delta, revertFunc) {
              handleEventResize(event, delta, revertFunc);
          },
          eventDrop: function (event) {
              handleEventDrop(event);
          },

          eventClick: function (event) {

          },
          eventAfterRender: function (event, element, view) {
    if (view.name === 'listWeek') {
        // If the current view is listWeek, update the event content
        element.find('.fc-list-item-title').html("<strong>" + event.task + "</strong><br/>Nama: " + event.name);
    }
},
          // Other calendar options...

          eventClick: function (event) {
        // When an event is clicked, fetch its details from the server
        $.ajax({
            url: "{{ route('events.show', '') }}" + '/' + event.id,
            type: "GET",
            success: function (response) {
                // Open the modal and populate it with the event details
                openEventModal(response);
            },
            error: function (error) {
                console.log(error);
                swal("Error", "Failed to fetch event details", "error");
            },
        });

    },
      });




      // Function to handle event drop (drag and drop)
      function handleEventDrop(event) {
  var id = event.id;
  var title = event.title;  // Add this line to get the title of the dropped event
 var rs = event.rs;
 var hrd_id = event.hrd_id;

 var province = event.province;
 var department = event.department;
 var task = event.task;

  var start_date = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
  var end_date = moment(event.end).format('YYYY-MM-DD HH:mm:ss');

  $.ajax({
      url: "{{ route('events.update', '') }}" + '/' + id,
      type: "PATCH",
      dataType: 'json',
      data: {
          id: id,
          title: title,  // Include the title in the data
          province: province,
      rs: rs,
      department: department,
      task: task,
          start_date: start_date,
          end_date: end_date
      },
      success: function (response) {
        Swal.fire({
                      icon: 'success',
                      title: 'Data Sudah Terupdate',
                      text: 'Terimakasih',
                  });
      },
      error: function (error) {
          console.log(error);

          // Revert the event if there's an error
          $('#calendar').fullCalendar('refetchEvents');

          swal("Error", "Failed to update event", "error");
      },
  });
}
function fetchScheduleList() {
    $.ajax({
        url: "{{ route('schedule.list') }}",
        type: "GET",
        success: function (response) {
            updateScheduleList(response);
        },
        error: function (error) {
            console.log(error);
        },
    });
}
fetchScheduleList();
function updateScheduleList(events) {
    $('#scheduleList').empty();

    var maxTasksToShow = 5; // Set the maximum number of tasks to display
    var taskCount = 0;

    events.forEach(function (event) {
        if (taskCount < maxTasksToShow) {
            var name = event.hrd_name; // Use hrd_name instead of hrd_id
            var task = event.task;
            var startDate = event.start_date;
            var endDate = event.end_date;

            var listItem = '<li class="list-group-item">';
            listItem += '<strong>' + name + '</strong>: <span style="color: blue;">' + task + '</span>';
            listItem += '<br>Start Date: ' + startDate;
            listItem += '<br>End Date: ' + endDate;
            listItem += '</li>';

            $('#scheduleList').append(listItem);
            taskCount++;
        }
    });

    // Add a "Load More" button if there are additional tasks
    if (events.length > maxTasksToShow) {
        var remainingTasks = events.length - maxTasksToShow;
        var moreTasksButton = '<li class="list-group-item text-center">' +
            '<button id="loadMoreBtn" class="btn btn-primary">Load More (' + remainingTasks + ' tasks)</button>' +
            '</li>';
        $('#scheduleList').append(moreTasksButton);

        // Event handler for the "Load More" button
        $('#loadMoreBtn').click(function () {
            // Remove the "Load More" button
            $('#loadMoreBtn').remove();

            // Display the remaining tasks
            events.slice(maxTasksToShow).forEach(function (event) {
                var name = event.hrd_name; // Use hrd_name instead of hrd_id
                var task = event.task;
                var startDate = event.start_date;
                var endDate = event.end_date;

                var listItem = '<li class="list-group-item">';
                listItem += '<strong>' + name + '</strong>: <span style="color: blue;">' + task + '</span>';
                listItem += '<br>Start Date: ' + startDate;
                listItem += '<br>End Date: ' + endDate;
                listItem += '</li>';

                $('#scheduleList').append(listItem);
            });
        });
    }

    // Add styles to make the list scrollable
    $('#scheduleList').css({
        'max-height': '600px',  // Set the maximum height for the list
        'overflow-y': 'auto'    // Add vertical scrollbar if needed
    });
}



function fetchJobTitle(employeeId) {
    $.ajax({
        url: "{{ route('events.getJobTitle') }}",
        type: "GET",
        data: { hrd_id: employeeId },
        success: function (response) {
            $('#jobtitle').val(response.jobtitle);

        },
        error: function (error) {
            console.log(error);
        },
    });
}

// Call fetchJobTitle on page load if hrd_id has a selected value
var initialEmployeeId = $('#hrd_id').val();
if (initialEmployeeId) {
    fetchJobTitle(initialEmployeeId);
}

// Event handler for hrd_id change
$('#hrd_id').change(function () {
    var employeeId = $(this).val();
    if (employeeId) {
        fetchJobTitle(employeeId);
    }
});


      // Function to open event modal for viewing/updating
      function openEventModal(event) {
    $('#eventId').val(event.id);

    $('#title').val(event.title);
   $('#province').val(event.province);
    $('#rs').val(event.rs);
    $('#department').val(event.department);
     $('#task').val(event.task);
    $('#startDate').val(moment(event.start_date).format('YYYY-MM-DDTHH:mm:ss'));
    $('#endDate').val(moment(event.end_date).format('YYYY-MM-DDTHH:mm:ss'));

    $('#eventModal').modal('toggle');
}

      // Function to handle modal close and update event
      $('#updateBtn').click(function () {
          var id = $('#eventId').val();
          var title = $('#title').val();
          var province = $('#province').val();
          var rs = $('#rs').val();
          var department = $('#department').val();
          var task = $('#task').val();
          var startDate = moment($('#startDate').val()).format('YYYY-MM-DD HH:mm:ss');
          var endDate = moment($('#endDate').val()).format('YYYY-MM-DD HH:mm:ss');


          var eventData = {
      title: title,
      province: province,
      rs: rs,
      department: department,
      task: task,
      start_date: startDate,
      end_date: endDate
  };
          $.ajax({
              url: "{{ route('events.update', '') }}" + '/' + id,
              type: "PATCH",
              dataType: 'json',
              data: eventData,
              success: function (response) {
                  $('#eventModal').modal('hide');
                  Swal.fire({
                      icon: 'success',
                      title: 'Data Sudah Terupdate',
                      text: 'Terimakasih',
                  });
              },
              error: function (error) {
                  if (error.responseJSON.errors) {
                      $('#titleError').html(error.responseJSON.errors.title);
                  }
              },
          });
      });

      $('#createBtn').click(function () {
    var createTitle = $('#createTitle').val();
    var hrdId = $('#hrd_id option:selected').val();
    var jobTitle = $('#jobtitle').val();
    var createProvince = $('#createProvince').val();
    var createRs = $('#createRs').val();
    var createDepartment = $('#createDepartment').val();
    var createTask = $('#createTask').val();

    var createStartDate = moment($('#createStartDate').val()).format('YYYY-MM-DD HH:mm:ss');
    var createEndDate = moment($('#createEndDate').val()).format('YYYY-MM-DD HH:mm:ss');

    var createEventData = {
        title: createTitle,
        hrd_id: hrdId,
        jobtitle: jobTitle,
        province: createProvince,
        rs: createRs,
        department: createDepartment,
        task: createTask,
        start_date: createStartDate,
        end_date: createEndDate
    };

    $.ajax({
        url: "{{ route('events.store') }}",
        type: "POST",
        dataType: 'json',
        data: createEventData,
        success: function (response) {
            // Handle success (if needed)
            console.log(response);
            $('#calendar').fullCalendar('refetchEvents');
            $('#createEventForm')[0].reset();

            Swal.fire({
                icon: 'success',
                title: 'Event Created Successfully',
                text: 'Terimakasih',
            }).then((result) => {
                // Check if the user clicked "OK"
                if (result.isConfirmed || result.isDismissed) {
                    // Reload the entire page
                    location.reload();
                }
            });
        },
        error: function (error) {
            // Handle error (if needed)
            console.log(error);
        },
    });
});


  });
</script>


@endsection
