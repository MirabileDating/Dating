<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{{SITE_LANGUAGE}}" lang="{{SITE_LANGUAGE}}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={{DOCUMENT_CHARSET}}" />

<title>{{H1}}</title>
<meta name='yandex-verification' content='7c06c63e7e9cba19' />
<meta name="description" content="{{ H2 }}" />
<meta name="keywords" content="{{ H3 }}" />
<meta name="robots" content="index,follow" />
<meta name="copyright" content="Copyright {{H9}} All Rights Reserved." />
<meta name="revisit-after" content="14" />

<base href="{{ OAC_SERVER_PATH }}" />
<link href="styles/style.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body>

<div id="pageContainer">
  <div id="header">
  </div>
  <div id="navcontainer" >
    <ul id="navlist">
		
{{IF logged_in}}

		<li{{IF index}} class="active"{{END index}}><a href="member.php" class="topnavlink">{{SH4}}</a></li>
		<li><a href="login.php?logoff=1">{{SH5}}</a></li>

{{ELSE}}

		<li{{IF index}} class="active"{{END index}}><a href="index.php" class="topnavlink">{{H8}}</a></li>
		<li{{IF register}} class="active"{{END register}}><a href="register.php" class="topnavlink">{{SH7}}</a></li>

		<li{{IF login}} class="active"{{END login}}><a href="login.php" class="topnavlink">{{SH6}}</a></li>

{{END logged_in}}

    </ul>
  </div>
