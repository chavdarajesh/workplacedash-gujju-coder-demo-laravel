<div class="gc-form-title">
    <h5>{{ __('New Vaccinations') }}</h5>
</div>
<div class="alert alert-secondary" role="alert">
    {{ __("By completing this form, you acknowledge you're reporting your vaccination status in an accurate and honest manner. Thank you for choosing to report your vaccination status.") }}
</div>
<form id="vaccinationsstore" action="{{ route('vaccinationsstore') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Have you been vaccinated') }}<span
                        class="required">*</span></label>
                <div class="rightcheckbox classvaccinated">
                    <div class="form-check">
                        <input class="form-check-input vaccinated" type="radio" name="vaccinated" id="exampleRadios1"
                            value="1" />
                        <label class="form-check-label" for="exampleRadios1">
                            {{ __('Yes') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input vaccinated" type="radio" name="vaccinated" id="exampleRadios12"
                            value="0" />
                        <label class="form-check-label" for="exampleRadios12">
                            {{ __('No') }}
                        </label>
                    </div>
                </div>
                <span class="invalid-feedback"
                    role="alert"><strong>{{ __('vaccinated field is required') }}</strong></span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Date administered') }}<span class="required">*</span></label>
                <input required type="datetime-local" value="{{ old('date_administered') }}" name="date_administered"
                    placeholder="" onClick="$(this).removeClass('placeholderclass')"
                    class="dateclass placeholderclass form-control" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe classvaccine_type">
                <label for="exampleInputEmail1">{{ __('Vaccine type') }}<span class="required">*</span></label>
                {!! GetVaccinetypeDropDown() !!}
            </div>
            <span class="invalid-feedback  mt-n2 mb-1"
                role="alert"><strong>{{ __('Vaccine type field is required.') }}</strong></span>
        </div>

        <div class="col-md-12">
            <div class="form-group gc-uploadbtn">
                <div class="gcspuploadedwpr">
                    <label for="vc-file-upload" class="custom-file-upload">
                        <img src="{{ asset('images/attached-file.png') }}" alt="">
                    </label>
                    <input id="vc-file-upload" class="vc-file-upload" name="picture" type="file" accept="image/*" />
                </div>
                <div id="vcfileinstedtimg"></div>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary addsecondvaccinations">{{ __('+ Add Vaccination') }}</button>

    <div class="secondvaccinations row">
        <div class="col-md-12">
            <button type="button" class="btn closesecondvaccinations">{{ __('X') }}</button>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Have you been vaccinated') }}<span
                        class="required">*</span></label>
                <div class="rightcheckbox classsecond_vaccinated">
                    <div class="form-check">
                        <input class="form-check-input second_vaccinated" type="radio" name="second_vaccinated"
                            id="exampleRadios1" value="1" />
                        <label class="form-check-label" for="exampleRadios1">
                            {{ __('Yes') }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input second_vaccinated" type="radio" name="second_vaccinated"
                            id="exampleRadios12" value="0" />
                        <label class="form-check-label" for="exampleRadios12">
                            {{ __('No') }}
                        </label>
                    </div>
                </div>
                <span class="invalid-feedback"
                    role="alert"><strong>{{ __('second_vaccinated field is required') }}</strong></span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleInputEmail1">{{ __('Date administered') }}<span class="required">*</span></label>
                <input type="datetime-local" value="{{ old('second_date_administered') }}"
                    name="second_date_administered" placeholder="" onClick="$(this).removeClass('placeholderclass')"
                    class="dateclass placeholderclass form-control" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group gcsptreeviewwapepe classvaccine_type">
                <label for="exampleInputEmail1">{{ __('Vaccine type') }}<span class="required">*</span></label>
                {!! GetVaccinetypeDropDown(false, true) !!}
            </div>
            <span class="invalid-feedback  mt-n2 mb-1"
                role="alert"><strong>{{ __('Vaccine type field is required.') }}</strong></span>
        </div>

        <div class="col-md-12">
            <div class="form-group gc-uploadbtn">
                <div class="gcspuploadedwpr">
                    <label for="second-vc-file-upload" class="custom-file-upload">
                        <img src="{{ asset('images/attached-file.png') }}" alt="">
                    </label>
                    <input id="second-vc-file-upload" class="second-vc-file-upload" name="second_picture"
                        type="file" accept="image/*" />
                </div>
                <div id="secondvcfileinstedtimg"></div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-primary gcspaddvaccinations">{{ __('Submit') }}</button>
</form>
