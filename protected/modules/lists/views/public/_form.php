<?php
/* @var $this ListsPublicController */
/* @var $model Lists */
/* @var $form CActiveForm */
?>


<?php $this->renderPartial("//partial-views/_flashMessage"); ?><?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'lists-form',
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true
	)
)); ?>
<h1>اضافه کردن ده فهرست برتر</h1>
لیست خود را ایجاد کنید و آن را ذخیره کنید. لیست شما در سایت ما نشان داده خواهد شد، به محض این که فرصتی برای بررسی آن خواهیم داشت.
<h3>پیش از اضافه کردن لیست ...</h3>
<ol>
	<li>
		طرح‌نما یا لورم ایپسوم به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود
	</li>
	<li>
		معمولاً طراحان گرافیک برای صفحه‌آرایی، نخست از متن‌های آزمایشی و بی‌معنی استفاده می‌کنند تا صرفاً به مشتری یا صاحب‌کار خود نشان دهند که صفحهٔ طراحی یا صفحه‌بندی شده،
	</li>
	<li>
		طرح‌نما یا لورم ایپسوم به متنی آزمایشی و بی‌معنی در صنعت چاپ، صفحه‌آرایی و طراحی گرافیک گفته می‌شود. طراح گرافیک از این متن به‌عنوان عنصری از ترکیب‌بندی برای پُر کردن صفحه و ارائهٔ اولیهٔ شکل ظاهری و کلیِ طرح سفارش‌گرفته‌شده استفاده می‌کند، تا ازنظر گرافیکی نشانگر چگونگی نوع و اندازهٔ قلم و ظاهرِ متن باشد.
	</li>
	<li>
		آنها با استفاده از محتویات ساختگی، صفحهٔ گرافیکی خود را صفحه‌آرایی می‌کنند تا مرحلهٔ طراحی و صفحه‌بندی را به پایان برند.
	</li>
	<li>
		آنها با استفاده از محتویات ساختگی، صفحهٔ گرافیکی خود را صفحه‌آرایی می‌کنند تا مرحلهٔ طراحی و صفحه‌بندی را به پایان برند.
	</li>
</ol>

<div class="add-list-form">
	<?php echo $form->errorSummary($model)?>
	<div class="form-row">
		<?php echo $form->textField($model,'title',array('class'=>'transparent-input', 'placeholder' => 'افزودن عنوان لیست')); ?>
		<?php echo $form->textArea($model,'description',array('placeholder'=>'توضیحات...')); ?>
		<?php echo $form->labelEx($model,'title')?>
		<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
			'id' => 'uploaderLogo',
			'model' => $model,
			'name' => 'image',
			'containerClass' => 'uploader',
			'maxFiles' => 1,
			'maxFileSize' => 0.5, //MB
			'url' => $this->createUrl('upload'),
			'deleteUrl' => $this->createUrl('deleteUpload'),
			'acceptedFiles' => '.jpg, .jpeg, .png',
			'serverFiles' => isset($image)?$image:[],
			'onSuccess' => '
				var responseObj = JSON.parse(res);
				if(responseObj.status){
					{serverName} = responseObj.fileName;
					$(".uploader-message").html("");
				}
				else{
					$(".uploader-message").html(responseObj.message);
					this.removeFile(file);
				}
			',
		)); ?>
		<?php echo $form->error($model,'image'); ?>
		<div class="uploader-message error"></div>
	</div>
	<?= $form->error($model, 'items')?>
	<?php
	for($i = 0; $i < 10; $i++):
		?>
		<div class="form-row">
			<span class="num <?php
			if($i==0) echo 'gold';
			if($i==1) echo 'silver';
			if($i==2) echo 'bronze';
			?>"><?= $i+1?></span>
			<div class="input-container">
				<?= CHtml::textField("Lists[items][{$i}][title]", isset($model->items[$i]['title'])?$model->items[$i]['title']:'', array('class' => 'transparent-input', 'placeholder' => "آیتم")) ?>
			</div>
			<div class="row">
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
					<?= CHtml::textArea("Lists[items][{$i}][description]", isset($model->items[$i]['description'])?$model->items[$i]['description']:'', array('class' => 'form-control', 'placeholder' => "نظر...")) ?>
				</div>
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
					<?php $this->widget('ext.dropZoneUploader.dropZoneUploader', array(
						'id' => "uploaderImage{$i}",
						'name' => "Lists[items][{$i}][image]",
						'maxFiles' => 1,
						'maxFileSize' => 0.5, //MB
						'url' => $this->createUrl('uploadItem'),
						'deleteUrl' => $this->createUrl('deleteUploadItem'),
						'acceptedFiles' => '.jpg, .jpeg, .png',
						'containerClass' => 'uploader',
						'serverFiles' => isset($itemImages) && isset($itemImages[$i])?$itemImages[$i]:[],
						'onSuccess' => "
								var responseObj = JSON.parse(res);
								if(responseObj.status){
									{serverName} = responseObj.fileName;
									$(\".uploader-message-{$i}\").html(\"\");
								}
								else{
									$(\".uploader-message-{$i}\").html(responseObj.message);
									this.removeFile(file);
								}
							",
					)); ?>
					<div class="uploader-message-<?= $i ?> error"></div>
				</div>
			</div>
		</div>
		<?php
	endfor;
	?>
	<div class="form-row last">
		<?php echo CHtml::submitButton('ذخیره پیشنویس',array('class' => 'btn btn-blue', 'name' => 'draft')); ?>
		<?php echo CHtml::submitButton($model->isNewRecord ? 'ذخیره لیست' : 'ویرایش لیست',array('class' => 'btn btn-gray', 'name' => 'publish')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>