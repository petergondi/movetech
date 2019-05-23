@extends('adminlayout')
@section('content')   

            <!-- Animated -->
            <div class="animated fadeIn">
                
                <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">Reply Mail</strong>
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

                                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Subject</th>
                                                    <th>Body</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                <form role="form" name="form1" class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('submitreplytoemailbody') }}">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" id="id" name="id" value="{{ $result->id }}">
                                                    <tr>
                                                    <td>
                                                        @if($result)
                                                            {{ $result->fname }}
                                                        @else
                                                        
                                                        @endif
                                                    </td>
                                                    <td>
                                                        
                                                        @if($result)
                                                            {{ $result->subject }}
                                                        @else
                                                        
                                                        @endif
                                                    </td>
                                                    <td>
                                                        
                                                        @if($result)
                                                            {{ $result->question }}
                                                        @else
                                                        
                                                        @endif
                                                    
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td><b>Mail</b></td>
                                                    <td></td>
                                                    <td>
                                                        <textarea id="replyquestion" name="replyquestion" cols='40' rows='6' ></textarea>
                                                        
                                                        @if ($errors->has('replyquestion'))
                                                            <span class="help-block">
                                                            <font color='red'>{{ $errors->first('replyquestion') }}</font>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    </tr>

                                                    <tr>
                                                    <td>
                                                        
                                                        
                                                    </td>
                                                    <td>
                                                    
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-primary" type="submit">Submit</button>
                                                    </td>
                                                    </tr>
                                                </form>
                                                
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                </div>
               <br> <br> <br> <br> <br> <br> <br> <br>
            </div>
            <!-- .animated -->
        
@endsection