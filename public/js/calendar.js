$(document).ready(function () {
  $(".tambah").hide();
  cekAvailDosen();
});

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
    const [date, time] = formatDate(new Date(start)).split(" ");
    $('[name="startDate"]').val(date);
    startDate = date;
    cekAvailDosen();
    $("#myModal").modal("show");
  },
  eventDrop: function (event, delta) {
    $.ajax({
      url: "/penjadwalan/eventAjax",
      data: {
        interval: delta._days,
        id: event.id,
        type: "update",
      },
      type: "POST",
      success: function (response) {
        displayMessage(event.title + " Updated Successfully");
      },
      error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
      },
    });
  },
  eventClick: function (event) {
    // console.log(event);
    var deleteMsg = confirm("Do you really want to delete?");
    if (deleteMsg) {
      hapusEvent(event.id, event);
    }
  },
});

function hapusEvent(id, title, from) {
  $.ajax({
    type: "POST",
    url: "/penjadwalan/eventAjax",
    data: {
      id: id,
      type: "delete",
    },
    success: function (response) {
      if (from == "penjadwalan") {
        window.location.replace("/penjadwalan");
      } else {
        calendar.fullCalendar("removeEvents", id);
        displayMessage(title + " Deleted Successfully");
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
      alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
    },
  });
}

function formatDate(date) {
  return (
    [
      date.getFullYear(),
      padTo2Digits(date.getMonth() + 1),
      padTo2Digits(date.getDate()),
    ].join("-") +
    " " +
    [padTo2Digits(date.getHours()), padTo2Digits(date.getMinutes())].join(":")
  );
}

function padTo2Digits(num) {
  return num.toString().padStart(2, "0");
}

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
  // toastr.success(message, "Notification");
  iziToast.show({
    theme: "dark",
    icon: "fas fa-check",
    title: "Notification",
    message: message,
    position: "topRight",
    progressBarColor: "rgb(0, 255, 184)",
  });
}
