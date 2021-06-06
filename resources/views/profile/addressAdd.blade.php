@extends('layouts.app')

@section('content')
    <form action="{{ route('address.add') }}" method='post' enctype="multipart/form-data">
        @csrf
        <h1 class="uk-heading-divider uk-text-center uk-text-bold cproduct-head">Create an Address</h1>
        <div>
            <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                <label class="uk-width-1-5@m uk-text-bold" for="name">Full name (First and Last name) :</label>
                <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                    <i class="uk-form-icon ri-pencil-fill"></i>
                    <input class="uk-input" type="text" id="name" name="name" required>
                </div>
            </div>
            <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                <label class="uk-width-1-5@m uk-text-bold" for="mobile">Mobile number :</label>
                <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                    <i class="uk-form-icon ri-pencil-fill"></i>
                    <input class="uk-input" type="number" id="mobile" name="mobile" pattern="[6-9]{1}[0-9]{9}" placeholder="10-digit mobile number without prefixes" required> 
                </div>
            </div>
            <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                <label class="uk-width-1-5@m uk-text-bold" for="pincode">PIN Code :</label>
                <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                    <i class="uk-form-icon ri-pencil-fill"></i>
                    <input class="uk-input" type="number" id="pincode" name="pincode" pattern="[0-9]{6}" placeholder="6-digit [0-9] PIN code" required>
                </div>
            </div>
            <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                <label class="uk-width-1-5@m uk-text-bold" for="address1">Flat, House no., Building, Company, Apartment :</label>
                <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                    <i class="uk-form-icon ri-pencil-fill"></i>
                    <input class="uk-input" type="text" id="address1" name="address1" required>
                </div>
            </div>
            <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                <label class="uk-width-1-5@m uk-text-bold" for="address2">Area, Colony, Street, Sector, Village :</label>
                <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                    <i class="uk-form-icon ri-pencil-fill"></i>
                    <input class="uk-input" type="text" id="address2" name="address2" required>
                </div>
            </div>
            <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                <label class="uk-width-1-5@m uk-text-bold" for="landmark">Landmark :</label>
                <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                    <i class="uk-form-icon ri-pencil-fill"></i>
                    <input class="uk-input" type="text" id="landmark" name="landmark" placeholder="E.g. Near AIIMS Flyover, Behind Regal Cinema, etc." required>
                </div>
            </div>
            <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                <label class="uk-width-1-5@m uk-text-bold" for="city">Town/City :</label>
                <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                    <i class="uk-form-icon ri-pencil-fill"></i>
                    <input class="uk-input" type="text" id="city" name="city" required>
                </div>
            </div>
            <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                <label class="uk-width-1-5@m uk-text-bold" for="address4">State / Province / Region :</label>
                <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                    <select name="state" id="state" class="uk-input" required>
                        <option value="" disabled selected>Select State</option>
                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                        <option value="Assam">Assam</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Chandigarh">Chandigarh</option>
                        <option value="Chhattisgarh">Chhattisgarh</option>
                        <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                        <option value="Daman and Diu">Daman and Diu</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Lakshadweep">Lakshadweep</option>
                        <option value="Puducherry">Puducherry</option>
                        <option value="Goa">Goa</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Haryana">Haryana</option>
                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                        <option value="Jharkhand">Jharkhand</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="Kerala">Kerala</option>
                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Manipur">Manipur</option>
                        <option value="Meghalaya">Meghalaya</option>
                        <option value="Mizoram">Mizoram</option>
                        <option value="Nagaland">Nagaland</option>
                        <option value="Odisha">Odisha</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Sikkim">Sikkim</option>
                        <option value="Tamil Nadu">Tamil Nadu</option>
                        <option value="Telangana">Telangana</option>
                        <option value="Tripura">Tripura</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="Uttarakhand">Uttarakhand</option>
                        <option value="West Bengal">West Bengal</option>
                    </select>    
                </div>
            </div>
            <div class="uk-padding-small uk-flex uk-flex-middle uk-flex-wrap">
                <label class="uk-width-1-5@m uk-text-bold" for="type">Address Type :</label>
                <div class="uk-inline uk-width-1-1 uk-width-4-5@m">
                    <select name="type" id="type" class="uk-input" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="Home">Home</option>
                        <option value="Work">Work</option>
                    </select>    
                </div>
            </div>
            <div class="uk-flex uk-flex-around">
                <button type="submit" class="uk-button cproduct-btn">Add Address</button>
            </div>
            <br>
        </div>
    </form>


@endsection
