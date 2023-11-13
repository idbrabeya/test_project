<?php
  // use App\Models\Image;
?>
@extends('layouts.app')
<style>
  .parent{
    margin: 0 auto;
    padding: 3px;
    display: flex;
    flex-direction: row;
    border: 2px solid grey;
  }
  .parent>div{
    margin: 5px;
    position: relative;
    width: 25%;
    height: 200px;
    border: 2px solid red;
    background: green;
  }
  .child img{
      position: absolute;
      width: 50px;
      height: 25px;
      top: 0px;
      right: 0px;
  }
  .child a{
    text-decoration: none;
    color: #fff;
    text-align: end;
  }
  .child a:hover{
    color: #fff !important;
  }
  .child a{
    position: absolute;
    right: 0px;
  }
</style>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card">
                <table class="table">
                        <thead>
                            <tr>
                              <th >Id</th>
                              <th >Nmae</th>
                              <th >Email</th>
                              <th >Marital_Status</th>
                              <th >Phone</th>
                              <th >Status</th>
                              <th >Image</th>
                              <th >Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @forelse ($datashows as $key=>$datashow)
                            <tr>
                                <td>{{$key+1}}</td>
                                 <td>{{$datashow->name}}</td>
                                 <td>{{$datashow->email}}</td>
                                 <td>{{$datashow->marital_status}}</td>
                                 <td>{{$datashow->phone}}</td>
                                 
                                 <td>
                                  <a onclick="status_change({{$datashow->id}})"> 
                                  @if ($datashow->status==1)
                                  <span  class="badge bg-primary">active</span>
                                  @else 
                                  <span class="badge bg-danger">deactive</span>
                                   @endif</a>
                                  </td>
                      
                               <td>
                                @foreach ($datashow->imagess as $img)
                                <img style="height: 50px; width:50px" src="{{asset('uploads/'.$img->images .'')}}" alt="Image">
                                @endforeach
                              </td>  
                                 <td>
                                   <a href="{{route('info.edit',$datashow->id)}}" class="btn btn-info btn-sm">Edit</a>
                                   <button type="button" class="btn btn-danger btn-sm deletedata" data-id="{{$datashow->id}}">Delete</button>
                                   <a href="" class="btn btn-warning btn-sm">Add More</a>
                                 </td>
                               </tr>
                            @empty
                                <td colspan="6">
                                    <div>
                                        <span class="text-danger">No Data Show</span>
                                    </div>
                                </td>
                            @endforelse
                      
                          </tbody>   
                  </table>
                </div>
            </div>
        </div>
    </div>
    {{-- test --}}
    <div class="parent">
      <div class="child">
        <img src="{{asset('uploads/1689577677.png')}}" alt="">
        <a href="">delete</a>
      </div>
      <div class="child">
        <img src="{{asset('uploads/1689577677.png')}}" alt="">
        <a href="">delete</a>
      </div>
      <div class="child">
        <img src="{{asset('uploads/1689577677.png')}}" alt="">
        <a href="">delete</a>
      </div>
      <div class="child">
        <img src="{{asset('uploads/1689577677.png')}}" alt="">
        <a href="">delete</a>
      </div>
    </div>
    <button class="button_hide">hide</button>
    <p class="content_hide">This is paragraph with little content </p>
    {{-- test --}}
@endsection
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@section('scripts')
<script>
  $(document).ready(function () {
      $('.deletedata').click(function () {
          var Id = $(this).data('id');

          Swal.fire({
              title: "Are you sure?",
              text: "You won't be able to revert this!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#d33",
              cancelButtonColor: "#3085d6",
              confirmButtonText: "Yes, delete it!",
          }).then((result) => {
              if (result.isConfirmed) {
                  $.ajax({
                      url: '/info_delete/' + Id,
                      type: 'get',
                    
                      success: function (response) {
                          console.log(response);
                          $('#row_' + Id).remove(); 
                          window.location.reload();
                         
                      },
                      error: function (xhr) {
                          console.log(xhr.responseText);
                          Swal.fire("Error!", "An error occurred.", "error");
                      }
                  });
              }
          });
      });
  });
</script>
  <script>
 function status_change(id){
  
      $.ajax({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },

        type:"post",
        url:'{{route('status.change')}}',
        data:{
        id: id
        },
        success:function(data){
            if(data==1){
              window.location.reload();
            }
        },
        error:function(xhr){
            console.log(xhr.responseTest);
          }
      });
     }

  </script>
  <script>
    $(document).ready(function() {
      $('.button_hide').click(function() {
        $('.content_hide').hide("slow",function(){
          alert("this paragrap is now hiden");
        });
       
      })
    })
  </script>
@endsection