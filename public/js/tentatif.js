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
    $("input:checkbox[data-dosen=" + dosen + "]:checked").each(function () {
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
    console.log([dosen, ta, JSON.stringify({ "data": resultArray })]);
}