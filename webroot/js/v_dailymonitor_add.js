function showConfirmationModal() {
  $('#modal-sm').modal('show');
}

$('#OpenImgUpload').click(function () { $('#vendorCodeInput').trigger('click'); });

$('#vendorCodeInput').change(function () {
  var file = $(this).prop('files')[0].name;
  $("#filessnames").append(file);
});

setTimeout(function() {
  $('.success').fadeOut('slow');
}, 2000);

$('#sapvendorcodeform').on('submit', function() {
  $('#sapvendorcode').trigger('reset');
});


$('#sapvendorInputForm').on('submit', function() {
  $('#sapvendorInput').trigger('reset');
});
