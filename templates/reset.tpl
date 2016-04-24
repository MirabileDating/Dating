{{ include('templates/header.tpl') }}
<div id="contentWrapper">
<div id="leftColumn1">  
	{{ include('templates/leftbar.tpl') }}
</div>
<div id="rightColumn1">
	{{ include('templates/rightbar.tpl') }}
</div>
<div id="content">
{{IF $logged_in}}

  <h1>{{A1}}</h1>
	<p>{{A11}}</p>

{{IF $success}}
	<p class="green"><strong>{{$success}}</strong></p>
{{ELSEIF $error_message}}
	<p class="red"><strong>{{$error_message}}</strong></p>
{{END}}

<fieldset>
	<legend>{{A7}}</legend>
		<form method="post" action="reset.php">
			<p {{IF $pass_error}}class="error"{{END}}><label for="old_pass">{{A10}}</label>
			<input id="old_pass" name="old_pass" type="password" size="30" value="" />
			</p>
			<div style="float:right;width:105px;margin-right:10px">
				<div id="new_pass_text" style="font-size: xx-small;"></div>
				<div id="new_pass_bar" style="font-size: xx-small; height: 2px; width: 0px; border: 1px solid white;"></div>
            </div>
			<p><label for="new_pass">{{A9}}</label>
			<input id="new_pass" name="new_pass" onKeyUp="runPassword(this.value, 'new_pass');" type="password" size="30" value="" />
			</p>

			<p><input type="submit" name="change" value="{{A8}}" /></p>
		</form>
</fieldset>
{{ELSE}}

  <h1>{{A3}}</h1>
	<p>{{A5}}</p>
	
{{IF $success}}
	<p class="green"><strong>{{$success}}</strong></p>
{{ELSEIF $error_message}}
	<p class="red"><strong>{{$error_message}}</strong></p>
{{END}}

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
</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}