<head>
	<script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('bootstrap/css/bootstrap.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('font-awesome/css/font-awesome.css') }}">
	@yield('headContent')
	<style type="text/css">
		body{
			padding: 3%;
		}
	</style>
</head>

<body>
	<script type="text/javascript">
		function selectAll(uniq){
			x=document.getElementsByTagName('checkbox');
			for (var i = 0;i<x.length; i++) {
				if(x[i].id.indexOf(uniq)>0)x[i].checked="checked";
			}
		}

		var gCounter=0;
		function CheckboxCol(id){
			
			text=id;
			var Icon='<span style="font-size:17px;">&nbsp '+text+'&nbsp</span>';
			gCounter++;
			chk='<label class="btn btn-block btn-warning" for="check_'+id+'_'+gCounter+'" style="height:100%;width:100%;"><input class="approvals" type="checkbox" name="approvals" id="check_'+id+'_'+gCounter+'" value="'+id+'"></input>'+
			Icon+'</label>';
			return chk;
		}
		function sendForms(role_id,val){
			approvals=document.getElementsByName('approvals');
			selected_role=document.getElementById(role_id).value;
			console.log(approvals);
			data=[];
			for(i=0;i<approvals.length;i++){
				if(approvals[i].checked)data.push(approvals[i].value);
			}
			console.log(data);
			// ajax data
			$.ajax({
				method: "POST",
				url: "{{ route('approveStuds') }}", 
				data: {'studIDs':data,'selected_role':selected_role, 'val':val},
				success: function(status) {
					console.log(status);
					$('#status').html(status['status']);
					updateTable(role_id);
				},
				error: function(){
					console.log('error !'); 
				}
			});
		}

		function requestButton(text,role_id,val,down){
			return "<button class='btn btn-default btn-m' type='button' onclick='sendForms(\""+role_id+"\","+val+")'><i class='fa fa-thumbs-o-"+ (down?"down":"up") +"'></i> "+text+"</button>";
		}
		function centerRow(text){
			return "<span class='text-muted' >"+text+"</span>";
		}
		
		function insertSelTable(checkB,cellObjData,divID,role_id,table_fields,table_fields2){

			var tableContainer=document.getElementById(divID);
			var table1= document.createElement('table');
			table1.className="table table-bordered table-striped";
			var zeroRow=table1.insertRow();
			zeroRow.insertCell().innerHTML=requestButton('Approve',role_id,1,0);
			zeroRow.insertCell().innerHTML=requestButton('Unapprove',role_id,0,1);
			zeroRow.insertCell().innerHTML="<div id='status'></div>";
			var firstRow=table1.insertRow();
			firstRow.style="background: #123456;color:white";
			if(checkB==1)firstRow.insertCell().innerHTML='Select';
			for(var i=0;i<table_fields2.length;i++)
				if(table_fields2[i].toLowerCase()!='id')
					firstRow.insertCell().innerHTML=table_fields2[i];

				empty=1;
				cellObjData.forEach(function(row,counter){
					empty=0;
					var current_row=table1.insertRow();
					if(checkB==1)current_row.insertCell().innerHTML=CheckboxCol(row['id']);

					table_fields.forEach(function(col){
						if(col.toLowerCase()!='id')current_row.insertCell().innerHTML='<strong>'+row[col]+'</strong>';
					});
				});
				if(empty==1)table1.insertRow().insertCell().innerHTML=centerRow('No Entries to review here...');
				tableContainer.innerHTML=table1.outerHTML;
			// tableContainer.appendChild(table1);
		}

		function insertVertTable(checkB,cellObjData,divID,role_id,table_fields,table_fields2){

			var tableContainer=document.getElementById(divID);
			var table1= document.createElement('table');
			table1.className="table table-bordered table-striped";
			table1.style="width:200px";
			var firstRow=table1.insertRow();
			firstRow.style="background: #123456;color:white";
			col_fields=['Sign Field','Info'];//'e-Signed by'];//table_fields2

			for(var i=0;i<col_fields.length;i++)
				firstRow.insertCell().innerHTML=col_fields[i];

			cellObjData.forEach(function(row,counter){//this should be 1
				table_fields.forEach(function(col){
					var current_row=table1.insertRow();
					current_row.insertCell().innerHTML=col;//CheckboxCol(row['id']);
					current_row.insertCell().innerHTML='<strong>'+row[col]+'</strong>';
					// current_row.insertCell().innerHTML= row[col];
					//add columns as cells here.
				});
			});
			tableContainer.innerHTML=table1.outerHTML;
				// tableContainer.appendChild(table1);
			}

			function insertStudTable(checkB,cellObjData,divID,role_id,table_fields,table_fields2){

				var tableContainer=document.getElementById(divID);
				var table1= document.createElement('table');
				table1.className="table table-bordered table-striped";
				var firstRow=table1.insertRow();
				firstRow.style="background: #123456;color:white";
				if(checkB==1)firstRow.insertCell().innerHTML='Select';

				col_fields=table_fields2;//['Sign Field','Info','e-Signed by'];
				for(var i=0;i<col_fields.length;i++)
					if(col_fields[i].toLowerCase()!='id')
						firstRow.insertCell().innerHTML=col_fields[i];

				cellObjData.forEach(function(row,counter){//this should be 1
					var current_row=table1.insertRow();
					if(checkB==1)current_row.insertCell().innerHTML=CheckboxCol(row['id']);
					table_fields.forEach(function(col){
						if(col.toLowerCase()!='id' || col.toLowerCase()!='approval id' )
							current_row.insertCell().innerHTML='<strong>'+row[col]+'</strong>';
					});
				});
				tableContainer.innerHTML=table1.outerHTML;
					// tableContainer.appendChild(table1);
				}

			</script>
			<!-- //this is like a {%block %} with {% endblock %} -->
			@yield('bodyContent') 
		</body>