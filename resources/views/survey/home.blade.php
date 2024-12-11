@extends('layouts.compliance_survey')

@section('content')

<style>

a.survey-box {  }
a.survey-box:hover {  }
.survey-box { border: solid 3px #e1e1e1; padding: 24px; width: 100%; max-width: 236px; margin-right: 24px;}
.survey-box .s-icon_ { height: 61px; display: flex; justify-content: center; align-items: center;}
.survey-box .s-icon_ img { width: 51px; }
.survey-box .s-title_ { font-size: 24px; margin-top: 24px; color: #737373; }
.survey-box .s-desc_ { margin-top: 24px; color: #b0b0b0; font-size: 13px; }

a.survey-box {  }
a.survey-box:hover { border: solid 3px #3e7bc4; }
a.survey-box:hover .s-title_ { color: #3e7bc4; }
a.survey-box:hover .s-desc_ { color: #3e7bc4; }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="trow_" style="background-color: #f2f2f2; padding: 14px 0px;">
                <h4 class="wd-100p cnt-center fs-24_ mb-3_ txt-blue weight_600">Where would you like to begin?</h4>
        </div>
    </div>
</div>

<div class="row mt-17_">

<div class="col-sm-12">

        <div class="row">
            <div class="col-sm-12">

                    <div class="flx-justify-center" style="margin-top: 40px;">

                            <a class="survey-box new-survey" href="{{ url('/survey/create') }}">
                                    <div class="trow_ cnt-center c-dib_ s-icon_"><img src="{{ asset('images/survey/new-survey.png') }}"></div>
                                    <div class="trow_ cnt-center s-title_">Start a New Survey</div>
                                    <div class="trow_ cnt-center s-desc_">Build a new Survey from scratch</div>
                            </a>

                            <a class="survey-box copy-survey" href="{{ url('/survey/edit-copy') }}">
                                    <div class="trow_ cnt-center c-dib_ s-icon_"><img src="{{ asset('images/survey/copy-survey.png') }}"></div>
                                    <div class="trow_ cnt-center s-title_">Copy a Survey</div>
                                    <div class="trow_ cnt-center s-desc_">Copy and edit your existing survey</div>
                            </a>

                            <a class="survey-box inventory-survey" href="{{ url('/survey/inventory') }}">
                                    <div class="trow_ cnt-center c-dib_  s-icon_"><img src="{{ asset('images/survey/inventory-survey.png') }}"></div>
                                    <div class="trow_ cnt-center s-title_">Survey Inventory</div>
                                    <div class="trow_ cnt-center s-desc_">Choose from Survey Inventory</div>
                            </a>

                    </div>

            </div>
        </div>
    </div>
</div>	
@endsection
