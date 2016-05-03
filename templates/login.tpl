{{ include('templates/header.tpl') }}

<div id="content">

<hr size="1" />


<fieldset>
	<legend>{{A3}}</legend>
		<form action="login.php" method="post">
			<p {{IF $email_error}}class="error"{{END}}><label for="email">{{A4}}</label>
			<input id="email" name="email" type="text" size="30" maxlength="30" value="{{$email}}" />
			</p>

			<p><label for="pass">{{A5}}</label>
			<input id="pass" name="pass" type="password" size="30" maxlength="30" value="{{$password}}" />
			</p>

			<p><input name="submit" type="submit" value="{{A3}}" /></p> 
			<p><input type="checkbox"  value="1" name="remember" {{IF $formremember}}checked="checked"{{END}} />
			{{A8}}<br />
			<a href="reset.php">{{A9}}</a></p>
		</form>
</fieldset>

{{IF $success}}
	<p class="green"><strong>{{$success}}</strong></p>
{{ELSEIF $error_message}}
	<hr size="1" />
	<p class="error"><strong>{{$error_message}}</strong></p>
{{END}}
</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}

