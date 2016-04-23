{{ include('templates/header.tpl') }}
<div id="contentWrapper">
<div id="leftColumn1">  
	{{ include('templates/leftbar.tpl') }}
</div>
<div id="rightColumn1">
	{{ include('templates/rightbar.tpl') }}
</div>
<div id="content">
<hr size="1" />

{{UNLESS success}}
<fieldset>
	<legend>{{A1}}</legend>
		<form action="register.php" method="post">
			<h2>{{A2}}</h2>
			<table width="500" align="center" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td width="50%" align="right">
			<p{{IF $name_error}} class="error"{{END}}><label for="nickname">{{A3}}:</label></p>
			</td><td width="50%">
			<input id="nickname" name="nickname" type="text" size="30" maxlength="30" value="{{$name}}" />
			
			</td>

				</tr><tr><td align="right">
                <p{{IF birthday_error}} class="error"{{END}}><label for="born">{{A4}}:</label></p>
				</td><td>
                <select style="width:60px" id="year" name="year" size="1">
				{{ BEGIN yearlist }} 
                    <option value="{{ value }}" {{IF value == $year}}selected="selected"{{END}}>{{ name }} </option>					
				{{ END }}
                </select>	
				
                <select style="width:80px" id="month" name="month" size="1">
				{{ BEGIN monthlist }} 
                    <option value="{{ value }}" {{IF value == $month}}selected="selected"{{END}}>{{ name }} </option>					
				{{ END }}
                </select>	
							
                <select style="width:60px" id="day" name="day" size="1">

				{{ BEGIN daylist }} 
                    <option value="{{ value }}" {{IF value == $day}}selected="selected"{{END}}>{{ name }}  </option>					
				{{ END daylist }}

                </select>	
                </td>
			</tr>				
			<tr><td align="right">
			<p{{IF gender_error}} class="error"{{END}}><label for="gender">{{A5}}:</label></p>
			</td><td>
			<input type="radio" id="male" name="gender" value="1" {{IF gender == "1"}}checked{{END}} /> {{A6}}</label>
			<input type="radio" id="female" name="gender" value="0" {{IF gender == "0"}}checked{{END}} /> {{A7}}</label>			
			</td>
			</tr></tr>
			<td align="right">
			
            <p{{IF email_error}} class="error"{{END}}><label for="email">{{A8}}:</label></p>
			</td><td>
			<input id="email" name="email" type="text" size="35" maxlength="50" value="{{$email}}" />
			</td>
			</tr><tr>
			<td align="right">
            <p{{IF repeatemail_error}} class="error"{{END}}><label for="repeatemail">{{A9}}:</label></p>
			</td><td>
			<input id="repeatemail" name="repeatemail" type="text" size="35" maxlength="50" value="{{$repeatemail}}" />
			</td></tr>
			
			<tr><td align="center" colspan="2">
			
			<img id="code" src="images/captcha.php" alt="" />
			
			</td></tr><tr><td align="right">
			<p{{IF secerror}} class="error"{{END}}><label for="captcha">{{A13}}:</label></p></td>
			<td><input id="captcha" name="captcha" type="text" />
			
			</td>
			</tr>
			<tr><td colspan="2" align="center">
			<input name="submit" type="submit" value="{{A12}}" /><br />
			</td></tr>
			<tr><td colspan="2" align="center">
			{{TOS_AGREE}}
			</td></tr>
			<tr><td colspan="2" align="center">
			{{A10}}
			</td></tr>
			</table>
	</form>
</fieldset>
{{END success}}

{{IF success}}

	<p class="success"><strong>{{$success}}</strong></p>
	<hr size="1" />
{{ELSEIF error_message}}
	<hr size="1" />
	<p class="error"><strong>{{$error_message}}</strong></p>
{{END success}}
</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}

