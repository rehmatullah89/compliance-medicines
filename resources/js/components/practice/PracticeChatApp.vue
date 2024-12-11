<template>
    <div class="chat-app">
        <Conversation :chatsession="chatsession" :user="user" @unSelectAdmin="unSelect" :practice="practice" :contact="selectedContact" :messages="messages" :newMessage="newMessage" @new="saveNewMessage"/>
       <!-- <ContactsList :contacts="contacts" @selected="startConversationWith"/> -->
    </div>
</template>

<script>
    import Conversation from './Conversation';
    import ContactsList from './ContactsList';

    export default {
        props: {
            user: {
                type: Object,
                required: true
            },
            chatsession:{
                type:Array,
                required:true
            },
              practice:{
                type:Object,
                required:true
            }
        },
        data() {
            return {
                selectedContact: null,
                messages: [],
                contacts: [],
                newMessage:0
            };
        },
        mounted() {
            console.log('This is qamar Jamil');
            console.log(this.chatsession);
            if(this.chatsession.length && this.chatsession[0].admin_id==0)
            {
                Echo.join('online');
            }
            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    if(!this.selectedContact && e.message.from_contact)
                    {
                        Echo.leave('PatientsRequest');
                        this.startConversationWith(e.message.from_contact);
                    }
                    this.hanleIncoming(e.message);
                    this.newMessage = this.newMessage+1;

                });

                axios.get('contact_pharmacy')
                .then((response) => {
                    console.log(response.data);
                    if(JSON.stringify(response.data) !== '{}')
                    {
                        this.startConversationWith(response.data);                        
                    }
                });
        },
        methods: {
            startConversationWith(contact) {
                this.updateUnreadCount(contact, true);
                 Echo.join('online'); 

              // axios.get(`/conversation/1`)
                axios.get(`conversation/${contact.id}`)
                    .then((response) => {
                        this.messages = response.data;
                        this.selectedContact = contact;
                    })
            },
            saveNewMessage(message) {
                if(!this.messages.length){
                    Echo.join('online');
                }
                console.log('mesage when push'+message);
                this.messages.push(message);
                 console.log(this.messages);
            },
            hanleIncoming(message) {
                if (this.selectedContact && message.from == this.selectedContact.id) {
                    this.saveNewMessage(message);
                   // alert(message);
                    return;
                }

                this.updateUnreadCount(message.from_contact, false);
            },
            updateUnreadCount(contact, reset) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id !== contact.id) {
                        return single;
                    }

                    if (reset)
                        single.unread = 0;
                    else
                        single.unread += 1;

                    return single;
                })
            },
            unSelect()
            {
                this.selectedContact = null;
            }
        },
        components: {Conversation, ContactsList}
    }
</script>


<style lang="scss" scoped>
.chat-app {
    display: flex;
}
</style>
