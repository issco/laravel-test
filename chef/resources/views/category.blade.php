@extends('home')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Categories</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home?token=<?php if(isset($_GET['token'])) echo $_GET['token']?>">Home</a></li>
                    <li class="breadcrumb-item active">Categories </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div> 
    <!-- /.container-fluid -->
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Add new
</button>
<div class="container" style="
  width: 380px;">
  <ul class="tags blue" id="blueTags">
    @if (isset($categories))
@foreach($categories as $category)
    <li><a href="#">{{$category->title}} <span>{{$category->recipies_count}}</span></a></li>
@endforeach
@endif
  </ul>
</div>


<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="
    width: 400px;
">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form>
  <div class="form-group">
    
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="New Category" name="title">

  </div>
  <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="saveButton" class="btn btn-primary" data-dismiss="modal">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
         jQuery(document).ready(function(){
            jQuery('#saveButton').click(function(e){
              $body = $("body");
                     $(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { setTimeout(function(){$body.removeClass("loading");}, 1900); }    
}); 
               var title=  document.getElementById("exampleInputEmail1").value;
               e.preventDefault();
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                      'Authorization':'Bearer ' + '<?php if(isset($_GET['token'])) echo $_GET['token']?>',
                      'Accept':'application/json',
                      'Content-Type':"application/x-www-form-urlencoded; charset=UTF-8"
                  }
              });
               jQuery.ajax({
                  url: "{{ url('/api/category/add') }}",
                  method: 'post',
                  data: {
                     "_token": "{{ csrf_token() }}",
                     "title": title,
                  },
                  success: function(result){ 
console.log(result);
$("#blueTags").empty();

for (var i = 0; i < result['data']['categories'].length; i++) {
    var obj = result['data']['categories'][i];
$("#blueTags").append('<li><a href="#">'+obj.title+'<span>'+obj.recipies_count+'</span></a></li>');
}
                         }
               });
               });
            });
      </script>
@stop

