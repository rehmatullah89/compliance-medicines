<div class="modal" id="practice-show-modal"  tabindex="-1">

    <div class="modal-dialog wd-87p-max_w_700" style="max-width: 800px;">

   

<div class="modal-content compliance-form_" >

        <!-- Modal Header -->

        <div class="modal-header" style="padding: 0px;">

            

            

            <button type="button" class="close stick-top-right-circle bw-hover" data-dismiss="modal" style="z-index: 99">✖</button>

        </div>



        <!-- Modal body -->

        <div class="modal-body bg-f2f2f2">

            <div class="row">

                <div class="col-sm-12">

                	<div class="row">

			            <div class="col-sm-12">

			                <div class="elm-left c-mr-4_ fs-19_ fs-17-force-child_ mt-14_ mb-7_">

			                    <span class="circle-bgred-colorwht modal_phr_count">{{count($practices)??'0'}}</span>
                                <span class="circle-bgred-colorwht modal_phy_count">{{count($physician)??'0'}}</span>
                                <span class="circle-bgred-colorwht modal_law_count">{{count($law_practices)??'0'}}</span>

			                    <span class="txt-blue weight_700" id="modal-label" style="text-transform: uppercase;"></span>

			                    <span class="txt-gray-9 weight_700">Practice Enrollments</span>
                                
			                    <span class="modal_phr_count">({{$practices_count??'0'}})</span>
                                <span class="modal_phy_count">({{$physician_count??'0'}})</span>
                                <span class="modal_law_count">({{$law_practices_count??'0'}})</span>

			                </div>
                            <div class="elm-right mb-10_ mt-7_">
                                <button class="btn bg-blue-txt-wht weight_600 fs-14_" style="line-height: 24px; padding: .1rem .75rem;" onclick="viewAddPractice();">+  Add  Practice </button>
                        </div>

			            </div>

			        </div>

                	<table class="table bordered overview_table" style="min-width: 700px;" id="modal-pharmacies">

      						<thead>

                        <tr class="weight_500-force-childs bg-blue">

                            <th class="txt-wht" style="width:36%;text-transform: capitalize;" id="modal-prc-type">Physician Name</th>

                            <th class="txt-wht" style="width:100px;">Zip</th>

                            <th class="txt-wht" style="width: 40px;">State</th>

                          	<th class="txt-wht" style="width:22%;">Site Contact</th>
                            <th class="txt-wht" style="width:22%;">CR Rep User</th>
                            

                        </tr>

                    </thead>

                </table>

                </div>

            </div>

        </div>



      </div> 



    </div>

  </div>