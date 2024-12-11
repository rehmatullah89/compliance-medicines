<template>
		<div class="row">
			<div class="col-sm-12">
				<div class="dash_chatbox pos-abs_"
					style="width: 380px; right: 5%; bottom: -3px;">
					<div class="trow_">
						
						
						<div class="trow_ chatbox_header cur-pointer collapsed" data-target="#chatbox_msg_control" data-toggle="collapse" aria-expanded="true">
							<div class="trow_  c-dib_ bg-grn-lk" style="padding: 14px 14px;">
								<span class="fa fa-headphones fs-40_" style="color: #fff;"></span>
								<div class="txt-wht tt_cc_ ml-14_ fs-18_"
									style="line-height: 40px;">live chat with us</div>
								<div class="elm-right txt-wht cnt-center mt-7_ close-button" style=""></div>
							</div>
						</div>
						
						<div id="chatbox_msg_control" class="trow_ collapse">
							<div class="trow_ chatbox_msg_control bg-gray-f2"
    							style="max-height: 200px; min-height: 100px; overflow-y: auto;">
    
    							<div class="trow_ inner-msgs fs-14_">
    								<div class="support-team-msg first-msg">
    									<div class="inner-msg-box c-dib_">
    										<div class="trow_ txt-blue">Welcome to here!</div>
    										<div class="trow_ txt-gray-7e">Ask us anything and we will help you</div>
    									</div>
    								</div>
    								<div class="user-msg">
    									<div class="inner-msg-box c-dib_">
    										<span class="msg-txt">Hello support team!</span> <span
    											class="msg-time">14:43</span>
    									</div>
    								</div>
    								<div class="support-team-msg">
    									<div class="inner-msg-box c-dib_">
    										<span class="msg-txt">Hello what kind of help you need</span>
    										<span class="msg-time">14:43</span>
    									</div>
    								</div>
    								<div class="user-msg cnt-right">
    									<div class="inner-msg-box c-dib_">
    										<span class="msg-txt">I have a question about the system</span>
    										<span class="msg-time">14:46</span>
    									</div>
    								</div>
    
    								<div class="support-team-msg">
    									<div class="inner-msg-box c-dib_">
    										<span class="msg-txt">Hello what kind of help you need</span>
    										<span class="msg-time">14:43</span>
    									</div>
    								</div>
    								<div class="user-msg cnt-right">
    									<div class="inner-msg-box c-dib_">
    										<span class="msg-txt">I have a question about the system</span>
    										<span class="msg-time">14:46</span>
    									</div>
    								</div>
    								<div class="support-team-msg">
    									<div class="inner-msg-box c-dib_">
    										<span class="msg-txt">Hello what kind of help you need</span>
    										<span class="msg-time">14:43</span>
    									</div>
    								</div>
    
    								<div class="user-msg cnt-right">
    									<div class="inner-msg-box c-dib_">
    										<span class="msg-txt">I have a question about the system</span>
    										<span class="msg-time">14:46</span>
    									</div>
    								</div>
    							</div>
    
    
    
    						</div>

<MessageComposer @send="sendMessage"/>
    					
						</div>
						
						
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
            messages: {
                type: Array,
                required: true
            }
        },
        methods: {
            scrollToBottom() {
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 50);
            },
              sendMessage(text) {
                if (!this.contact) {
                    return;
                }

                axios.post('conversation/send', {
                    contact_id: this.contact.id,
                    text: text
                }).then((response) => {
                    this.$emit('new', response.data);
                })
            }
        },
        watch: {
            contact(contact) {
                this.scrollToBottom();
            },
            messages(messages) {
                this.scrollToBottom();
            }
        }
    }
</script>
