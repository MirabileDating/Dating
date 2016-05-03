{{ include('templates/header.tpl') }}


<div id="content">
<fieldset>
	<legend>{{A1}}</legend>
		<form action="editmember.php" method="post">
	<table width="580 "border="1">
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
	<input id="name" name="name" type="text" size="30" maxlength="30" value="{{profile.name}}" />
	</td>
	</tr>
	<tr>
	<td>
	{{A4}}: 
	</td>
	<td colspan="2">
                <select style="width:240px" id="country" name="country" onchange="getStates(this);" size="1">
			 {{UNLESS profile.country}}
                	<option value="" selected="selected">{{A8}}</option>
					{{ BEGIN countrylist}}
						<option value="{{countryname}}">{{countryname}}</option>
					{{ END }}
                {{ELSE}}			 
			
					{{ BEGIN countrylist}}
						<option value="{{countryname}}" {{IF countryname==profile.country}}selected="selected"{{END}}>{{countryname}}</option>
					{{ END }}
				{{ END }}

                </select>
	</td>

	</tr>

	<tr>
	<td>
	
	{{A5}}
	</td>
	<td colspan="2">
                <select style="width:220px" id="state" name="state" onchange="getCities(country,this)" size="1">
			 {{UNLESS profile.state}}
                	<option value="" selected="selected">{{A9}}</option>
					{{ BEGIN statelist}}
						<option value="{{name}}">{{name}}</option>
					{{ END }}
                {{ELSE}}			 
					{{ BEGIN statelist}}
						<option value="{{name}}" {{IF name==profile.state}}selected="selected"{{END}}>{{name}}</option>
					{{ END }}
			{{END}}
                </select>				
	</tr>
	<tr>
	<td>
	{{A6}}
	</td>
	<td colspan="2">
                <select style="width:160px" id="city" name="city" size="1">
			 {{UNLESS profile.city}}
                	<option value="" selected="selected">{{A10}}</option>
					{{ BEGIN citylist}}
						<option value="{{name}}">{{name}}</option>
					{{ END }}
                {{ELSE}}			 

				{{ BEGIN citylist }} 
                    <option value="{{ name }}" {{IF name==profile.city}}selected="selected"{{END}}>{{ name }} </option>					
				{{ END }}
			{{END}}				
                </select>	
	</tr>
			<tr><td colspan="2" align="center">
			<input name="submit" type="submit" value="{{A7}}" /><br />
			</td></tr>	
	</table>
	</form>
</fieldset>
</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}

