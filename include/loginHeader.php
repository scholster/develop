<div id="header">
    <div class="wrapper" id="head">
        <a href="/"><div class="logo"></div></a>
        <?php
        $login = new LoginController();
        if (!($login->loggedIn)) {
            ?>
            <ul class="nav_right">
                <a href="#" class="big-link" data-reveal-id="sign_in"  data-animation="fade" style="color:#8d8d8d;"><li> Sign In  </li></a>
                <a href="#" class="big-link" data-reveal-id="sign_up" data-animation="fade"  style="color:#ffffff;"> <li class="sign_up"> Sign Up</li> </a>
            </ul>
            <?php
        }
        ?>
    </div>
</div>