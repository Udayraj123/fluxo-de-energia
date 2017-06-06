<head>
<script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<link rel="stylesheet" src="{{ URL::asset('bootstrap/css/bootstrap.css') }}"/>
@yield('headContent')
</head>

<body>
<script>

function ajaxer(){
    $.ajax({
  method: "POST",
  url: "<?php echo route('decayHandle'); ?>",
  
  success: function(data) {
    le=data['le'];
    decay=data['decay'];
    console.log("decayed to",le);
    $('#LE').val(parseInt(le));
  },
  
  error: function(){// ERROR NOT HANDLING ?
    alert('user not in db'); 
  }
});
}

</script>

<button onclick='ajaxer();'>AJAX</button>

@yield('bodyContent') 
<!-- //this is like a {%block %} with {% endblock %} -->
	
</body>