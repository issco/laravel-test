@extends('home') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <!-- /.col -->
         <div class="col-sm-12">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a href="/home?token=<?php if(isset($_GET['token'])) echo $_GET['token']?>">Home</a></li>
               <li class="breadcrumb-item"><a href="/recipies?token=<?php if(isset($_GET['token'])) echo $_GET['token']?>">Recipies </a></li>
               <li class="breadcrumb-item active"><a href="/recipe/edit/{{$recipe['id']}}">Edit</a></li>
               <li class="breadcrumb-item active">{{$recipe['title']}}</li> 
            </ol>
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
   <div id="update"></div>

</div>
<div class="container" style="direction: rtl;text-align:right;">
   <div class="row">
      <div class="col-sm-6" id="stepsContainer">
        <label>المكونات: </label>
         <div id="steps" class="container">
            
<?php
 $json_array  = json_decode($recipe['steps'], true);

 if(isset($json_array)){
 for ($i=0;$i<count($json_array);$i+=1) {
   $step=$json_array[$i];

    ?>
            <?php $r=rand(); ?>
            <div id="steps">
            <div class="input-group" id="<?php echo $r; ?>" style="margin-bottom: 6px;">
               <button type="button" class="btn btn-success btn-sm" style="margin-left: 1px;height: 30px" onclick="addNewStep('<?php echo $r; ?>');"><i class="fas fa-plus"></i></button>
               <button type="button" class="btn btn-danger btn-sm" style="margin-left: 1px;height: 30px" onclick="removeStep('<?php echo $r; ?>')"><i class="fas fa-minus"></i></button>
               <input type="text" class="form-control input-sm" 
                  placeholder="ingredient" name="fields[]" style="width: 198px;height: 30px;" value="{{$step['title']}}" />
               <span class="input-group-btn" style="width:0px;"></span>
               <input type="text" class="form-control input-sm" 
                  placeholder="Amount" name="fields[]" style="height: 30px;" value="{{$step['amount']}}" />
               <div role="separator" class="dropdown-divider"></div>
            </div>
            </div>
<?php }}
    ?>

         </div>
      </div>
      <div class="col-sm-6" style="direction: initial;padding-left: 15px;margin-top: 30px;">
         <div id="imageContainer" class="row">
            <img src="{{$recipe['thumbnail']}}" width="86%" class="Responsive image rounded" onclick="initVideoModal('<?php echo $recipe['video']?>');">
            <br>
        </div>
         <div id="dataContainer" class="row" style="margin-top: 10px;" >
            <form class="form-inline">
               <div class="form-group ">
  <div class="form-group">
    <select class="form-control" id="exampleFormControlSelect1" name="category">
    
    @if (isset($categories))
@foreach($categories as $category)
<option value="{{$category->id}}" {{$category->title ==$recipe['category'] ? 'selected' : null }}>{{$category->title}}</option>
@endforeach
@endif
 </select>
  </div>
               </div>

               <div class="form-group">
                  <input type="text"  class="form-control" id="staticEmail5" value="{{$recipe['title']}}" style=" width: 350px;" required>

                   <input type="hidden"  class="form-control" id="idR" value="{{$recipe['id']}}">
               </div>

            </form>

         </div>
      </div>
   </div>
</div>
<button type="button" id="updateButton" class="btn btn-success" 
style="
position:absolute;
bottom: 3px;
border-radius: 0px;
margin-left: 7px;
width: 20%;"
>Update</button>
<div id="videoContainer">
</div>

<script>
         jQuery(document).ready(function(){
            jQuery('#updateButton').click(function(e){
              $body = $("body");
                       $(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { setTimeout(function(){$body.removeClass("loading");}, 1900); }    
}); 
                var id=  document.getElementById("idR").value;
               var title=  document.getElementById("staticEmail5").value;
               var steps = [];
$('input[name="fields[]"]').each( function() {
    steps.push(this.value);
});
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
                  url: "{{ url('/api/recipe/update/') }}",
                  method: 'put',
                  data: {
                     "_token": "{{ csrf_token() }}",
                     "title": title,
                     "category_id":$("#exampleFormControlSelect1 option:selected").val(),
                     "steps":steps,
                     "id":id
                  },
                  success: function(result){
console.log(result);
$("#update").empty();
if(result['message']){$("#update").append('<div class="alert alert-info" role="alert">'+result['message']+'</div>')}                    }
               });
               });
            });
      </script>
@stop