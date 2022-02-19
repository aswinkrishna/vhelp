    $(".custom-upload").each(function() {
var uploadForm = $(this);
var uploadInput = $(this).find('#chooseFile');
$(uploadInput).bind('change', function () {
var filename = $(uploadInput).val();
if (/^\s*$/.test(filename)) {
$(uploadForm).find(".file-upload").removeClass('active');
 $(uploadForm).find("#noFile").text("No file chosen...");
}
else {
 $(uploadForm).find(".file-upload").addClass('active');
 $(uploadForm).find("#noFile").text(filename.replace("C:\\fakepath\\",     
""));
 }
});
});