@extends('adminlayout')

<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="{{ asset('public/style/js/cropie.js')}}"></script>

<style>
    .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        width: 150px;
        height: 150px;
    }

    .cropit-preview-image-container {
        cursor: move;
    }

    .image-size-label {
        margin-top: 10px;
    }

    input {
        display: block;
    }



    #result {
        margin-top: 10px;
        width: 900px;
    }

    #result-data {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        word-wrap: break-word;
    }

</style>
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">
                        <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Update 4-PAY Products </strong>Separate Features with a comma ',' for a any new feature.
                                        <a  href="{{route('products_vendor')}}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pencil"></i> all products</a>
                                                    
                                    </div>
                                    <div class="card-body">
                                                <center>
                                                    @foreach (['danger', 'warning', 'success', 'info'] as $msgfin)
                                                        @if(Session::has('alert-' . $msgfin))
                                                        <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                                                    
                                                                {{ Session::get('alert-' . $msgfin) }} 
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                    
                                                </center>
                                            <form  name="form1" id='form1' class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('admin4payupdate_product') }}">
                                                            {{ csrf_field() }}
                                                            @if($result)
                                                                <input type="hidden" id="id" value="{{ $result->id }}" name="id" >
                                                            @else
                                                                <input type="hidden" id="id" value="{{ old('id') }}" name="id" >
                                                            @endif
                                                            
                                                                
                                        <div class="row">
                                                    <div class="col-md-6">
                                                    
                                                    <hr>
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Product Name</label></div>
                                                            <div class="col-12 col-md-9">
                                                                
                                                                @if($result)
                                                                    <input type="text" id="productname" value="{{ $result->productname }}" name="productname" placeholder="Product Name" class="form-control">
                                                                @else
                                                                    <input type="text" id="productname" value="{{ old('productname') }}" name="productname" placeholder="Product Name" class="form-control">
                                                                
                                                                @endif
                                                                <small class="form-text text-muted">
                                                                    @if ($errors->has('productname'))
                                                                        <span class="help-block">
                                                                        <font color='red'>{{ $errors->first('productname') }}</font>
                                                                    </span>
                                                                    @endif
                                                                
                                                                </small>
                                                            </div>
                                                        </div>

                                                        
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Model No.</label></div>
                                                            <div class="col-12 col-md-9">
                                                                
                                                                @if($result)
                                                                    <input type="text" id="modelnumber" value="{{ $result->modelnumber }}" name="modelnumber" placeholder="Model No." class="form-control">
                                                                @else
                                                                    <input type="text" id="modelnumber" value="{{ old('modelnumber') }}" name="modelnumber" placeholder="Model No." class="form-control">
                                                                
                                                                @endif
                                                                <small class="form-text text-muted">
                                                                    @if ($errors->has('modelnumber'))
                                                                        <span class="help-block">
                                                                        <font color='red'>{{ $errors->first('modelnumber') }}</font>
                                                                    </span>
                                                                    @endif
                                                                
                                                                </small>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Category</label></div>
                                                            <div class="col-12 col-md-9">
                                                            
                                                                
                                                                @if($result)
                                                                    
                                                                    <select onchange="categorychange()" name="category" id="category" class="form-control">
                                                                            <option value="{{$result->category}}">{{$result->category}}</option>
                                                                        @foreach($categorys as $category)
                                                                            <option value="{{$category->category}}">{{$category->category}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                @else
                                                                    <select onchange="categorychange()" name="category" id="category" class="form-control">
                                                                        <option value=""></option>
                                                                        @foreach($categorys as $category)
                                                                            <option value="{{$category->category}}">{{$category->category}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                    
                                                                <small class="form-text text-muted">
                                                                
                                                                    @if ($errors->has('category'))
                                                                        <span class="help-block">
                                                                        <font color='red'>{{ $errors->first('category') }}</font>
                                                                    </span>
                                                                    @endif
                                                                
                                                                </small>
                                                            </div>
                                                        </div>
                                                            
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Sub-Category</label></div>
                                                            <div class="col-12 col-md-9">
                                                                
                                                                    @if($result)
                                                                        <select name="subcategory" id="subcategory" class="form-control">
                                                                            <option value="{{$result->subcategory}}">{{$result->subcategory}}</option>
                                                                            @foreach($subcategorys as $subcategory)
                                                                                <option value="{{$subcategory->subcategory}}">{{$subcategory->subcategory}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                      
                                                                    @else
                                                                        <select name="subcategory" id="subcategory" class="form-control">
                                                                           
                                                                        </select>
                                                                    @endif
                                                                <small class="form-text text-muted">
                                                                
                                                                    @if ($errors->has('subcategory'))
                                                                        <span class="help-block">
                                                                        <font color='red'>{{ $errors->first('subcategory') }}</font>
                                                                    </span>
                                                                    @endif
                                                                
                                                                </small>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Selling Cost</label></div>
                                                            <div class="col-12 col-md-9">
                                                                @if($result)  
                                                                    <input type="text" id="currentcost" value="{{ $result->currentcost }}" name="currentcost" placeholder="Selling Cost" class="form-control">
                                                                
                                                                @else
                                                                    <input type="text" id="currentcost" value="{{ old('currentcost') }}" name="currentcost" placeholder="Selling Cost" class="form-control">
                                                                
                                                                @endif
                                                                <small class="form-text text-muted">
                                                                
                                                                    @if ($errors->has('currentcost'))
                                                                        <span class="help-block">
                                                                        <font color='red'>{{ $errors->first('currentcost') }}</font>
                                                                    </span>
                                                                    @endif
                                                                
                                                                </small>
                                                            </div>
                                                        </div>

                                                        
                                                                    <div>
                                                                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                                                            <i class="fa fa-lock fa-lg"></i>&nbsp;
                                                                            <span id="payment-button-amount">Update</span>
                                                                            
                                                                        </button>
                                                                    </div>

                                                    </div>

                                                    <div class="col-md-6">
                                                            <hr>
                                                                <div class="row form-group">
                                                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Product Features</label></div>
                                                                        <div class="col-12 col-md-9">
                                                                            @if($result)  
                                                                                <textarea cols=30 rows=3 id="productfeatures" name="productfeatures" >{{ $result->productfeatures }}</textarea>
                                                                            
                                                                            @else
                                                                                <textarea cols=30 rows=3 id="productfeatures" name="productfeatures" ></textarea>
                                                                            
                                                                            @endif
                                                                <small class="form-text text-muted">
                                                                            
                                                                                @if ($errors->has('productfeatures'))
                                                                                    <span class="help-block">
                                                                                    <font color='red'>{{ $errors->first('productfeatures') }}</font>
                                                                                </span>
                                                                                @endif
                                                                            
                                                                            </small>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                    <div class="row form-group">
                                                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Description</label></div>
                                                                        <div class="col-12 col-md-9">
                                                                            
                                                                            
                                                                            @if($result) 
                                                                                <textarea cols=30 rows=3 id="productdescription" name="productdescription" >{{ $result->productdescription }}</textarea>
                                
                                                                            @else
                                                                                <textarea cols=30 rows=3 id="productdescription" name="productdescription" ></textarea>
                                
                                                                            @endif
                                                                            <small class="form-text text-muted">
                                                                            
                                                                                @if ($errors->has('productdescription'))
                                                                                    <span class="help-block">
                                                                                    <font color='red'>{{ $errors->first('productdescription') }}</font>
                                                                                </span>
                                                                                @endif
                                                                            
                                                                            </small>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                    <div class="row form-group">
                                                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Image</label></div>
                                                                        <div class="col-12 col-md-9">
                                                                             
                                                                            
                                                                                @if($result) 
                                                                                    <img src="{{asset("/imageupload/".$result->imageurl)}}"  alt="No Image">
                                                                            
                                                                                @else
                                                                                    
                                                                                @endif

                                                                            <div class="image-editor">
                                                                                <input type="file" name="imageurl" class="cropit-image-input" id="imageurl" style="border:none"  class="form-control">
                                                                                <div class="cropit-preview"></div>
                                                                                <div class="image-size-label">
                                                                                    Resize image
                                                                                </div>
                                                                                <input type="range" class="cropit-image-zoom-input">
                                                                                <input type="hidden" name="image-data" class="hidden-image-data" />

                                                                            </div>

                                            
                                                                            <small class="form-text text-muted">
                                                                            
                                                                            @if ($errors->has('imageurl'))
                                                                                    <span class="help-block">
                                                                                        <font color='red'>{{ $errors->first('imageurl') }}</font>
                                                                                    </span>
                                                                            @endif
                                                                            
                                                                            </small>
                                                                        </div>
                                                                    </div>


                                                    </div>
                                                    
                                        </div></form>
                                    </div>
                                </div>

                        </div>
                     
                </div>
               <br> <br> <br> 
            </div>
            <!-- .animated -->
            
            <script>
            
                $('#currentcost').on('input', function (event) { 
                this.value = this.value.replace(/[^0-9.]/g, '');
                });

                 $(function() {
            $('.image-editor').cropit({'minZoom':1});

            $('form').submit(function() {
                // Move cropped image data to hidden input
                var imageData = $('.image-editor').cropit('export');
                $('.hidden-image-data').val(imageData);

                // Print HTTP request params
                var formValue = $(this).serialize();
                $('#result-data').text(formValue);

                // Prevent the form from actually submitting
                return true;
            });

        });

        var _URL = window.URL;
        $("#imageurl").change(function (e) {
            var file, img;
            if ((file = this.files[0])) {
                img = new Image();

                var imgsize=this.files[0].size;
                var imgsizee=imgsize/1024
                //var imgsize=imgsizee/1024;
                img.onload = function () {
                    // alert("Width:" + this.width + "   Height: " + this.height);
                    var width=this.width;
                    var height=this.height;

                    if( width < 200 && height < 200 ) {
                        alert("Image size  should  atleast be 200 * 200")
                    }
                    // else if(imgsizee>1000){
                    //   alert("Image size  should  be  Less  than 1000Kbs")
                    // alert(imgsizee);
                    //}
                    else {
                        // function();
                    }


                };
                img.src = _URL.createObjectURL(file);
            }
        });

                function categorychange(){

                    var sto=document.getElementById("subcategory");
                    for(var st = sto.options.length - 1 ; st >= 0 ; st--)
                    {
                        sto.remove(st);
                    }
                    var s = document.getElementById('category');
                    var category = s.options [s.selectedIndex] .value;

                    var select = document.getElementById("subcategory");
                        $.ajax
                        ({
                                url: '{{ route('admingetsubcategory') }}',
                                type:'get',
                                data: {category:category},
                                success: function(data)
                                {   
                                   
                                                var myobject = data['subcategorys'];
                                                for(index in myobject) {
                                                    select.options[select.options.length] = new Option(myobject[index], myobject[index]);
                                                }
                                        
                                }
                         });

                }

                function deleterecord() {
                    if (confirm("Delete This Record")) {
                        $('#pleaseWaitDialog').modal('show');
                    } else {
                        return false;
                    }
                }

              

            </script>
        
@endsection