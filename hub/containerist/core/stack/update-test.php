<?

// tests stack-update.mod
header ("Content-Type: text/html;charset=utf-8");

?><html>
<head>
<style>	
textarea {
	width: 600px;
	height: 400px;
}

.form-text, textarea {
	font-family: "Monaco", "Courier New", Helvetica, Arial;
	font-size: 14px;
	line-height: 18px;
}
</style>
</head>
<body>
<form id="origin_form" name="origin_form" action="/demo/stack-update.mod" method="GET">
<input type="hidden" name="id" value="test" class="form-text" />
<textarea name="content">
	
</textarea>
<br>
<input type="submit" name="submit" value="save" size="30" class="btn"/>
</form>
</body>
</html>