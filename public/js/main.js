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
      console.log(info);
      $('#calendarAddModal').modal("show");
      // document.getElementById("start_date").value = info.dateStr;
      $('#title').val('');
      $('#description').val('');
      $('#start_date').val(info.dateStr);
      $('#end_date').val(info.dateStr);

      $('#add_event').off().on('click', function (e) {
        e.preventDefault();
        console.log('cliccked');
        addEvent();
        return false;
      });

    },
    eventClick: function (info, jsEvent, view) {
      $('#display_event').modal("show");

      // Event Detail
      const title = info.event.title;
      const description = info.event.extendedProps.description;
      const start_date = moment(info.event.start).format("Do MMM YYYY");
      const end_date = info.event.end ? moment(info.event.end).format("Do MMM YYYY") : start_date;
      // console.log(info.event);

      // display in modal
      $('#event_title').text(title);
      $('#event_description').text(description);
      $('#event_start').text(start_date);
      $('#event_end').text(end_date);

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
      console.log(response);
      $('#calendarAddModal').modal("hide");
      display_calender();
    },
    error: function () {
      alert('Error');
    }
  });
}