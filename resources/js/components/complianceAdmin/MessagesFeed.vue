<template>
	<div class="comp_admin-chatbox " :aria-expanded="this.show == 'hide'?'false':'true'">
	
		<div class="flx-justify-start bg-white top-header-chat-wrapper" @click="showHideModal">
			<div class="thc-inner-box wd-40p bg-gray-f2 pa-7_">
				<span class="fa fa-comment chat-icon_ pos-rel_ txt-blue fs-24_">
					<span class="msg-counter pos-abs_" v-if="show == 'hide'" :class="contacts.length == 0?'':'blink-icon'">{{contacts.length}}</span>
				</span>
   			</div>
		</div>

		<div class="trow_ bottom-fixed-chat-wrapper  pos-fxd_" style="max-width: 480px; right: 1%; bottom: 40px;">
			<div class="trow_ chatbox_header cur-pointer"
				:class="this.show == 'hide'?'collapsed':''"  data-toggle="collapse" :aria-expanded="this.show == 'hide'?'false':'true'">
				<div class="flx-justify-start bg-white " @click="showHideModal">
					<div class="wd-40p bg-gray-f2 pa-7_">
						<div class="trow_ c-dib_">
	    					<span class="fa fa-comment chat-icon_ pos-rel_ txt-blue fs-40_">
								<span class="msg-counter pos-abs_" v-if="show == 'hide'" :class="contacts.length == 0?'':'blink-icon'">{{contacts.length}}</span>
							</span>
	    					<div class="txt-blue tt_cc_ ml-4_ fs-21_ colps-show" style="line-height: 40px;">Chat Contacts</div>
	    				</div>
	    			</div>
					<div class="wd-60p pa-7_ colps-show">
						<div class="trow_ c-dib_">
	        				<div class="txt-gray-6 tt_cc_ ml-14_ fs-21_" style="line-height: 40px;width:80%;" v-if="contact">{{ contact.name }}<span class="gren_cir onoffst"></span>
                                                    <button @click="showConfirmationPopUp($event)" id="endChat_btn" class="btn bg-orange_red-txt-wht weight_500 fs-12_ hide tt_uc_ cnt-center pa1-8_ no-wrap-text" style="float: right;">end chat</button>
                                                </div>
                                                <div class="txt-gray-6 tt_cc_ ml-14_ fs-21_" style="line-height: 40px;" v-if="!contact">Select a Contact</div>
	        				<div class="elm-right txt-gray-6 cnt-center mt-7_ close-button"></div>
	    				</div>
                                        <div class="endchat-verify-popup pos-abs_ " style="z-index:15;margin-top:15px;" :class="confirmPopup">
                                                <div class="ec-v-content br-rds-2 bg-white pa-14_">
                                                        <div class="trow_ pa-4_ cnt-center txt-blue " >Do you Really want to End Chat</div>
                                                        <div class="trow_ pa-4_ c-dib_ cnt-center">
                                                                <button class="btn bg-blue-txt-wht weight_500 fs-14_ tt_uc_ p4-8_ mr-1vw mt-7_ no-wrap-text" @click="hideConfirmationPopUP($event)">no</button>
                                                                <button class="btn bg-red-txt-wht weight_500 fs-14_ tt_uc_ p4-8_ mt-7_ no-wrap-text" @click="EndChatSession(contact.id, $event)">yes</button>
                                                        </div>
                                                </div>
                                        </div>
	    			</div>
				</div>
			</div>
                        
			<div id="chatbox_msg_control_box" class="trow_ collapse " :class="show">
				<div style="display: flex; justify-content: flex-start;">
					<div class="left-col_userlist_ wd-40p bg-gray-f2">
						
						<div class="trow_ user-row_ pos-rel_ c-dib_" v-for="contact in sortedContacts" :key="contact.id" @click="selectContact(contact)" :class="{ 'selected': contact == selected }">
							<div class="user_photo c-dib pos-abs_">
							<span class="uname-letter txt-white">{{contact.name.charAt(0)}}</span>
								
								<span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
								<!-- <span class="live_"></span> -->
							</div>
							<div class="trow_">
							<div class="trow_ user-name_">{{contact.name}}</div>
							<div class="trow_ user-email" style="color: #d2cafd;">{{contact.email}}</div>
							</div>
						</div>
					</div>
	
					<div class="wd-60p right-col-chatbox" v-if="contact">
						<div class="trow_ chatbox_msg_control bg-gray-f2 feed"  style="max-height: 200px; min-height: 100px; overflow-y: auto;" ref="feed">
							<div class="trow_ inner-msgs fs-14_">
								<div class="support-team-msg first-msg">
									<div class="inner-msg-box c-dib_">
										<div class="trow_ txt-blue">Welcome to here!</div>
										<div class="trow_ txt-gray-7e">
											</div>
									</div>
								</div>
	    						 	 <div v-for="message in messages" :class="`message${message.to == contact.id ? ' support-team-msg' : ' user-msg cnt-right'}`" :key="message.id">
    									<div class="inner-msg-box c-dib_" >
    										<span class="msg-txt"> {{ message.text }}</span>
    										<span class="msg-time">{{message.created_at | moment("h:mm:ss a")}}</span>
    									</div>
                                </div>
						    </div>
						</div>
	
						<div class="trow_ sent_msg-control" >
							<div class="trow_ inner-box-smc pos-rel_ c-dib_">
								<input type="text" v-model="message" @keydown.enter="send" placeholder="Message...">
   								<button v-model="message" @click="send"
   									class="elm-right pos-abs_ send-msg-btn bg-blue-txt-wht br-rds-50p"
   									type="button">
   									<span class="fa fa-send"></span>
   								</button>
							</div>
						</div>
                                                
					</div>
				</div>
			</div>
		</div>
	</div>

</template>
<style>
.red_cir{
  height: 15px;
  width: 15px;
  background-color: red;
  border-radius: 50%;
  display: inline-block;
  margin-top: 5px;
  }
.gren_cir{
  height: 15px;
  width: 15px;
  background-color: #afd13f;
  border-radius: 50%;
  display: inline-block;
  margin-top: 5px;
  }
.hide{
display:none;
}
.show{ display:block;}
</style>
<script>

    export default {
        props: {
            contact: {
                type: Object
            },
            contacts: {
                type: Array,
		required:true
            },
            messages: {
                type: Array,
                required: true
            }
        },
           data() {
            return {
                message: '',
		show : 'hide',
		selected: this.contacts.length ? this.contacts[0] : null,
                confirmPopup:'hide'
            };
        },
        methods: {

            selectContact(contact) {
                this.selected = contact;

                this.$emit('selected', contact);
            },
            showHideModal(){
		if(this.show == 'hide'){
			  this.show = 'show';
		 }else{
                          this.show = 'hide';
		 }
		  console.log(this.show);
			
            },
            scrollToBottom() {
                if(typeof this.$refs.feed != 'undefined')
                { var timeslog = 100; }else{ var timeslog = 50; }
                    setTimeout(() => {
                        this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                    }, timeslog);
            },
             send(e) {
                e.preventDefault();
                
                if (this.message == '') {
                    return;
                }

                this.$emit('send', this.message);
                this.message = '';
            },
            EndChatSession(practice_id, e)
            {
                e.stopPropagation();
                e.preventDefault();
                this.$emit('EndSession', practice_id);
                //alert(practice_id);
                this.confirmPopup = 'hide';
            },
            hideConfirmationPopUP(e){
                e.stopPropagation();
                e.preventDefault();
                this.confirmPopup = 'hide';
            },
            showConfirmationPopUp(e){
                e.stopPropagation();
                e.preventDefault();
                this.confirmPopup = 'show';
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
		 computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    if (contact == this.selected) {
                        return Infinity;
                    }

                    return contact.unread;
                }]).reverse();
            }
        },
      
    }
</script>
