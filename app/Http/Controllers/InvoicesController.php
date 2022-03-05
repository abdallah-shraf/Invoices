<?php

namespace App\Http\Controllers;

use App\invoices;
use App\sections;
use App\invoices_detalis;
use App\invoice_Attachments;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;

use App\Notifications\Creat_notfication;




class InvoicesController extends Controller
{
    /*
    ** Display a listing of the resource.
    ** @return \Illuminate\Http\Response
    */

    function __construct()
    {
        $this->middleware('permission:قائمة الفواتير', ['only' => ['index', 'store']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create', 'store']]);
        $this->middleware('permission:تغير حالة الدفع', ['only' => ['Status_Update']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit', 'update']]);
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['Print_invoice']]);

        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoic= invoices::all();
       return view('invoices.invoices',compact('invoic'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoic = invoices::all();
        $section= sections::all();
        return view('invoices.add', compact('invoic', 'section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //insert invoice To dataBase
        $inv=new invoices();
        $inv->invoice_Number=$request->input('invoice_Number');
        $inv->invoice_Date=$request->input('invoice_Date');
        $inv->due_Date=$request->input('due_Date');
        $inv->product = $request->input('product');
        $inv->section_id=$request->input('section');
        $inv->Amount_collection=$request->input('Amount_collection');
        $inv->Amount_Commission=$request->input('Amount_Commission');
        $inv->discount=$request->input('Discount');
        $inv->rate_vat=$request->input('Rate_VAT');
        $inv->value_vat=$request->input('Value_VAT');
        $inv->total=$request->input('total');
        $inv->status='غير مدفوعه';
        $inv->Value_status=2;
        $inv->not=$request->input('note');
        $inv->save();


        //insert invoices_detalis To dataBase
        $inv_Id= invoices::latest()->first()->id;

        invoices_detalis::create([
            'id_Invoice' => $inv_Id,
            'invoice_number' => $request->invoice_Number,
            'product' => $request->product,
            'Section' => $request->section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        //insert invoice_Attachments To DataBase
        if ($request->hasFile('pic')) {

            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_Number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }


        //$user=User::first();
        //Notification Email
        // $user->notify(new InvoicePaid($inv_Id));
        // Notification::send($user,new InvoicePaid($inv_Id));

        //Notification Data Base

        $user = User::first();
        $invoices = invoices::latest()->first();
        $user->notify(new Creat_notfication($invoices));
        //Notification::send($user, new Creat_notfication($invoices));


        session()->flash('done','تمت إضافه الفاتوره بنجاح');
        return back();





       // return redirect('/invoices')->with("done", "تمت الإضافه بنجاح");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoic=invoices::where('id',$id)->first();
        return view('invoices.status_update',compact('invoic'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inv= invoices::where('id',$id)->first();
        $section= sections::all();
        return view('invoices.edite',compact('inv', 'section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inv=invoices::find($id);
        $inv->invoice_Number=$request->invoice_Number;
        $inv->invoice_Date=$request->invoice_Date;
        $inv->due_Date=$request->due_Date;
        $inv->product = $request->input('product');
        $inv->section_id = $request->input('section');
        $inv->Amount_collection = $request->input('Amount_collection');
        $inv->Amount_Commission = $request->input('Amount_Commission');
        $inv->discount = $request->input('Discount');
        $inv->rate_vat = $request->input('Rate_VAT');
        $inv->value_vat = $request->input('Value_VAT');
        $inv->total = $request->input('total');
        $inv->status = 'غير مدفوعه';
        $inv->Value_status = 2;
        $inv->not = $request->input('note');

        $inv->save();
        session()->flash('update');
        return redirect('invoices');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->invoice_id;
        $invoices=invoices::where('id',$id);
        $details= invoice_Attachments::where('invoice_id',$id)->first();

        $id_page=$request->id_page;
        if ($id_page!=2){
            if (!empty($details->invoice_number)) {
                Storage::disk('public_uploads')->deleteDirectory($details->invoice_number);
            }
            $invoices->forceDelete();
            session()->flash('delet');
            return back();
        }
        else{
            $invoices->delete();
            session()->flash('archef');
            return back();
        }

    }

    public function getproducts($id){
        $products= DB::table('products')->where("section_id",$id)->pluck("Product_name","id");
        return json_encode($products);
    }

    public function Status_Update(Request $request, $id){


        $inv=invoices::findOrFail($id);


        if($request->x== 'مدفوعه'){

            $inv->update([
                'Value_status' => 1,
                'status' => $request->x,
                'Payment_Date'=>$request->pyment_date,


            ]);

           invoices_detalis::create([
                'id_Invoice'=>$request->id,
                'invoice_number'=>$request->invoice_Number,
                'product'=>$request->product,
                'Section'=>$request->section,
                'Status'=>$request->x,
                'Value_Status'=>1,
                'receivable' => $request->receivable,
                'rest_payout' => $request->rest_payout,
                'note'=>$request->note,
                'Payment_Date'=>$request->pyment_date,
                'user' => (Auth::user()->name),
           ]);


        }
        else{
            $inv->update([
                'Value_status' => 3,
                'status' => $request->x,
                'Payment_Date' => $request->pyment_date,

            ]);
            invoices_detalis::create([
                'id_Invoice' => $request->id,
                'invoice_number' => $request->invoice_Number,
                'product' => $request->product,
                'Section' => $request->section,
                'Status' => $request->x,
                'Value_Status' => 3,
                'receivable' => $request->receivable,
                'rest_payout' => $request->rest_payout,
                'note' => $request->note,
                'Payment_Date' => $request->pyment_date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('update_stut',"تم دفع الفاتوره");
        return redirect('invoices');

    }


    public function Invoice_unPaid(){
        $invoic=invoices::where('Value_Status',2)->get();
        return view('invoices.invoice_unPaid', compact('invoic'));
    }

    public function Invoice_Partial()
    {
        $invoic = invoices::where('Value_Status', 3)->get();
        return view('invoices.Invoice_Partial', compact('invoic'));
    }

    //payable invoices
    public function  invoice_Paid()
    {
        $invoic = invoices::where('Value_Status', 1)->get();
        return view('invoices.invoice_Paid', compact('invoic'));
    }

    //print invoice
    public function Print_invoice($id){

        $invoic=invoices::where('id',$id)->first();
        return view('invoices.print',compact('invoic'));
    }

    //Notification Read

    public function MarkAsRead_all(Request $request)
    {

        $userUnreadNotification = auth()->user()->unreadNotifications;

        if ($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }
    }

    public function unreadNotifications_count()

    {
        return auth()->user()->unreadNotifications->count();
    }

    public function unreadNotifications()

    {
        foreach (auth()->user()->unreadNotifications as $notification) {

            return $notification->data['title'];
        }
    }



}
