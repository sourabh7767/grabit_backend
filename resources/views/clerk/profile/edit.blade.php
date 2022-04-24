@extends('clerk.app')
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
                @elseif(Session::has('error'))
                    <div class="alert alert-danger">
                        <ul>
                        <li>{{ session('error') }}</li>
                        </ul>
                    </div>
                @endif

                <form role="form" method="post" action="{{action('App\Http\Controllers\clerk\ProfileController@update',$clerk->id)}}" enctype="multipart/form-data">
                    <div class="col-md-6 col-6  mt-4">

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" name="name" value="{{$clerk->name}}" required disabled onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" value="{{$clerk->email}}" disabled onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" name="phone" value="{{$clerk->phone}}"  onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>

                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Old Password</label>
                            <input type="password" class="form-control" name="oldpassword"  required onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>


                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password"  required onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>

                        @method('PUT')
                        @csrf
                        <div class="text-center">
                            <input type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0" value="Update">
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection