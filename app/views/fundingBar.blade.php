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
	// var cellData2=[];
	var InvestorNames=[];
	var Percentages=[];
	var currRow=[];
	var preProg=['id','launched','category','name','total_shares'];
	var postProg=['avl_shares','FT'];
	var firstRow=['#','id','is Launched?','category','name','total_shares','Fundings','avl_shares','FT'];//being funded
	// From backend = ['id', 'category', 'name', 'total_shares', 'avl_shares', 'FT', ];
	// var firstRow2=['#','id','category','name','total_shares','Fundings','avl_shares','FT'];//launched
	var counter=1;
	cellData.push(firstRow);
	// cellData2.push(firstRow2);
	// Now use ajax for this - 
	var funding_products = {{json_encode($funding_products)}};

	for (var i = 0; i < funding_products.length; i++) {
		cr = funding_products[i];
		currRow=[counter++];
		for (var j = 1; j < preProg.length; j++) {
	currRow.push(cr[preProg[j]])
		}
		currRow.push(makeProgress(cr.InvestorNames,cr.Percentages,cr.id,cr.Info));
		for (var j = 1; j < postProg.length; j++) {
			currRow.push(cr[postProg[j]])
		}
		cellData.push(currRow);
}
	insertTable(cellData,"myFundings",1);
	// insertTable(cellData2,"detailFundings",1);
	
</script>

@stop