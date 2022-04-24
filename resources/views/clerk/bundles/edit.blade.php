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

                <form role="form" enctype="multipart/form-data" method="post" action="{{action('App\Http\Controllers\clerk\BundlesController@update',$bundles->id)}}">
                    <div class="col-md-5 col-5  mt-4" style="display: inline-block;">

                        <div class="input-group input-group-outline mb-3 focused is-focused" style="margin-top: -15px">
                            <label class="form-label">AR Name</label>
                            <input type="text" name="bundle_name_ar" value="{{$bundles->bundle_name_ar}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>         <br>





                        <div class="input-group input-group-outline mb-3 focused is-focused" >
                            <label class="form-label">price</label>
                            <input type="text" name="price" class="form-control" value="{{$bundles->price}}" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>


                        <div class="input-group input-group-outline mb-3 focused is-focused" >
                            <label class="form-label">price after discount</label>
                            <input type="text" name="total_after_discount" value="{{$bundles->total_after_discount}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>
                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <label class="form-label">Stock</label>
                            <input type="text"  name="stock" value="{{$bundles->stock}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
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


                        <div class="input-group input-group-outline mb-3  focused is-focused" >

                            <label class="form-label focused">EN Name</label>
                            <input type="text" name="bundle_name" value="{{$bundles->bundle_name}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                        </div>


                        <div class="form-check form-switch ps-0 is-filled">
                            <input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault" value="1" name="status"
@if($bundles->status==1)
checked=""
    @endif
                            >
                            <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="flexSwitchCheckDefault">Available</label>
                        </div>
                        <br>
                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <p style="padding-right: 15px">Sub Category</p>
                            <select name="sub_category_id" id="category" style="width: 40%;border-radius: 8px;height: fit-content;">
                                <option>select</option>
                                @foreach($sub_categories as $sub_categorie)
                                    <option value="{{$sub_categorie->id}}"
                                    @if($sub_categorie->id == $bundles->sub_category_id)
                                        selected
                                        @endif
                                    > {{$sub_categorie->sub_category_name}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="input-group input-group-outline mb-3 focused is-focused">
                            <p style="padding-right: 15px">Items</p>
                            <select name="items[]" id="category" style="width: 60%;border-radius: 8px;" multiple>
                                <option>select</option>
                                @foreach($storeitems as $storeitem)
                                    <option value="{{$storeitem->id}}"
                                    @if(in_array($storeitem->id,unserialize($bundles->items)))
                                        selected

                                     @endif
                                    > {{$storeitem->ar_item_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <br>


                        <div class="form-check form-check-info text-start ps-0">
                            <label class="form-check-label" for="flexCheckDefault"> Upload Image</a>  &nbsp;&nbsp;&nbsp;&nbsp;
                                <input class="form-check-input" type="file" name="img" value="" id="flexCheckDefault" style="width: auto">
                            </label>
                        </div>
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="img_src"  value="{{$bundles->img}}">
                        <br>
                        <br>
                        <br>

                        <div class="text-center">
                            <input type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0" value="Update">
                        </div>


                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>

@endsection
