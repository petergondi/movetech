
@extends('viewproductslayout')
<style>
.checkoutform{
    border: 1px solid #FE980F;
    padding-left: 60px;
    padding-right: 60px;
}
</style>
@section('content')  
 
        <div class='row' >
                    <div class="col-sm-12" >
                            <center><h2><font color="red"><span class="glyphicon glyphicon-exclamation-sign"></span></font></h2></center>
                            <div class="col-sm-2" >
                            </div>
                            <div class="col-sm-8" >
                            <div class="checkoutform" >
                                
                                <center>
                                            @foreach (['danger', 'warning', 'success', 'info'] as $msgfin)
                                                @if(Session::has('alert-' . $msgfin))
                                                
                                                      <font color='red'>  {{ Session::get('alert-' . $msgfin) }} </font> 
                                                @endif
                                            @endforeach          
                                </center>
                                <br><br>
                               <center> No Item in the Cart<center>
                                <br><br>
                                                
                                    </div>
                            </div>
                            <div class="col-sm-2" >
                            </div>                        
                    </div>
        </div>
@endsection