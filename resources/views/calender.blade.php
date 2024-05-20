<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Jquery CDN -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <!-- Moment Js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- Toast UI Calender -->
  <!-- <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" /> -->
  <!-- <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
  <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script> -->

  <!-- fullcalendar -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
  <script>

  </script>
  <title>Calender</title>
</head>

<body>

  <h1 class="display-6 text-center">Calender Events Management System</h1>
  <div id="displayMessage"></div>

  <!-- <div id="calendar" style="height: 800px"></div> -->
  <div id='calendar'></div>

  <!-- Add Event Modal -->
  <div class="modal fade" id="calendarAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Event</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="add_event_form" action="/api/calender/addEvent" method="post">
            @csrf
            <div class="img-container">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="title">Event Title</label>
                    <sup>*</sup>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter your event name" required>
                    <span class="invalid-feedback d-block"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="message-text" class="col-form-label">Description:</label>
                    <sup>*</sup>
                    <textarea class="form-control" name="description" id="description" required></textarea>
                    <span class="invalid-feedback d-block"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="start_date">Event start</label>
                    <sup>*</sup>
                    <input required type="date" name="start_date" id="start_date" class="form-control onlydatepicker" placeholder="Event start date">
                    <span class="invalid-feedback d-block"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="end_date">Event end</label>
                    <sup>*</sup>
                    <input required type="date" name="end_date" id="end_date" class="form-control" placeholder="Event end date">
                    <span class="invalid-feedback d-block"></span>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" id="add_event" class="btn btn-primary" value="Add Event">
        </div>
      </div>
    </div>
  </div>

  <!-- Display Event Modal -->
  <div class="modal fade" id="display_event" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="event_title">Event title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="event_description">This is description</p>
          <div class="d-flex justify-content-between">
            <span>Start: <p id="event_start">This is start</p></span>
            <span>End: <p id="event_end">This is end</p></span>
          </div>
        </div>
        <div class="modal-footer d-flex justify-content-between">
          <div>
            <button type="button" class="btn btn-info" data-bs-dismiss="modal">Close</button>
          </div>
          <div>
            <button type="button" class="btn btn-danger" data-bs-target="#delete_event_modal" data-bs-toggle="modal">Delete</button>
            <button type="button" class="btn btn-warning" data-bs-target="#edit_event_modal" data-bs-toggle="modal">Edit</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Event modal -->
  <!-- Modal -->
  <div class="modal fade" id="delete_event_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-top-right">
      <div class="modal-content text-center">
        <div class="modal-header bg-danger text-white d-flex justify-content-center">
          <h5 class="modal-title fs-5" id="exampleModalLabel"> Are you sure?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <i class="fas fa-times fa-3x text-danger">Do you want to delete this event ?</i>

        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-outline-danger" id="delete_event">Yes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Event Modal -->

  <div class="modal fade" id="edit_event_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Event</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="edit_event_form" action="/api/calender/EditEvent" method="post">
            @csrf
            <div class="img-container">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="title">Event Title</label>
                    <input required type="text" name="title" id="edit_title" class="form-control" placeholder="Edit your event name">
                    <span class="invalid-feedback d-block"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="message-text" class="col-form-label">Description:</label>
                    <textarea required class="form-control" name="description" id="edit_description" placeholder="Edit your description"></textarea>
                    <span class="invalid-feedback d-block"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="start_date">Event start</label>
                    <input required type="date" name="start_date" id="edit_start_date" class="form-control onlydatepicker" placeholder="Event start date">
                    <span class="invalid-feedback d-block"></span>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="end_date">Event end</label>
                    <input required type="date" name="end_date" id="edit_end_date" class="form-control" placeholder="Event end date">
                    <span class="invalid-feedback d-block"></span>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <input type="submit" id="edit_event" class="btn btn-primary" value="Edit Event">
        </div>
      </div>
    </div>
  </div>

  <!-- footer     -->
  <script src="/js/main.js"></script>
  <!-- <script src="{{ asset('/js/main.js') }}"></script> -->

</body>

</html>