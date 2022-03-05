<?php

namespace App\Http\Controllers;

use App\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    /*
    ** Display a listing of the resource.
    ** @return \Illuminate\Http\Response
    */

    function __construct()
    {
        $this->middleware('permission:الاقسام', ['only' => ['index', 'store']]);
        $this->middleware('permission:اضافة قسم', ['only' => ['create', 'store']]);
        $this->middleware('permission:تعديل قسم', ['only' => ['edit', 'update']]);
        $this->middleware('permission:حذف قسم', ['only' => ['destroy']]);
    }
    public function index()
    {
        $section=sections::all();
        return view('sections.sections',compact('section'));
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'section_name'=>'required|unique:sections|max:255',
            'description'=>'required',
        ],[
            'section_name.required'=>'الرجاء إدخال أسم القسم',
            'section_name.unique'=>'أسم القسم مسجل مسبقا',
            'description.required'=>'الرجاء إدخال الوصف',

        ]);



            sections::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'Created-by'=>(Auth::user()->name),
            ]);

            return redirect('/sections')->with("done", "تمت الإضافه بنجاح");

    }


    public function show(sections $sections)
    {
       //
    }

    public function edit($id)
    {
       $section= sections::find($id);
      return view('sections.edit', compact('section'));

    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'section_name' => 'required|max:255|unique:sections,section_name,'.$id,
            'description' => 'required'
        ], [
            'section_name.required' => 'الرجاء إدخال أسم القسم',
            'section_name.unique' => 'أسم القسم مسجل مسبقا',
            'description.required' => 'الرجاء إدخال الوصف'

        ]);
        $section= sections::find($id);
        /*  $section->section_name = $request->input('section_name');

         $section->description = $request->input('description');*/
         $section->update([
            'section_name' => $request->section_name,
            'description' => $request->description,
        ]);


         $section->save();

        return redirect('/sections')->with("done", "تمت التعديل بنجاح");
    }


    public function destroy($id)
    {
        $section = sections::find($id);
        $section->delete();
        return redirect('/sections')->with("done", "تم حذف القسم بنجاح");


    }
}
