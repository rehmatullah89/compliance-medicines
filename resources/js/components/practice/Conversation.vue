<template>
    <div class="conversation">
       <!-- <h1>{{ contact ? contact.name : 'Select a Contact' }}</h1> -->
        <MessagesFeed :practice="practice" :user="user" :contact="contact" :chatsession="chatsession" @unSelectAdmin="unSelect" :newMessage="newMessage" :messages="messages" @send="sendMessage"/>
      
    </div>
</template>

<script>
    import MessagesFeed from './MessagesFeed';
   

    export default {
        props: {
            contact: {
                type: Object,
                default: null
            },
            user: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                required: true
            },
             chatsession:{
                type:Array,
                required:true
            },
            newMessage:{
                type:Number,
                required:true
            },
               practice:{
                type:Object,
                required:true
            }
        },
        methods: {
           sendMessage(text) {
                if (!this.contact) {
                    return;
                }

                axios.post('/conversation/send', {
                    contact_id: this.contact.id,
                    text: text
                }).then((response) => {
                    this.$emit('new', response.data);
                })
            },
            unSelect()
            {
                this.$emit('unSelectAdmin');
            }

        },
        components: {MessagesFeed}
    }
</script>

