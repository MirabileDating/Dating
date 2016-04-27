{{ include('templates/header.tpl') }}
<div id="contentWrapper">
<div id="leftColumn1">  
	{{ include('templates/leftbar.tpl') }}
</div>
<div id="rightColumn1">
	{{ include('templates/rightbar.tpl') }}
</div>

<div id="content">

	<table width="600 "border="1">
	<tr>
		<td width="30%">
		{{A2}}
		</td>
		<td colspan="2" width="40%">
	
		</td>

	</tr>
	<tr>
	<td>
	{{A3}}
	</td>
	<td colspan="2">
	<input id="nickname" name="nickname" type="text" size="30" maxlength="30" value="{{$name}}" />
	</td>
	</tr>
	<tr>
	<td>
	{{A4}}: 
	</td>
	<td colspan="2">
                <select style="width:160px" id="country" name="country" onchange="getStates(this);" size="1">
				{{ BEGIN daylist }} 
                    <option value="{{ value }}" {{IF value == $day}}selected="selected"{{END}}>{{ name }}  </option>					
				{{ END daylist }}
                </select>	
	</td>

	</tr>

	<tr>
	<td>
	
	{{A5}}
	</td>
	<td colspan="2">
                <select style="width:160px" id="state" name="state" onchange="getCities(country,this);" size="1">
				{{ BEGIN yearlist }} 
                    <option value="{{ value }}" {{IF value == $year}}selected="selected"{{END}}>{{ name }} </option>					
				{{ END }}
                </select>	
	</tr>
	<tr>
	<td>
	{{A6}}
	</td>
	<td colspan="2">
                <select style="width:160px" id="city" name="year" size="1">
				{{ BEGIN yearlist }} 
                    <option value="{{ value }}" {{IF value == $year}}selected="selected"{{END}}>{{ name }} </option>					
				{{ END }}
                </select>	
	</tr>
	</table>

</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}

