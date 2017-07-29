
<div class="login-content">
    <p><?= (!empty($error)) ? $error : '' ?></p>
    <form action="/admin/login" method="POST" class="margin-bottom-0">
        <div class="form-group m-b-20">
            <input type="text" name="login" class="form-control input-lg" placeholder="Login" />
        </div>
        <div class="form-group m-b-20">
            <input type="password" name="pass" class="form-control input-lg" placeholder="Password" />
        </div>

        <div class="checkbox m-b-20">
            <label>
                <input type="checkbox" value="on" name="rememberMe" /> Remember Me
            </label>
        </div>
        <div class="form-group ">
            <div class="col-xs-11 col-xs-offset-1 m-b-20">
                <?= $captcha ?>
                <input name="CaptchaCode" id="CaptchaCode" type="text"/>
            </div>
        </div>
        <div class="login-buttons">
            <button type="submit" class="btn btn-success btn-block btn-lg">Sign me in</button>
        </div>
    </form>
</div>
