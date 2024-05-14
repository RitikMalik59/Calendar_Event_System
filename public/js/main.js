$(document).ready(function () {
  // console.log("ready!");

  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {

    initialView: 'dayGridMonth',
    timeZone: 'UTC',
    events: 'api/calender/getEvents',
    eventDidMount: function (info) {
      console.log(info.event.extendedProps);
      // {description: "Lecture", department: "BioChemistry"}
    },
    editable: true,

    eventResize: function (info) {
      alert(info.event.title + " end is now " + info.event.end.toISOString());
      // info.revert();
      if (!confirm("is this okay?")) {
        info.revert();
      }
    }


  });
  calendar.render();
});