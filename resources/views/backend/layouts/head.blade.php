
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>GG-Trade Admin</title>
  @php
      $setting = \App\Models\Settings::first();
  @endphp
  <link rel="icon" href="{{asset($setting->favicon)}}" type="image/x-icon">

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('backend/assets/vendors/mdi/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/assets/vendors/base/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="{{asset('backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
  <!-- End plugin css for this page -->

  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('backend/assets/css/style.css')}}">
  <!-- endinject -->

  <link rel="stylesheet" href="{{asset('backend/assets/summernote/summernote-bs4.css')}}">

  <link rel="stylesheet" href="{{asset('backend/assets/switch-button-bootstrap/css/bootstrap-switch-button.css')}}">
