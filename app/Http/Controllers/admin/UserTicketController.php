<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserTicket as Ticket;
use App\Models\UserTicketContent as TicketContent;

class UserTicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function openTicketList(Request $request)
    {
        $tickets = Ticket::where('status','=',1)
        ->orderByDesc('updated_at')
        ->paginate(20);
        
        $sortedTickets = $tickets->getCollection()
        ->map(function($t){
            $t->sort_date = $t->contents()->orderByDesc('id')->take(1)->first(['id','ticket_id','user_id','created_at'])->created_at ?? $t->updated_at;
            return $t;
        })
        ->sortByDesc(function($ticket) {
            return [
                $ticket->status,  
                $ticket->sort_date, 
            ];
        })
        ->values();
        

        $tickets->setCollection($sortedTickets);

        $data['tickets'] = $tickets;
        // dd($data);
        return view('admin.tickets.open_list',$data);
    }

    public function closedTicketList(Request $request)
    {
        $tickets = Ticket::where('status','=',0)
        ->orderByDesc('updated_at')
        ->paginate(50);
        
        $sortedTickets = $tickets->getCollection()
        ->map(function($t){
            $t->sort_date = $t->contents()->orderByDesc('id')->take(1)->first(['id','ticket_id','user_id','created_at'])->created_at ?? $t->updated_at;
            return $t;
        })
        ->sortByDesc(function($ticket) {
            return [
                $ticket->status,  
                $ticket->sort_date, 
            ];
        })
        ->values();
        

        $tickets->setCollection($sortedTickets);

        $data['tickets'] = $tickets;
        // dd($data);
        return view('admin.tickets.closed_list',$data);
    }

    public function closeTicket(Ticket $ticket)
    {
        $ticket->update(['status'=>0]);
        return redirect('/admin/user-tickets/closed');
    }

    public function destroyTicket(Ticket $ticket)
    {
        $stat = $ticket->status ? 'open' : 'closed';
        $ticket->contents()->delete();
        $ticket->delete();

        return redirect('/admin/user-tickets/'.$stat);
    }

    public function ticketMessageList(Ticket $ticket, Request $request)
    {
        $data['ticket'] = $ticket;
        // $data['messages'] = $ticket->contents()->orderByDesc('id')->paginate(2);
        $messages = $ticket->contents()->with('user:id,name,photo')
        ->orderByDesc('id')
        ->paginate(15);

        $sortedResult = $messages->getCollection()->sortBy('id')->values();
        $messages->setCollection($sortedResult);
        $data['messages'] = $messages;

        return view('admin.tickets.content',$data);
    }

    public function ticketMessageStore(Ticket $ticket, Request $request)
    {

        $request->validate([
            'message'=> 'required|string',
            'post_image' => 'image|nullable|max:5000',
        ]);

        $msg = strip_tags($request->message);
        if(isset($request->post_image))
        {
            $img = $request->post_image->store('uploads/ticket_images','public');
            $msg = $msg.'  <img src="/storage/'.$img.'">';
        }

        $ticket->contents()->create([
            'user_id' => auth()->user()->id,
            'message' => $msg,
        ]);

        $ticket->update(['status'=>1]);

        return redirect('/admin/user-tickets/'.$ticket->id.'/contents');
    }
    
    public function ticketMessageDestroy(Ticket $ticket,Request $request)
    {

        $request->validate([
            'mid'=> 'required|numeric',
        ]);

        $msg = TicketContent::find($request->mid);
        
        $msg->delete();

        return redirect()->back();      

        // return redirect('/admin/user-tickets/'.$ticket->id.'/contents');
    }

}
