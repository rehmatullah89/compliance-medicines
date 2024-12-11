




<div class="modal" id="modal-facili-management-listing">
  <div class="modal-dialog" style="width: 93%; max-width: 1140px;">
    <div class="modal-content">

      
      
      <style>
        table.bordered.enter-mngmnt_table { border-collapse: separate; border: 0px; }
        table.bordered.enter-mngmnt_table thead {  }
        table.bordered.enter-mngmnt_table thead tr th { vertical-align: top; border-top: solid 1px #3e7bc4;}
        table.bordered.enter-mngmnt_table thead tr th:last-child { border-right: solid 1px #3e7bc4; }
        table.bordered.enter-mngmnt_table thead tr th:first-child { border-left: solid 1px #3e7bc4; }
        
        table.bordered.enter-mngmnt_table tbody {  }
        table.bordered.enter-mngmnt_table tbody tr {  }
        table.bordered.enter-mngmnt_table tbody tr td { vertical-align: top; }
        table.bordered.enter-mngmnt_table tbody tr td:first-child { border-left: solid 1px #ccc; }
        table.bordered.enter-mngmnt_table tbody tr td:last-child { border-right: solid 1px #ccc; }
        table.bordered.enter-mngmnt_table tbody tr:last-child {  }
        table.bordered.enter-mngmnt_table tbody tr:last-child td { border-bottom: solid 1px #ccc; }
        table.bordered.enter-mngmnt_table tbody tr:last-child td:first-child { border-radius: 0px 0px 0px 6px; }
        table.bordered.enter-mngmnt_table tbody tr:last-child td:last-child { border-radius: 0px 0px 6px 0px; }
        
        </style>
      
      
      
      <!-- Modal body -->
      <div class="modal-body">
          
          <div class="row">
                <div class="col-sm-12">
                    <div class="elm-left c-mr-4_ fs-17-force-child_">
                        <span class="txt-blue weight_700 tt_uc_" style="line-height: 28px;">Facilitator(s)</span>
                    </div>
                    <div class="elm-right">
              <button class="btn bg-blue-txt-wht weight_600 fs-14_" data-toggle="modal" data-target="#modal-facili-management-add-new" style="line-height: 20px; padding: .1rem .75rem;">+ Add</button>
            </div>
                </div>
            </div>
          
        
        
        <div class="row mt-14_ mb-7_">
          <div class="col-sm-12  table-responsive">
            <table class="table bordered enter-mngmnt_table" id="facili-listing-table" style="min-width: 1024px;">
              <thead>
                <tr class="weight_500-force-childs bg-blue">
                  <th class="txt-wht">First Name</th>
                  <th class="txt-wht">Last Name</th>
                  <th class="txt-wht">Email Address.</th>
                  <th class="txt-wht">Phone No.</th>
                </tr>
              </thead>
              <tbody>
    
      
                
                <tr>
                  <td class="txt-blue tt_cc_ weight_500">Group Name Here</td>
                  <td class="txt-gray-7e tt_cc_ weight_500">George</td>
                  <td class="txt-gray-7e tt_lc_ weight_500">testmail@gmail.com</td>
                  <td class="txt-gray-7e tt_cc_ weight_500">(248) 801 - 9011</td>
                </tr>
                
              </tbody>
            </table>
          </div>
        </div>
        
        
        
        
        
        
      </div>

      <!-- Modal footer -->
      <?php
      /*
      <div class="modal-footer">
          <div class="flx-justify-start wd-100p">
            <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ " data-dismiss="modal">CANCEL</button>
            <button type="button" class="btn bg-blue-txt-wht weight_500 fs-14_" style="margin-left: auto;">SAVE</button>
          </div>
      </div>
      */
      ?>

    </div>
  </div>
</div>



<div class="modal" id="modal-facili-management-add-new">
  <div class="modal-dialog wd-87p-max_w_700">
    <div class="modal-content compliance-form_">
      <form class="trow_"  name='facili_form' action="javascript:void(0);"
       id="facili-reg-form" onsubmit="add_update_facilitator();" method="post">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title hupdate_ent">Add New Facilitator</h4>
        <!--button type="button" class="close" data-dismiss="modal">&times;</button-->
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
          
                          <div class="col-sm-12 pl-0 pr-0">
                <div class="flds-fn-ln-sfx flx-justify-start mb-14_">
                  
                  <div class="wd-50p field fld-lname mr-1p">
                    <label class="wd-100p" style="color: #666;">First Name:</label>
                    <input class="wd-100p" type="text" placeholder="Enter First Name" name="first_name">
                  </div>
                  <div class="wd-50p field fld-suffix">
                    <label class="wd-100p" style="color: #666;">Last Name:</label>
                    <input class="wd-100p" type="text" placeholder="Enter Last Name" name="last_name">
                  </div>
                </div>
                
                
                
                <div class="flds-cty-st-zp flx-justify-start mb-14_">
                  
                  <div class="wd-50p field fld-city mr-1p">
                    <label class="wd-100p" style="color: #666;">Email:</label>
                    <input class="wd-100p" type="text" placeholder="Enter Email" name="email">
                  </div>
                  <div class="wd-50p field fld-state">
                    <label class="wd-100p" style="color: #666;">Phone No:</label>
                    <input class="wd-100p" type="text" placeholder="Enter Phone No" name="phone_number" mask="(000) 000-0000">
                  </div>
                  
                </div>
            </div>
           
        </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
          <div class="flx-justify-start wd-100p">
            <button type="button" class="btn bg-red-txt-wht weight_500 fs-14_ " data-dismiss="modal">CANCEL</button>
            <button type="submit" class="btn bg-blue-txt-wht weight_500 fs-14_" id="submit_facilitator" style="margin-left: auto;">SAVE</button>
          </div>
      </div>
</form>
    </div>
  </div>
</div>
