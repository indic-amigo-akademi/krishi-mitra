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
                <div id="first_block">
                    <div class="group">
                        <input class="input" type="text" required />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Name</label>
                    </div>

                    <div class="group">
                        <input class="input" type="text" required />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Username</label>
                    </div>

                    <div class="group">
                        <input class="input" type="number" required />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Contact</label>
                    </div>

                    <button class="Log_button" type="submit" onclick="onEdit1();">Next</button>
                </div>

                <div id="second_block" style="display: none">
                    <div class="group">
                        <input class="input" type="text" required />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Email</label>
                    </div>

                    <div class="group">
                        <input class="input" type="password" required />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Create Password</label>
                    </div>

                    <div class="group">
                        <input class="input" type="password" required />
                        <span class="highlight"></span>
                        <span class="bar"></span>
                        <label>Confirm Password</label>
                    </div>

                    <input type="checkbox" checked="checked" name="remember" class="radioBtn" /><span> Keep me
                        Logged in</span>
                    <button class="Log_button" type="submit">Submit</button>
                </div>
                <div class="footer">
                    <span>Already have an account</span>
                    <a uk-toggle="target: #signin-form">Sign In</a>
                    <hr />
                </div>
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
