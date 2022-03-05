<?php

namespace App\Http\Controllers;

use App\invoices_detalis;
use App\invoices;
use App\invoice_Attachments;
use Illuminate\Support\Facades\Storage;
use file;
use Illuminate\Http\Request;

class InvoicesDetalisController extends Controller
{
    /*
    ** Display a listing of the resource.
    ** @return \Illuminate\Http\Response
    */

    function __construct()
    {
        $this->middleware('permission:حذف المرفق', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_detalis $invoices_detalis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function edit($id )
    {
        $inv= invoices::where('id',$id)->first();
        $dtal= invoices_detalis::where('id_Invoice',$id)->get();
        $atta= invoice_Attachments::where('invoice_id',$id)->get();
        return view('invoices.invoices_dealse',compact('inv', 'dtal','atta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_detalis $invoices_detalis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\invoices_detalis  $invoices_detalis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request )
    {
        $invo = invoice_Attachments::findOrFail($request->id_file);
        $invo->delete();
       Storage::disk('public_uploads')->delete($request->invoice_number . '/' . $request->file_name);
        session()->flash('done', 'تم حذف المرفق ');
        return back();
    }


    /*public function download($id)
    {

        $data = file::where('id', $id)->firstOrFail();
        $data_path = public_path('files/' . $data->file);
        return  response()->download($data_path);
    }*/
    //open files
    public function open_file($invoice_number,$file_name)
    {

        $file=Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number.'/'.$file_name);
        return response()->file($file);
    }
    //Download files
    public function Download($invoice_number, $file_name)
    {

        $file = Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($invoice_number . '/' . $file_name);
        return response()->download($file);
    }
}
