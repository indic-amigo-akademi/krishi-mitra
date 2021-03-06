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

                <form action="{{ route('login') }}" method="POST" id="modal-login-form">
                    @csrf
                    <div class="group">
                        <input class="input uk-input" type="text" name="email" required autocomplete="email"
                            autofocus />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Username / Email</label>

                        <small class="uk-text-danger uk-margin-bottom">
                            <strong class="error-email"></strong>
                        </small>
                    </div>

                    <div class="group">
                        <input class="input uk-input" type="password" name="password" required
                            autocomplete="current-password" />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Password</label>

                        <small class="uk-text-danger uk-margin-bottom">
                            <strong class="error-password"></strong>
                        </small>
                    </div>

                    <input type="checkbox" name="remember" class="radioBtn uk-checkbox" checked /><span> Keep me Logged
                        in</span>
                    <button class="form-btn submit-btn" type="button">Login</button>
                </form>
                <div class="footer">
                    <a href="/password/reset">
                        <p>Forgot Password ?</p>
                    </a>
                    <span>Don't have an account</span>
                    <a uk-toggle="target: #signup-form">Sign Up</a>
                    <hr />
                </div>
            </div>
            <div class="sign_img" style="background-image:url({{ asset('images/background/img4.jpeg') }})"></div>
        </div>

    </div>
</div>
