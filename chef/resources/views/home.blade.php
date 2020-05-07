<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8"> 
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SH | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
<script type="text/javascript">var baseUrl = window.location.protocol + "//" +window.location.host + "/" + window.location.pathname.split('/')[1];

  let searchParams = new URLSearchParams(window.location.search);
  let param = searchParams.get('token');
if (searchParams.get('token') == null) {
param="{{$token ?? 'null'}}";
}  
</script>


<!-- @if(isset($token))
<script type="text/javascript">
  let param1 = searchParams.get('token');
  if(param1==null)
window.location.href=window.location.href+"?token={{$token}}";
</script>
@else
<script type="text/javascript">alert("here else");</script>
@endif -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
 
<link rel="stylesheet" type="text/css" href="/css/chef.css">
<script src="/plugins/jquery/jquery.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/home?token=<?php if(isset($_GET['token'])) echo $_GET['token']?>" class="nav-link">Home</a>
        <input type="hidden" name="token" id="tokenHolder">
      </li>
<!--       <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> -->
    </ul>
<div class=" col-sm-8"></div>
    <!-- SEARCH FORM -->
    <form class="form ml-3" dir="rtl">
      <div class="input-group input-group-sm" style="  position:relative;
  overflow:auto;">
        <input class="form-control form-control-navbar" type="search" placeholder="بحث" aria-label="Search" id="searchInput" onkeyup="getResults(this.value)">
        <div class="input-group-append">
<!--           <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button> -->
        </div>
        <div id="livesearch" style="direction: rtl;text-align:right;"></div>
      </div>
    </form>

       <script type="text/javascript">
      function getResults(SI){
        if (SI.length>2) {
               jQuery.ajax({
                  url: "/api/search",
                  method: 'get',
                  data: {
                     "param": SI,
                  },
                  success: function(result){ 
$("#livesearch").empty();

for (var i = 0; i < result['data'].length; i++) {
    var obj = result['data'][i];
  $("#livesearch").append('<div id="'+obj['id']+'" style="display:inline"></div>');

$("#"+obj['id']).
append('<div class="d-inline p-2  text-white"><a  style="color:#212529;float: right;" class="arabic" target="_blank" href="'+obj['url']+'">'+obj['title']+'</a></div>');


$("#"+obj['id']).
append('<div class="d-inline " style="float:Left;"><a href="/recipe/'+obj['id']+'/edit?token=<?php if(isset($_GET['token'])) {echo $_GET['token'];}?>" style="margin-left:1px;margin-right:1px;"><button type="button" class="btn btn-primary  fsm"><i class="fas fa-edit"></i></button></a><a href="/recipe/'+obj['id']+'/delete" style="margin-left:1px;margin-right:1px;"><button type="button" class="btn btn-danger  fsm"><i class="fas fa-trash-alt"></i></button></a></div>');

$("#"+obj['id']).append('<hr style="margin:0px">');
// $("#"+obj['id']).append('<div> <a class="arabic" target="_blank" href="'+obj['url']+'">'+obj['title']+'</a></div>');

// $("#"+obj['id']).append('<div><a href="/recipe/'+obj['id']+'/edit?token=<?php if(isset($_GET['token'])) {echo $_GET['token'];}?>"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a><a href="/recipe/'+obj['id']+'/delete"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></a></div>');


    }
                         }
               });
      }
      else{
        $("#livesearch").empty();
      }
      }
    </script>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->

      <!-- Notifications Dropdown Menu -->

<!--       <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="https://www.facebook.com/mr.hungryy/" target="_blank" class="brand-link">
      <img src="/images/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">FB page</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/images/sh.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a  class="d-block">Admin hungryy</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/statistics?token=<?php if(isset($_GET['token'])) echo $_GET['token']?>" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>
                Statistics
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="/recipies?token=<?php if(isset($_GET['token'])) echo $_GET['token']?>" class="nav-link">
              <i class="nav-icon fas fa-utensils"></i>
              <p>
                Recipes
              </p>
            </a>
          </li>
            <li class="nav-item">
            <a href="/categories?token=<?php if(isset($_GET['token'])) echo $_GET['token']?>" class="nav-link">
              <i class="nav-icon fas fa-list-alt"></i>
              <p>
                Categories
              </p>
            </a>
          </li>
            <li class="nav-item">
            <a href="/recipe?token=<?php if(isset($_GET['token'])) echo $_GET['token']?>" class="nav-link">
              <i class="nav-icon fas fa-plus"></i>
              <p>
                Add new recipe+
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
 @yield('content')
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
   <!--<aside class="control-sidebar control-sidebar-dark">
    Control sidebar content goes here
  </aside> -->
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src='/plugins/jquery/jquery.min.js'></script>
<!-- jQuery UI 1.11.4 -->
<script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="/plugins/datatables/jquery.dataTables.js"></script>
<script src="/plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
<script src="/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline --> 
<!-- <script src="plugins/sparklines/sparkline.js"></script> -->
<!-- JQVMap -->
<script src="/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="/plugins/moment/moment.min.js"></script>
<script src="/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/js/dashboard.js"></script>
<!-- AdminLTE App -->
<!-- <script src="/js/adminlte.min.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="/js/demo.js"></script>
<script src="/js/add_remove_steps.js"></script>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>

<script type="text/javascript">

</script>



<script type="text/javascript">
  $(function() {
  $(document).on('click', '.btn-add', function(e) {
    e.preventDefault();

    var dynaForm = $('.dynamic-wrap form:first'),
      currentEntry = $(this).parents('.entry:first'),
      newEntry = $(currentEntry.clone()).appendTo(dynaForm);

    newEntry.find('input').val('');
    dynaForm.find('.entry:not(:last) .btn-add')
      .removeClass('btn-add').addClass('btn-remove')
      .removeClass('btn-success').addClass('btn-danger')
      .html('<span class="glyphicon glyphicon-minus"></span>');
  }).on('click', '.btn-remove', function(e) {
    $(this).parents('.entry:first').remove();

    e.preventDefault();
    return false;
  });
});
</script>

<script>

  document.getElementById('tokenHolder').value=param;


       if($('#tokenHolder').val() == ''){

      param="{{$token ?? 'null'}}";
   }

         jQuery(document).ready(function(){
               $.ajaxSetup({
                  headers: {
                      'Content-Type':"application/json",
                      'Accept':"application/json",
                      'Authorization':'Bearer '+param,

                  }
              }); 
               jQuery.ajax({
                  url: "{{ url('/api/auth') }}",
                  method: 'post', 
                  data: {},
                  success: function(result){
                    console.log(result);
                    if (result['code']=="USER000") {
                        console.log(result['message']);
                    }
                      },
                      error:function(httpObj, textStatus) {  
                          if(httpObj.status==401){
                              alert("Unauthenticated");
                              window.location.href='/';
                            }
                      }
               });
            });
      </script>
<div id="videoContainer"></div>
<div class="modalLoading"><!-- Place at bottom of page --></div>
</body>
</html>
