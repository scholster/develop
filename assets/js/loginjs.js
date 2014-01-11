$(window).load(function() {

    $(window).scroll(function() {

        var y = $(this).scrollTop();
        // whether that's below the form
        if (y >= 400 && y <= 1687) {

            // if so, ad the fixed class



            $('#header').addClass('fixed');
            $('.grey_body').css({
                position: 'fixed', 
                top: '57px'
            });
            $('.grey_border').css({
                position: 'fixed', 
                top: '57px'
            });
            $('.img_mask_cont').css({
                position: 'fixed', 
                top: '55px'
            });
            $('.img_white_bg').css({
                position: 'fixed', 
                top: '55px'
            });
            $('.mask_bottom').css({
                height: '500px'
            });
            $('.img_white_bg').css({
                height: '800px'
            });


        }
        else if (y > 1687) {

            $('#header').addClass('fixed_border');
            $('.grey_body').css({
                position: 'absolute', 
                top: '1580px'
            });
            $('.grey_border').css({
                position: 'absolute', 
                top: '1580px'
            });
            $('.img_mask_cont').css({
                position: 'absolute', 
                top: '1278px'
            });
            $('.img_white_bg').css({
                position: 'absolute', 
                top: '1278px'
            });
            $('.mask_bottom').css({
                height: '315px'
            });
            $('.img_white_bg').css({
                height: '838px'
            });
        }

        else {
            // otherwise remove it

            $('#header').removeClass('fixed');
            $('#header').removeClass('fixed_border');
            $('.grey_body').css({
                position: 'absolute', 
                top: '458px'
            });
            $('.grey_border').css({
                position: 'absolute', 
                top: '458px'
            });
            $('.img_mask_cont').css({
                position: 'absolute', 
                top: '0px'
            });
            $('.img_white_bg').css({
                position: 'absolute', 
                top: '0px'
            });
            $('.mask_bottom').css({
                height: '500px'
            });

        }
    });
});


function checkEmail() {
    $("#email_format").fadeTo(0, 0);
    var value = $("#emailId").val();
    var a = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
    if (a) {
        stopClick();
        showLoading();
        $("#registerReplace").fadeTo(750, 0, function() {
            $("#registerReplace").load("/ajax/userEmail",
            {
                email: value
            },
            function() {
                hideLoading();
                releaseClick();
                $("#registerReplace").fadeTo(500, 1);
            });
        });
    }
    else {
        $("#email_format").fadeTo(200, 1);
    }
}

function registerEmail(e) {
    if (e.keyCode == 13) {
        checkEmail();
    }
}

function enterLogin(e){
    if (e.keyCode == 13) {
        login();
    }
}

function login() {
    var value = $("#loginEmail").val();
    var password = $("#loginPassword").val();
    var a = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
    if (a) {
        stopClick();
        showLoading();
        $("#email_format_signUp").fadeTo(0, 0);
        $("#wrong_UserPassword_signUp").fadeTo(0, 0);
        if (password == '' || password.length < 6) {
            $("#wrong_UserPassword_signUp").html("Password should have 6 characters");
            $('#wrong_UserPassword_signUp').fadeTo(100, 1);
        } else {
            $.post("/ajax/userLogin", {
                loginUserName: value,
                loginPassword: password
            }, function(data, status) {
                if (data == "1") {
                    window.location.href = "/";
                }
                else if (data == "0") {
                    $("#wrong_UserPassword_signUp").html("Wrong username and password combination");
                    $('#wrong_UserPassword_signUp').fadeTo(100, 1);
                } else {
                    alert("Some Error Occured. Pleas try again.")
                }
                hideLoading();
                releaseClick();
            });
        }
    } else {
        $("#email_format_signUp").fadeTo(100, 1);
    }
}

function enterLogin2(e){
    if (e.keyCode == 13) {
        login2();
    }
}

function login2() {
    var value = $("#login_email").val();
    var password = $("#login_password").val();
    var a = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(value);
    if (a) {
        stopClick();
        showLoading();
        $("#email_format_login").fadeTo(0, 0);
        $("#wrong_UserPassword").fadeTo(0, 0);
        if (password == '' || password.length < 6) {
            $("#wrong_UserPassword").html("Password should have 6 characters");
            $('#wrong_UserPassword').fadeTo(100, 1);
        } else {
            $.post("/ajax/userLogin", {
                loginUserName: value,
                loginPassword: password
            }, function(data, status) {
                if (data == "1") {
                    window.location.href = "/";
                }
                else if (data == "0") {
                    $("#wrong_UserPassword").html("Wrong username and password combination");
                    $('#wrong_UserPassword').fadeTo(100, 1);
                } else {
                    alert("Some Error Occured. Pleas try again.")
                }
                hideLoading();
                releaseClick();
            });
        }
    } else {
        $("#email_format_login").fadeTo(100, 1);
    }
}

function checkEmailExist(type) {
    var email;
    var divId;
    var string;
    $("#email_register_error").fadeTo(0, 0);
    $("#username_register_error").fadeTo(0, 0);
    flag_register = false;
    if (type == 1) {
        email = $("#register_email").val();
        divId = "#email_register_error";
        string = "Email id already exists.";
    }
    else {
        email = $("#register_username").val();
        divId = "#username_register_error";
        string = "Username already taken.";
    }
    if (email.length > 3) {
        $.post("validationCheck", {
            email: email,
            type: type
        }, function(data, status) {
            if (data == "1") {
                $(divId).html(string);
                $(divId).fadeTo(100, 1);
            }
        });
    } else {
        $("#email_register_error").css('opacity', '0');
        $("#username_register_error").css('opacity', '0');
    }
}

function validateRegisterForm() {

    email = $("#register_email").val();
    username = $("#register_username").val();
    password = $("#register_password").val();
    var flag = 0;

    var a = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(email);
    if (!a) {
        $("#email_register_error").html("Email Id not in correct format.");
        $("#email_register_error").fadeTo(100, 1);
        flag = 1;
    } else {
        $("#email_register_error").fadeTo(0, 0);
    }

    if (username.length < 4) {
        $("#username_register_error").html("Username must be at least 4 characters long.");
        $("#username_register_error").fadeTo(100, 1);
        flag = 1;
    } else {
        $("#username_register_error").fadeTo(0, 0);
    }

    if (password.length < 6) {
        $("#password_register_error").html("Password must be at least 6 characters long.");
        $("#password_register_error").fadeTo(100, 1);
        flag = 1;
    } else {
        $("#password_register_error").fadeTo(0, 0);
    }

    if (flag == 0) {
        stopClick();
        showLoading();
        $.ajax({
            type: "POST",
            url: "validationCheck",
            data: {
                email: email,
                type: 3,
                username: username
            },
            async: false
        }).done(function(msg) {
            if (msg == 1) {

                checkEmailExist(0);
                checkEmailExist(1);

            }
            else {
                var email = $("#register_email").val();
                var username = $("#register_username").val();
                var password = $("#register_password").val();
                var a = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(email);
                if (a && username.length > 2 && password.length > 5) {
                    $.post("registration", {
                        email: email,
                        username: username,
                        password: password
                    }, function(data, status) {
                        if (data == "1") {
                            window.location.href = "/";
                        }
                        else if (data == "2") {
                            checkEmailExist(0);
                            checkEmailExist(1);
                        }
                    });
                }
            }
            hideLoading();
            releaseClick();
        });
    } else {
        checkEmailExist(0);
        checkEmailExist(1);
    }
}


function stopClick() {
    $("#stopClick").css('height', $(document).height());
    $("#stopClick").css('width', $(document).width());
    $("#stopClick").css('z-index', '2000');
}
function releaseClick() {
    $("#stopClick").css('height', '0');
    $("#stopClick").css('width', '0');
    $("#stopClick").css('z-index', '0');
}

function showLoading() {
    $("#ajaxLoader").css('height', $(document).height());
    $("#ajaxLoader").css('width', $(document).width());
    $("#ajaxLoader").css('z-index', '2000');
}

function hideLoading() {
    $("#ajaxLoader").css('height', '0');
    $("#ajaxLoader").css('width', '0');
    $("#ajaxLoader").css('z-index', '0');
}
function showLoginBox() {
    stopClick();
    $("#loginBox").show("500", function() {
        releaseClick();
    });
}
function closeLoginBox() {
    stopClick();
    $("#loginBox").hide("1000", function() {
        releaseClick();
    });

}

function showSignInBox() {
    stopClick();
    $("#loginBox2").show("500", function() {
        releaseClick();
    });
}

function closeSignInBox() {
    stopClick();
    $("#loginBox2").hide("1000", function() {
        releaseClick();
    });

}

function openForgotPassword() {
    closeSignInBox();
    $("#forgotPasswordBox").show(500);
}

function closeForgotPassword() {
    $("#forgotPasswordBox").hide();
}

function forgotPasswordGo() {
    email = $("#fp_email").val();
    var a = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i.test(email);
    if (a) {
        $.post("/ajax/forgotPassword.php", {
            email: email
        }, function(data, status) {
            if (data.data == 1) {
                $("#forgotPassword_u").val(data.id);
                $("#forgotPasswordInner2").show();
                $("#forgotPasswordInner1").hide();
                $("#forgotPasswordInner2").fadeTo(500, 1);
            } else if (data.data == 4) {
                $("#forgotPasswordError").html("This email Id does not Exist. Please Check.");
            } else {
                $("#forgotPasswordError").html("Some error occured. Please retry.");
            }
        }, 'json');
    }else{
        $("#forgotPasswordError").html("Email Id not in correct format.");
    }
}

function feedBackChange(){
    var value = $("#feedback_txt").val();
    if(value.length>16){
        $(".feedback_txt").css("font-size","50px");
    }
    if(value.length>69){
        $(".feedback_txt").css("font-size","33px");
    }
    if(value.length<69){
        $(".feedback_txt").css("font-size","50px");
    }
    if(value.length<16){
        $(".feedback_txt").css("font-size","100px");
    }
}

function submitFeedBack(){
    var value = $("#feedback_txt").val();
    if(value.length>200){
        $("#feedback_error").html("Text too long. Max. characters allowed is 200.");
    }else if(value.length==0){
        $("#feedback_error").html("You didn't write anything.");
    }else{
        console.log("asa");
        $("#feedback_error").html("");
        $.post("/ajax/postFeedback.php", {
            feedback: value
        }, function(data) {
            if (data.data == 'Valid') {
                $("#feedback_error").html("Thank You for your feedback.");
                $("#feedback_txt").val("");
                feedBackChange();
            } else {
              $("#feedback_error").html("Some error occured. Please try again.");
            }
        }, 'json');
    }
}

function changepassword() {
    var password = $("#newPassword").val();
    if (password.length > 5) {
        if (password == $("#confirmPassword").val()) {
            $.post("ajax/resetPassword.php", {
                password: $("#newPassword").val()
            },function (data){
                if(data.data=='1'){
                    $("#replace").html('<div class="email_field" style="text-align:center; color:#939393; font-family:Century_Gothic_Bold; line-height:100px">Password Reset Successfully.</div>');
                }
            },'json');
        } else {
            $("#errorDiv").html('Password and confirm password does not match.');
        }
    } else {
        $("#errorDiv").html('Password must contain atleast 6 characters.');
    }
}