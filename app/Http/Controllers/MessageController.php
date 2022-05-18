<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Client;
use App\Models\MessagesClient;
use Twilio\Rest\Client as Twilio;
use App\Models\Empresa;



function console_log( $data ){
    echo '<script>';
    echo 'console.log('. json_encode( $data ) .')';
    echo '</script>';
  }


class MessageController extends Controller
{
     public function __construct(){
         $this->middleware('auth');
     }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all();
        return view('message.index')->with('messages',$messages);
    }

    public function SendMessage($id)
    {
        $message = Message::find($id);
        $empresa = Empresa::find(1);

        $messagesClients = MessagesClient::where('message_id',$message->id)->get();
        // CADA EMPRESA (USER) VAI TER AS SUAS CREDENCIAS DO TWILIO
        // var_dump(env('APP_ENV'));
             $twilio_account = $empresa->TwilioAccountID;
             $twilio_auth = $empresa->TwilioAccountSecret;
        // var_dump($twilio_account,$twilio_auth);
         $twilio = new Twilio($twilio_account, $twilio_auth);
        // var_dump($twilio);
         foreach($messagesClients as $msg){

        $client = Client::find($msg->client_id);
            $twilio->messages->create(
                $client->phone,
                array(
                    'from' => $empresa->TwilioAccountPhone,
                    'body' => $message->message
                )
                );
            }
            return redirect('/messages');

    }
    public function SendMessageExpress($id){        
        $message = Message::find($id);
        $empresa = Empresa::find(1);

        
        $messagesClients = MessagesClient::where('message_id',$message->id)->get();
        
        $expressApiUrl = env('APP_URL') . '/docs/SubmissionManager2.wsdl';
        $expressClient = $empresa->AlticeAccountID;
        $expressPassword = $empresa->AlticeAccountSecret;
        $options = array(
            'application' => 'NicoBusiness',
            'username' => $expressClient,
            'password' => $expressPassword,
       );
       $soap = new SoapClient($expressApiUrl, [
        # This array and its values are optional
        'soap_version' => SOAP_1_2,
        'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
        'cache_wsdl' => WSDL_CACHE_BOTH,
        # Helps with debugging
        'trace' => TRUE,
        'exceptions' => TRUE
    ]);

        // console_log($soapClient);


        
    }
    public function SendMessageTwilio($id)
    {
        $message = Message::find($id);
        $empresa = Empresa::find(1);


        $messagesClients = MessagesClient::where('message_id',$message->id)->get();
        // CADA EMPRESA (USER) VAI TER AS SUAS CREDENCIAS DO TWILIO
        // var_dump(env('APP_ENV'));
        $twilio_account = $empresa->TwilioAccountID;
        $twilio_auth = $empresa->TwilioAccountSecret;
         //var_dump($twilio_account,$twilio_auth);
         $twilio = new Twilio($twilio_account, $twilio_auth);
        // var_dump($twilio);
         foreach($messagesClients as $msg){

        $client = Client::find($msg->client_id);
            $twilio->messages->create(
                $client->phone,
                array(
                    'from' => $empresa->TwilioAccountPhone,
                    'body' => $message->message
                )
                );
            }
            return redirect('/messages');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();
        return view('message.create')->with('clients',$clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = new Message();
        $clients=Client::all();

        $clients_id = array();
        //  dd($client_id);
        $messages->subject = $request->get('subject');
        $messages->message = $request->get('message');

        $messages->save();

        $lastMessage = Message::select('id')->orderByDesc('id')->limit(1)->get();
                //localizar o primeiro checkbox
        foreach ($clients as $client) {
            if ($request->get($client->id)) {
                $messageClient = new MessagesClient();
            $messageClient->message_id = $lastMessage[0]->id;
            $messageClient->client_id = $client->id;
            $messageClient->save();
            }

        }
        return redirect('/messages');}

    /**}}
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $message = Message::find($id);
        // $message->clients_id=json_decode($message->clients_id);
        $clients = Client::all();
        $messagesClients = MessagesClient::where('message_id',$message->id)->get();
        return view('message.edit')->with('flag',0)->with('message',$message)->with('clients',$clients)->with('messagesClient',$messagesClients);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $message = Message::find($id);
        $clients=Client::all();




        $message->subject = $request->get('subject');
        $message->message = $request->get('message');
        $messagesClients = MessagesClient::where('message_id',$message->id)->delete();
        // dd($request->get(1));
        foreach ($clients as $client) { if ($request->get($client->id)) {
            $messageClient = new MessagesClient();
        $messageClient->message_id = $id;
        $messageClient->client_id = $client->id;
        $messageClient->save();
        }
        }
        // foreach($messagesClients as $mess){
        //     $mess->delete();
        // }



        $message->save();

        return redirect('/messages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Message::find($id);
        $message->delete();
        return redirect('/messages');
    }
}
