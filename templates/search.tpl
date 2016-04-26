{{ include('templates/header.tpl') }}
<div id="contentWrapper">
<div id="leftColumn1">  
	{{ include('templates/leftbar.tpl') }}
</div>
<div id="rightColumn1">
	{{ include('templates/rightbar.tpl') }}
</div>

<div id="content">
{{ BEGIN profile }}
	<table width="600 "border="1">
	<tr>
	<td rowspan="7" width="30%">
	</td>
	<td width="40%">
	{{A1}}: <b>{{approved}}</b>
	</td>
	<td>
	{{A8}} {{w_gender}}
	</td>
	</tr>
	<tr>
	<td>
	{{A6}}: <b>{{name}}</b>
	</td>
	<td>
	</td>
	</tr>
	<tr>
	<td>
	{{A7}}: <b>{{age}}</b>
	</td>
	<td>
	</td>
	</tr>

	<tr>
	<td>
	
	{{A2}}: <b>{{gender}}</b>
	</td>
	<td>
	</td>
	</tr>
	<tr>
	<td>
	{{A3}}: <b>{{city}}</b>
	</td>
	<td>
	</td>
	</tr>
	<tr>
	<td>
	{{A4}}: <b>{{state}}</b>
	</td>
	<td>
	</td>
	</tr>
	<tr>
	<td>
	{{A5}}: <b>{{country}}</b>
	</td>
	<td>
	</td>
	</tr>
	</table>
	{{ END profile }}
</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}

