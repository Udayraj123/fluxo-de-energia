function newUser(){
	x=document.getElementsByTagName('input');
	var data={};
	for(i=0;i<x.length;i++){
		data[x[i].name.toString()]=x[i].value;
	}
	$.ajax({
		method: "POST",
		url: "{{ route('createUser') }}",
		data: data,
	})
	.success(function( resp) {
		alert(resp['resp']);
	});
}