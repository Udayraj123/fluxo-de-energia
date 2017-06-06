core table code.js


<script type="text/javascript">
  var cellData=[
  "SeedTable",
  ['#','Seed','Price','Growth time'],
  ['1.','seed1','-','-'],
  ['2.','seed2','-','-'],
  ['3.','seed3','-','-'],
  ['4.','seed4','-','-'],
  ['5.','seed5','-','-'],
  ] ;
var start=0;
var tableContainer=document.getElementById(cellData[start]);
var table1= document.createElement('table');
table1.className="table table-bordered";
var tableHeight=cellData.length-2,tableWidth=cellData[start+1].length;

for(var i=start+1;i<tableHeight;i++){
  var current_row=table1.insertRow();
  if(i==start+1)current_row.style="background:black;color:white";
  for(var j=0; j<tableWidth;j++){
    var current_col=current_row.insertCell();
    current_col.innerHTML='<strong>'+cellData[i%tableHeight][j%tableWidth]+'</strong>';
  }
}
SeedTable.appendChild(table1);



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
      tableContainer.appendChild(table1);
    }
    function insertTable2(cellData,divID,black){

      var start=0;
      var tableContainer=document.getElementById(divID);
      var tableHeight=cellData.length-start,tableWidth=cellData[start+1].length;
      var n = 12/tableWidth;
      for(var i=start;i<tableHeight;i++){
        var current_row=document.createElement('div');  current_row.className="row";
        if(i==start && black){
          current_row.style="background:black;color:white";
        }
        for(var j=0; j<tableWidth;j++){
          var current_col=document.createElement('div');  current_col.className="col-md-"+n;
          current_col.innerHTML='<strong>'+cellData[i%tableHeight][j%tableWidth]+'</strong>';
          current_row.appendChild(current_col);
        }
        tableContainer.appendChild(current_row);
      }
    }

</script>