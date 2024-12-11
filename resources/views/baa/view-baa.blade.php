@extends('layouts.compliance')
@section('content')




 <style>
        #bus-assoc-agrmnts{color: #242424;}

        #bus-assoc-agrmnts h3 { font-size: 24px; margin: 24px 0px; font-weight: 600; }

        #bus-assoc-agrmnts p{font-size: 18px; line-height: 1.6em; margin: 14px 0px;}
        #bus-assoc-agrmnts p span { font-size: inherit; line-height: inherit; }

        #bus-assoc-agrmnts ul { list-style-type: disc; list-style-position: outside; padding-left: 40px; }
        #bus-assoc-agrmnts ul li{font-size: 18px; line-height: 1.4em; margin-bottom: 7px;}
        #bus-assoc-agrmnts ul li span { font-size: inherit; line-height: inherit; }

        #bus-assoc-agrmnts .uppercase_bold{text-transform: uppercase;font-weight:600;}

        #bus-assoc-agrmnts a { font-size: inherit; color: #3e7bc4; text-decoration: underline; display: inline-block; vertical-align: baseline; }
        #bus-assoc-agrmnts a:hover {  color: #007bff !important;}

        #bus-assoc-agrmnts strong { display: inline-block; font-size: inherit; font-weight: 700; line-height: inherit; }

        #bus-assoc-agrmnts p.list-level1 { padding-left: 0%; }
        #bus-assoc-agrmnts p.list-level1 .list-number { display: inline-block; font-weight: 700; padding-right: 1%; }

        #bus-assoc-agrmnts p.list-level2 { padding-left: 2.6%; }
        #bus-assoc-agrmnts p.list-level2 .list-number { display: inline-block; font-weight: 700; padding-right: 1%; }

        #bus-assoc-agrmnts p.list-level3a { padding-left: 5.9%; }
        #bus-assoc-agrmnts p.list-level3a .list-number { display: inline-block; font-weight: 700; padding-right: 0.7%; }

        #bus-assoc-agr-form {  }
        #bus-assoc-agr-form .bag-field_ { position: relative; padding-left: 80px;}
        #bus-assoc-agr-form label {font-size: 20px;width: 80px;margin: 0px;padding-top: 10px;position: absolute;top: 0px;left: 0px;}
        #bus-assoc-agr-form .radio-field-option label { position: relative; top: auto; left: auto; }
        #bus-assoc-agr-form input[type="text"] {padding: 10px 7px;border-radius: 2px;border: solid 1px #ccc;font-size: 20px;width: 100%;}
        #bus-assoc-agr-form .by_field_ input[type="text"] { }

        #bus-assoc-agr-form .company-form {border: solid 1px #ccc;border-radius: 24px;padding: 32px;}
        #bus-assoc-agr-form .company-form .bag-field_ {  }
        #bus-assoc-agr-form .company-form label { font-style: italic; font-weight: 700; color: #aaa;}
        #bus-assoc-agr-form .company-form input[type="text"] {background-color: #e4e4e4;}
        #bus-assoc-agr-form .company-form .by_field_ {  }
        #bus-assoc-agr-form .company-form .by_field_ input[type="text"] { padding-bottom: 3px; border: 0px; border-bottom: solid 1px #ccc; background-color: transparent;}


        #bus-assoc-agr-form .bus_assoc-form { border: solid 1px #ccc;border-radius: 24px;padding: 32px; }
        #bus-assoc-agr-form .bus_assoc-form .bag-field_ {  }
        #bus-assoc-agr-form .bus_assoc-form label {  }
        #bus-assoc-agr-form .bus_assoc-form input[type="text"] {  }
        #bus-assoc-agr-form .bus_assoc-form .by_field_ {  }
        #bus-assoc-agr-form .bus_assoc-form .by_field_ input[type="text"] {padding-bottom: 3px; border: 0px;border-bottom: solid 1px #ccc;}

        .bottom-solid-line { margin-left: 7px; margin-right:7px; border-bottom: solid 2px #242424;width: 100px;display: inline-block;height: 1.04em;}

        .field-placeholder {

    margin-left: 7px;
    margin-right: 7px;
    border-bottom: solid 1px #242424;
    width: 100px;
   DISPLAY: INLINE;
    height: 1.4em;
    font-weight: 600;
    padding-left: 4px;
    padding-right: 7px;

}
        .left-indent-4p { text-indent: 4%; }

        .modal {background-color: #242424 !important;}

    </style>

<div class="row" id="hidden-opa" >
	<div class="col-sm-12" style="max-width: 1180px; margin: 0px auto; padding-bottom: 100px;">

		<div class="trow_ cnt-center mt-40_ mb-14_ c-dib_">

			<a class="navbar-brand" href="javascript:void(0)">
				<img src="{{asset('images/home-assets/logo-big.png')}}" style="max-width: 300px;" alt="Site Logo">
			</a>
		</div>

		<div class="trow_ ">
			<h2 class="trow_ cnt-center txt-blue tt_uc_ weight_600 fs-36_ mt-14_ mb-14_">business associate agreement</h2>
		</div>

		<div id="bus-assoc-agrmnts">
            <p class="left-indent-4p">This Business Associate Agreement is executed by and between Compliance Reward, LP. (the "Company") with a principal address of <span class="field-placeholder" style="width: 120px;">{{$practice->businessAgreement->accepted_terms_user ?: 'None'}}</span>, and Representative, an individual ("Business Associate") with a principal address of <span class="field-placeholder" style="width: 270px;">{{$practice->practice_address}}</span> to be effective as of the <span class="field-placeholder" style="width: 30px;">{{date('d', strtotime($practice->businessAgreement->accepted_terms_dt))}}</span> day of <span class="field-placeholder" style="width: 20px;">{{date('m', strtotime($practice->businessAgreement->accepted_terms_dt ?: '0000'))}}</span>, 20<span class="field-placeholder" style="width: 30px;">{{date('y', strtotime($practice->businessAgreement->accepted_terms_dt ?: '0000'))}}</span> (this "Agreement") and is made a part of that certain Marketing Agency Agreement already entered into by and between these same parties dated as of this same Effective Date (the "Marketing Agency Agreement").</p>

            <p class="left-indent-4p">The purpose of this Agreement is to satisfy certain obligations of Company under the Health Insurance Portability and Accountability Act of 1996 and its implementing regulations (45 CFR Parts 160 and 164), as such may be amended from time to time ("HIPAA") to ensure the integrity and confidentiality of Protected Health Information (as such term is defined by HIPAA and as referenced herein). Company has designated itself, and all entities which it owns or in which it has a controlling ownership interest, as an affiliated covered entity ("ACE") pursuant to 45 CFR &sect; 164.512.</p>

            <div class="trow_ mb-14_">
                <p class="list-level1"><span class="list-number">1.0</span> <strong>Definitions.</strong> Capitalized terms used, but not otherwise defined, in this Agreement shall have the meanings given them in HIPAA. For convenience of reference, the definitions of "Individually Identifiable Health Information" and "Protected Health Information" as of the Effective Date are as follows:</p>
                <p class="list-level1"><span class="list-number">1.1</span> "Individually Identifiable Health Information" means information that is a subset of health information, including demographic information collected from an individual, and: (i) is created or received by a health care provider, health plan, employer, or health care clearinghouse; and (ii) relates to the past, present, or future physical or mental health or condition of an individual; the provision of health care to an individual; or the past, present, or future payment for the provision of health care to an individual; and (a) that identifies the individual, or (b) with respect to which there is a reasonable basis to believe the information can be used to identify the individual.</p>
                <p class="list-level1"><span class="list-number">1.2</span> "Protected Health Information" means Individually Identifiable Health Information that Business Associate receives from Company or from another business associate of Company of which Business Associate creates for Company which is transmitted or maintained in any form or medium. <br> "Protected Health Information" shall not include education records covered by the Family Educational Right and Privacy Act, as amended, 20 USC &sect; 1232g, or records described in 20 USC &sect; 1232g(a)(4)(B)(iv), or employment records held by Company in its role as employer.</p>
            </div>
            <div class="trow_ mb-14_">
            	<p class="list-level1"><span class="list-number">2.0</span> <strong>Applicability of Agreement.</strong> Company and Business Associate are parties to the Marketing Agency Agreement, and perhaps one or more other contracts or relationships, written or unwritten, formal or informal in which Company provides Protected Health Information to Business Associate. As of the Effective Date, this Agreement automatically amends all existing contracts and relationships between Business Associate and Company involving the use or disclosure of Protected Health Information, in order to fully comply with the requirements and limitations of HIPAA, and its governing regulations, as amended from time to time.</p>
            </div>
            <div class="trow_ mb-14_">
                <p class="list-level1"><span class="list-number">3.0</span> <strong>Privacy of Protected Health Information.</strong> Business Associate is permitted or required to use or disclose Protected Health Information it creates or receives for or from Company or to request Protected Health Information on Company's behalf only as follows:</p>
                <p class="list-level1"><span class="list-number">3.1</span> <strong>Functions and Activities on Company's Behalf.</strong> Except as otherwise limited in this Agreement, Business Associate is permitted to request the minimum necessary Protected Health Information on Company's behalf, and to use and to disclose the minimum necessary Protected Health Information to perform functions, activities, or services for or on behalf of Company.</p>
                <p class="list-level1"><span class="list-number">3.2</span> <strong>Business Associate's Operations.</strong> Business Associate may use the minimum necessary Protected Health Information for Business Associate's proper management and administration, or to carry out Business Associate's legal responsibilities. Business Associate may disclose the minimum necessary Protected Health Information for Business Associate's proper management and administration or to carry out Business Associate's legal responsibilities only if:</p>
                <p class="list-level2"><span class="list-number">3.2.1</span> The disclosure is required by law; or</p>
                <p class="list-level2"><span class="list-number">3.2.2</span> Business Associate obtains reasonable assurance, from any person or organization to which Business Associate shall disclose Protected Health Information that the person or organization shall:</p>
                <p class="list-level3a"><span class="list-number">a.</span> Hold such Protected Health Information in confidence and use or further disclose it only for the purpose for which Business Associate disclosed it to the person or organization or as required by law; and</p>
                <p class="list-level3a"><span class="list-number">b.</span> Promptly notify Business Associate (who shall in turn promptly notify Company) of any instance of which the person or organization becomes aware in which the confidentiality of such Protected Health Information was breached.</p>
                <p class="list-level1"><span class="list-number">3.3</span> <strong>Prohibition on Unauthorized Use or Disclosure.</strong> Business Associate shall neither use nor disclose Protected Health Information except as permitted or required by this Agreement, as otherwise permitted in writing by Company, or as required by law. This Agreement does not authorize Business Associate to use or disclose Protected Health Information in a manner that would violate the requirements of the Health Insurance Portability and Accountability Act of 1996 and its implementing regulations (45 CFR Parts 160-164, as amended from time to time) if done by Company, except as set forth in Section 3.2.</p>
                <p class="list-level1"><span class="list-number">3.4</span> <strong>Information Safeguards.</strong> Business Associate shall develop, implement, maintain, and use appropriate administrative, technical, and physical safeguards, in compliance with HIPAA and any other implementing regulations issued by the United States Department of Health and Human Services. The safeguards shall be designed to preserve the integrity and confidentiality of, and to prevent any nonpermitted or violating use or disclosure of, Protected Health Information. Business Associate shall keep the safeguards current.</p>
                <p class="list-level1"><span class="list-number">3.5</span> <strong>Subcontractors and Agents.</strong> Business Associate shall require any of its subcontractors and agents, to which Business Associate is permitted by this Agreement or in writing by Company to disclose Protected Health Information, to provide reasonable assurance, that such subcontractor or agent shall comply with the same privacy and security obligations as Business Associate with respect to such Protected Health Information.</p>
            </div>
            <div class="trow_ mb-14_">
                <p class="list-level1"><span class="list-number">4.0</span> <strong>Individual Rights.</strong></p>
                <p class="list-level1"><span class="list-number">4.1</span> <strong>Access.</strong> Business Associate shall, within twenty (20) days after Company's request, make available to Company or, at Company's direction, to the individual (or the individual's personal representative) for inspection and obtaining copies of any Protected Health Information about the individual that is in Business Associate's custody or control, so that Company may meet its access obligations under 45 CFR &sect; 164.524, as amended from time to time.</p>
                <p class="list-level1"><span class="list-number">4.2</span> <strong>Amendment.</strong> Business Associate shall, within forty (40) days of receiving a written notice from Company, promptly amend or permit Company access to amend any portion of the Protected Health Information, so that Company may meet its amendment obligations under 45 CFR &sect; 164.526, as amended from time to time.</p>
                <p class="list-level1"><span class="list-number">4.3</span> <strong>Disclosure Accounting.</strong> So that Company may meet its disclosure accounting obligations under 45 CFR &sect; 164.528 (as amended from time to time):</p>
                <p class="list-level2"><span class="list-number">4.3.1</span> Disclosure Tracking. Starting on the Effective Date, Business Associate shall record information concerning each disclosure of Protected Health Information, not excepted from disclosure tracking under the Agreement Section 4.3.2 below, that Business Associate makes to Company or a third party. The information Business Associate shall record is: (i) the disclosure date, (ii) the name and (if known) address of the person or entity to whom Business Associate made the disclosure, (iii) a brief description of the Protected Health Information disclosed, and (iv) a brief statement of the purpose of the disclosure (items i &mdash; iv, collectively, the "disclosure information"). For repetitive disclosures Business Associate makes to the same person or entity (including Company) for a single purpose, Business Associate may provide (1) the disclosure information for the first of these repetitive disclosures, (2) the frequency, periodicity, or number of these repetitive disclosures, and (3) the date of the last of these repetitive disclosures. Business Associate shall make this disclosure information available to Company within forty (40) days after Company's request.</p>
                <p class="list-level2"><span class="list-number">4.3.2</span> Exceptions from Disclosure Tracking. Business Associate need not record disclosure information or otherwise account for disclosures of Protected Health Information that this Agreement or Company in writing permits or requires: (i) for purposes of treating the individual who is the subject of the Protected Health Information disclosed, payment for that treatment, or for the health care operations of Company; (ii) to the individual who is the subject of the Protected Health Information disclosed or to that individual's personal representative; (iii) pursuant to a valid authorization by the person who is the subject of the Protected Health Information disclosed; (iv) to persons involved in that individual's health care or payment related to that individual's health care; (v) for notification for disaster relief purposes; (vi) for national security or intelligence purposes; (vii) as part of a limited data set; or (viii) to law enforcement officials or correctional institutions regarding inmates or other persons in lawful custody.</p>
                <p class="list-level2"><span class="list-number">4.3.3</span> Disclosure Tracking Time Periods. Business Associate must have available for Company the disclosure information required by this Agreement, Section 4.3.1 for the six (6) years preceding Company's request for the disclosure information (except Business Associate need have no disclosure information for disclosures occurring before April 14, 2003.)</p>
                <p class="list-level1"><span class="list-number">4.4</span> <strong>Restriction Requests; Confidential Communications.</strong> Business Associate shall comply with any agreements for confidential communications of which it is aware and to which Company agrees pursuant to 45 CFR &sect; 164.522(b)(as amended from time to time) by communicating with enrollees using agreed upon alternative means or alternative locations.</p>
                <p class="list-level1"><span class="list-number">4.5</span> <strong>Inspection of Books and Records.</strong> Business Associate shall make its internal practices, books, and records, relating to its use and disclosure of Protected Health Information, available to Company and to the United States Department of Health and Human Services to determine compliance with 45 CFR Parts 160-164 or this Agreement, as either may be amended from time to time.</p>
            </div>
            <div class="trow_ mb-14_">
                <p class="list-level1"><span class="list-number">5.0</span> <strong>Breach of Privacy Obligations.</strong></p>
                <p class="list-level1"><span class="list-number">5.1</span> <strong>Reporting.</strong> Business Associate shall report to Company any use, disclosure, or Security Incident which involves Protected Health Information not permitted by this Agreement or in writing by Company. Business Associate's report shall at least:</p>
                <p class="list-level2"><span class="list-number">5.1.1</span> Identify the nature of the nonpermitted use, disclosure or Security Incident;</p>
                <p class="list-level2"><span class="list-number">5.1.2</span> Identify who made the nonpermitted use, disclosure or caused the Security Incident, and who received the nonpermitted or violating disclosure;</p>
                <p class="list-level2"><span class="list-number">5.1.3</span> Identify what corrective action Business Associate took or shall take to prevent further nonpermitted uses, disclosures or Security Incident;</p>
                <p class="list-level2"><span class="list-number">5.1.4</span> Identify what Business Associate did or shall do to mitigate any deleterious effect of the nonpermitted use, disclosure or Security Incident; and</p>
                <p class="list-level2"><span class="list-number">5.1.5</span> Provide such other information, including a written report, as Company may reasonably request.</p>
                <p class="list-level1"><span class="list-number">5.2</span> <strong>Termination of Agreement.</strong></p>
                <p class="list-level2"><span class="list-number">5.2.1</span> <strong>Right to Terminate for Breach.</strong> Company may terminate this Agreement with Business Associate if it determines, in its sole discretion, that Business Associate has breached any material provision of this Agreement and failed to cure the breach within the time specified in good faith by Company. Company may exercise this right to terminate this Agreement by providing Business Associate written notice of termination, stating the breach of the Agreement that provides the basis for the termination. Any such termination shall be effective immediately or at such other date specified in Company's notice of termination.</p>
                <p class="list-level2"><span class="list-number">5.2.2</span> <strong>Obligations upon Termination:</strong> Return or Destruction. Upon termination, cancellation, expiration, or other conclusion of the contract or relationship, Business Associate shall, if feasible, return to Company or destroy all Protected Health Information, including all Protected Health Information in whatever form or medium (including any electronic medium) and all copies of and any data or compilations derived from and allowing identification of any individual who is a subject of</p>
                <p class="list-level3a"><span class="list-number">a.</span> Protected Health Information, as may be then required by HIPAA and its governing regulations, as amended from time to time. Business Associate shall complete such return or destruction as promptly as possible, but not later than thirty (30) days after the effective date of the termination, cancellation, expiration, or other conclusion of the contract or relationship. Business Associate shall identify any Protected Health Information that cannot feasibly be returned to Company or destroyed. Business Associate shall limit its further use or disclosure of that Protected Health Information to those purposes that make return or destruction of that Protected Health Information infeasible.</p>
                <p class="list-level3a"><span class="list-number">b.</span> Continuing Privacy Obligations. Business Associate's obligation to protect the privacy of the Protected Health Information it created or received for or from Company shall be continuous and survive termination, cancellation, expiration, or other conclusion of the contract or relationship.</p>
                <p class="list-level3a"><span class="list-number">c.</span> Other Obligations and Rights. Business Associate's other obligations and rights and Company's obligations and rights upon termination, cancellation, expiration, or other conclusion of the contract or relationship shall be those as defined in the terms of the contract or relationship.</p>
            </div>
            <div class="trow_ mb-14_">
                <p class="list-level1"><span class="list-number">6.0</span> <strong>Compliance with Requirements for Standard Transactions.</strong> If Business Associate conducts in whole or in part Standard Transactions for or on behalf of Company, Business Associate shall comply, and shall require any subcontractor or agent involved with the conduct of such Standard Transactions to comply, with each applicable requirement of 45 CFR 162, as amended from time to time. Business Associate shall not enter into, or permit its subcontractors or agents to enter into, any trading partner agreement in connection with the conduct of Standard Transactions for or on behalf of Company that:</p>
                <p class="list-level1"><span class="list-number">6.1</span> Changes the definition, data condition, or use of a data element or segment in a Standard Transaction;</p>
                <p class="list-level1"><span class="list-number">6.2</span> Adds any data elements or segments to the maximum defined data set;</p>
                <p class="list-level1"><span class="list-number">6.3</span> Uses any code or data element that is marked "not used" in the Standard Transaction's implementation specification or is not in the Standard Transaction's implementation specification; or</p>
                <p class="list-level1"><span class="list-number">6.4</span> Changes the meaning or intent of the Standard Transaction's implementation specification.</p>
            </div>
            <div class="trow_ mb-14_">
                <p class="list-level1"><span class="list-number">7.0</span> <strong>General Provisions.</strong></p>
                <p><strong>Amendments to Agreement.</strong> Upon the effective date of any final regulations or amendments to final regulations promulgated by the United States Department of Health and Human Services with respect to Protected Health Information, Standard Transactions, or Security, this Agreement and the contract or relationship of which it is part shall be deemed automatically amended such that the obligations they impose on Business Associate remain in compliance with such new law(s) and/or regulations.</p>
            </div>
            <div class="trow_ mb-14_">
                <p class="list-level1"><span class="list-number">8.0</span> <strong>Conflicts.</strong> The terms and conditions of this Agreement shall override and control any conflicting term or condition of the Marketing Agency Agreement. All nonconflicting terms and conditions of Agreement remain in full force and effect.</p>
                <p><strong>IN WITNESS, WHEREOF,</strong> Company and Business Associate execute this Agreement in multiple originals to be effective on the date first written above.</p>
            </div>
        </div>


        <div class="trow_"> <!-- form -->
            <div id="bus-assoc-agr-form" class="wd-100p mb-24_ flx-justify-start flex-vr-end">
            	<div class="wd-47p elm-left">

        			<div class="trow_ mb-24_">
        				<p class="trow_ mb-14_ fs-17_ txt-gray-6"><strong class="fs-17_ txt-black-24 weight_700 tt_uc_ cnt-left">company</strong> Compliance Reward, LP.</p>
        			</div>

        			<div class="trow_ bag-form_ company-form bg-gray-f2">

                    <div class="trow_ bag-field_ by_field_ mb-14_">
        					<label>By:</label>
        					 <div id="" class="jay-signature-pad">
                                <div class="jay-signature-pad--body mb-7_ br-rds-4" style="width: 100%; height: 100px; border: solid 1px #aaa;">
                                    <img width=500 height=250 style="width: 100%; height: 100%; border-radius: 7px;" src="{{$practice->businessAgreement->crb_accepted_terms != NULL ? asset('storage/'.$practice->businessAgreement->cr_accepted_terms_signature) : 'https://via.placeholder.com/300x120/FFFFFF/000000?text=CR%20has%20Not%20Signed%20Yet'}}">
                            </div>
                                <div class="signature-pad--footer txt-center">                                    <div class="description cnt-left c-dib_ mb-7_"><strong class="fs-17_ weight_600"> CR Signatures Above </strong></div>
                                                                               
                                                                                                                                                 </div>                            </div>
        				</div>
        		       <form id="agreement" action="" method="POST">

                        <div class="trow_ bag-field_ date_field_ mb-14_">
                            <input type="hidden" id="signatureImage" name="accepted_terms_signature" value="">
                            <label>Date:</label>
                           {{-- dd($practice->businessAgreement->crb_accepted_terms_dt)--}}
        					<input type="text" readonly="readonly"  name="accepted_terms_dt" value="{{$practice->businessAgreement->crb_accepted_terms_dt != '0000-00-00 00:00:00' ? date('m/d/Y', strtotime($practice->businessAgreement->crb_accepted_terms_dt)) : ''}}">
        				</div>

        				<div class="trow_ bag-field_ name_field_ mb-14_">
        					<label>Name:</label>
        					<input type="text" readonly="readonly" name="accepted_terms_user" value="{{$practice->businessAgreement->crb_accepted_terms_user != NULL ? $practice->businessAgreement->crb_accepted_terms_user : ''}}">
        				</div>

        				<div class="trow_ bag-field_ title_field_">
        					<label>Title:</label>
        					<input type="text" readonly="readonly" name="accepted_terms_role" class="cnt-left" value="{{$practice->businessAgreement->cr_accepted_terms_role != NULL ? $practice->businessAgreement->crb_accepted_terms_role : ''}}">
        				</div>

        				   </form>

</div>

            	</div>
            	<div class="wd-47p" style="margin-left: auto;">


        			<div class="trow_ bag-form_ mb-14_ bus_assoc-form">

        				<div class="trow_ bag-field_ by_field_ mb-14_">
        					<label>By:</label>
        					 <div id="" class="jay-signature-pad">
                                <div class="jay-signature-pad--body mb-7_ br-rds-4" style="width: 100%; height: 100px; border: solid 1px #aaa;">
                                <img width=500 height=250 style="width: 100%; height: 100%; border-radius: 7px;" src="{{asset('storage/'.$practice->businessAgreement->accepted_terms_signature ?: '') }}">                                </div>
                                <div class="signature-pad--footer txt-center">                                    <div class="description cnt-left c-dib_ mb-7_"><strong class="fs-17_ weight_600"> Practice Signatures Above </strong></div>
                                                                               
                                                                                                                    </div>                                </div>                            </div>
        				</div>
        		       <form id="agreement" action="{{ route('agreement') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="prac_id" value="{{auth::user()->practice_id}}">
                <input type="hidden" name="user_id" value="{{auth::user()->id}}">

        				<div class="trow_ bag-field_ date_field_ mb-14_">
                            <input type="hidden" id="signatureImage" name="accepted_terms_signature" value="">
        					<label>Date:</label>
        					<input type="text" readonly="readonly"  name="accepted_terms_dt" value="{{date('m/d/Y', strtotime($practice->businessAgreement->accepted_terms_dt ?: '0000'))}}">
        				</div>

        				<div class="trow_ bag-field_ name_field_ mb-14_">
        					<label>Name:</label>
        					<input type="text" readonly="readonly" name="accepted_terms_user" value="{{$practice->businessAgreement->accepted_terms_user ?: 'None'}}">
        				</div>

        				<div class="trow_ bag-field_ title_field_">
        					<label>Title:</label>
        					<input type="text" readonly="readonly" name="accepted_terms_role" class="cnt-left" @if(isset($practice->businessAgreement->accepted_terms_role))
        					value='{{strtoupper(str_replace("_"," ",$practice->businessAgreement->accepted_terms_role ?: ""))}}'
        					@endif>
        				</div>
        				   </form>
        			</div>

            	</div>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                  style="display: none;">
                {{ csrf_field() }}
            </form>



            <div class="flx-justify-start wd-100p pb-14_ mt-40_">
            	<!-- <button type="button" class="btn bg-red-txt-wht weight_500 fs-17_ tt_uc_"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">decline</button>
            	<button class="btn bg-blue-txt-wht weight_500 fs-17_ tt_uc_" id="submit_agreement" style="line-height: 20px; padding: .6rem .75rem; margin-left: auto;">agree &amp; submit <span style=" line-height: inherit; font-size: inherit; font-weight: 500; letter-spacing: -3px;">&#10095;&#10095;</span></button> -->
            </div>

        </div>



	</div>
</div>



<div class="trow_" style="display: none">
<button class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" type="button" data-toggle="modal" data-target="#review-and-sign">show modal</button>
</div>

<div class="modal" data-backdrop='static' data-keyboard='false' id="review-and-sign">
  <div class="modal-dialog" style="max-width: 480px;">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-transparent-force pos-rel_" style="font-size: 1px;">
        <h4 class="modal-title"><span style="visibility: hidden; font-size: 1px;">BAA Confirmation</span></h4>
        <button type="button" class="close stick-top-right-circle" onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">&#10006;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">

  					<div class="trow_ cnt-center c-dib_ mb-7_"><span class="txt-black-24 weight_900 tt_uc_ fs-26_">please review and sign</span></div>
  					<div class="trow_ cnt-center c-dib_ mb-12_"><span class="txt-black-24 weight_600 tt_uc_ fs-21_">the business associate agreement</span></div>
  				</div>
  			</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      		<div class="flx-justify-center wd-100p pb-14_">
        		<button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" style="margin-right: 2.4vw" onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">decline</button>
        		<button class="btn bg-blue-txt-wht weight_600 fs-20_ tt_uc_" style="line-height: 20px; padding: .6rem .75rem; margin-left: 2.4vw;" data-dismiss="modal">continue <span style=" line-height: inherit; font-size: inherit; font-weight: 500; letter-spacing: -3px;">&#10095;&#10095;</span></button>
        	</div>
      </div>

    </form>
  </div>
</div>

<div class="modal" data-backdrop='static' data-keyboard='false' id="review-confirmation">
  <div class="modal-dialog" style="max-width: 480px;">
    <form class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header bg-transparent-force pos-rel_" style="font-size: 1px;">
        <h4 class="modal-title"><span style="visibility: hidden; font-size: 1px;">Confirmation</span></h4>
      <!--   <button type="button" class="close stick-top-right-circle" data-dismiss="modal">&#10006;</button> -->
      </div>

      <!-- Modal body -->
      <div class="modal-body">
  			<div class="row">
  				<div class="col-sm-12">

  					<div class="trow_ cnt-center c-dib_ mb-7_"><span class="txt-black-24 weight_900 tt_uc_ fs-24_">Do you really want to decline this agreement?</span></div>

  				</div>
  			</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
      		<div class="flx-justify-center wd-100p pb-14_">
        		<button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_" data-dismiss="modal" style="min-width: 70px;margin-right: 2.4vw">No</button>
        		<button class="btn bg-blue-txt-wht weight_600 fs-20_ tt_uc_" style="line-height: 20px; padding: .6rem .75rem; margin-left: 2.4vw;min-width: 70px" onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();" >Yes</button>
        	</div>
      </div>

    </form>
  </div>
</div>




@endsection

@section('js')

<!-- <script src="{{asset('js/jSignature/jSignature.min.noconflict.js')}}"></script> -->
   <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
        <script>
            var wrapper = document.getElementById("signature-pad");
            var clearButton = wrapper.querySelector("[data-action=clear]");
            var changeColorButton = wrapper.querySelector("[data-action=change-color]");
            var savePNGButton = wrapper.querySelector("[data-action=save-png]");
            var saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
            var saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
            var canvas = wrapper.querySelector("canvas");
            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });
            // Adjust canvas coordinate space taking into account pixel ratio,
            // to make it look crisp on mobile devices.
            // This also causes canvas to be cleared.
            function resizeCanvas() {
                // When zoomed out to less than 100%, for some very strange reason,
                // some browsers report devicePixelRatio as less than 1
                // and only part of the canvas is cleared then.
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                // This part causes the canvas to be cleared
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                // This library does not listen for canvas changes, so after the canvas is automatically
                // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
                // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
                // that the state of this library is consistent with visual state of the canvas, you
                // have to clear it manually.
                signaturePad.clear();
            }
            // On mobile devices it might make more sense to listen to orientation change,
            // rather than window resize events.
            window.onresize = resizeCanvas;
            resizeCanvas();
            function download(dataURL, filename) {
                var blob = dataURLToBlob(dataURL);
                var url = window.URL.createObjectURL(blob);
                var a = document.createElement("a");
                a.style = "display: none";
                a.href = url;
                console.log(url);
              /*  a.download = filename;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);*/
            }
            // One could simply use Canvas#toBlob method instead, but it's just to show
            // that it can be done using result of SignaturePad#toDataURL.
            function dataURLToBlob(dataURL) {
                var parts = dataURL.split(';base64,');
                var contentType = parts[0].split(":")[1];
                var raw = window.atob(parts[1]);
                var rawLength = raw.length;
                var uInt8Array = new Uint8Array(rawLength);
                for (var i = 0; i < rawLength; ++i) {
                    uInt8Array[i] = raw.charCodeAt(i);
                }
                return new Blob([uInt8Array], { type: contentType });
            }
            clearButton.addEventListener("click", function (event) {
                signaturePad.clear();
            });
            changeColorButton.addEventListener("click", function (event) {
                var r = Math.round(Math.random() * 255);
                var g = Math.round(Math.random() * 255);
                var b = Math.round(Math.random() * 255);
                var color = "rgb(" + r + "," + g + "," + b +")";
                signaturePad.penColor = color;
            });
            savePNGButton.addEventListener("click", function (event) {
                if (signaturePad.isEmpty()) {
                toastr.error('Please Enter Signature To Accept T/C.');
                return false;
                } else {
                var dataURL = signaturePad.toDataURL();
                $('#signatureImage').val(dataURL);
                console.log(dataURL);
                // download(dataURL, "signature.png");
                }
            });
            saveJPGButton.addEventListener("click", function (event) {
                if (signaturePad.isEmpty()) {
                toastr.error('Please Enter Signature To Accept T/C.');
                return false;
                } else {
                var dataURL = signaturePad.toDataURL("image/jpeg");
                download(dataURL, "signature.jpg");
                }
            });
            saveSVGButton.addEventListener("click", function (event) {
                if (signaturePad.isEmpty()) {
                toastr.error('Please Enter Signature To Accept T/C.');
                return false;
                } else {
                var dataURL = signaturePad.toDataURL('image/svg+xml');
                download(dataURL, "signature.svg");
                }
            });
        </script>
<script type="text/javascript">

     $(document).ready(function () {

        @if(isset(request()->print) && request()->print == 1)
        window.open("{{url('view-rppa/'.request()->id.'?print=1')}}", '_blank')
        window.print();
        @endif



// $('input[type="radio"]').click(function(){
// 	// alert($(this).val());
// 	if($(this).val() == 'no'){
// 		$('#review-and-sign').hide();
// 		$('#review-and-sign').show();
// 	}
// });
 // $("#signature").jSignature();

     	 $('#review-and-sign').on('hide.bs.modal', function (e) {
  $('#hidden-opa').removeClass('v-hidden-opacity');
});

 //$('#review-and-sign').modal('show', {backdrop: 'static', keyboard: false});


$('#submit_agreement').on('click',function(){
     toastr.remove();
    if(!$("#yes_option").is(":checked")){
   toastr.error('Please agree the terms and conditions by clicking yes.');
   $('#yes_option input').focus();
	}else{

     savePNGButton.click();

// console.log($('#signatureImage').val());
     // return;
      if (signaturePad.isEmpty()) {
                // toastr.error('Please Enter Signature To Accept T/C.');
                return false;
                }

	$('#agreement').submit();
	}

})




    });



</script>
@endsection
