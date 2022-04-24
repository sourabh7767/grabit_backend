@extends('admin.app')
@section('content')


    <div class="container-fluid py-4">
        <div class="row">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @elseif(Session::has('message'))
                    <div class="alert alert-success">
                        <p class="text-white">{{session('message')}}</p>
                    </div>

                    @endif

                <form role="form" method="post" action="{{action('App\Http\Controllers\admin\AdminsController@store')}}" enctype="multipart/form-data">
                    <div class="col-md-6 col-6  mt-4">

                    <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required  onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>



                    <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>


                        @csrf
                        <div class="text-center">
                            <input type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0" value="Insert">
                        </div>


                    </div>
                    
                </form>
            </div>
        </div>
    </div>

@endsection