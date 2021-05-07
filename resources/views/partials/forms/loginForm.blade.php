<div class="uk-flex-top form-container" id="signin-form" uk-modal>
    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
        <div class="uk-flex .uk-flex-around .uk-flex-row">
            <div class="uk-padding-small">
                <div class="upper_modal">
                    <h3><b>SIGN IN</b></h3>
                    <div class="icon">
                        <div class="img">
                            <img src="{{ asset('images/icons/google.png') }}" width="14px" height="14px" />
                        </div>
                        <div class="img">
                            <img src="{{ asset('images/icons/facebook.png') }}" width="14px" height="14px" />
                        </div>
                    </div>
                    <p>Or Sign Up with Email</p>
                    <hr />
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="group">
                        <input class="input" type="email" name="email" required autocomplete="email" autofocus />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Email</label>
                    </div>

                    <div class="group">
                        <input class="input" type="password" name="password" required autocomplete="current-password" />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Password</label>
                    </div>

                    <input type="checkbox" checked="checked" name="remember" class="radioBtn" /><span> Keep me Logged
                        in</span>
                    <button class="form-btn" type="submit">Submit</button>
                </form>
                <div class="footer">
                    <p>Forgot Password ?</p>
                    <span>Don't have an account</span>
                    <a uk-toggle="target: #signup-form">Sign Up</a>
                    <hr />
                </div>
            </div>
            <div class="sign_img" style="background-image:url({{ asset('images/background/img4.jpeg') }})"></div>
        </div>

    </div>
</div>
