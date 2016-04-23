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
{{IF success}}
	<p class="green"><strong>{{$success}}</strong></p>
{{ELSEIF error_message}}
	<p class="red"><strong>{{$error_message}}</strong></p>
{{END success}}

<fieldset>
	<legend>{{A1}}</legend>
		<form action="register.php" method="post">
			<h2>{{A2}}</h2>
			<p{{IF $nickname_error}} class="error"{{END}}><label for="nickname">{{A3}}</label>
			<input id="nickname" name="nickname" type="text" size="30" maxlength="30" value="{{$nickname}}" />
			</p>

			
                <p{{IF born_error}} class="error"{{END}}><label for="born">{{BORN}}</label>
			
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
                </p>
				

			<p{{IF gender_error}} class="error"{{END}}><label for="gender">{{GENDER}}</label>
			<input type="radio" id="male" name="gender" value="1" {{IF gender == "1"}}checked{{END}} /> {{MALE}}</label>
			<input type="radio" id="female" name="gender" value="0" {{IF gender == "0"}}checked{{END}} /> {{FEMALE}}</label>			
			</p>

			
            <p{{IF email_error}} class="error"{{END}}><label for="email">{{EMAIL}}</label>
			<input id="email" name="email" type="text" size="35" maxlength="50" value="{{$email}}" />
			</p>
		
                <p><label for="reason">{{REASON}}</label>
                <select style="width:240px" id="reason" name="reason" size="1">

				{{ BEGIN reasonlist }} 
                    <option value="{{ value }}" {{IF value == reason}}selected="selected"{{END}}>{{ name }} </option>					
				{{ END }}
                </select>
                </p>

				
			<p><input name="submit" type="submit" value="{{SUBMIT}}" /><br />
			
			{{TOS_AGREE}}
			</p>

			<p>{{REQUIRED}}
			</p>
	</form>
</fieldset>
<hr size="1" />
</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}

