@extends('layouts.app')

@section('content')
<style>
  .top-sec{
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    margin: 0px;
  }
.box{
  height: 25%;
  width:25%;
  position: relative;
  margin: 0px;
  padding: 5px 
}

.box i{
  position: absolute;
  right: 5px;
  color: #fff;
  font-size: 20px;
  cursor: pointer;
}

.box i:hover{
  color: gray;
}
.box a{
  color: #000;
}
.box img{
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info">
                    <h4>Edit Info</h4>
                </div>

                <div class="card-body">
                <form method="post" action="{{route('info.update', $info_edit->id)}} " enctype="multipart/form-data" >
                    @csrf
                    <div class="mb-3">
                      <label for="" class="form-label">Name</label>
                      <input type="name" name="name" class="form-control" value="{{$info_edit->name}}" >
                    </div>
                    <div class="mb-3">
                      <label for="" class="form-label">Email</label>
                      <input type="email" class="form-control" name="email" value="{{$info_edit->email}}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Marital Status</label>
                        <select name="marital_status" class="form-select" value="">
                            <option value="" selected>Select Status</option>
                             <option value="Single" @if ($info_edit->marital_status=='Single')Selected @endif >Single</option>
                             <option value="Married" @if ($info_edit->marital_status=='Married')Selected @endif >Married</option>
                             <option value="Divorce" @if ($info_edit->marital_status=='Divorce')Selected @endif >Divorce</option>   
                        </select>
                     </div>
                      <div class="mb-3">
                        <label for="" class="form-label">phone</label>
                        <input type="number" class="form-control" name="phone" value="{{$info_edit->phone}}">
                      </div>
                      <div class="mb-3 top-sec"> 
                      @foreach ($info_edit->imagess as $info_edit_img)
                     <span class="box">
                      <a href="{{route('info.image.delete',$info_edit_img->id)}}" ><i class="fas fa-window-close"></i></a>
                      <img src="{{asset('uploads/'.$info_edit_img->images .'')}}" alt="Image">
                     </span>
                      @endforeach
                    </div>
                      <br>
                      <label for="" class="form-label">Image</label>
                      <input type="file" class="form-control" name="new_image[]" value="" multiple><br>
                    <button type="submit" class="btn btn-primary">Update_Info</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://kit.fontawesome.com/1a57f12784.js"></script>
@section('scripts')
  <script>
 
</script>
@endsection
