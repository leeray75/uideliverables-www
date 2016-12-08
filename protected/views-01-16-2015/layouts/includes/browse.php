<?php
if ( (isset($this->isSSL) and $this->isSSL === true) and (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on')) {
    if(!headers_sent()) {
        header("Status: 301 Moved Permanently");
        header(sprintf(
            'Location: https://%s%s',
            $_SERVER['HTTP_HOST'],
            $_SERVER['REQUEST_URI']
        ));
        exit();
    }
}
else if((isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] === 'on')){
	
	if(isset($this->isSSL) and !$this->isSSL === true)
	{
		if(!headers_sent()) {
			header("Status: 301 Moved Permanently");
			header(sprintf(
				'Location: http://%s%s',
				$_SERVER['HTTP_HOST'],
				$_SERVER['REQUEST_URI']
			));
			exit();
		}
    }
}
?>
<?php if(isset($this->metaDescription)): ?>
<meta name="description" content="<?php echo $this->metaDescription; ?>">
<?php endif ?>
<?php if(isset($this->metaKeywords)): ?>
<meta name="keywords" content="<?php echo $this->metaKeywords; ?>"> 
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1" />

<?php endif ?>
<meta name="author" content="Raymond Lee" />

<script language="javascript">
var user = user || {};
var UserNav = UserNav || {};
var GlobalVariables = GlobalVariables || {};
</script>
