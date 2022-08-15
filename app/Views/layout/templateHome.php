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

  <!--fullcalendar plugin files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />

  <!-- Template CSS -->
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/style.css">
  <link rel="stylesheet" href="<?= base_url() ?>/template/assets/css/components.css">


  <!-- for plugin notification -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
</head>


<body>

  <div id="app">
    <div class="main-wrapper">

      <?= $this->renderSection('content'); ?>

    </div>
  </div>
  <!-- General JS Scripts -->
  <?= script_tag('template/node_modules/jquery/dist/jquery.min.js') ?>
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
  <?= script_tag('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js') ?>
  <?= script_tag('template/node_modules/moment/min/moment.min.js') ?>
  <?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js") ?>
  <?= script_tag("https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js") ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <?= script_tag('template/node_modules/bootstrap/dist/js/bootstrap.min.js') ?>
  <?= script_tag('template/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js') ?>
  <?= script_tag('template/assets/js/stisla.js') ?>

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
  <?= script_tag('template/assets/js/page/modules-datatables.js') ?>

  <?= script_tag('js/calendar.js') ?>

  <script>

  </script>

</body>

</html>