    var myUrl = window.location.href;
    var base_url = myUrl.split('?')[0];

    function tahunAjaran() {
        addQSParm('ta', $("[name='tahunAjaran']").val());
        window.location.replace(myUrl);
    }

    function checklistTentatif(value) {
        let dosen;
        let sesi;
        let hari;
        let ta;
        dosen = value.split(',')[0];
        sesi = value.split(',')[1];
        hari = value.split(',')[2];
        jenis = value.split(',')[3];
        ta = $('[name=jadwalTentatifTahunAjaran]').val();

        let arrayhari = [];
        $("input:checkbox[data-dosen=" + dosen + "]:checked").each(function() {
            arrayhari.push({
                "sesi": $(this).val().split(',')[0],
                "hari": $(this).val().split(',')[1],
                "jenis": $(this).val().split(',')[2]
            });
        });

        const mapById = arrayhari.reduce((data, {
            sesi,
            hari,
            jenis,
        }) => {
            data[jenis] = {
                jenis,
                sesi: ((data[jenis] ? data[jenis].sesi + "," : "") + `${sesi}`).split(','),
                hari: ((data[jenis] ? data[jenis].hari + "," : "") + `${hari}`).split(','),
            }
            return data;
        }, {});

        const resultArray = Object.values(mapById);

        let genNewArray = [];
        resultArray.forEach(element => {
            let jenisJadwal = element.jenis;
            uniqsesi = [...new Set(element.sesi)];
            uniqsesi.forEach(seloro => {
                genNewArray.push({ 'jenis': jenisJadwal, 'sesi': seloro, 'hari': getIndex(element.sesi, element.hari, seloro) });
            });

        });

        let jadwal = JSON.stringify({ "data": genNewArray });

        let data = { dosen: dosen, ta: ta, jadwal: jadwal }
        saveTentatif(data);
    }

    function getIndex(arr, arr2, search) {
        var dataset = arr;
        var results = [];

        var ind

        // the while loop stops when there are no more found
        while ((ind = dataset.indexOf(search)) != -1) {
            results.push(ind + results.length)
            dataset.splice(ind, 1)
        }

        let res = [];
        results.forEach(element => {
            res.push(arr2[element]);
        });

        return res;
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

    function addQSParm(name, value) {
        var re = new RegExp("([?&]" + name + "=)[^&]+", "");

        function add(sep) {
            myUrl += sep + name + "=" + encodeURIComponent(value);
        }

        function change(nama, value) {
            var forMaintenance = new URLSearchParams(window.location.search);
            $urlke = 1;
            if (value == "") {
                forMaintenance.delete(nama);
            }

            for (const [k, v] of forMaintenance) {
                if (nama == k && v == value) {
                    if ($urlke == 1) {
                        base_url += "?" + k + "=" + encodeURIComponent(v);
                    } else {
                        base_url += "&" + k + "=" + encodeURIComponent(v);
                    }
                } else if (nama == k && v != value) {
                    if ($urlke == 1) {
                        base_url += "?" + k + "=" + encodeURIComponent(value);
                    } else {
                        base_url += "&" + k + "=" + encodeURIComponent(value);
                    }
                } else if (nama != k && v != value) {
                    if ($urlke == 1) {
                        base_url += "?" + k + "=" + encodeURIComponent(v);
                    } else {
                        base_url += "&" + k + "=" + encodeURIComponent(v);
                    }
                }
                $urlke++;
            }

            myUrl = base_url;
        }


        if (myUrl.indexOf("?") === -1) {
            add("?");
        } else {
            if (re.test(myUrl)) {
                change(name, value);
            } else {
                add("&");
            }
        }

    }