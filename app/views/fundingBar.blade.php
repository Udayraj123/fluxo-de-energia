@extends('master_home')

<!-- titles array -->
@section('headContent')
<title>My Fundings</title>
@stop

<!-- bg sources array -->
@section('bgsource')
god.jpg
@stop


@section('bodyContent') 

<script type="text/javascript">
	var Colors=["aqua","red","green","yellow","blue"];
	var progWidth=750;

	function makeProgress(InvestorNames,Percentages,id,Info){
var progressDiv='<div style="width:'+progWidth+'px;" id="'+id+'"class="container-fluid">';//document.getElementById(id);

var len=InvestorNames.length;
var progressGroup='<div class="progress lg">';
for(var i=0;i<len;i++){
	progressGroup+='<div class="progress-bar progress-bar-'+
	Colors[i%Colors.length]+
	'" style="width: '+Percentages[i]+'%">'+
	'<div class="progress-label">'+
	'<span class="badge bg-yellow" style="font-size:10px">'+InvestorNames[i]+' </span> '+
	Percentages[i]+'% </div></div>';
}
progressGroup+='</div>';


var Q=document.createElement('div');
Q.innerHTML='<div class="row">'+
progressGroup+
'</div>'+
'</div>';

return progressDiv+ '<div class="row">'+
progressGroup+
'</div>'+
'</div>'+
'</div>';//appendChild(Q);
}



</script>
<br>
<div class="row"  style="background:#66ff66;border-radius:10px;margin:5%0%0%2%;opacity:0.85">

	<div class="col-md-12">
		<div id="myFundings" class="container" style="overflow-y:auto;height:75%;background:#66ff66;border-radius:10px;width:100%;opacity:0.85">
			<div class="box-header with-border">
				<h3 class="box-title"> Your Fundings </h3>
			</div>
		</div>
	</div>
</div>
<!-- 
<div class="row"  style="background:#66ff66;border-radius:10px;margin:5%0%0%2%;opacity:0.85">
	<div class="col-md-6">
		<div id="detailFundings" class="container" style="overflow-y:auto;height:75%;background:#66ff66;border-radius:10px;width:100%;opacity:0.85">
			<div class="box-header with-border">
				<h3 class="box-title"> Product Performance </h3>
			</div>
		</div>
	</div>
</div> -->


<script type="text/javascript">
	var cellData=[];
	var cellData2=[];
	var InvestorNames=[];
	var Percentages=[];
	var currRow=[];
	var firstRow=['#','id','product','name','total_shares','Fundings','avl_shares','FT'];//being funded
	var firstRow2=['#','id','product','name','total_shares','avl_shares','Fundings','FT'];//launched
	var counter=0;
	cellData.push(firstRow);
	cellData2.push(firstRow2);
	
	@foreach ($products as $prod)
	currRow=[];
	counter++;
	currRow.push(counter.toString());
	currRow.push('{{ $prod->id }}');
	currRow.push('{{ $prod->category }}');
	currRow.push('{{ $prod->name }}');
	currRow.push('{{ $prod->total_shares }}');

	//Change The following-
	InvestorNames=[];
	Percentages=[] //Length of InvestorNames = Percentages
	Info="Funding Details Here..."

	@foreach ($prod->investors as $inv)
	{{
		$invms=	Investment::where('investor_id',$inv->id)->where('product_id',$prod->id)->get();
		$num_shares=0;
		foreach ($invms as $i) {
			$num_shares += $i->num_shares;
		}
		$total_shares=$prod->total_shares;
		$percentage = $num_shares/$total_shares*100;
	}}
		InvestorNames.push('U'+'{{ $inv->user->username }}'.substr(4));//variables used later
		p1={{ $percentage }}
		Percentages.push(p1);
	@endforeach //cool !

	currRow.push(makeProgress(InvestorNames,Percentages,"{{ $prod->id}}",Info) );
	currRow.push('{{ $prod->avl_shares }}');
	currRow.push('{{ $prod->FT }}');
	@if($prod->being_funded==1)
	cellData.push(currRow);
	@else
	//launched or expired
	cellData2.push(currRow);
	@endif
	@endforeach

	insertTable(cellData,"myFundings",1);
	// insertTable(cellData2,"detailFundings",1);
	
</script>

@stop