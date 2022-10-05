<!DOCTYPE html>
<html lang="en">
<head>
      @include('backend.layouts.head')
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">

           @include('backend.layouts.nav')
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
     
             @include('backend.layouts.sidebar')

      </nav>  

          @yield('content')


    <!-- partial:partials/_footer.html -->
      <footer class="footer">
        @include('backend.layouts.footer')

      </footer>
      <!-- partial -->

      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

@include('backend.layouts.script')
</body>

</html>

