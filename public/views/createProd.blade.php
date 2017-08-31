
@extends('master_home')

@section('bodyContent')
<br>
<script type="text/javascript">
    var c1={{ $c1 }};
    var c2={{ $c2 }};
    var c3={{ $c3 }};
    var c4={{ $c4 }};
    var k ={"seed" : 500,"fertilizer" : 2000,"land" : 7000};
    function getUC(){

        var ET=document.getElementById('ET').value;
        var FT=document.getElementById('FT').value;
        var Tol=document.getElementById('Tol').value;
        var quality=document.getElementById('quality').value;
        var type=document.getElementById('category').value;
        
        var bp=k[type.toString()];
        return bp*(c1*quality+c2*FT+c3*ET)*(1+c4*Tol);
    }

    function update(){

        var u=document.getElementById('unit_price');
        var t=document.getElementById('total_cost');
        var n=document.getElementById('avl_units');
        u.value=getUC();
        t.value=u.value*n.value;
        console.log(u.value);
    }
    setInterval("update()",1000);

</script>
<pre>
    {{ Form::open(array('url' => route("createProduct"))) }}

    All Fields are required : 
    <label>name: <input type='text' name='name' id='name' value="prod" /></label><br>
    <label>TYPE: <select name='category' id='category' >
       <option value="seed"> Seed</option>
       <option value="land"> Land</option>
       <option value="fertilizer"> Fertilizer</option>
   </select>
</label><br>
<label>description: <input type='text' name='description' id='description' value="desc" /></label><br>

<label>quality : <input min="5" max="100" value="10" type="range" name='quality' id='quality'/></label><br>
<label>ET : <input min="5" max="30" value="5" type="range" name='ET' id='ET'/></label><br>
<label>FT : <input min="2" max="10" value="5" type="range" name='FT' id='FT'/></label><br>
<label>Tolerance : <input min="0" max="100" type="range" name='Tol' id='Tol' value=4/></label><br>
<label>unit_price: <input readonly="readonly" type='number' id='unit_price' name='unit_price' value="2000"/></label><br>
<label>avl_units: <input type='number' name='avl_units' id='avl_units' value=100 /></label><br>
<!-- Disabled ones are not sent -->
<label>total_cost: <input disabled="true" type='number' id='total_cost' name='total_cost' value="200000"/></label><br>

<label>total_shares: <input type='number' name='total_shares' id='total_shares' value=50 /></label><br>


<input type='submit' value="SAVE" />
{{ Form::close() }}

</pre>
<br>
@endsection
