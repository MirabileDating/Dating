{{ include('templates/header.tpl') }}
					

<div id="content">
<fieldset>
	<legend>{{A1}}</legend>
		<form action="search.php" method="post">

	<table width="580 "border="0">
	<tr>
	<td width="20%"><b>{{A2}}:</b></td>
	<td width="30%">
					<select style="width:140px" id="gender" name="gender" onchange="getStates(this);" size="1">
					{{ BEGIN searchlist}}
						<option value="{{value}}" {{IF value==gender}}selected="selected"{{END}}>{{name}}</option>
					{{ END }}	
					</select>
	</td>
	<td width="20%"><b>{{A3}}:</b></td>
	<td width="30%">
					<select style="width:60px" id="fromage" name="fromage" onchange="getStates(this);" size="1">
					{{ BEGIN fromagelist}}
						<option value="{{value}}" {{IF value==fromage}}selected="selected"{{END}}>{{value}}</option>
					{{ END }}	
					</select>
					-					
					<select style="width:60px" id="toage" name="toage" onchange="getStates(this);" size="1">
					{{ BEGIN toagelist}}
						<option value="{{value}}" {{IF value==toage}}selected="selected"{{END}}>{{value}}</option>
					{{ END }}	
					</select>	
	
	</td>
	</tr>
	<tr>
	<td colspan="4" align="center">
				<input name="submit" type="submit" value="{{A1}}" /><br />
	</td>
	</tr>


	</table>
	</form>
	
	<hr size="1" />
	<table border="0" width="580" align="center" cellpadding="0" cellspacing="0" >
	{{ BEGIN listdata }}
	<tr>
	<td rowspan="5" width="90" align="center">
		<img src="{{image}}" alt="{{name}}" style="width:88px;height:88px;"/>
	</td>
	<td width="410">
		Distance: {{distance}} km
	</td>
	<tr>
	<td>{{name}}</td>
	</tr>
	<tr>
	<td>{{w_gender}}</td>
	</tr>
	<tr>
	<td>{{birthdate}}</td>
	</tr>
	<tr>
	<td>{{city}}, {{country}}</td>
	</tr>
	{{ END listdata }}	
	</table>
	<hr size="1" />
{{paginator}} 	
{{ITEMS}} {{$paginate.first}} - {{$paginate.last}} {{OF}} {{$paginate.total}} {{DISPLAYED}}
</p>

<hr />
	<div id="paginate">
 			<p>{{prev}} {{middle}} {{next}}
			</p>

	</div>	
	</fieldset>
</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}

