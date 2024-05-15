$(document).ready(function () {
  // console.log("ready!");

  display_calender();
});

function display_calender() {

  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {

    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    timeZone: 'IST',// Asia/Kolkata
    events: 'api/calender/getEvents',
    // eventColor: '#378006',
    dateClick: function (info) {
      // console.log(info.dateStr);
      $('#calendarAddModal').modal("show");
      // document.getElementById("start_date").value = info.dateStr;
      $('#title').val('');
      $('#description').val('');
      $('#start_date').val(info.dateStr);
      $('#end_date').val(info.dateStr);

      $('#add_event').off().on('click', function (e) {
        e.preventDefault();

        const title = $('#title').val();
        const description = $('#description').val();
        const start_date = $('#start_date').val();
        const end_date = $('#end_date').val();
        // console.log(title, end_date, start_date, description);
        if (title !== '' && description !== '' && start_date !== '' && end_date !== '') {

          // console.log('not empty');
          addEvent();
        } else {
          // console.log(' empty');
          alert('Please submit all required field :) ');
        }
        return false;
      });

    },
    eventClick: function (info, jsEvent, view) {
      $('#display_event').modal("show");

      // Event Detail
      const id = info.event.id;
      const title = info.event.title;
      const start = info.event.start;
      const end = info.event.end ?? start;
      const description = info.event.extendedProps.description;
      const start_date = moment(start).format("Do MMM YYYY");
      // console.log(start_date);
      const end_date = moment(end).format("Do MMM YYYY");
      // console.log(info.event);

      // display in modal
      $('#event_title').text(title);
      $('#event_description').text(description);
      $('#event_start').text(start_date);
      $('#event_end').text(end_date);

      // Delete Event
      $('#delete_event').off().on('click', function (e) {
        e.preventDefault();
        // console.log('delete', info.event.id);
        deleteEvent(id);

        return false;
      });

      // Edit Event
      $('#edit_title').val(title);
      $('#edit_description').val(description);
      $('#edit_start_date').val(moment(start).format('YYYY-MM-DD'));
      $('#edit_end_date').val(moment(end).format('YYYY-MM-DD'));
      // $('#edit_end_date').val();
      // $('#edit_start_date').val('2024-05-08');
      // console.log(moment(info.event.start).format('L'));
      // $('#edit_end_date').val(info.event.end);

      $('#edit_event').off().on('click', function (e) {
        e.preventDefault();
        // console.log('Edit', info.event.id);
        // console.log(title);

        const title = $('#edit_title').val();
        const description = $('#edit_description').val();
        const start_date = $('#edit_start_date').val();
        const end_date = $('#edit_end_date').val();
        // console.log(title, end_date, start_date, description);
        if (title !== '' && description !== '' && start_date !== '' && end_date !== '') {
          // console.log('not empty');
          editEvent(id);
        } else {
          // console.log(' empty');
          alert('Please submit all required field :) ');
        }


        return false;
      });

    },
    eventDidMount: function (info) {
      // console.log(info.event.extendedProps);
      // {description: "Lecture", department: "BioChemistry"}
    },
    editable: true,

    eventResize: function (info) {
      // alert(info.event.title + " end is now " + info.event.end.toISOString());
      // info.revert();
      if (confirm("Press okay to revert back event size?")) {
        info.revert();
      }
    }


  });
  calendar.render();
}

function addEvent() {

  $.ajax({
    type: "POST",
    url: $('form#add_event_form').attr('action'),
    data: $('form#add_event_form').serialize(),
    success: function (response) {
      // alert(response);
      // console.log(response);
      $('#calendarAddModal').modal("hide");
      display_calender();
    },
    error: function () {
      alert('Error');
    }
  });
}

function deleteEvent(id) {

  $.ajax({
    type: 'POST',
    url: 'api/calender/deleteEvent/' + id,
    data: { id: id },
    success: function (response) {
      console.log(response);
      $('#display_event').modal("hide");
      $('#delete_event_modal').modal("hide");
      display_calender();
    },
    error: function () {
      alert('Error');
    }
  })
}

function editEvent(id) {

  $.ajax({
    type: "POST",
    url: $('form#edit_event_form').attr('action') + '/' + id,
    data: $('form#edit_event_form').serialize(),
    success: function (response) {
      console.log(response);

      $('#display_event').modal("hide");
      $('#edit_event_modal').modal("hide");
      display_calender();
      // display_calender();
    },
    error: function () {
      alert('Error');
    }
  });
}