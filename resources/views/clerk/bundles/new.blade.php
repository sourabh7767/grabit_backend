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

                <form role="form" enctype="multipart/form-data" method="post" action="{{action('App\Http\Controllers\clerk\BundlesController@store')}}">
                    <div class="col-md-5 col-5  mt-4" style="display: inline-block;">

                    <div class="input-group input-group-outline mb-3" style="margin-top: -15px">
                        <label class="form-label">AR Name</label>
                        <input type="text" name="bundle_name_ar" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                    </div>         <br>

                    <div class="input-group input-group-outline mb-3 " >

                            <label class="form-label focused">AR Description</label>
                            <textarea type="text" name="description_ar" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                        </div>



                        <div class="input-group input-group-outline mb-3" >
                            <label class="form-label">price</label>
                            <input type="text" name="price" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>


                        <div class="input-group input-group-outline mb-3" >
                            <label class="form-label">price after discount</label>
                            <input type="text" name="total_after_discount" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="input-group input-group-outline mb-3">
                            <label class="form-label">Stock</label>
                            <input type="text"  name="stock" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>


                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>

                    <div class="col-md-5 col-6  mt-4 pull-right" style="display: inline-block;padding-left: 18px;">


                        <div class="input-group input-group-outline mb-3 " >

                            <label class="form-label focused">EN Name</label>
                            <input type="text" name="bundle_name" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>

                        <div class="input-group input-group-outline mb-3 " >

                            <label class="form-label focused">EN Description</label>
                            <textarea type="text" name="description" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                        </div>

                        <div class="form-check form-switch ps-0 is-filled">
                            <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault" value="1" name="status" checked="">
                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault">Available</label>
                        </div>
                        <br>
                        <div class="input-group input-group-outline mb-3">
                             <p style="padding-right: 15px">Sub Category</p>
                            <select name="sub_category_id" id="category" style="width: 40%;border-radius: 8px;height: fit-content">
                                <option>select</option>
                                @foreach($sub_categories as $sub_categorie)
                                    <option value="{{$sub_categorie->id}}"> {{$sub_categorie->sub_category_name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="input-group input-group-outline mb-3">
                            <p style="padding-right: 15px">Items</p>
                            <select name="items[]" id="category" style="width: 60%;border-radius: 8px;" multiple>
                                <option>select</option>
                                @foreach($items as $item)
                                    <option value="{{$item->id}}"> {{$item->ar_item_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <br>


                        <div class="form-check form-check-info text-start ps-0">
                            <label class="form-check-label" for="flexCheckDefault"> Upload Image</a>  &nbsp;&nbsp;&nbsp;&nbsp;
                             <input class="form-check-input" type="file" name="img" required value="" id="flexCheckDefault" style="width: auto">
                            </label>
                        </div>
                        @csrf
                        <br>
                        <br>
                        <br>

                        <div class="text-center">
                            <input type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0" value="Insert">
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>

@endsection
