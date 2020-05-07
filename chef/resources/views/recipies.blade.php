@extends('home') @section('content')

<!-- Content Header (Page header) -->

<div class="content-header" style="padding: 0px">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Recipies</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home?token=<?php if(isset($_GET['token'])) echo $_GET['token']?>">Home</a></li>
                    <li class="breadcrumb-item active">Recipies </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>

<!-- /.content-header -->
<section class="content">
    <div class="row">
        <div class="col-12">
            <!-- /.card -->

            <div class="card">
                <!-- /.card-header -->
                <div class="card-body" style="direction: rtl;text-align:right;padding-top: 0px;padding-bottom: 0px">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Video</th>
                                <th>Recipe</th>
                                <th style="width: 50px;">Category</th>
                                <th style="width: 50px;"><small>Youtube</small>Views</th>
                                <th style="width: 50px;"><small>app</small>Views</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="direction: rtl" id="tbody">
                            <?php if(isset($Recipies)) 
                            foreach ($Recipies as $recipe) {
                                ?>
                                <tr >
                                    <td style="max-height: 90px;width:90px;padding: 1px">
                                        <img src="<?php echo $recipe['thumbnail']?>" alt="img-thumbnail" class="img-thumbnail test" style="display:block; width:100px; height:80px;" onclick="initVideoModal('<?php echo $recipe['embed']?>');">
                                    </td>
                                    <td> <span class="arabic"><?php echo $recipe['title'];?></span></td>
                                    <td><span class="arabic"><?php echo $recipe['category'];?></span></td>
                                    <td>
                                        <?php echo $recipe['youtube_views'];?> <i class="fas fa-eye"></i></td>
                                    <td>
                                        <?php echo $recipe['views'];?> <i class="fas fa-eye"></i></td>
<td><a href="/recipe/<?php echo $recipe['id'];?>/edit?token=<?php if(isset($_GET['token'])) {echo $_GET['token'];}?>">
                                            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button>
                                        </a>

                                        <a href="/recipe/<?php echo $recipe['id'];?>/delete">
                                            <button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                        </a>

                                    </td>
                                </tr>
                                <?PHP                             }?>
                        </tbody>
                    </table>
                    <div class="row justify-content-center" id="navigators">
                         <input type="hidden" id="nav" value="1">
                        <script type="text/javascript">
                            $current_page=1;
                        </script>
<i class="fas fa-chevron-circle-right" id="next" onclick="$current_page++;pageNavigate($current_page);"></i>
<i class="fas fa-chevron-circle-left" id="prev" onclick="$current_page--;pageNavigate($current_page);"></i>
<div class="alert alert-primary" role="alert" id="Msg" hidden>

</div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

<script>

       function pageNavigate(page){ 
$body = $("body");

       $(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { setTimeout(function(){$body.removeClass("loading");}, 1900); }    
});              
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content'),
                      'Authorization':'Bearer ' + '<?php if(isset($_GET['token'])) echo $_GET['token']?>',
                      'Accept':'application/json',
                      'Content-Type':"application/x-www-form-urlencoded; charset=UTF-8"
                  }
              });
               jQuery.ajax({
                  url: "/api/getReceipies/"+page,
                  method: 'get',
                  data: {
                     "_token": "{{ csrf_token() }}",
                  },
                  success: function(result){ 
$("#tbody").empty();
if (result['code']=="FORM015") {
    document.getElementById('Msg').innerHTML=result['message'];
    document.getElementById('Msg').hidden=false;
    if($current_page>1){
            $('#next').hide();
            $('#prev').show();
        }
    if($current_page<1){
        $('#next').show();
        $('#prev').hide();
        }
    }

console.log($current_page);
    if((1< $current_page)&&($current_page <= result['data']['totalPages'])){
            $('#next').hide();
            $('#prev').show();
            document.getElementById('Msg').hidden=true;
        }

    if((1== $current_page)&&($current_page < result['data']['totalPages'])){
            $('#next').show();
            $('#prev').hide();
            document.getElementById('Msg').hidden=true;
        }
else {document.getElementById('Msg').hidden=true;} 
for (var i = 0; i < result['data']['data'].length; i++) { 
    var obj = result['data']['data'][i];
// $("#tbody").append('<li><a href="#">'+obj.title+'<span>'+obj.recipies_count+'</span></a></li>');
$("#tbody").append('<tr id="'+obj['id']+'"></tr>'); 
$("#"+obj['id']).append('<td style="max-height: 90px;width:90px;padding: 1px"><img src="'+obj['thumbnail']+'" alt="img-thumbnail" class="img-thumbnail test" style="display:block; width:100px; height:80px;" onclick="initVideoModal('+obj['embed']+');"></td>');

$("#"+obj['id']).append('<td> <span class="arabic">'+obj['title']+'</span></td>');

$("#"+obj['id']).append('<td> <span class="arabic">'+obj['category']+'</span></td>');

$("#"+obj['id']).append('<td>'+obj['youtube_views']+'<i class="fas fa-eye"></i></td>');
$("#"+obj['id']).append('<td>'+obj['views']+'<i class="fas fa-eye"></i></td>');

$("#"+obj['id']).append('<td><a href="/recipe/'+obj['id']+'/edit?token=<?php if(isset($_GET['token'])) {echo $_GET['token'];}?>"><button type="button" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></button></a><a href="/recipe/'+obj['id']+'/delete"><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button></a></td>');

}
                         }
               });
   }
      </script>
 

@stop