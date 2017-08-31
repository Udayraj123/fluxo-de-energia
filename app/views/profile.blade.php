<script type="text/javascript">
  function convertDictToArr(dict){
    arr = [];
    for (var d in dict){
      arr.push(dict[d]);
    }
    return arr;
  }
  function inv_detail(){
    $.ajax({
      method: "POST",
      url: "{{ route('getInvDetail') }}",
      //data: { '': redeemLE },
    })
    .success(function( data1 ) {
      // console.log(convertDictToArr(data1[0]));

      var cellData=[];
      var firstRow=['Product ID','Product Name','Product Category','God Name','Total Inserted', 'Total Received'];
      var counter=0;
      cellData.push(firstRow);
      for(var i=0; i<data1.length ;i++){
        cellData.push(convertDictToArr(data1[i]));
      }    
      insertTable(cellData,'inv_table',1);
      


      
    });
  }
  window.onload=inv_detail;
</script>


<!-- ------------ -->

<div class="col-xs-6" id="inv_table">

</div>

<!-- ------------ -->