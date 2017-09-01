@extends('master_home')
<!-- titles array -->
@section('headContent')
<title>Create Product</title>
<style type="text/css">
.tablecontainer{
  padding-right: 30px;
  padding-left: 30px;
  background:#66ff66;border-radius:10px;opacity:0.85;
}
</style>
@stop

<!-- bg sources array -->
@section('bgsource')
god.jpg
@stop


@section('bodyContent') 
<script type="text/javascript">
c={{json_encode(Config::get('game.baseCIs'))}};

var c1= c['c1'];
var c2= c['c2'];
var c3= c['c3'];
var c4= c['c4'];
    var k = {{json_encode(C::get('game.basePrices'));}};//direct dictionary it is ! {"seed" : 500,"fertilizer" : 2000,"land" : 7000};
    function getUC(){

      var ET=document.getElementById('ET').value;
      var FT=document.getElementById('FT').value;
      var Tol=document.getElementById('Tol').value;
      var quality=document.getElementById('quality').value;
      var type=document.getElementById('category').value;

      var bp=k[type.toString()];
      return bp*(c1*quality+c2*FT+c3*ET)*(1+c4*Tol);
    }

    function update(){

     var u=document.getElementById('unit_price');
     var t=document.getElementById('total_cost');
     var n=document.getElementById('avl_units');
     u.value=getUC();
     total_cost=u.value*n.value;
     t.value=total_cost;

     le=$('#le').val();
     lowerTHR=$('#lowerTHR').val();
     dis = (le - total_cost < lowerTHR);
     $('#createProd').attr('disabled',dis);
     
     // console.log(u.value);
   }
   setInterval("update()",{{C::get('game.msRefreshRate')}});

   function updateProdList(){
//make a function in GC to return the products array : notifn of purchases
}
</script>

<!-- ------------------------- -->
<script>
$(function () {
  $('#create_product').on('submit', function (e) {
    e.preventDefault();
    $('#create_product').attr('disabled',true);
    $.ajax({
      type: 'post',
      url: '{{route("createProduct")}}',
      data: $('#create_product').serialize(),
      success: function (data) {
        $('#txn_msg').html(data);
        $('#myModal').modal('show');
        $('#myModalClose').click(reloadPage);
      }
    });
  });
});
</script>


<!-- ------------------------- -->

<div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Your Transaction Details</h4>
      </div>
      <div class="modal-body">
        <p id="txn_msg">Transcation Message</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="myModalClose" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ------------------------- -->
<!-- 
<div class="well" style="background:#3399ff">
  <input id="ex6" type="text" data-slider-min="-5" data-slider-max="20" data-slider-step="1" data-slider-value="3" data-value="8" value="8" style="display: none;">
  <span id="ex6CurrentSliderValLabel">Price <span id="ex6SliderVal">8</span></span>
</div>
<<<<<<< HEAD
<div class="row" align="center">
=======
Not required anymore
 -->
<div style="height: 30px;">
</div>
 <div class="row" align="center">
 <div class="col-md-6" >
   <div class="tablecontainer" style="margin-left:50px;margin-right   : 50px;"> 
     <div class="box-header" align="center">
       <h3 class="box-title" style="font-size:28px;opacity:1">Create Product</h3>
     </div>

     <div class="form-group">

       <table  style="width:100%">
         <form id="create_product">
           {{-- Form::open(array('url' => route("createProduct"))) --}}
           <tr>
            <td><br><label>Name : </td> 
            <td><input type='text' class="form-control" name='name' id='name' value="prod" /> </label> </td>
          </tr>
          <tr>

            <td><br> <label for="fruit_id"> Category :
            </td>
            <td>
             <select class="form-control"  class="form-control"  name='category' id='category'>
              <option value="seed"> Seed</option>
              <option value="land"> Land</option>
              <option value="fertilizer"> Fertilizer</option>
            </select>
          </label>
        </td>
      </tr>
      <tr><td><br>
        <label>Description : </label> </td><td> <input type='text' name='description'  class="form-control"  html="false" id='description' value="desc" />
      </td></tr><tr><td><br>
      <label>Quality : </td><td> <input min="5" max="100"  oninput="update()" value="10" type="range" name='quality' id='quality'/></label> 
    </td></tr><tr><td><br>
    <label>Expiry Time : </td><td> <input min="5" max="{{C::get('game.maxET')}}"  oninput="update()" value="30" type="range" name='ET' id='ET'/></label>
  </td></tr><tr><td><br>
  <label>Funding Time : </td><td> <input min="2" max="{{C::get('game.maxFT')}}"  oninput="update()" value="30" type="range" name='FT' id='FT'/></label>
</td></tr><tr><td><br>
<label>Tolerance : </td><td> <input min="0" max="100" type="range" name='Tol' id='Tol'  oninput="update()" value=4/></label>
</td></tr><tr><td><br>
<label>Unit Price: </td><td> <input readonly="readonly" type='number' class="form-control" id='unit_price' name='unit_price' value="2000"/></label>
</td></tr><tr><td><br>
<label>Available Units: </td><td> <input type='number' name='avl_units' class="form-control" id='avl_units' value=100 /></label>
</td></tr><tr><td><br>
<!-- Disabled ones are not sent -->
<label>Total Cost: </td><td> <input disabled="true" type='number' class="form-control" id='total_cost' name='total_cost' value="200000"/></label>
</td></tr><tr><td><br>
<label>Total Shares: </td><td> <input type='number' class="form-control" name='total_shares' id='total_shares' value=50 /></label>
</td></tr><tr><td colspan="2" align="center"><br>
<input type='submit' value="Create Product" class="btn btn-default btn-lg" id='createProd' />
</td></tr>
</form>
{{-- Form::close() --}}
</table>
<br>
</div>
</div>
</div>
<div class="col-md-6">
 <div class="row">
   <div id="selfProducts" class="tablecontainer" style=" overflow-y:auto;height:35%;margin-left:50px;margin-right   : 50px;"> 
    <div class="box-header with-border">
      <h3 class="box-title"> selfProducts</h3>
    </div>
  </div>
</div>
<div class="row" style="margin-top: 30px;">
 <div  id="launchedProducts" class="tablecontainer" style="overflow-y:auto;height:40%;margin-left:50px;margin-right  : 50px;"> 
   <div class="box-header with-border">
     <h3 class="box-title"> launchedProducts</h3>
   </div>
 </div>
</div>

</div>


<script type="text/javascript">
var cellData=[];
var cellData2=[];
var currRow=[];
var firstRow=['#','id','name','description','quality','total_shares','bid_price','FT','created_at'];
var firstRow2=['#','id','name','description','quality','total_units','unit_price','ET','launched_at'];
var counter=0;
cellData.push(firstRow);
cellData2.push(firstRow2);

@foreach ($products as $p)

currRow=[];
counter++;
currRow.push(counter.toString());
currRow.push('{{ $p->id }}');
currRow.push('{{ $p->name }}');
currRow.push('{{{ $p->description }}}');
currRow.push('{{ $p->quality }}');
@if($p->being_funded==1)
currRow.push('{{ $p->total_shares }}');
currRow.push('{{ $p->bid_price }}');
currRow.push('{{ $p->FT }}');
var t = "{{ $p->created_at }}".split(/[- :]/);
var d = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));
currRow.push(d.toLocaleTimeString());
@else
currRow.push('{{ $p->total_units }}');
currRow.push('{{ $p->unit_price }}');
currRow.push('{{ $p->ET }}');
x=new Date(1000*{{ $p->launched_at or '1'}});
currRow.push(x.toLocaleTimeString());
@endif

@if($p->being_funded==1)
cellData.push(currRow);
@else
cellData2.push(currRow);
@endif
@endforeach

insertTable(cellData,"selfProducts",1);
insertTable(cellData2,"launchedProducts",1);
</script>
<script>

      // $(document).ready(function() {
        /* Example 1 */
        $("#ex6").slider();
        $("#ex6").on("slide", function(slideEvt) {
          $("#ex6SliderVal").text(slideEvt.value);
        });    


        document.getElementById('#ex6CurrentSliderValLabel').style='display:None'
        setTimeout("$('#ex6CurrentSliderValLabel').hide()",3000);


        </script>


        @stop




        @endsection
