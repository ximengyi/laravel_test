@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">文件长传实验</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>


          <div>  <form action="/client" method="post" enctype="multipart/form-data">

          <input type="file" name="tus_file" id="tus-file" />
          <input type="submit" value="Upload" />
         </form></div>






            </div>
        </div>
    </div>
</div>
@endsection
