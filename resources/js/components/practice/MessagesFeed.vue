<template>
	
				<div class="dash_chatbox practice_admin-chatbox" :aria-expanded="this.show == 'hide'?'false':'true'"
					style="width: 320px; right: 5%;">
					<vue-toastr ref="confirmtoast"></vue-toastr>
					<div class="trow_ cb-inner-wrapper pos-rel_" >
						
						
						<div class="endchat-verify-popup pos-abs_ " :class="confirmPopup">
							
							<div class="ec-v-content br-rds-2 bg-white pa-14_">
								<div class="trow_ pa-4_ cnt-center txt-blue " >Do you Really want to End Chat</div>
								<div class="trow_ pa-4_ c-dib_ cnt-center">
									<button class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ p4-8_ mr-1vw mt-7_ no-wrap-text" @click="hideConfirmationPopUP">no</button>
									<button class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_ p4-8_ mt-7_ no-wrap-text" @click="leaveChat">yes</button>
								</div>
							</div>
							
						</div>
						
						<div class="trow_ chatbox_header cur-pointer"  :class="this.show == 'hide'?'collapsed':''"  data-toggle="collapse" :aria-expanded="this.show == 'hide'?'false':'true'" >
							<div class="vertical-chat-bar bg-grn-lk" style="padding: 0px 10px;bottom: 7%;transform: scale(0.7);right: -4px;" @click="showHideModal">
								<span class="fa fa-comment fs-40_ vcb-chat-ico_"  :class="newMessage > 0?'blink-icon redtext':''" style="color: rgb(255, 255, 255);"></span>
								<div class="txt-wht tt_cc_ ml-14_ fs-18_ tt_cc_ vcb-heading" style="line-height: 40px;" >live chat with us</div>
							
							</div>
							<div class="trow_ normal-header c-dib_ bg-grn-lk" style="padding: 0px 0px;" >
									<div class="trow_ c-dib_ bg-grn-lk" style="padding: 0px 0px;" @click="showHideModal" >
										<span class="fa fa-headphones hd-chat-ico_ fs-40_" style="color: #fff;"></span>
										<div class="txt-wht tt_cc_ hd-heading ml-14_ fs-18_ tt_uc_" style="line-height: 40px;">live chat with us</div>
									  <div class="elm-right txt-wht cnt-center mt-7_ minimize-button" style=""></div>
							
								    </div>
								<!--	<div class="elm-right txt-wht cnt-center mt-7_ close-button" style="" v-if="session_started || chatsession.length" @click="leaveChat"></div> -->
							</div>
						</div>


						
						<div id="chatbox_msg_control" class="trow_ collapse " :class="show" >

	<div class="trow_ form_control" style="padding: 1px 32px;" v-if="!session_started && !chatsession.length" >
								
								<div class="trow_ mt-14_">
									<span class="trow_ cnt-center txt-blue mb-4_">Welcome to</span>
									<span class="trow_ cnt-center ">Online Support Service</span>
								</div>
								
								<div class="trow_ mt-7_ cnt-center c-dib_">
									<a class="" href="http://compliancerewards.ssasoft.com/compliance_html_30jan/?path=home">
                    					<img src="http://compliancerewards.ssasoft.com/compliancereward/public/images/logo.png" alt="Site Logo" style="max-height: 40px;">
                    				</a>
								</div>
								
								<form class="compliance-form_ mt-14_">
									<p v-if="errors.length">
    <ul>
      <li v-for="(error,key,index) in errors" class="txt-red"> {{ key+1 }} - {{ error }}</li>
    </ul>
  </p>
									<div class="trow_ pos-rel_ field field-name mb-7_">
										<input class="wd-100p" type="text" required maxlength="30" placeholder="Enter Your Name" v-model="practiceAdmin.padmin_name">
										<span class="fa fa-user field-ico_ cnt-center txt-blue pos-abs_"></span>
									</div>
									
									<div class="trow_ pos-rel_ field callback-number mb-7_">
									    <input class="wd-100p" type="text" pattern="[0-9]" required maxlength="10" placeholder="Enter Callback Number" v-model="practiceAdmin.padmin_callback">
									    <span class="fa fa-phone field-ico_ cnt-center txt-blue pos-abs_"></span>
									</div>
									
									<div class="trow_ pos-rel_ field mobile-number mb-7_">
									   <input class="wd-100p" type="text" pattern="[0-9]" required maxlength="10" placeholder="Enter Your Mobile Number" v-model="practiceAdmin.padmin_mobile">
									   <span class="fa fa-mobile-phone field-ico_ cnt-center txt-blue pos-abs_"></span>
									</div>
									
									<div class="trow_ pos-rel_ field select-issue mb-7_">
										<span class="fa fa-question field-ico_ cnt-center txt-blue pos-abs_"></span>
										<select class="wd-100p" required v-model="practiceAdmin.padmin_issue">
											<option value="Rx / Patient Enrollment">Rx / Patient Enrollment</option>
											<option value="ADDING A NEW PRODUCT / NDC">ADDING A NEW PRODUCT / NDC</option>
											<option value="ADDING A COMPOUNDED Rx">ADDING A COMPOUNDED Rx</option>
											<option value="PROCESSING ORDER REQUEST">PROCESSING ORDER REQUEST</option>
											<option value="INVOICES and RECIEPTs QUESTIONS">INVOICES and RECIEPTs QUESTIONS</option>
										</select>
									</div>
									
									<div class="trow_ field-submit mt-14_ c-dib_ cnt-center">
										<button type="button" :disabled="requestPros" class="btn br-rds-24 bg-blue-txt-wht weight_500 fs-14_ tt_cc_" @click="startSession">start session</button>
									</div>
									
								</form>
								
								<div class="trow_ mt-7_ mb-7_">
									<div class="trow_ cnt-center txt-gray-6">
										To Start, please enter all available information and click on start session.
									</div>
								</div>
								
							
							</div>
							



							<div class="trow_ chatbox_msg_control bg-gray-f2 feed" ref="feed" style="max-height: 200px; min-height: 100px; overflow-y: auto;" v-if="session_started || chatsession.length">
    
    							<div class="trow_ inner-msgs fs-14_">
    								<div class="support-team-msg first-msg">
    									<div class="inner-msg-box c-dib_">
    										<div class="trow_ txt-blue" >Welcome to here!</div>
    										<div class="trow_ txt-gray-7e">Thank you for reaching to live support, support representative will be with you shortly.</div>
    									</div>
    								</div>
	    							<div v-if="contact">
	    						 	 	<div v-for="message in messages" :class="`message${(message.to == contact.id) ? ' support-team-msg' : ' user-msg cnt-right'}`" :key="message.id">
	    									<div class="inner-msg-box c-dib_" >
	    										<span class="msg-txt"> {{ message.text }}</span>
	    										<span class="msg-time">{{message.created_at | moment("h:mm:ss a")}}</span>
	    									</div>
	    								</div>
	                                </div>
    							</div>
    
    
    						</div>

                    		<div class="trow_ sent_msg-control"  v-if="session_started || chatsession.length">
    							<div class="trow_ inner-box-smc pos-rel_ c-dib_">
    								<input :disabled="contact==null" type="text" v-model="message" @keydown.enter="send" placeholder="Message...">
    								<button  :disabled="contact==null" @click="send"
    									class="elm-right pos-abs_ send-msg-btn bg-blue-txt-wht br-rds-50p"
    									type="button">
    									<span class="fa fa-send"></span>
    								</button>
    							</div>
    						</div>
    						
    						<div class="trow_ end-chat_control cnt-center c-dib_" v-if="session_started || chatsession.length" >
    						<a class="mr-14_ mt-3_ opct-87_1" href="https://anydesk.com/en/downloads" target="_blank" style="
"><img src="http://compliancerewards.ssasoft.com/compliancereward/public/images/weblink.png" style="
    width: 27px;
    height: 28px;
"></a>
    							<button class="btn bg-orange_red-txt-wht weight_500 fs-14_ tt_uc_ cnt-center p4-8_ mt-2_ mb-7_ no-wrap-text" @click="showConfirmationPopUP">end chat</button>
    						</div>
    					
						</div>
						
						
					</div>
				</div>
	

</template>
 
<script>

    export default {
        props: {
            contact: {
                type: Object
			},
			user:{
                type:Object,
                required:true
            },
            messages: {
                type: Array,
                required: true
            },
			 chatsession:{
                type:Array,
                required:true
            }, newMessage:{
                type:Number,
                required:true
            }, practice:{
                type:Object,
                required:true
            }
        },
           data() {
            return {
				errors: [],
				practiceAdmin:{
				padmin_name:this.user.name,
				padmin_callback:this.practice.practice_phone_number,
				padmin_mobile:this.practice.practice_phone_number,
				padmin_issue:'Rx / Patient Enrollment'
				},
				requestPros:false,
				session_started:false,
                message: '',
				show : 'hide',
				confirmPopup:'hide'
				
				
            };
        },

        methods: {

      /*  created() {
alert(this.practice);
this.practiceAdmin.padmin_name = contact.name;
this.practiceAdmin.padmin_callback = this.practice.practice_phone_number;
this.practiceAdmin.padmin_mobile = this.practice.practice_phone_number;
	console.log(this.chatsession);
},
mounted() {
alert(this.practice);
this.practiceAdmin.padmin_name = contact.name;
this.practiceAdmin.padmin_callback = this.practice.practice_phone_number;
this.practiceAdmin.padmin_mobile = this.practice.practice_phone_number;
	console.log(this.chatsession);
},*/
showConfirmationPopUP(){
	this.confirmPopup = 'show';
},
hideConfirmationPopUP(){
	this.confirmPopup = 'hide';
},
			leaveChat(){
			//	Echo.join('online');
				console.log('click on leave button');		 
/*if (!confirm("Do you really want to end session!")) {
  return false;
}*/
				//return false;
				   axios.get(`/leave-and-removechat`)
                    .then((response) => {
						console.log(response.data);
						console.log(this.messages);
						console.log(this.chatsession);
                        Echo.leave('online');
						Echo.leave('PatientsRequest');
					this.confirmPopup = 'hide';
                   this.practiceAdmin.padmin_name=this.user.name;
				this.practiceAdmin.padmin_callback=this.practice.practice_phone_number;
				this.practiceAdmin.padmin_mobile=this.practice.practice_phone_number;
				this.practiceAdmin.padmin_issue='Rx / Patient Enrollment';
					
				this.$emit('unSelectAdmin');
                      this.messages.splice(0,this.messages.length);
					   this.session_started = false;
					   this.chatsession.splice(0,this.chatsession.length);
					
                      //  this.selectedContact = contact;
					  
                    })
           
			},
			startSession(){

				 this.errors = [];

      if (!this.practiceAdmin.padmin_name) {
        this.errors.push('Name required.');
      }
      if (!this.practiceAdmin.padmin_callback) {
        this.errors.push('callback required.');
      }
	  if (!this.practiceAdmin.padmin_mobile) {
        this.errors.push('Mobile required.');
      }
	  if (!this.practiceAdmin.padmin_issue) {
        this.errors.push('Select issue.');
      }

   
	 
	   if (this.errors.length) {
        return false;
      }

        if (this.practiceAdmin.padmin_callback.length < 10) {
        this.errors.push('callback should be 10 digits.');
      }
	  if (this.practiceAdmin.padmin_mobile.length < 10) {
        this.errors.push('Mobile should be 10 digits.');
      }

         if (this.errors.length) {
        return false;
      }
 		/*	Echo.join('PatientsRequest');
			console.log(JSON.stringify(this.practiceAdmin));
              axios.post('/send_first_request',{practiceAdmin:JSON.stringify(this.practiceAdmin)})
			  .then((response)=>{
				  //Echo.leave('PatientsRequest');
				  console.log('testing in message feed')
          			 console.log(response.data.session_started);
		             this.session_started = response.data.session_started;
					
			  });
*/
			this.requestPros = true;
			Echo.join('PatientsRequest');
		  axios.post('/startSession',{practiceAdmin:JSON.stringify(this.practiceAdmin)})
			  .then((response)=>{
				 // Echo.leave('PatientsRequest');
				  console.log('testing in message feed')
				  this.requestPros = false;
          			 console.log(response.data.session_started);
		             this.session_started = response.data.session_started;
					
			  }).catch(error => {
					console.log(error)
					this.requestPros = false;
				});


			},

			showHideModal(){
				//alert('there');
				this.newMessage = 0;
  if(this.show == 'hide'){
				 
				  this.show = 'show';
				   
			  }else{
				 
				  this.show = 'hide';
				  this.errors.length = 0;
			  }
			  console.log(this.show);
			
			},
            scrollToBottom() {
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 50);
            },
             send(e) {
                e.preventDefault();
                
                if (this.message == '') {
                    return;
                }

                this.$emit('send', this.message);
                this.message = '';
            }
        },
        watch: {
            contact(contact) {
                this.scrollToBottom();
            },
            messages(messages) {
                this.scrollToBottom();
            }
        },
      
    }
</script>
