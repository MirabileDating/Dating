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
						<option value="{{value}}">{{name}}</option>
					{{ END }}	
					</select>
	</td>
	<td width="20%"><b>{{A3}}:</b></td>
	<td width="30%">
					<select style="width:60px" id="fromage" name="fromage" onchange="getStates(this);" size="1">
					{{ BEGIN fromagelist}}
						<option value="{{value}}">{{value}}</option>
					{{ END }}	
					</select>
					-					
					<select style="width:60px" id="toage" name="toage" onchange="getStates(this);" size="1">
					{{ BEGIN toagelist}}
						<option value="{{value}}">{{value}}</option>
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
	</fieldset>
	{{ BEGIN listdata }}
		<img src="{{image}}" alt="{{name}}" style="width:88px;height:88px;"/>
		Distance from you: {{distance}} km	<br>
	{{ END listdata }}	
{{paginator}} 	
{{ITEMS}} {{$paginate.first}} - {{$paginate.last}} {{OF}} {{$paginate.total}} {{DISPLAYED}}
</p>

<hr />
	<div id="paginate">
 			<p>{{prev}} {{middle}} {{next}}
			</p>

	</div>	
</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}

