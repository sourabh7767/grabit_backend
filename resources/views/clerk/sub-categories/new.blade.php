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

                    @endif

                <form role="form" method="post" action="{{action('App\Http\Controllers\clerk\SubCategoriesController@store')}}" enctype="multipart/form-data">
                    <div class="col-md-6 col-6  mt-4">

                    <div class="input-group input-group-outline mb-3">
                        <label class="form-label">AR Name</label>
                        <input type="text" class="form-control" name="category_name_ar" required  onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>

                    <div class="input-group input-group-outline mb-3">
                        <label class="form-label">AR Description</label>
                        <input type="text" class="form-control" name="description_ar" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>



                    </div>

                    <div class="col-md-6 col-6  mt-4">

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">EN Name</label>
                            <input type="text" class="form-control" name="category_name" required onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>

                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">EN Description</label>
                            <input type="text" class="form-control" name="description" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>


                        <div class="form-check form-check-info text-start ps-0">

                            <label class="form-check-label" for="flexCheckDefault"> Upload Image</a>
                                                                            &nbsp; &nbsp; &nbsp;
                            <input class="form-check-input" type="file" name="img" required value="" id="flexCheckDefault" style="width: auto"> </label>
                        </div>
                        <br>
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