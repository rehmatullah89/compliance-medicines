@extends('layouts.compliance')
<link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">

@section('content')
<!-- {{ auth()->user()->roles[0]->name }} -->


                <div class="card-body" id="app">
                @if(auth::user()->hasRole('compliance_admin') || auth::user()->can('all access'))
                    <chat-app :user="{{ auth()->user() }}"></chat-app>
                @else
                <practice-chat-app :user="{{ auth()->user()}}" ></practice-chat-app>
                @endif
                </div>
           
{{--
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Chats</div>
<div id="app">
                <div class="panel-body">
                    <chat-messages :messages="messages"></chat-messages>
                </div>
                <div class="panel-footer">
                    <chat-form
                        v-on:messagesent="addMessage"
                        :user="{{ Auth::user() }}"
                    ></chat-form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
--}}
@endsection

@section('js')
<script>
 /* 
$(document).ready(function(){
$(".chatbox_header").click(function(event_object){
	event_object.stopPropagation();
	event_object.preventDefault();	
});
});
  export default {
        mounted() {
            console.log('Main Chat App')   
        }
    } */
</script> 
@endsection
