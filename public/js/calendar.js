$(document).ready(function () {
  $(".tambah").hide();
  cekAvailDosen();

  var calendar = $("#calendar").fullCalendar({
    height: "auto",
    header: {
      left: "prev,next today",
      center: "title",
      right: "month,agendaWeek,agendaDay,listWeek",
    },
    editable: true,
    events: "/penjadwalan/event",
    eventRender: function (event, element, view) {
      if (event.allDay === "true") {
        event.allDay = true;
      } else {
        event.allDay = false;
      }
    },
    timeFormat: "h:mm",
    selectable: true,
    selectHelper: true,
    select: function (start, end, allDay) {
      // var title = prompt("Event Title:");
      // if (title) {
      //   var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
      //   var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
      //   $.ajax({
      //     url: "/penjadwalan/eventAjax",
      //     data: {
      //       title: title,
      //       start: start,
      //       end: end,
      //       type: "add",
      //     },
      //     type: "POST",
      //     success: function (data) {
      //       displayMessage("Event Created Successfully");
      //       calendar.fullCalendar(
      //         "renderEvent",
      //         {
      //           id: data.id,
      //           title: title,
      //           start: start,
      //           end: end,
      //           allDay: allDay,
      //         },
      //         true
      //       );
      //       calendar.fullCalendar("unselect");
      //     },
      //   });
      // }
    },
    eventDrop: function (event, delta) {
      var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
      var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");

      $.ajax({
        url: "/penjadwalan/eventAjax",
        data: {
          title: event.title,
          start: start,
          end: end,
          id: event.id,
          type: "update",
        },
        type: "POST",
        success: function (response) {
          displayMessage("Event Updated Successfully");
        },
      });
    },
    eventClick: function (event) {
      var deleteMsg = confirm("Do you really want to delete?");
      if (deleteMsg) {
        $.ajax({
          type: "POST",
          url: "/penjadwalan/eventAjax",
          data: {
            id: event.id,
            type: "delete",
          },
          success: function (response) {
            calendar.fullCalendar("removeEvents", event.id);
            displayMessage("Event Deleted Successfully");
          },
        });
      }
    },
  });
});

let sesi;
let startDate;

$("#tambahPenjadwalan").fireModal({
  body: $(".tambah").html(),
  title: "Tambah " + $("#judul").text(),
  center: true,
  size: "modal-xl",
  closeButton: true,
  buttons: [
    {
      text: "Close",
      class: "btn btn-secondary btn-shadow",
      handler: function (modal) {
        modal.modal("hide");
      },
    },
    {
      text: "Save",
      submit: true,
      class: "btn btn-primary btn-shadow",
      handler: function (modal) {
        modal.click();
      },
    },
  ],
});

$("[name=sesi]").change(function () {
  sesi = $(this).val().split(",")[0];
  cekAvailDosen();
});

$("[name=startDate]").change(function () {
  startDate = $(this).val();
  cekAvailDosen();
});

function dateIsValid(date) {
  return date instanceof Date && !isNaN(date);
}

function cekAvailDosen() {
  console.log([sesi, startDate]);
  if (typeof sesi !== "undefined" && typeof startDate !== "undefined") {
    $.ajax({
      type: "POST",
      url: "/dosen/load",
      dataType: "json",
      data: {
        sesi: sesi,
        startDate: startDate,
      },
      beforeSend: function (e) {
        if (e && e.overrideMimeType) {
          e.overrideMimeType("application/json;charset=UTF-8");
        }
      },
      success: function (response) {
        let html = "";
        response.forEach((element) => {
          html +=
            '<option value="' +
            element.dosenEmailGeneral +
            '"> <strong>' +
            element.jumlahAmpu +
            "</strong> | " +
            element.dosenFullname +
            "</option>";
        });
        $('[name="dosen[]"]').empty();
        $('[name="dosen[]"]').append(html);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      },
    });
  }
}

function displayMessage(message) {
  toastr.danger(message, "Event");
}
