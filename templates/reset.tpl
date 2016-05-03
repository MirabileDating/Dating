{{ include('templates/header.tpl') }}

<div id="content">


{{IF $tokenphase}}
{{IF $validtoken}}
<hr size="1" />
  <h1>{{A1}}</h1>
	<p>{{A13}}</p>


<fieldset>
	<legend>{{A7}}</legend>
		<form method="post" action="reset.php">
			<p {{IF $pass_error}}class="error"{{END}}><label for="password1">{{A9}}</label>
			<input id="password1" name="password1" type="password" size="30" value="" />
			</p>
			<div style="float:right;width:105px;margin-right:10px">
				<div id="new_pass_text" style="font-size: xx-small;"></div>
				<div id="new_pass_bar" style="font-size: xx-small; height: 2px; width: 0px; border: 1px solid white;"></div>
            </div>
			<p><label for="password2">{{A12}}</label>
			<input id="password2" name="password2" onKeyUp="runPassword(this.value, 'new_pass');" type="password" size="30" value="" />
			</p>
			<input id="token" name="token" type="hidden" size="32" value="{{$token}}" />
			<p><input type="submit" name="submit" value="{{A8}}" /></p>
		</form>
</fieldset>
{{END}}

{{ELSEIF $logged_in}}
{{UNLESS $success}}
  <h1>{{A1}}</h1>
	<p>{{A13}}</p>


<fieldset>
	<legend>{{A7}}</legend>
		<form method="post" action="reset.php">
			<p {{IF $pass_error}}class="error"{{END}}><label for="password1">{{A9}}</label>
			<input id="password1" name="password1" type="password" size="30" value="" />
			</p>
			<div style="float:right;width:105px;margin-right:10px">
				<div id="new_pass_text" style="font-size: xx-small;"></div>
				<div id="new_pass_bar" style="font-size: xx-small; height: 2px; width: 0px; border: 1px solid white;"></div>
            </div>
			<p><label for="password2">{{A12}}</label>
			<input id="password2" name="password2" onKeyUp="runPassword(this.value, 'password2');" type="password" size="30" value="" />
			</p>

			<p><input type="submit" name="change" value="{{A8}}" /></p>
		</form>
</fieldset>
{{END}}
{{ELSE}}

{{UNLESS $success}}
  <h1>{{A3}}</h1>
	<p>{{A5}}</p>
	


<fieldset>
	<legend>{{A6}}</legend>
		<form method="post" action="reset.php">
			<p {if $mail_error}class="error"{/if}><label for="email">{{A4}}*:</label>
			<input id="email" name="email" type="text" size="35" maxlength="50" value="" />
			</p>

			<p><input type="submit" name="submit" value="{{A2}}" /></p>
		</form>
</fieldset>
{{END}}
{{END}}
<hr size="1" />
{{IF $success}}
	<p class="success"><strong>{{$success}}</strong></p>
{{ELSEIF $error_message}}
	<p class="error"><strong>{{$error_message}}</strong></p>
{{END}}
</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}