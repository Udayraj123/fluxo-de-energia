@extends('master_home')

@section('bodyContent')

<!-- titles array -->
@section('headContent')
<title>Buy Product</title>
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
var X;
function getUC(){
	var product_id=document.getElementById('product_id').value;
		//send ajax here.
		$.ajax({
			method: "POST",
			url: "{{ route('productPriceHandle') }}",
			data: {'product_id':product_id},
			success: function(data) {
				// console.log(data);
				bp=parseInt(data['buy_price']);
				RET=parseInt(data['RET']);
				if(RET==-1 && bp==-1){
					//remove
					console.log('Removing : '+product_id);
					$('#product_id option[value="'+product_id+'"]').remove();
				}
				$('#buy_price').val(bp);
				$('#RET').val(RET);
			},

  			error: function(){// Server Disconnected
  				X=data;	
  				console.log('error updating bp, check type X in console'); 
  			}
  		});

	}
	setInterval("getUC()",{{C::get('game.msRefreshRate')}});
	</script>

	<script type="text/javascript">
	$(function () {
		$('#buy_product').on('submit', function (e) {
			e.preventDefault();
			$.ajax({
				type: 'post',
				url: '{{route("buyProduct")}}',
				data: $('#buy_product').serialize(),
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
	<div style="height: 30px;">
	</div>

	<div class="row" align="center">
		<div class="col-md-6" >
			<div class="tablecontainer" style="margin-left:50px;margin-right: 50px; "> 
				<div class="box-header" align="center">
					<h3 class="box-title" style="font-size:28px;opacity:1">Buy Product</h3>
				</div>

				<div class="form-group">
					<table style="width:100%">
						<form id="buy_product">

							{{-- Form::open(array('url' => route("buyProduct"))) --}}
							<tr>

								<td><br>
									<label for="product_id"> Product  : &nbsp;&nbsp;&nbsp; </label>
								</td>
								<td>
									<select class="form-control" name='product_id' onchange="getUC()" id='product_id'>
										@foreach ($products as $prod)
										<option value="{{ $prod->id }}">{{ $prod->god->user->username or 'GOD'}}'s'  {{ $prod->category }} {{ $prod->name }} id: ({{ $prod->id }})</option>
										@endforeach
									</select>
								</td> </tr><tr><td><br>
								<label>buy_price : </td><td><input disabled="true" class="form-control" id='buy_price' value=1472 /></label>	
							</td></tr><tr><td><br>
							<label>RET : </td><td><input disabled="true" class="form-control" id='RET' value=5 /></label>	
						</td></tr><tr><td><br>
						<label>num_units : </td><td><input type='number' class="form-control" name='num_units' value=10 /></label>	
					</td></tr><tr><td align="center" colspan="2">	
<br>
					<input type='submit' class="btn btn-lg" value="Buy Product" />
				</td></tr>

				{{-- Form::close() --}}
			</form>
		</table>
<br>
	</div>
	<!-- form closed -->

</div>
<!-- table container -->
</div>
<!-- /.col -->

<div class="col-md-6">
	<div class="row">
		<div id="boughtProducts" class="tablecontainer" style=" overflow-y:auto;height:35%;margin-left:50px;margin-right   : 50px;"> 
			<div class="box-header with-border">
				<h3 class="box-title"> Available Products</h3>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
var cellData=[];
var currRow=[];
var firstRow=['#','id','From','Product','description','num_units','avl_units','buy_price','quality','ET','bought_at'];
var counter=0;
cellData.push(firstRow);
@foreach ($boughtProducts as $p)
currRow=[];
counter++;
currRow.push(counter.toString());
currRow.push('{{ $p->id }}');
currRow.push('{{ $p->god->user->username }}');
currRow.push('{{ $p->name }}');
currRow.push('{{ $p->description }}');
currRow.push('{{ $p->pivot->num_units }}');
currRow.push('{{ $p->pivot->avl_units }}');
currRow.push('{{ $p->pivot->buy_price }}');
currRow.push('{{ $p->quality }}');
currRow.push('{{ $p->ET }}');
currRow.push('{{ $p->pivot->created_at }}');
cellData.push(currRow);
@endforeach

var cellData=[];
var firstRow=['#','id','From','Product','name','description', 'quality','ET','created_at'];
var counter=0;
cellData.push(firstRow);
@foreach ($products as $p)
currRow=[];
counter++;
currRow.push(counter.toString());
currRow.push('{{ $p->id }}');
currRow.push('{{ $p->god->user->username }}');
currRow.push('{{ $p->category }}');
currRow.push('{{ $p->name }}');
currRow.push('{{ $p->description }}');
currRow.push('{{ $p->quality }}');
currRow.push('{{ $p->ET }}');
currRow.push('{{ $p->created_at }}');
cellData.push(currRow);
@endforeach

insertTable(cellData,"boughtProducts",1);

</script>


@stop