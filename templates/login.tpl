{{ include('templates/header.tpl') }}
<div id="contentWrapper">
<div id="leftColumn1">  
	{{ include('templates/leftbar.tpl') }}
</div>
<div id="rightColumn1">
	{{ include('templates/rightbar.tpl') }}
</div>
<div id="content">
<form action="login_fb.php" method="post">
 <input type="submit" name="submit" class="button_facebook" value="{{LOGIN_FACEBOOK}}"/>
 </form>
  
     

</p>

{{IF $success}}
	<p class="green"><strong>{{$success}}</strong></p>
{{ELSEIF $error_message}}
	<p class="red"><strong>{{$error_message}}</strong></p>
{{END}}

<fieldset>
	<legend>{{LOGIN_BELOW_LEGEND}}</legend>
		<form action="login.php" method="post">
			<p {{IF $email_error}}class="error"{{END}}><label for="email">{{EMAIL}}</label>
			<input id="email" name="email" type="text" size="30" maxlength="30" value="{{$email}}" />
			</p>

			<p><label for="pass">{{PASSWORD}}</label>
			<input id="pass" name="pass" type="password" size="30" maxlength="30" value="{{$password}}" />
			</p>

			<p><input name="submit" type="submit" value="{{LOGIN}}" /></p> 
			<p><input type="checkbox"  value="1" name="remember" {{IF $formremember}}checked="checked"{{END}} />
			{{REMEMBER_ME}}<br />
			{{FORGOT_PASSWD}}</p>
		</form>
</fieldset>

</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}

