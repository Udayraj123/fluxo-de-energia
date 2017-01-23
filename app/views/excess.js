
  function insertTable(cellData,divID,black){
    var start=0;
    var tableContainer=document.getElementById(divID);
    var table1= document.createElement('table');
    table1.className="table table-bordered";
    var tableHeight=cellData.length-start,tableWidth=cellData[start+1].length;

    for(var i=start;i<tableHeight;i++){
      var current_row=table1.insertRow();
      if(i==start && black){
        current_row.style="background:black;color:white";
      }
      for(var j=0; j<tableWidth;j++){
        var current_col=current_row.insertCell();
        current_col.innerHTML='<strong>'+cellData[i%tableHeight][j%tableWidth]+'</strong>';
      }
    }
    tableContainer.innerHTML=table1;
    // tableContainer.appendChild(table1);
  }

    disables=['domain_val'];
  disables2=['domain_val2'];
  hostel_roles=[];

  //load the javascript array with data from backend
  //load bound domain roles (hostel & department)
  @foreach(Config::get('preset.hostel_roles') as $r )
  hostel_roles.push('{{ $r }}');
  @endforeach

  department_roles=[];
  @foreach(Config::get('preset.department_roles') as $r )
  department_roles.push('{{ $r }}');
  @endforeach

  //load the javascript array with data from backend
  //load filters for each role 
  checks={};
  @foreach(Config::get('preset.checks') as $k=>$r )
  row=[]; @foreach($r as $ki=>$ri ) row.push('{{$ri}}'); @endforeach checks['{{$k}}']=(row);
  @endforeach

  function toggleInputs(){
   x=document.getElementById('role').value;
   if(hostel_roles.indexOf(x)<0){
     for(i=0;i<disables.length;i++)document.getElementById(disables[i]).disabled="true";
   } 
 else {
   for(i=0;i<disables.length;i++)document.getElementById(disables[i]).removeAttribute('disabled');
 }
if(department_roles.indexOf(x)<0){
  for(i=0;i<disables2.length;i++)document.getElementById(disables2[i]).disabled="true";
}
else {
  for(i=0;i<disables2.length;i++)document.getElementById(disables2[i]).removeAttribute('disabled');
} 
}