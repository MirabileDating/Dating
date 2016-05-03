{{ include('templates/header.tpl') }}


<div id="content">
	<h1>{{$smarty.const.PICTURE_HOME}}</h1>
	<p>{{$smarty.const.PICTURE_NEWS}}</p>

{{IF $success}}
	<p class="green"><strong>{{$success}}</strong></p>
{{ELSEIF $error_message}}
	<p class="red"><strong>{{$error_message}}</strong></p>
{{END}}

{{$ROOT_DIRECTORY}}
	<p>
	
	
        <div id="galleria_public">
			<table border="1">	
			<tr>
			<td colspan="3" align="center">Public pictures</td>
			</tr>
			<tr>
			{{BEGIN gallerypubimg}}
			{{IF name.id}}
			
				<td>
				<form name="modify" action="pictures.php" method="post">
				<input type="hidden" name="image" value="{{name.image}}">
				<input type="hidden" name="imagefull" value="{{name.imagefull}}">
				<input type="hidden" name="imagethumb" value="{{name.imagethumb}}">
				<input type="hidden" name="id" value="{{name.id}}">
				<a id="{{name.id}}" href="{{name.image}}"><img name="{{name.id}}" id="{{name.id}}" src="{{wwwroot}}{{name.imagethumb}}" data-title="{{name.title}}" data-description="{{name.description}}"></a><br>
				{{if(!$mainpic,"<input name='delete' type='submit' value='Delete'  /> <input name='makemain' type='submit' value='Make Main'/>")}}
				</form>
				</td>
			{{END}}
				{{if($newrow,"<tr></tr>")}}
			{{END}}
			<tr>
			</table>
        </div>	
	</p>
	<p>
	
        <div id="galleria_private">
			<table border="1">	
			<tr>
			<td colspan="3" align="center">Private pictures (needs your approval)</td>
			</tr>
			<tr>
			{{BEGIN galleryprivimg}}
			
			{{IF name.id}}
			<td>			
			<form name="modify" action="pictures.php" method="post">
				<input type="hidden" name="image" value="{{name.image}}">
				<input type="hidden" name="imagefull" value="{{name.imagefull}}">
				<input type="hidden" name="imagethumb" value="{{name.imagethumb}}">
				<input type="hidden" name="id" value="{{name.id}}">
			<a id="{{name.id}}" href="{{name.image}}"><img name="{{name.id}}" id="{{name.id}}" src="{{wwwroot}}{{name.imagethumb}}" data-title="{{name.title}}" data-description="{{name.description}}"></a><br>
			<input name="delete" type="submit" value="Delete"  /> 
			</form>
			</td>
			{{if($newrow,"<tr></tr>")}}
			{{END}}
			{{if(newrow,"<br>") }}
			{{END}}
			</tr>
			</table>
			 
        </div>	
	</p>	
	
<fieldset>
	<legend>{{EDIT_PROFILE_IMAGE_LEGEND}}</legend>
		<form enctype="multipart/form-data" action="pictures.php" method="post">
			<p><label for="image">{{YOUR_IMAGE}}</label>
			<input id="file" name="file" type="file" size="30" value="" />
			</p>
			<p>
			<p><label for="title">{{IMGTITLE}}</label>
			<input id="title" name="title" type="text" size="30" maxlength="30" value="{{title}}" />
			</p>
			<p><label for="description">{{IMGDESC}}</label>
			<textarea id="description" name="description" size="250" maxlength="250">{{description}}</textarea>
			</p>

			<p><label for="folder">{{FOLDER}}</label>
                <select style="width:210px" id="folder" name="folder" size="1">
    	           	{{BEGIN folderlist}}
                    	<option value="{{id}}" {{IF id}}selected="selected"{{END}}>{{name}}</option>
	               	{{END}}
                </select>
                </p>			
			<input type="hidden" name="MAX_FILE_SIZE" value="2097152" /> 
			<input name="addimage" type="submit" value="{{SUBMIT}}" />
			</p>
		</form>
</fieldset>	

</div>     
<br class="clearFloat"/>
</div>
{{ include('templates/footer.tpl') }}