<?php
require_once '../Model/createDataBaseConnection.php';

require_once '../Model/LoginModel.php';
require_once '../Controller/LoginController.php';

require_once '../Model/UserDetailsModel.php';
require_once '../Controller/UserDetailsController.php';

require_once '../Model/AnalyticsModel.php';
require_once '../Controller/AnalyticsController.php';

$login = new LoginController();

if (!$login->loggedIn) {
    $_SESSION['naviageTo'] = $_SERVER[REQUEST_URI];
    include_once '../login.php';
    exit();
}

$userObject = new UserDetailsController($_SESSION['userId']);
$userInfo = $userObject->info;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php include_once '../include/headInclude.php'; ?>
        <title>queskey</title>
        <script src="http://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript" src="/assets/js/jquery.form.js"></script>
        <link rel="stylesheet" type="text/css" href="/assets/imageUpload/imgareaselect-default.css" />
        <script type="text/javascript" src="/assets/js/jquery.imgareaselect.pack.js"></script>
        <script>
            $(document).ready(function() {
                $('#UploadForm').on('submit', function(e) {
                    e.preventDefault();
                    $('#SubmitButton').attr('disabled', ''); // disable upload button
                    //show uploading message
                    $("#output").empty();
                    $("#output").html('<div style="padding:10px"><img src="/assets/img/loader.gif" alt="Please Wait"/> <span>Uploading...</span></div>');
                    $(this).ajaxSubmit({
                        target: '#output',
                        success: afterSuccess //call function after success
                    });
                });                                
                
                $('#password_change_form').on('submit',function(e){
                    var oldPassword = $('#oldPassword').val();
                    var newPassword = $('#newPassword').val();
                    var confirmNewPassword = $('#confirmNewPassword').val();
                    if(oldPassword.length<6 || newPassword.length<6 || newPassword!=confirmNewPassword){
                        e.preventDefault();
                        if(oldPassword.length<6){
                            $('#password_change_error').html("Old Password must have atleast 6 characters.");
                        }else if(newPassword.length<6){
                            $('#password_change_error').html("New Password must have atleast 6 characters.");
                        }else{
                            $('#password_change_error').html("New Password and Confirm New Password does not match.");
                        }
                    }
                });
                
                var height = $(document).height();
                var intheight = parseInt(height)-200;
                $(".top_wrapper").css("height",intheight+"px");
            });
            function afterSuccess() {
                $('#UploadForm').resetForm();  // reset form
                $('#SubmitButton').removeAttr('disabled'); //enable submit button
                $('#output').css('background-color', '#f2f2f2');
                $('#fileChooser').hide();
            }
            
        </script>

    </head>

    <body>
        <div id="body_wrapper">
            <div id="headerAndNav">
                <?php include_once '../include/header.php'; ?>
            </div>
            <div class="inner_wrapper">
                <div class="top_wrapper">
                    <div class="page_header_back" >
                        <div class="page_header_back_text" style="color:#959595">
                            Settings
                        </div>

                    </div>
                    <form method="post" action="/action/updateUserInfo.php">
                        <div class="setting_field">
                            <div class="setting_field_left"> Name</div>
                            <div class="setting_field_right">
                                <div class="setting_name_extra">First</div>
                                <input type="text" maxlength="20" name="firstName"  class="setting_text" value="<?php echo $userInfo['firstName']; ?>" style="width:185px" />
                                <div style="margin-top:10px;">
                                    <div class="setting_name_extra">Last</div>
                                    <input type="text" name="lastName"  class="setting_text" value="<?php echo $userInfo['lastName']; ?>" style="width:185px" />
                                </div>
                            </div>
                        </div>

                        <div class="setting_field">
                            <div class="setting_field_left"> Work</div>
                            <div class="setting_field_right">

                                <input type="text" name="work"  class="setting_text" value="<?php echo $userInfo['work']; ?>" style="width:246px" />

                            </div>
                        </div>


                        <div class="setting_field">
                            <div class="setting_field_left"> Education</div>
                            <div class="setting_field_right">

                                <input type="text" name="education"  class="setting_text" value="<?php echo $userInfo['education']; ?>"  style="width:246px" />

                            </div>
                        </div>


                        <div class="setting_field">
                            <div class="setting_field_left"> Location</div>
                            <div class="setting_field_right">

                                <input type="text" name="location"  class="setting_text" value="<?php echo $userInfo['location']; ?>" style="width:246px"/>

                            </div>
                        </div>




                        <div class="setting_field">
                            <div class="setting_field_left"> </div>
                            <div class="setting_field_right">
                                <input class="setttingsUpdateButton" name="updateUserData" type="submit" value="update">
                            </div>
                        </div>

                    </form>


                    <?php
                    if ($userInfo['fbId'] < 1) {
                        ?>

                        <div class="setting_field">
                            <div class="setting_field_left">Change Password</div>
                            <div class="setting_field_right">

                            </div>
                        </div>



                        <form method="post" action="/action/updateUserInfo.php" id="password_change_form">

                            <div class="setting_field">
                                <div class="setting_field_left"> Old Password</div>
                                <div class="setting_field_right">

                                    <input type="password" name="oldPassword" id="oldPassword"  class="setting_text" style="width:246px"/>

                                </div>
                            </div>

                            <div class="setting_field">
                                <div class="setting_field_left"> New Password</div>
                                <div class="setting_field_right">

                                    <input type="password" name="newPassword" id="newPassword"  class="setting_text" style="width:246px"/>

                                </div>
                            </div>

                            <div class="setting_field">
                                <div class="setting_field_left"> Confirm New Password</div>
                                <div class="setting_field_right">

                                    <input type="password" name="confirmNewPassword" id="confirmNewPassword"  class="setting_text" style="width:246px"/>

                                </div>
                            </div>

                            <div id="password_change_error" style="width: 100%; height: 20px; font-size: 14px; color: #333; text-align: center; opacity: none;">
                                <?php
                                if (isset($_SESSION['passwordChangeMessage'])) {
                                    echo $_SESSION['passwordChangeMessage'];
                                    unset($_SESSION['passwordChangeMessage']);
                                    ?>
                                    <script>
                                        $('html,body').animate({
                                            scrollTop: 550
                                        },600);
                                    </script>
                                    <?php
                                }
                                ?>
                            </div>


                            <div class="setting_field">
                                <div class="setting_field_left"> </div>
                                <div class="setting_field_right">
                                    <input class="setttingsUpdateButton" name="updateUserPassword" type="submit" value="update">
                                </div>
                            </div>

                        </form>
                        <form action="imageUpload.php" method="post" enctype="multipart/form-data" id="UploadForm">
                            <div class="setting_field">
                                <div class="setting_field_left">Change Profile Picture </div>
                                <div class="setting_field_right" id="fileChooser" style="width: 300px;">
                                    <input name="file" type="file" />
                                    <input type="submit"  id="SubmitButton" value="Upload" />
                                </div>
                            </div>
                        </form>
                        <div id="output" class="setting_field" style="width: 600px; padding: 20px; "></div>
                        <?php
                    }
                    ?>
                </div>
                <?php include_once '../include/footer.php'; ?>
            </div>
        </div>
    </body>
</html>