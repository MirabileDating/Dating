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
{{IF $validtoken}}

  <h1>{{A1}}</h1>
	<p>{{A11}}</p>


<fieldset>
	<legend>{{A7}}</legend>
		<form method="post" action="reset.php">
			<p {{IF $pass_error}}class="error"{{END}}><label for="password">{{A10}}</label>
			<input id="password" name="password" type="password" size="30" value="" />
			</p>
			<div style="float:right;width:105px;margin-right:10px">
				<div id="new_pass_text" style="font-size: xx-small;"></div>
				<div id="new_pass_bar" style="font-size: xx-small; height: 2px; width: 0px; border: 1px solid white;"></div>
            </div>
			<p><label for="password2">{{A9}}</label>
			<input id="password2" name="password2" onKeyUp="runPassword(this.value, 'new_pass');" type="password" size="30" value="" />
			</p>

			<p><input type="submit" name="change" value="{{A8}}" /></p>
		</form>
</fieldset>
{{ELSE}}

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