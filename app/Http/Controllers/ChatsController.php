<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Message;

use App\Events\MessageSent;

use App\Events\NewMessage;
use App\Events\MessageForAdmins;
use App\Chat;
use DB;
use App\User;

use App\PracticeComplianceadminChat;

use App\ChatSession;

class ChatsController extends Controller
{
    //


public function __construct()
{
  $this->middleware('auth');
}

/**
 * Show chats
 *
 * @return \Illuminate\Http\Response
 */
public function index()
{
  return view('chat');
}

/**
 * Fetch all messages
 *
 * @return Message
 */
public function fetchMessages()
{
 return Chat::with('user')->get();
}

/**
 * Persist message to database
 *
 * @param  Request $request
 * @return Response
 */
public function sendMessage(Request $request)
{
  $user = Auth::user();


  $message = $user->chats()->create([
    'message' => $request->input('message')
  ]);

  broadcast(new MessageSent($user, $message))->toOthers();

  return ['status' => 'Message Sent!'];
}

public function get()
{
    // get all users except the authenticated one

    $contacts = User::whereHas('roles', function($q){
                          $q->where('name','practice_admin');
                  })->with('pharmacySessions')
                  ->whereHas('pharmacySessions', function($q){
                          $q->wherein('admin_id', [auth()->id(), 0]);
                          $q->where('status', 1);
                  })->has('pharmacyChat')
                  // ->whereHas('pharmacyChat',function($q){
                  //     $q->where('from',auth()->id())->orWhere('to',auth()->id());
                  // })
                  ->where('id', '!=', auth()->id())
                        ->when((isset(auth::user()->practices->first()->id) && auth::user()->practices->first()->id != Null && !auth::user()->hasRole('practice_super_group')), function($query){
                        $query->where('practice_id', null);
              })->get();

    // get a collection of items where sender_id is the user who sent us a message
    // and messages_count is the number of unread messages we have from him
    $unreadIds = PracticeComplianceadminChat::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
    ->where(function ($query) {
          $query->where('to', auth()->id())
          ->orwhere('to', 0);
      })->where('read', null)
        ->groupBy('from')
        ->get();

    // add an unread key to each contact with the count of unread messages
    $contacts = $contacts->map(function($contact) use ($unreadIds) {
        $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

        $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

        return $contact;
    });


    return response()->json($contacts);
}


public function get_contacts_for_admin($id=false)
{

  $contacts = User::select(['users.id AS id', 'pcs.padmin_name AS name', 'users.email', 
              DB::raw('(SELECT COUNT(pcc.id) FROM practice_complianceadmin_chats AS pcc WHERE pcc.from=pcs.user_id AND pcc.chat_session_id=pcs.id AND pcc.read IS NULL) AS unread')])
              ->join('practice_compliacneadmin_session AS pcs', 'pcs.user_id', 'users.id')
              ->when($id!=false, function($query) use ($id){
                  $query->where('users.id', $id);
              })
              ->where('pcs.status',  1)->wherein('admin_id', [auth()->id(), 0])->get();
  
              
  return response()->json($contacts);
}

public function get_pharmacy_session()
{
  $contacts = User::select(['users.id as id', 'users.name', 'users.email'])
                  ->join('practice_compliacneadmin_session AS pcs', 'pcs.admin_id', 'users.id')
                    ->where('pcs.user_id', auth()->id())
                    ->where('pcs.status', 1)->first();

     

        $unreadIds = PracticeComplianceadminChat::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
    ->where(function ($query) {
          $query->wherein('to', [auth()->id(), 0]);
      })->where('read', null)
        ->groupBy('from')
        ->get();

      return response()->json($contacts);
}

public function getMessagesFor($id=false)
{
      // mark all messages with the selected contact as read
      PracticeComplianceadminChat::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

      // get all messages between the authenticated user and the selected user
      $messages = PracticeComplianceadminChat::where(function($q) use ($id) {
          $q->where('from', auth()->id());
          $q->wherein('to', [$id, 0]);
      })->orWhere(function($q) use ($id) {
          $q->where('from', $id);
          $q->wherein('to', [auth()->id(), 0]);
      })
      ->orderBy('id','asc')
      ->get();
  
    return response()->json($messages);
}

public function send(Request $request)
{

  $check = PracticeComplianceadminChat::where('from', $request->contact_id)->where('to', 0)->first();
  if($check and $check->count()>0)
  {
    PracticeComplianceadminChat::where('from', $request->contact_id)->where('to', 0)->update(['to' => auth()->id(), 'read' => true]);  
    ChatSession::where('status', 1)->where('user_id', $request->contact_id)->update(['admin_id' => auth()->id()]);   
  }

  
    $message = PracticeComplianceadminChat::create([
        'from' => auth()->id(),
        'to' => $request->contact_id,
        'text' => $request->text
    ]);
    
    
    broadcast(new NewMessage($message))->toOthers();

    return response()->json($message);
}

public function sendPracticeRequest(Request $request, User $user)
{
  $practice_session_data = json_decode($request->practiceAdmin, true);
  $practice_session_data['user_id'] = auth()->id();
  $practice_session_data['created_at'] = date("Y-m-d H:i:s");
  $practice_session_data['updated_at'] = date("Y-m-d H:i:s");
  //dd($request->all());
    broadcast(new MessageForAdmins($practice_session_data, Auth::user()));
    return response()->json(['message'=> 'Request has been sent please wait for response.', 'session_data'=>$practice_session_data, 'session_started'=>true ]);
}

public function startSession(Request $request)
{  
    // $tempData = html_entity_decode($request->practiceAdmin);
    $practice_session_data = json_decode($request->practiceAdmin, true);
    // $practice_session_data = json_decode($request->practiceAdmin);
    // print_r($request->practiceAdmin);
    // echo "<br>";
    // print_r($tempData);
    // echo "<br>";
    // print_r($practice_session_data);
    $practice_session_data['status'] = 1;
  $insert_chat_session =  Auth::user()->pharmacySessions()->save(new ChatSession($practice_session_data));

  $message = PracticeComplianceadminChat::create([
        'from' => auth()->id(),
        'to' => 0,
        'text' => $practice_session_data['padmin_issue']  
    ]);

  broadcast(new MessageForAdmins($message));

    return response()->json(['session_data'=>$insert_chat_session,'session_started'=>true]);
}


public function leaveAndRemoveChat($id=0){
    if (auth::user()->hasRole('practice_admin') || auth::user()->can('practice admin')){
      $chat_messages =  PracticeComplianceadminChat::where('to',auth::user()->id)
        ->orWhere('from',auth::user()->id)->delete();
      $chat_session =  auth::user()->pharmacySessions()->delete();
        return response()->json(['chat_messages'=>$chat_messages,'chat_session'=>$chat_session]);
    }
}

    public function leaveAndRemoveChatbyadmin($id){
        $chat_messages =  PracticeComplianceadminChat::where('to',$id)
        ->orWhere('from',$id)->delete();
      $chat_session =  User::find($id)->pharmacySessions()->delete();
        return response()->json(['chat_messages'=>$chat_messages,'chat_session'=>$chat_session]);
    }
}