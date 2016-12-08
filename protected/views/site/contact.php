<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */
	/*$this->pageCSS = array(
		"/www/content/css/resume.css",
	);
	*/
	$this->pageJS = array(
		"/www/assets/16495a84/jquery.yiiactiveform.js",
	);
$this->pageTitle=Yii::app()->name . ' - Contact Me';
$this->metaKeyWords="contact,questions,comments,suggestions,email";
$this->metaDescription="Please feel free to contact me if you have any questions, comments, or suggestions. I will receive everything sent through this contact form.";
$this->breadcrumbs=array(
	'Contact',
);

?>
<style type="text/css">
.row{ margin-bottom: 10px;}
textarea,
input[type=text],
input[type=email]{ width: 80%;}

</style>
<h1>Contact Me</h1>
<?php if(Yii::app()->user->hasFlash('contact')): ?>
<div class="flash-success"> <?php echo Yii::app()->user->getFlash('contact'); ?> </div>
<?php else: ?>
<p> <!-- If you have business inquiries or other questions, please fill out the following form to contact me. Thank you. --> 
  Please feel free to contact me if you have any questions, comments, or suggestions. I will receive everything sent through this contact form. </p>
<div class="form">
  <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
  <!--
<form id="contact-form" method="post" action="/www/index.php/site/contact">
-->
  <p class="note">Fields with <span class="required">*</span> are required.</p>
  <?php echo $form->errorSummary($model); ?>
  <div class="row">
    <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2"><?php echo $form->labelEx($model,'name'); ?></div>
    <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10"> <?php echo $form->textField($model,'name'); ?> <?php echo $form->error($model,'name'); ?> </div>
  </div>
  <div class="row">
    <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2"><?php echo $form->labelEx($model,'email'); ?></div>
    <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10"> <?php echo $form->textField($model,'email'); ?> <?php echo $form->error($model,'email'); ?> </div>
  </div>
  <div class="row">
    <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2"><?php echo $form->labelEx($model,'subject'); ?></div>
    <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10"> <?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?> <?php echo $form->error($model,'subject'); ?> </div>
  </div>
  <div class="row">
    <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2"><?php echo $form->labelEx($model,'body'); ?></div>
    <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10"> <?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?> <?php echo $form->error($model,'body'); ?> </div>
  </div>
  <?php if(CCaptcha::checkRequirements()): ?>
  <div class="row">
    <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2"><?php echo $form->labelEx($model,'verifyCode'); ?> </div>
    <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10"> 
      <!-- begin CCaptcha widget -->
      <?php $this->widget('CCaptcha'); ?>
      <!-- end CCaptcha widget -->
      <div> 
        
        <!-- begin verfy code --> 
        <?php echo $form->textField($model,'verifyCode'); ?> 
        <!-- end verify code --> 
      </div>
      <div class="hint">Please enter the letters as they are shown in the image above. <br />
        Letters are not case-sensitive.</div>
      <!-- /hint -->
      <div><?php echo $form->error($model,'verifyCode'); ?> </div>
    </div>
  </div>
  <?php endif; ?>
  <div class="row buttons">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align: center;"><?php echo CHtml::submitButton('Submit'); ?> </div>
  </div>
  <?php $this->endWidget(); ?>
</div>
<!-- form -->

<?php endif; ?>
<script language="javascript">
$(document).ready(function(){
	if(Modernizr.inputtypes.email){
		$('#ContactForm_email').attr('type','email');
	}
});
</script>