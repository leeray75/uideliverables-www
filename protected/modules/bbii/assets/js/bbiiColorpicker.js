$('#colorpickerField').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		$(el).val(hex);
		$(el).ColorPickerHide();
		$('#colorpickerColor').css('backgroundColor', '#' + hex);
	},
	onBeforeShow: function () {
		$(this).ColorPickerSetColor(this.value);
		$('#colorpickerColor').css('backgroundColor', '#' + this.value);
	}
})
.bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
	$('#colorpickerColor').css('backgroundColor', '#' + this.value);
});

$('#colorpickerColor').css('backgroundColor', '#' + $('#colorpickerField').val());