<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $title . " | " . lang('Auth.appName'); ?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/@fortawesome/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/@fortawesome/fontawesome-free/css/all.css">
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/selectric/public/selectric.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/summernote/dist/summernote-bs4.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/node_modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/components.css">
</head>


<body>

  <div id="app">
    <div class="main-wrapper">

      <?= $this->renderSection('content'); ?>

    </div>
  </div>
  <!-- General JS Scripts -->
  <?= script_tag('template/node_modules/jquery/dist/jquery.min.js') ?>
  <?= script_tag('https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js') ?>
  <?= script_tag('template/node_modules/bootstrap/dist/js/bootstrap.min.js') ?>
  <?= script_tag('template/node_modules/moment/min/moment.min.js') ?>
  <?= script_tag('template/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js') ?>
  <?= script_tag('template/assets/js/stisla.js') ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

  <!-- JS Libraies -->
  <?= script_tag('template/node_modules/datatables/media/js/jquery.dataTables.min.js') ?>
  <?= script_tag('template/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') ?>
  <?= script_tag('template/node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js') ?>
  <?= script_tag('template/node_modules/select2/dist/js/select2.full.min.js') ?>
  <?= script_tag('template/node_modules/bootstrap-daterangepicker/daterangepicker.js') ?>
  <?= script_tag('template/node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') ?>
  <?= script_tag('template/node_modules/selectric/public/jquery.selectric.min.js') ?>
  <?= script_tag('template/node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') ?>
  <?= script_tag('template/node_modules/cleave.js/dist/cleave.min.js') ?>
  <?= script_tag('template/node_modules/cleave.js/dist/addons/cleave-phone.us.js') ?>
  <?= script_tag('template/node_modules/summernote/dist/summernote-bs4.js') ?>

  <!-- Template JS File -->
  <?= script_tag('template/assets/js/scripts.js') ?>
  <?= script_tag('https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js') ?>

  <!-- Page Specific JS File -->
  <?= script_tag('template/assets/js/page/forms-advanced-forms.js') ?>
  <?= script_tag('template/assets/js/page/module-datatables.js') ?>

  <script>
    var site_url = "<?= site_url() ?>";
  </script>
  <?= script_tag('js/calendar.js') ?>

  <script>
    $(document).ready(function() {
      $('.tambah').hide();
      cekAvailDosen();
    });

    let sesi;
    let startDate;

    $("#tambahPenjadwalan").fireModal({
      body: $('.tambah').html(),
      title: 'Tambah ' + $('#judul').text(),
      center: true,
      size: 'modal-xl',
      closeButton: true,
      buttons: [{
        text: 'Close',
        class: 'btn btn-secondary btn-shadow',
        handler: function(modal) {
          modal.modal('hide');
        }
      }, {
        text: 'Save',
        submit: true,
        class: 'btn btn-primary btn-shadow',
        handler: function(modal) {
          modal.click();
        }
      }]
    });

    $('[name=sesi]').change(function() {
      sesi = $(this).val().split(',')[0];
      cekAvailDosen();
    });

    $('[name=startDate]').change(function() {
      startDate = $(this).val();
      cekAvailDosen();
    });

    function dateIsValid(date) {
      return date instanceof Date && !isNaN(date);
    }

    function cekAvailDosen() {
      console.log([sesi, startDate]);
      if (typeof sesi !== 'undefined' && typeof startDate !== 'undefined') {
        $.ajax({
          type: 'POST',
          url: '/dosen/load',
          dataType: "json",
          data: {
            sesi: sesi,
            startDate: startDate,
          },
          beforeSend: function(e) {
            if (e && e.overrideMimeType) {
              e.overrideMimeType("application/json;charset=UTF-8");
            }
          },
          success: function(response) {
            let html = '';
            response.forEach(element => {
              html += '<option value="' + element.dosenEmailGeneral + '" > <strong>' + element.jumlahAmpu + '</strong> | ' + element.dosenFullname + '</option>';
            });
            $('[name="dosen[]"]').empty();
            $('[name="dosen[]"]').append(html);
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
          }
        });
      }
    }
  </script>

</body>

</html>