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
  <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />

  <!-- fullcalendar -->
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

  <!-- CDN -->
  <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
  <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>


  <title>Calender</title>
</head>

<body>
  <h1 class="display-6 text-center">Calender Events Management System</h1>


  <!-- <div id="calendar" style="height: 800px"></div> -->
  <div id='calendar'></div>

  <div id="" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
          <h4 id="modalTitle" class="modal-title"></h4>
        </div>
        <div id="modalBody" class="modal-body"> </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
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
                    <input type="text" name="title" id="title" class="form-control" placeholder="Enter your event name">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <label for="message-text" class="col-form-label">Description:</label>
                    <textarea class="form-control" name="description" id="description"></textarea>

                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="start_date">Event start</label>
                    <input type="date" name="start_date" id="start_date" class="form-control onlydatepicker" placeholder="Event start date">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="end_date">Event end</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" placeholder="Event end date">
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

  <!-- Start popup dialog box -->
  <div class="modal fade" id="event_entry_modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Add New Event</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="img-container">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <label for="event_name">Event name</label>
                  <input type="text" name="event_name" id="event_name" class="form-control" placeholder="Enter your event name">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="event_start_date">Event start</label>
                  <input type="date" name="event_start_date" id="event_start_date" class="form-control onlydatepicker" placeholder="Event start date">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label for="event_end_date">Event end</label>
                  <input type="date" name="event_end_date" id="event_end_date" class="form-control" placeholder="Event end date">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="save_event()">Save Event</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End popup dialog box -->

  <div class="modal-dialog modal-frame modal-top">
    <div class="modal-content rounded-0">
      <div class="modal-body py-1">
        <div class="d-flex justify-content-center align-items-center my-3">
          <h4>
            <span class="badge bg-primary">v52gs1</span>
          </h4>
          <p class="pt-3 mx-4">
            We have a gift for you! Use this code to get a
            <strong>10% discount</strong>.
          </p>
          <button type="button" class="btn btn-primary btn-sm ms-2" data-mdb-ripple-init="">Use it</button>

          <button type="button" class="btn btn-info btn-sm ms-2" data-mdb-ripple-init="" data-mdb-dismiss="modal">
            No, thanks
          </button>
        </div>
      </div>
    </div>
  </div>

  <button type="button" class="btn btn-primary mb-2" data-mdb-ripple-init="" data-mdb-modal-init="" data-mdb-target="#exampleFrameModal1" style="">
    Top
  </button>

  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button> -->

  <!-- Modal -->
  <!-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
    <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    <div class="modal-dialog modal-frame modal-top">
      <div class="modal-content rounded-0">
        <div class="modal-body">
          <div class="d-flex justify-content-center align-items-center my-3">
            <h4>
              <span class="badge bg-primary">v52gs1</span>
            </h4>
            <p class="pt-3 mx-4">
              We have a gift for you! Use this code to get a
              <strong>10% discount</strong>.
            </p>
            <button type="button" class="btn btn-primary btn-sm ms-2" data-mdb-ripple-init="">Use it</button>

            <button type="button" class="btn btn-info btn-sm ms-2" data-mdb-ripple-init="" data-mdb-dismiss="modal">
              No, thanks
            </button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div> -->

  <!-- Display Event Modal -->

  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#display_event">
    Display Event
  </button>

  <!-- Modal -->
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
            <button type="button" class="btn btn-warning">Edit</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- delete modal -->

  <!-- Button trigger modal -->
  <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#delete_event">
    delete
  </button> -->

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

  <div class="modal-dialog modal-sm" id="delete_event">
    <div class="modal-content text-center">
      <div class="modal-header bg-danger text-white d-flex justify-content-center">
        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
      </div>
      <div class="modal-body">
        <i class="fas fa-times fa-3x text-danger"></i>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-danger" data-mdb-ripple-init="">No</button>
        <button type="button" class="btn btn-outline-danger" data-mdb-ripple-init="" data-mdb-dismiss="modal">
          Yes
        </button>
      </div>
    </div>
  </div>





  <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Modal 1</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Show a second modal and hide this one with the button below.
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">Open second modal</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalToggleLabel2">Modal 2</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Hide this modal and show the first with the button below.
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Back to first</button>
        </div>
      </div>
    </div>
  </div>
  <button class="btn btn-primary" data-bs-target="#exampleModalToggle" data-bs-toggle="modal">Open first modal</button>
  <!-- footer     -->
  <script src="/js/main.js"></script>
  <!-- <script src="{{ asset('/js/main.js') }}"></script> -->

</body>

</html>