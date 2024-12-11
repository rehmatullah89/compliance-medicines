<template>
    <div class="chat-app">
        <Conversation @EndSessionWith="EndChatSessionWith" :contact="selectedContact" :contacts="contacts" @selected="startConversationWith"  :messages="messages" @new="saveNewMessage"/>
       <!-- <ContactsList :contacts="contacts" @selected="startConversationWith"/> -->
       <vue-toastr ref="mytoast"></vue-toastr>
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
            }
        },
        data() {
            return {
                selectedContact: null,
                messages: [],
                contacts: [],
                newRequests:[],
                onlineUser:[]
            };
        },
        mounted() {
 var self = this; 
    Echo.join('online')
    .here(users => {
       // this.users = users
         console.log(users);
    })
    .joining(user => {
      
        var contact_in_list = this.contacts.filter(u => (u.id === user.id));
        if(contact_in_list.length && !this.onlineUser.includes(contact_in_list[0].id)){ 
            this.onlineUser.push(contact_in_list[0].id); 
        }
        console.log(this.onlineUser);
        if(this.selectedContact.id==user.id){
                window.$('.onoffst').addClass('gren_cir');
                window.$('#endChat_btn').addClass('hide');
                window.$('.onoffst').removeClass('red_cir');
            }
    })
    .leaving(user => {
            console.log('Practice leave online Channel');
        if(this.selectedContact && this.selectedContact.id==user.id){
                window.$('.onoffst').removeClass('gren_cir');
                window.$('#endChat_btn').removeClass('hide');
                window.$('.onoffst').addClass('red_cir');
            }
        var contact_is_list = this.contacts.filter(u => (u.id == user.id));

        //self.$refs.mytoast.i("Practice user "+user.name+" has left chat");
        if(contact_is_list.length!=0)
        {
            self.$refs.mytoast.i("Practice user "+user.name+" has left chat");
            
            var indexOnline = this.onlineUser.indexOf(contact_is_list[0].id);
              if (indexOnline > -1) {
                this.onlineUser.splice(indexOnline, 1);
              }
              console.log(this.onlineUser);
          //this.contacts = this.contacts.filter(u => (u.id !== user.id));
        }
    })


Echo.join(`PatientsRequest`)
.joining(user => {
        console.log('Practice Join Channel '+user.name)
         if(this.selectedContact && this.selectedContact.id==user.id){
                window.$('.onoffst').addClass('gren_cir');
                window.$('#endChat_btn').addClass('hide');
                window.$('.onoffst').removeClass('red_cir');
            }
    })
    .leaving(user => {
       console.log('Practice leave patientsRequest Channel');      
       
        var contact_in_list = this.contacts.filter(u => (u.id === user.id));
        if(this.newRequests.includes(user.id) && contact_in_list.length)
        {   
            if(this.selectedContact && contact_in_list.length){
                var contact_selected = this.selectedContact.id === user.id;
                window.$('.onoffst').removeClass('gren_cir');
                window.$('#endChat_btn').removeClass('hide');
                window.$('.onoffst').addClass('red_cir');
                this.selectedContact = null;
            }
          this.contacts = this.contacts.filter(u => (u.id !== user.id));         

          console.log('user contacts');
          console.log(this.contacts);
        }
        
    });


     Echo.channel(`PatientsRequest`)
     .listen('MessageForAdmins', (e) => {    
         console.log('new rquest comming channel');
         console.log(e);
      
            if(e.message.from_contact.unread == undefined){ e.message.from_contact.unread = 1; }
            console.log(e.message);
            var contact_in_list = this.contacts.filter(u => (u.id === e.message.from));
           if(!contact_in_list.length){ 
                    axios.get('/contacts_admin/'+e.message.from)
                        .then((response) => {
                        console.log('response of contact array check');
                        this.contacts.push(response.data[0]);

                            console.log(this.contacts);
                        });
               }

            console.log(this.contacts);
            if(e.message.to==0){ this.newRequests.push(e.message.from);  }
            //console.log(this.newRequests);
            this.hanleIncoming(e.message);
    });



            Echo.private(`messages.${this.user.id}`)
                .listen('NewMessage', (e) => {
                    console.log('new Old Channel message');
                    console.log(e);           
                    this.hanleIncoming(e.message);
              
                });

          axios.get('/contacts_admin')
                .then((response) => {
                 console.log('response of contact array check');
                this.contacts = response.data;

                    console.log(this.contacts);
                });
               // this.startConversationWith( {id: 1, name: "Hassan", email: "hassan.imtiaz@ssasoft.com"});
        },
        methods: {
            startConversationWith(contact) {
              this.updateUnreadCount(contact, true);

               axios.get(`conversation/${contact.id}`)
                    .then((response) => {
                        this.messages = response.data;
                        console.log(this.messages);
                        this.selectedContact = contact;
                        console.log(this.onlineUser);
                        console.log(this.selectedContact.id);
                        if(!this.onlineUser.includes(this.selectedContact.id))
                        {
                            window.$('.onoffst').removeClass('gren_cir');
                            window.$('#endChat_btn').removeClass('hide');
                            window.$('.onoffst').addClass('red_cir');
                        }
                        else{
                            window.$('.onoffst').removeClass('red_cir');
                            window.$('#endChat_btn').addClass('hide');
                            window.$('.onoffst').addClass('gren_cir');                            
                        }
                    })
            },
            EndChatSessionWith(practic_id){
                axios.get(`/end_chat_by_admin/${practic_id}`)
                .then((response) => {
                    this.selectedContact = null;
                    this.contacts = this.contacts.filter(u => (u.id !== practic_id));
                });
                 
            },
            saveNewMessage(message) {
                console.log(message);
                if(this.newRequests.includes(message.to))
                {
                    this.newRequests = this.newRequests.filter(u => (u !== message.to));
                }
                this.messages.push(message);
            },
            hanleIncoming(message) {
                if (this.selectedContact && message.from == this.selectedContact.id) {
                    this.saveNewMessage(message);
                   // alert(message);
                    return;
                }else{ 
                    this.updateUnreadCount(message.from_contact, false);
                }
               
                    
               
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
