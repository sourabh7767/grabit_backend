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
                @endif

                    <form role="form" enctype="multipart/form-data" method="post" action="{{action('App\Http\Controllers\clerk\ItemsController@update',$item->id)}}">
                        <div class="col-md-5 col-5  mt-4" style="display: inline-block;">

                            <div class="input-group input-group-outline mb-3 focused is-focused" style="margin-top: -15px">
                                <label class="form-label">AR Name</label>
                                <input type="text" name="ar_item_name" value="{{$item->ar_item_name}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>         <br>

                            <div class="input-group input-group-outline mb-3 focused is-focused" style="margin-top: -15px">
                                <label class="form-label">AR Description</label>
                                <input type="text" name="ar_description" value="{{$item->ar_description}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>

                            <br>

                            <div class="input-group input-group-outline mb-3 focused is-focused" >
                                <label class="form-label">price</label>
                                <input type="text" name="price" value="{{$item->price}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>


                            <div class="input-group input-group-outline mb-3 focused is-focused" >
                                <label class="form-label">price after discount</label>
                                <input type="text" name="discount" value="{{$item->discount}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <div class="input-group input-group-outline mb-3 focused is-focused">
                                <label class="form-label">Stock</label>
                                <input type="text"  name="stock" value="{{$item->stock}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                                <div class="input-group input-group-outline mb-3 focused is-focused" >
                                <label class="form-label">Price Time Out (Minutes)</label>
                                <input type="text" name="price_time_out" value="{{$item->price_time_out}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div> <br>
                        </div>

                        <div class="col-md-5 col-6  mt-4 pull-right" style="display: inline-block;padding-left: 18px;">


                            <div class="input-group input-group-outline mb-3  focused is-focused" >

                                <label class="form-label focused">EN Name</label>
                                <input type="text" name="en_item_name"  value="{{$item->en_item_name}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>
                            <div class="input-group input-group-outline mb-3 focused is-focused" >


                                <label class="form-label">EN Description</label>
                                <input type="text" name="en_description" value="{{$item->en_description}}" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                            </div>

                            <div class="form-check form-switch ps-0 is-filled">
                                <input class="form-check-input ms-auto text-success" type="checkbox" id="flexSwitchCheckDefault" value="1" name="status"
                                       @if($item->status)
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
                                        @if($sub_categorie->id == $item->sub_category_id)
                                        selected
                                        @endif
                                            > {{$sub_categorie->sub_category_name}}</option>
                                    @endforeach
                                </select>
                            </div>


                            <br>


                            <div class="form-check form-check-info text-start ps-0">
                                <label class="form-check-label" for="flexCheckDefault"> Upload Image</a>    &nbsp;&nbsp;&nbsp;&nbsp;
                                 <input class="form-check-input" type="file" name="img" value="" id="flexCheckDefault" style="width: auto">
                                </label>
                            </div>
                            @csrf
                            @method('PUT')
                            <br>
                            <br>
                            <input type="hidden" value="{{$item->img}}" name="img_src">
                            <div class="text-center">
                                <input type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0" value="Insert">
                            </div>


                        </div>

                    </form>
            </div>
        </div>
    </div>

    <script>
        function get_region(e){
            $cities=document.getElementById("cities");
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                ob=JSON.parse(this.responseText);
                i=0;
                document.getElementById("cities").innerHTML = "";
                for(var r in ob) {

                    ele = document.createElement("option");
                    ele.value = ob[i].id;
                    ele.text = ob[i].area_name_en;
                    $cities.append(ele);
                    i++;
                }
            }
            xhttp.open("GET", "http://127.0.0.1:8000/api/cities/"+e.value, true);
            xhttp.send();



        }

    </script>
@endsection
