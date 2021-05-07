<div class="uk-flex-top form-container" id="signup-form" uk-modal>
    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
        <div class="uk-flex .uk-flex-around .uk-flex-row">
            <div class="sign_img" style="background-image:url({{ asset('images/background/img5.jpeg') }})"></div>

            <div class="uk-padding-small">
                <div class="upper_modal">
                    <h3><b>SIGN UP</b></h3>
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
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div id="first_block">
                        <div class="group">
                            <input class="input" type="text" name="name" required autocomplete="name" autofocus />
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Name</label>
                        </div>

                        <div class="group">
                            <input class="input" type="text" name="username" required autocomplete="username" />
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Username</label>
                        </div>

                        <div class="group">
                            <input class="input" type="number" name="phone" required autocomplete="phone" />
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Phone Number</label>
                        </div>

                        <button class="form-btn" type="submit" onclick="onEdit1();">Next</button>
                    </div>

                    <div id="second_block" style="display: none">
                        <div class="group">
                            <input class="input" type="email" name="email" required autocomplete="email" />
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Email</label>
                        </div>

                        <div class="group">
                            <input class="input" type="password" name="password" required autocomplete="new-password" />
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Create Password</label>
                        </div>

                        <div class="group">
                            <input class="input" type="password" name="password_confirmation" required
                                autocomplete="new-password" />
                            <span class="highlight"></span>
                            <span class="bar"></span>
                            <label>Confirm Password</label>
                        </div>

                        <input type="checkbox" checked="checked" name="remember" class="radioBtn" /><span> Keep me
                            Logged in</span>
                        <button class="form-btn" type="submit"> {{ __('Register') }}</button>
                    </div>
                    <div class="footer">
                        <span>Already have an account</span>
                        <a uk-toggle="target: #signin-form">Sign In</a>
                        <hr />
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function onEdit1() {
        var edit = document.getElementById("second_block");
        edit.style.display = "block";
        edit = document.getElementById("first_block");
        edit.style.display = "none";
    }

</script>
