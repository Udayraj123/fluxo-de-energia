<head>
<script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
<link rel="stylesheet" src="{{ URL::asset('bootstrap/css/bootstrap.css') }}"/>
@yield('headContent')
</head>

<body>

@yield('bodyContent') 
<!-- //this is like a {%block %} with {% endblock %} -->
	
</body>