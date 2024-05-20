$(document).ready(function () {
  // console.log("ready!");

  display_calender();
});

function display_calender() {

  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {

    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'prevYear,prev,next,nextYear today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },
    timeZone: 'IST',// Asia/Kolkata
    events: 'api/calender/getEvents',
    eventColor: '#378006',
    // eventColor: '#378006',
    dateClick: function (info) {
      // console.log(info.dateStr);
      $('#calendarAddModal').modal("show");
      $('#title').val('');
      $('#description').val('');
      $('#start_date').val(info.dateStr);
      $('#end_date').val(info.dateStr);

      // remove all previous error
      $('input').removeClass('is-invalid is-valid');
      $('textarea').removeClass('is-invalid is-valid');
      $('.invalid-feedback').text('');

      $('#add_event').off().on('click', function (e) {
        e.preventDefault();
        const isValidForm = customValid($("#add_event_form"))
        console.log(isValidForm);

        if (isValidForm) {
          addEvent();
          displayMessage('Event added successfully :)', 'success')
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
        displayMessage('Event Deleted Successfully ! ', 'danger')
        return false;
      });

      // Edit Event default value
      $('#edit_title').val(title);
      $('#edit_description').val(description);
      $('#edit_start_date').val(moment(start).format('YYYY-MM-DD'));
      $('#edit_end_date').val(moment(end).format('YYYY-MM-DD'));

      $('#edit_event').off().on('click', function (e) {
        e.preventDefault();
        // console.log('Edit', info.event.id);
        const isValidForm = customValid($("#edit_event_form"))
        // console.log(isValidForm);
        if (isValidForm) {
          editEvent(id);
          displayMessage('Event updated successfully :)', 'warning')
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


function customValid(form) {
  // find all the input fields
  // loop and check if the input fields has required and max min attr
  // depending on the attribute add condition and list the error message
  // find the parent div and append the error message with proper class
  // Also change the input class
  // If all the validatioin is success then return True
  // else return False
  const inputs = form.find('input, textarea');
  let isValid = true;

  inputs.each((indx, input) => {
    const error = []
    const $input = $(input)
    if ($input.attr('required') && $input.val() === '') {
      error.push('This field is required !!!')
    }
    if ($input.attr('min') && $input.val() < $input.attr('min')) {
      error.push('This field must be greater than' + $input.attr('min'))
    }
    if ($input.attr('max') && $input.val() > $input.attr('max')) {
      error.push('This field must be less than' + $input.attr('max'))
    }

    if (error.length > 0) {
      $input.addClass('is-invalid')
      $input.parent().find('.invalid-feedback').text(error.join(', '))
      isValid = false;
    } else {
      $input.removeClass('is-invalid').addClass('is-valid')
      $input.parent().find('.invalid-feedback').text('')
      // isValid = true;
    }
    // console.log(error);
  })
  return isValid;
}

function displayMessage(message, type) {
  const messageElement = $('#displayMessage');
  const alert =
    `
    <div class='alert alert-${type} alert-dismissible' role='alert'>
      <div>${message}</div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  `;

  messageElement.html(alert);
  setTimeout(() => {
    messageElement.html('');
    // console.log('timer');
  }, 5000);

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
      // console.log(response);
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
      // console.log(response);

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