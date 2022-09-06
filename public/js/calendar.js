$(document).ready(function() {
    $(".tambah").hide();
    $(".edit").hide();
    cekAvailDosen();
    $('.fc-goToCalendar-button, .fc-prev-button, .fc-next-button, .fc-nextYear-button, .fc-prevYear-button, .fc-month-button, .fc-agendaWeek-button, .fc-agendaDay-button, .fc-listWeek-button').addClass('btn-primary');

    $('.typeSesi').show();
    $('.typeManual').hide();
});

var calendar = $("#calendar").fullCalendar({
    height: "auto",
    header: {
        left: "prevYear,prev,next,nextYear today goToCalendar",
        center: "title",
        right: "month,agendaWeek,agendaDay,listWeek",
    },
    editable: true,
    events: "/penjadwalan/event",
    eventRender: function(event, element, view) {
        if (event.allDay === "true") {
            event.allDay = true;
        } else {
            event.allDay = false;
        }
        element.bind('click', function() {
            if (element.data('alreadyclicked')) {
                element.data('alreadyclicked', false);

                if (element.data('alreadyclickedTimeout')) {
                    clearTimeout(element.data('alreadyclickedTimeout'));
                }
                if ($('[name=role]').val() != 'biasa') {
                    var deleteMsg = confirm("Do you really want to delete?");
                    if (deleteMsg) {
                        hapusEvent(event.id, event);
                    }
                }
            } else {
                element.data('alreadyclicked', true);
                var alreadyclickedTimeout = setTimeout(function() {
                    element.data('alreadyclicked', false);
                    console.log('Was single clicked' + event.id);
                    $("#viewJadwal" + event.id).modal("show");
                }, 300);
                element.data('alreadyclickedTimeout', alreadyclickedTimeout);
            }
            return false;
        });
    },
    customButtons: {
        goToCalendar: {
            text: 'Google Calendar',
            click: function() {
                window.open("http://calendar.google.com", '_blank');
            }
        },
    },
    timeFormat: "h:mm",
    selectable: true,
    selectHelper: true,
    select: function(start, end, allDay) {
        const [date, time] = formatDate(new Date(start)).split(" ");
        // console.log(date+'T'+time);
        $('[name="startDate"]').val(date);
        $('[name="waktuStart"]').val(date + 'T' + time);
        $('[name="waktuEnd"]').val(date + 'T' + time);
        startDate = date;
        cekAvailDosen();
        $("#tambahJadwalDashboard").modal("show");
    },
    eventDrop: function(event, delta) {
        cekJadwalBentrok(event, delta, calendar);
    },
    loading: function(bool) {
        console.log('loading');
    },
    eventAfterAllRender: function(view) {
        console.log('loading dismiss');
    }
});

function cekJadwalBentrok(event, delta, calendar) {
    console.log(event);
    $.ajax({
        url: "/penjadwalan/cekBentrok",
        data: {
            interval: delta._days,
            id: event.id,
        },
        type: "POST",
        success: function(response) {
            if (JSON.parse(response).status) {
                ubahJdwl(event, delta);
            } else {
                calendar.fullCalendar("refetchEvents");
                displayMessageError(JSON.parse(response).message);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    });
}

function ubahJdwl(event, delta) {
    $.ajax({
        url: "/penjadwalan/eventAjax",
        data: {
            interval: delta._days,
            id: event.id,
            type: "update",
        },
        type: "POST",
        success: function(response) {
            displayMessage(event.title + " Updated Successfully");
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    });
}

function hapusEvent(id, title, from) {
    $.ajax({
        type: "POST",
        url: "/penjadwalan/eventAjax",
        data: {
            id: id,
            type: "delete",
        },
        success: function(response) {
            if (from == "penjadwalan") {
                window.location.replace("/penjadwalan");
                displayMessage(title + " Deleted Successfully");
            } else {
                calendar.fullCalendar("removeEvents", id);
                displayMessage(title + " Deleted Successfully");
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
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
        " " + [padTo2Digits(date.getHours()), padTo2Digits(date.getMinutes())].join(":")
    );
}

function padTo2Digits(num) {
    return num.toString().padStart(2, "0");
}

let sesi;
let startDate;
let waktuStart;
let jenis;
let angkatan;
let blok;

$("#tambahPenjadwalan").fireModal({
    body: $(".tambah").html(),
    title: "Tambah " + $("#judul").text(),
    center: true,
    size: "modal-xl",
    closeButton: true,
    buttons: [{
            text: "Close",
            class: "btn btn-secondary btn-shadow",
            handler: function(modal) {
                modal.modal("hide");
            },
        },
        {
            text: "Save",
            submit: true,
            class: "btn btn-primary btn-shadow",
            handler: function(modal) {
                modal.click();
            },
        },
    ],
});

$("[name=sesi]").change(function() {
    sesi = $(this).val().split(",")[0];
    cekAvailDosen();
});

$("[name=startDate]").change(function() {
    startDate = $(this).val();
    cekAvailDosen();
});

$("[name=waktuStart]").change(function() {
    startDate = $(this).val();
    cekAvailDosen();
});

$("[name=waktuEnd]").change(function() {
    startDate = $(this).val();
    cekAvailDosen();
});

$("[name=jenisJadwal]").change(function() {
    jenis = $(this).val();
    sesi = 19;
    getSesi(jenis);
    cekAvailDosen();
});

$("[name=blok]").change(function() {
    blok = $(this).val();
    cekAvailDosen();
});

$("[name=angkatan]").change(function() {
    angkatan = $(this).val();
    cekAvailDosen();
});

function getSesi(jenis) {
    let jenisJadwalId = jenis.split(',')[0];
    if (jenisJadwalId != 3) {
        $('.typeSesi').show();
        $('.typeManual').hide();
        collectSesi({
            jenisJadwal: jenisJadwalId,
            type: 'add',
            obj: $('[name=sesi]'),
            sesi: null
        });
    } else {
        $('.typeSesi').hide();
        $('.typeManual').show();
    }
}

function collectSesi({
    jenisJadwal = null,
    type = null,
    obj = null,
    sesi = null
} = {}) {
    $.ajax({
        type: "POST",
        url: "/sesi/getSesi",
        dataType: "json",
        data: {
            id: jenisJadwal,
        },
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            let html = "";
            html += '<option value="">Pilih Sesi</option>';

            response.forEach((element) => {
                let status = (element.sesiId == sesi) ? "selected" : ""
                html += '<option value="' + element.sesiId + ',' + element.sesiStart + ',' + element.sesiEnd + '" ' + status + '>' + element.sesiNama + ' (' + element.sesiStart + '-' + element.sesiEnd + ')</option>';
            });

            if (type = 'add') {
                obj.empty();
                obj.append(html);
            } else if (type = 'edit') {
                obj.empty();
                obj.append(html);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    });
}

function editJadwal(id) {
    let jenisJadwalId = $("#editPenjadwalan" + id).data('jenisjadwalid');
    if (jenisJadwalId != 3) {
        $(".typeManual").hide();
        $(".typeSesi").show();
        collectSesi({
            jenisJadwal: jenisJadwalId,
            type: 'edit',
            obj: $("#editPenjadwalan" + id).find("[name=sesi]"),
            sesi: $("#editPenjadwalan" + id).data('sesi')
        });
    } else {
        $(".typeManual").show();
        $(".typeSesi").hide();
    }

    sesi = $("#editPenjadwalan" + id).data('sesi');
    startDate = $("#editPenjadwalan" + id)
        .find("[name=startDate]")
        .val();
    jenis = $("#editPenjadwalan" + id).data('jenisjadwalid');
    blok = $("#editPenjadwalan" + id)
        .find("[name=blok]")
        .val();
    angkatan = $("#editPenjadwalan" + id)
        .find("[name=angkatan]")
        .val();
    cekAvailDosen({
        from: 'edit',
        id: id
    });
}

function duplikatJadwal(id) {
    let jenisJadwalId = $("#clonePenjadwalan" + id).data('jenisjadwalid');
    if (jenisJadwalId != 3) {
        $(".typeManual").hide();
        $(".typeSesi").show();
        collectSesi({
            jenisJadwal: jenisJadwalId,
            type: 'edit',
            obj: $("#clonePenjadwalan" + id).find("[name=sesi]"),
            sesi: $("#clonePenjadwalan" + id).data('sesi')
        });
    } else {
        $(".typeManual").show();
        $(".typeSesi").hide();
    }

    sesi = $("#clonePenjadwalan" + id).data('sesi');
    startDate = $("#clonePenjadwalan" + id)
        .find("[name=startDate]")
        .val();
    jenis = $("#clonePenjadwalan" + id).data('jenisjadwalid');
    blok = $("#clonePenjadwalan" + id)
        .find("[name=blok]")
        .val();
    angkatan = $("#clonePenjadwalan" + id)
        .find("[name=angkatan]")
        .val();
    cekAvailDosen({
        from: 'clone',
        id: id
    });
}

function dateIsValid(date) {
    return date instanceof Date && !isNaN(date);
}

function cekDosenSelect(id, result, from) {
    if (typeof sesi !== "undefined" && typeof startDate !== "undefined") {
        $.ajax({
            type: "POST",
            url: "/penjadwalan/select",
            dataType: "json",
            data: {
                id: id,
            },
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                // console.log([result, response]);
                let dosen = response;
                let html = "";
                result.forEach((element) => {
                    let selected = "";
                    selected = (dosen.includes(element.dosenEmailGeneral)) ? "selected" : "";
                    html +=
                        '<option value="' +
                        element.dosenSimakadId + ',' + element.dosenEmailGeneral +
                        '" ' +
                        selected +
                        "> <strong>" +
                        element.jumlahAmpu +
                        "</strong> | " +
                        element.dosenFullname +
                        "</option>";
                });
                if (from == 'edit') {
                    $("#editPenjadwalan" + id)
                        .find('[name="dosen[]"]')
                        .empty();
                    $("#editPenjadwalan" + id)
                        .find('[name="dosen[]"]')
                        .append(html);
                } else if (from == 'clone') {
                    $("#clonePenjadwalan" + id)
                        .find('[name="dosen[]"]')
                        .empty();
                    $("#clonePenjadwalan" + id)
                        .find('[name="dosen[]"]')
                        .append(html);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });
    }
}

function cekAvailDosen({
    from = null,
    id = null
} = {}) {
    console.log([sesi, startDate]);

    if (typeof sesi !== "undefined" && typeof startDate !== "undefined" && typeof jenis !== "undefined" && typeof angkatan !== "undefined" && typeof blok !== "undefined") {
        $.ajax({
            type: "POST",
            url: (id == null) ? "/dosen/load" : "/dosen/loadEdit",
            dataType: "json",
            data: {
                sesi: sesi,
                startDate: startDate,
                jenis: jenis,
                angkatan: angkatan,
                blok: blok,
            },
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                if (id == null) {
                    let html = "";
                    response.forEach((element) => {
                        html +=
                            '<option value="' +
                            element.dosenSimakadId + ',' + element.dosenEmailGeneral +
                            '"> <strong>' +
                            element.jumlahAmpu +
                            "</strong> | " +
                            element.dosenFullname +
                            "</option>";
                    });
                    $('[name="dosen[]"]').empty();
                    $('[name="dosen[]"]').append(html);
                } else {
                    cekDosenSelect(id, response, from);
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            },
        });
    }
}

function displayMessage(message) {
    iziToast.show({
        theme: "dark",
        icon: "fas fa-check",
        title: "Notification",
        message: message,
        position: "topRight",
        progressBarColor: "rgb(0, 255, 184)",
    });
}

function displayMessageError(message) {
    iziToast.show({
        theme: "dark",
        icon: "fas fa-times",
        title: "Error",
        message: message,
        position: "topRight",
        progressBarColor: "rgb(255, 0, 72)",
    });
}

function detailJadwal(id, calid) {
    let element = $("#viewJadwal" + id).find(".partisipan");
    getDataDetail(calid, element);
}

function getDataDetail(calid, element) {
    let stat = { "needsAction": "badge-info", "accepted": "badge-success", "declined": "badge-dangger", "tentative": "badge-warning" };
    $.ajax({
        type: "POST",
        url: "/penjadwalan/detail",
        dataType: "json",
        data: {
            calId: calid,
        },
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            console.log(response);
            let html = '';
            let status;
            response.forEach(data => {
                status = stat[data.responseStatus];
                html += '<li class="list-group-item d-flex justify-content-between align-items-center">';
                html += data.displayName+' - '+data.email;
                html += '<span class="badge '+ status +' badge-pill"> </span>';
                html += '</li>';
            });
            $('.jmlDosen').empty();
            $('.jmlDosen').append(response.length);
            element.empty();
            element.append(html);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        },
    });
}