
  <!-- plugins:js -->
  <script src="{{asset('backend/assets/vendors/base/vendor.bundle.base.js')}}"></script>
  <!-- endinject -->

  <!-- Plugin js for this page-->
  <script src="{{asset('backend/assets/vendors/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('backend/assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
  <script src="{{asset('backend/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
  <!-- End plugin js for this page-->

  <!-- inject:js -->
  <script src="{{asset('backend/assets/js/off-canvas.js')}}"></script>
  <script src="{{asset('backend/assets/js/hoverable-collapse.js')}}"></script>
{{--  <script src="{{asset('backend/assets/js/template.js')}}"></script>--}}
  <!-- endinject -->

  <!-- Custom js for this page-->
  <script src="{{asset('backend/assets/js/dashboard.js')}}"></script>
  <script src="{{asset('backend/assets/js/data-table.js')}}"></script>
  <script src="{{asset('backend/assets/js/jquery.dataTables.js')}}"></script>
  <script src="{{asset('backend/assets/js/dataTables.bootstrap4.js')}}"></script>
  <!-- End custom js for this page-->

   <!-- summernote-->
   <script src="{{asset('backend/assets/summernote/summernote-bs4.js')}}"></script>


  <!-- slider button-->
  <script src="{{asset('backend/assets/switch-button-bootstrap/src/bootstrap-switch-button.js')}}"></script>

  @yield('scripts')

  <script>
      setTimeout(function () {
            $('#alert').slideUp();
      },4000)

  </script>

  <script>
      $(document).ready(function () {
          $('#dtBasicExample').DataTable();
          $('.dataTables_length').addClass('bs-select');
      });
  </script>

  <script>
      function currency_change(currency_code){
          $.ajax({
              type: 'post',
              url: '{{route('currency.load')}}',
              data:{
                  currency_code: currency_code,
                  _token: '{{csrf_token()}}',
              },
              success:function (response) {
                  if(response['status']){
                      location.reload();
                  }else{
                      alert('Server error');
                  }
              }
          });
      }
  </script>

