<?php
require_once '../Model/createDataBaseConnection.php';
require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    echo 'INVALID';
    exit();
}

$userId = $_SESSION['userId'];
?>


<script type="text/javascript">

    var sel;

    function preview(img, selection) {
        if (!selection.width || !selection.height)
            return;

        sel = selection;

        imgHeight = $("#photo").height();

        var scaleX = 138 / selection.width;
        var scaleY = 138 / selection.height;

        $('#preview img').css({
            width: Math.round(scaleX * 300),
            height: Math.round(scaleY * imgHeight),
            marginLeft: -Math.round(scaleX * selection.x1),
            marginTop: -Math.round(scaleY * selection.y1)
        });
    }

    function saveImage() {

        var x1 = 0;
        var y1 = 0;
        var width = 0;

        if (!sel) {
            var x1 = 0;
            var y1 = 0;
            var width = 100;
        } else {
            if (!sel.width || !sel.height)
                return;

            var x1 = sel.x1;
            var y1 = sel.y1;
            var width = sel.width;
        }

        imgHeight = $("#photo").height();

        $.post("/ajax/saveImage.php", {
            x1: x1,
            y1: y1,
            width: width,
            imgHeight: imgHeight
        }, function(data) {
            if (data == '1') {
                window.location.href = "/settings";
            } else {
                alert(data);
            }
        });
    }

    $(document).ready(function() {
        $('img#photo').imgAreaSelect({aspectRatio: '1:1', handles: true,
            fadeSpeed: 200, onSelectChange: preview, x1: 0, y1: 0, x2: 150, y2: 150});
    });
</script>

<?php
$allowedExts = array("jpeg", "jpg", "png");

$extension = end(explode(".", $_FILES["file"]["name"]));

$_SESSION['extension'] = $extension;

if ((($_FILES["file"]["type"] == "image/jpeg") ||
        ($_FILES["file"]["type"] == "image/jpg") ||
        ($_FILES["file"]["type"] == "image/pjpeg") || ($_FILES["file"]["type"] == "image/x-png") ||
        ($_FILES["file"]["type"] == "image/png")) && ($_FILES["file"]["size"] < 2097152) && in_array($extension, $allowedExts)) {
    if ($_FILES["file"]["error"] > 0) {
        echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    } else {

        move_uploaded_file($_FILES["file"]["tmp_name"], "../assets/userPic/temp_" . $userId . '_f.' . $extension);
    }
} else {
    echo "Invalid file";
    exit();
}
?>
<div class="frame" style="margin: 0 0.3em; width: 300px; height: 300px; float: left;">
    <img src="/assets/userPic/<?php echo 'temp_' . $userId . '_f.' . $extension; ?>" id="photo" width="300"/>
</div>
<div class="frame2" style="margin: 0 16px; width: 138px; height: 138px; float: right; border-radius: 77px; margin-right: 56px;
-webkit-border-radius: 77px;
-moz-border-radius: 77px;">
    <div id="preview" style="width: 138px; height: 138px; overflow: hidden; border-radius: 77px;
-webkit-border-radius: 77px;
-moz-border-radius: 77px;">
        <img src="/assets/userPic/<?php echo 'temp_' . $userId . '_f.' . $extension; ?>" style="width: 300px; margin-left: 0px; margin-top: 0px;">
    </div>
</div>
<button onclick="saveImage();" class="setttingsUpdateButton" style="background-color: #8dbf6a; float: left; margin-left: 100px; margin-top: 30px;">Save</button>