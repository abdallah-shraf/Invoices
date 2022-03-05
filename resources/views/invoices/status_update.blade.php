@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection
@section('title')
  تحديث حاله الدفع
@stop
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الفواتير/تعديل الفاتوره</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row d-block">
                    <div class="card">
                        <div class="card-body">
                                <form action="{{ route('Status_Update',$invoic->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                    <div class="form-row">


                                        <div class="form-group col-md-4 ">
                                            <label class="control-label" >رقم الفاتوره </label>
                                            <input type="text" value="{{$invoic->invoice_Number}}" name="invoice_Number" id="inputName" class="form-control"required readonly>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label class="control-label" >تاريخ الفاتوره</label>
                                            <input type="text" value="{{$invoic->invoice_Date}}" name="invoice_Date" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" class="form-control fc-datepicker" required readonly>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label class="control-label" >تاريخ الأستحقاق</label>
                                            <input type="text" name="due_Date" value="{{$invoic->due_Date}}"  placeholder="YYYY-MM-DD" class="form-control fc-datepicker" required readonly>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="" class="control-label">القسم</label>
                                            <select name="section" onclick="console.log($(this).val())" onchange="console.log('change is firing')" class="form-control SlectBox" >
                                               <option value=" {{ $invoic->section->id }}" required readonly>
                                                 {{ $invoic->section->section_name }}
                                                </option>

                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="inputName" class="control-label">المنتج</label>
                                            <select id="product" name="product" class="form-control"required readonly>
                                                <option value="{{$invoic->product}}">{{$invoic->product}}</option>
                                            </select>
                                        </div>



                                        <div class="form-group col-md-4">
                                            <label for="inputName" class="control-label">مبلغ العمولة</label>
                                            <input type="text" class="form-control form-control-lg" id="Amount_Commission"
                                                name="Amount_Commission" value="{{$invoic->Amount_Commission}}" title="يرجي ادخال مبلغ العمولة " oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required readonly>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="inputName" class="control-label">الخصم</label>
                                            <input type="text" class="form-control form-control-lg" id="Discount" name="Discount"
                                                title="يرجي ادخال مبلغ الخصم "
                                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                value="{{$invoic->discount}}" required readonly>
                                        </div>


                                        <div class="form-group col-md-4">
                                            <label for="inputName" class="control-label">نسبة ضريبة القيمة المضافة</label>
                                            <select name="Rate_VAT" id="Rate_VAT" class="form-control" onchange="myFunction()" required readonly>
                                                <!--placeholder-->
                                                <option value="{{$invoic->rate_vat}}" selected disabled>{{$invoic->rate_vat}}</option>

                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputName" class="control-label">قيمة ضريبة القيمة المضافة</label>
                                            <input type="text" value="{{$invoic->value_vat}}" class="form-control" id="Value_VAT" name="Value_VAT" required readonly>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="inputName" class="control-label">الاجمالي شامل الضريبة</label>
                                            <input type="text" value="{{$invoic->total}}" class="form-control" id="Total" name="total" required readonly>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="exampleTextarea">ملاحظات</label>
                                            <textarea class="form-control"  id="exampleTextarea" name="note" rows="3" required readonly></textarea>
                                        </div>

                                        <div class="form-group col-md-4" id="receivabl">
                                            <label for="inputName" class="control-label">المبلغ المدفوع</label>
                                            <input type="text" class="form-control form-control-lg" id="receivable"
                                                name="receivable" title="يرجي ادخال مبلغ العمولة " oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)0\./g, '$1');" required>
                                        </div>


                                        <div class="form-group col-md-6" id="rest_payou">
                                            <label for="inputName" class="control-label">باقى المبلغ </label>
                                            <input type="text" class="form-control form-control-lg" value="{{$invoic->rest_payout}}"  id="rest_payout" name="rest_payout"  value=0 required readonly>

                                        </div>



                                        <div class="form-group col-md-6">
                                            <label for="exampleTextarea">حالة الدفع</label>
                                            <select class="form-control" id="status" name="x" onchange="fFunction()" required>
                                                <option selected="true" disabled="disabled">-- حدد حالة الدفع --</option>
                                                <option value="مدفوعه">مدفوعه</option>
                                                <option value="مدفوعه جزئيا"> مدفوعه جزئيا</option>
                                            </select>
                                        </div>


                                       <div class="form-group col-md-6">
                                            <label class="control-label" >تاريخ الدفع</label>
                                            <input type="text" name="pyment_date" value="{{ date('Y-m-d') }}" placeholder="YYYY-MM-DD" class="form-control fc-datepicker">
                                        </div>
                                        <div class="alert alert-danger" role="alert" id="alert" >
                                            <label class="control-label" id="cc" ></label>
                                        </div>
                                        <div class="form-group col-md-12" id="aleart">
                                         <button type="submit" id="send" class="btn btn-primary  btn-block"  > تغير حاله الدفع </button>
                                        </div>
                                     </div>


                                </form>

                        </div>
                     </div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>


    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
    <script>
        document.getElementById('alert').style.display='none';


        function fFunction() {
            var rest_payout = document.getElementById("rest_payout").value;
            var receivable = document.getElementById("receivable").value;
            var Total = document.getElementById("Total").value;
            var status = document.getElementById("status").value;

            var cc = document.getElementById("cc").value;


            if (receivable==Total && status== 'مدفوعه' ) {
                document.getElementById("receivable").value =Total;
                document.getElementById("rest_payout").value =0;


            }else if( receivable < Total && status== 'مدفوعه جزئيا' && intResults2!=0  ){

                 var intResults2 = Total-receivable ;
                document.getElementById("rest_payout").value =intResults2 ;
                document.getElementById("status").value ='مدفوعه جزئيا' ;

            }
             else {
                document.getElementById('alert').style.display='block';
                document.getElementById('send').style.display='none';
                document.getElementById("cc").innerHTML="الرجاء إدخال البينات صحيحا";
            }
            }


    </script>

@endsection
