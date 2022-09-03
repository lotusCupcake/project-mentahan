function checklistTentatif(value) {
    let dosen;
    let sesi;
    let hari;
    let ta;
    dosen = value.split(',')[0];
    sesi = value.split(',')[1];
    hari = value.split(',')[2];
    ta = $('[name=jadwalTentatifTahunAjaran]').val();

    let arrayhari = [];
    $("input:checkbox[data-dosen=" + dosen + "]:checked").each(function() {
        arrayhari.push({
            "sesi": $(this).val().split(',')[0],
            "hari": $(this).val().split(',')[1]
        });
    });

    const mapById = arrayhari.reduce((data, {
        sesi,
        hari,
    }) => {
        data[sesi] = {
            sesi,
            hari: ((data[sesi] ? data[sesi].hari + "," : "") + `${hari}`).split(',')
        }
        return data;
    }, {})

    const resultArray = Object.values(mapById);
    let jadwal = JSON.stringify({ "data": resultArray });
    let data = { dosen: dosen, ta: ta, jadwal: jadwal }
    saveTentatif(data);
}

function saveTentatif(params) {
    $.ajax({
        type: "POST",
        url: "/tentatif/tambah",
        data: {
            dosen: params['dosen'],
            ta: params['ta'],
            jadwal: params['jadwal']
        },
        success: function(response) {
            if (JSON.parse(response).status) {
                displayMessage(JSON.parse(response).message);
            } else {
                displayMessageError(JSON.parse(response).message);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    })
};