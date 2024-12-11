<template>
	<div class="trow_ sent_msg-control" style="">
    							<div class="trow_ inner-box-smc pos-rel_ c-dib_">
    								<input type="text" v-model="message" @keydown.enter="send" placeholder="Message...">
    								<button v-model="message" @click="send"
    									class="elm-right pos-abs_ send-msg-btn bg-blue-txt-wht br-rds-50p"
    									type="button">
    									<span class="fa fa-send"></span>
    								</button>
    							</div>
    						</div>
   </template>

<script>
    export default {
        data() {
            return {
                message: ''
            };
        },
        methods: {
            send(e) {
                e.preventDefault();
                
                if (this.message == '') {
                    return;
                }

                this.$emit('send', this.message);
                this.message = '';
            }
        }
    }
</script>

<style lang="scss" scoped>
.composer textarea {
    width: 96%;
    margin: 10px;
    resize: none;
    border-radius: 3px;
    border: 1px solid lightgray;
    padding: 6px;
}
</style>

