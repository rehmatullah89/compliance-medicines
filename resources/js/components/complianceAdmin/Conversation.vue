<template>
    <div class="conversation">
       <!-- <h1>{{ contact ? contact.name : 'Select a Contact' }}</h1> -->
        <MessagesFeed :contact="contact" :contacts="contacts" @EndSession="EndChatSession" @selected="startConversationWith" :messages="messages" @send="sendMessage"/>
      
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
            messages: {
                type: Array,
                required: true
            },
             contacts: {
                type: Array,
                required: true
            }
        },
        methods: {

            startConversationWith(contact){
                  this.$emit('selected', contact);
            },
            EndChatSession(practice_id){
                  this.$emit('EndSessionWith', practice_id);
            },
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
            }
        },
        components: {MessagesFeed}
    }
</script>

