@extends('master_home')

<!-- titles array -->
@section('headContent')
<title>Energy</title>
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
			url: "{{ route('bidHandle') }}",
			data: {'product_id':product_id},
			success: function(data) {
				console.log(data);
				$('#bid_price').val(parseInt(data['bid_price']));
				$('#avl_shares').val(parseInt(data['avl_shares']));
				$('#num_shares').attr('max',data['avl_shares']);
				$('#RFT').val(parseInt(data['RFT']));
			},

  			error: function(data){// Server Disconnected
  				X=data;	
  				alert('error updating bp, check type X in console'); 
  			}
  		});

	}
	setInterval("getUC()",{{C::get('game.msRefreshRate')}});
	</script>
	<!-- ------------------------- -->
	<script>
	$(function () {
		$('#make_investment').on('submit', function (e) {
			$('#make_investment').attr('disabled',true);
			e.preventDefault();
			$.ajax({
				type: 'post',
				url: '{{route("makeInvestment")}}',
				data: $('#make_investment').serialize(),
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

	<br>
	<div class="row" align="center">

		<div class="col-md-6" >
			<div class="tablecontainer" style="margin-left:50px;margin-right: 50px;"> 
				<div class="box-header" align="center">
					<h3 class="box-title" style="font-size:28px;opacity:1">Make Investment</h3>
				</div>


				<div class="form-group">

					<table style="width:100%">
						<form id="make_investment">
							{{-- Form::open(array('url' => route("makeInvestment"))) --}}
							<tr>

								<td><br>
									<label for="product_id"> Product Type  : &nbsp;&nbsp;&nbsp; </label>
								</td>
								<td>
									<select class="form-control" onchange="getUC()" name='product_id' id='product_id'>
										@foreach ($products as $prod)
										<option value="{{ $prod->id }}">{{ $prod->god->user->username or 'GOD'}}'s'  {{ $prod->category }} {{ $prod->name }} id: ({{ $prod->id }})
										</option>
										@endforeach
									</select>
								</td> </tr>
								<tr><td><br>
									<label>Current Bidding Price : </td><td><input class="form-control" disabled="true" type='number' id='bid_price' value=0 /></label>
								</td></tr>
								<tr><td><br>
									<label>Remaining Funding Time : </td><td><input disabled="true" class="form-control" type='number' id='RFT' value=0 /></label>
								</td></tr>
								<tr><td><br>
									<label>Available Shares : </td><td><input disabled="true" class="form-control" type='number' id='avl_shares' value=0 /></label>
								</td></tr>
								<tr><td><br>
									<label>Number Of Shares : </td><td><input type='number' name='num_shares' class="form-control" id='num_shares' max=100 min=0 value=10 /></label>
								</td></tr>
								<tr><td colspan="2" align="center" ><br> <input type='submit' class="btn btn-lg btn-default" value="Make Investment"/> 
								</td></tr>

								{{-- Form::close() --}}
							</form>
						</table>
						<br>
					</div>

					<!-- /.box-header -->

				</div>
			</div>
		</div>

		<div class="col-md-6" style="position: relative; left: 8%; top:5%;">
			<div id="productLaunched" class="container" style="overflow-y:auto;height:75%;background:#66ff66;border-radius:10px;width:100%;margin:-51%0%0%80%;opacity:0.85">
				<div class="box-header with-border">
					<h3 class="box-title"> Upcoming Products</h3>
				</div>


				
			</div>
		</div>


		<script type="text/javascript">
		var cellData=[];
		var currRow=[];
		var firstRow=['#','id','product','Owner','name','description','bid price','quality','FT','RFT'];
		var counter=0;
		cellData.push(firstRow);
		
		@foreach ($products as $prod)
		currRow=[];
		counter++;
		currRow.push(counter.toString());
		currRow.push('{{ $prod->id }}');
		currRow.push('{{ $prod->category }}');
		currRow.push('{{ $prod->god->user->username }}');
		currRow.push('{{ $prod->name }}');
		currRow.push('{{ $prod->description }}');
		currRow.push('{{ $prod->bid_price }}');
		currRow.push('{{ $prod->quality }}');
		currRow.push('{{ $prod->FT }}');
		currRow.push('{{ Game::getRFT($prod) }}');
		cellData.push(currRow);
		@endforeach

		insertTable(cellData,"productLaunched",1);
		
		</script>

		@stop