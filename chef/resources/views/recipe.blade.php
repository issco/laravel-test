@extends('home')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Recipies</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home?token=<?php if(isset($_GET['token'])) echo $_GET['token']?>">Home</a></li>
                    <li class="breadcrumb-item active">Add Recipe </li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
 
<div class="container" style="width: 56%;padding-top: 10px;">
  @if(!empty($Msg))
  <div class="alert alert-success"> {{ $Msg }}</div>
@endif

@if (\Session::has('Msg'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('Msg') !!}</li>
        </ul>
    </div>
@endif


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul> 
    </div>
@endif

 
<form method="post" action="/recipe/add" style="direction: rtl;text-align:right;" enctype="multipart/form-data">
<input type="hidden" name="_token" id="csrf-token" value="{{Session::token() }}">
<input type="hidden" name="auth_token" id="token" value="<?php if(isset($_GET['token'])) echo $_GET['token']?>">
<!-- video file input -->
<!-- 	<div class="custom-file">
  <input type="file" class="custom-file-input" id="customFile" name="video" accept="video/*" required>

      <script type="text/javascript">
        $('#customFile').bind('change', function() {
              if((this.files[0].size/1024/1024)>150)
            alert('This video size is: ' + this.files[0].size/1024/1024 + "MB");

        });
    </script>

  <label class="custom-file-label" for="customFile">  ............... الفيديو </label>
</div>
<br><br> -->


<!-- Thumbnail file input -->
<!-- 
  <div class="custom-file">
  <input type="file" class="custom-file-input" id="customFile2" name="thumb" accept="image/*" required>
  <label class="custom-file-label" for="customFile2">............... صورة العرض</label>
</div>
<br><br> -->


<!-- Video title -->
<!--   <div class="form-group">
  <input type="text" class="form-control" name="title" required  placeholder="اسم الطبخة">
  </div> -->


  <div class="form-group">
  <input type="text" class="form-control" name="url" required  placeholder="Youtube URL">
  </div>


  <div class="form-group"> 
    <!-- <label for="exampleFormControlSelect1">الفئة</label> -->
    <select class="form-control" id="exampleFormControlSelect1" name="category">
    @if (isset($categories))
@foreach($categories as $category)
          <option value="{{$category->id}}">{{$category->title}}</option>
@endforeach
@endif

    </select>
  </div>
    <div class="form-group">
  <input type="number" class="form-control" value=1 name="count" required placeholder="المكونات تكفي لعدد أشخاص">
  </div>
<div role="separator" class="dropdown-divider"style="border-top: 1px solid #4990d7"></div>

<!-- start steps part -->
<div id="steps" class="container">
<?php $r=rand(); ?>
<div class="input-group" id="<?php echo $r; ?>" style="margin-bottom: 6px;">
<button type="button" class="btn btn-success btn-sm" style="margin-left: 1px;height: 30px" onclick="addNewStep('<?php echo $r; ?>');"><i class="fas fa-plus"></i></button>
<button type="button" class="btn btn-danger btn-sm" style="margin-left: 1px;height: 30px" onclick="removeStep('<?php echo $r; ?>')"><i class="fas fa-minus"></i></button>
  <input type="text" class="form-control input-sm" 
  placeholder="ingredient" name="fields[]" style="width: 198px;height: 30px;"/>
  <span class="input-group-btn" style="width:0px;"></span>
  <input type="text" class="form-control input-sm" 
  placeholder="Amount" name="fields[]" style="height: 30px;" />
<div role="separator" class="dropdown-divider"></div>
</div>
</div>
<!-- end steps -->
  <button type="submit" class="btn btn-primary">إضافة</button>
</form>

</div>
@stop