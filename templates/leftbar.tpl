<h3>{{S1}}</h3>

{{IF logged_in}}
<ul>
	<li {{IF member}} class="active"{{END register}}><a href="member.php">{{SH4}}</a></li>
	<li {{IF editprofile}} class="active"{{END register}}><a href="editmember.php">{{S7}}</a></li>
	<li {{IF pictures}} class="active"{{END register}}><a href="pictures.php">{{S11}}</a></li>
	<li {{IF search}} class="active"{{END register}}><a href="search.php">{{S10}}</a></li>
	<hr size="1" />
	<li {{IF reset}} class="active"{{END register}}><a href="reset.php">{{S9}}</a></li>
	<hr size="1" />
	<li {{IF logoff}} class="active"{{END register}}><a href="login.php?logoff">{{SH5}}</a></li>

</ul>
{{ELSE}}
<ul>
		<li {{IF index}} class="active"{{END index}}><a href="index.php">{{ H8 }}</a></li>
		<li {{IF login}} class="active"{{END login}}><a href="login.php">{{ SH6 }}</a></li>
		<li {{IF register}} class="active"{{END register}}><a href="register.php">{{SH7}}</a></li>
</ul>
{{END loggedin}}



