<h3>{{S1}}</h3>

{{IF logged_in}}
<ul>
	<li><a href="member.php">{{SH4}}</a></li>
	<li><a href="matches.php">{{S2}}</a></li>
	<li> <a href="settings.php">{{ S7}}</a></li>
	<li> <a href="reset.php">{{ S9}}</a></li>
	<li> <a href="login.php?logoff=1">{{ SH5}}</a></li>
</ul>
{{ELSE}}
<ul>
		<li><a href="login.php">{{ SH6 }}</a></li>
		<li><a href="register.php">{{SH7}}</a></li>
</ul>
{{END loggedin}}



