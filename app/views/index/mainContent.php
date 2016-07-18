<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <form method="POST" role="form" name="user_registration_form" id="user_registration_form" action="users/register">
                <h2>User Registration Form</h2>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="firstname" id="first_name" class="form-control input-lg" placeholder="First Name" tabindex="1" required maxlength="20" data-parsley-pattern="[a-zA-Z]+" data-parsley-error-message="Use text characters only">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="lastname" id="last_name" class="form-control input-lg" placeholder="Last Name" tabindex="2" required  maxlength="40" data-parsley-pattern="[a-zA-Z]+" data-parsley-error-message="Use text characters only">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="address1" id="address1" class="form-control input-lg" placeholder="Street Address" tabindex="3" required>
                </div>
                <div class="form-group">
                    <input type="text" name="address2" id="address2" class="form-control input-lg" placeholder="Apt. #" tabindex="4">
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="city" id="city" class="form-control input-lg" placeholder="City" tabindex="5" required maxlength="20" data-parsley-pattern="[a-zA-Z]+" data-parsley-error-message="Use text characters only">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <select name="state" id="state" class="form-control input-lg" placeholder="State" tabindex="6" required>
                                <option value="">State</option>
                                <option value="AL">AL</option>
                                <option value="AK">AK</option>
                                <option value="AZ">AZ</option>
                                <option value="AR">AR</option>
                                <option value="CA">CA</option>
                                <option value="CO">CO</option>
                                <option value="CT">CT</option>
                                <option value="DE">DE</option>
                                <option value="DC">DC</option>
                                <option value="FL">FL</option>
                                <option value="GA">GA</option>
                                <option value="HI">HI</option>
                                <option value="ID">ID</option>
                                <option value="IL">IL</option>
                                <option value="IN">IN</option>
                                <option value="IA">IA</option>
                                <option value="KS">KS</option>
                                <option value="KY">KY</option>
                                <option value="LA">LA</option>
                                <option value="ME">ME</option>
                                <option value="MD">MD</option>
                                <option value="MA">MA</option>
                                <option value="MI">MI</option>
                                <option value="MN">MN</option>
                                <option value="MS">MS</option>
                                <option value="MO">MO</option>
                                <option value="MT">MT</option>
                                <option value="NE">NE</option>
                                <option value="NV">NV</option>
                                <option value="NH">NH</option>
                                <option value="NJ">NJ</option>
                                <option value="NM">NM</option>
                                <option value="NY">NY</option>
                                <option value="NC">NC</option>
                                <option value="ND">ND</option>
                                <option value="OH">OH</option>
                                <option value="OK">OK</option>
                                <option value="OR">OR</option>
                                <option value="PA">PA</option>
                                <option value="RI">RI</option>
                                <option value="SC">SC</option>
                                <option value="SD">SD</option>
                                <option value="TN">TN</option>
                                <option value="TX">TX</option>
                                <option value="UT">UT</option>
                                <option value="VT">VT</option>
                                <option value="VA">VA</option>
                                <option value="WA">WA</option>
                                <option value="WV">WV</option>
                                <option value="WI">WI</option>
                                <option value="WY">WY</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input name="zipcode" id="zip" class="form-control input-lg" placeholder="ZIP Code (5 or 9 digits)" tabindex="6" required maxlength="10" data-parsley-zip-code="/^\d{5}(?:-\d{4})?$/m">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="form-group">
                            <select name="country" id="country" class="form-control input-lg" tabindex="5" required>
                                <option value="">Country</option>
                                <option value="US">USA</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3"><input type="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="9"></div>
                </div>
            </form>
        </div>
    </div>
</div>