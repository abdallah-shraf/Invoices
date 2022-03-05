@extends('layouts.master')
@section('title')
  معلومات الفاتوره
@stop
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الفواتير/معلومات الفاتوره</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">

                    <div class="container">
                         @if (Session::has('done'))
                            <div class="alert alert-success  alert-dismissible fade show"role="alert">
                                <h2>{{Session::get('done')}}</h2>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                     @endif
                    @if ($errors->any())
                        <div class="alert alert-danger alert-warning alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات الفاتوره</a></li>
                                        <li><a href="#tab5" class="nav-link" data-toggle="tab">حالات الدفع</a></li>
                                        <li><a href="#tab6" class="nav-link" data-toggle="tab">المرفاقات</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">
                                    <!--Information Invoices-->
                                    <div class="tab-pane active" id="tab4">
                                        <!--div-->

                                            <div class="col-xl-12">
                                                <div class="card">

                                                    <div class="card-body">
                                                        <div class="table-responsive mt-15">
                                                            <table class="table table-striped mg-b-0 text-md-nowrap">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">رقم الفاتوره</th>
                                                                        <td>{{$inv->invoice_Number}}</td>
                                                                        <th scope="row">تاريخ الإصدار</th>
                                                                        <td >{{$inv->invoice_Date}}</td>
                                                                        <th scope="row">تاريخ الستحقاق</th>
                                                                        <td>{{$inv->due_Date}}</td>
                                                                        <th scope="row">القسم</th>
                                                                        <td>{{$inv->section->section_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">المنتج</th>
                                                                        <td>{{$inv->product}}</td>
                                                                        <th scope="row">مبلغ التحصيل</th>
                                                                        <td>{{$inv->Amount_collection}}</td>
                                                                        <th scope="row">مبلغ العمول</th>
                                                                        <td>{{$inv->Amount_Commission}}</td>
                                                                        <th scope="row">الخصم</th>
                                                                        <td>{{$inv->discount}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">نسبه الضريبه</th>
                                                                        <td>{{$inv->rate_vat}}</td>
                                                                        <th scope="row">قيمه الضريبه </th>
                                                                        <td>{{$inv->value_vat}}</td>
                                                                        <th scope="row"> الإجمالى مع الضريبه</th>
                                                                        <td>{{$inv->total}}</td>
                                                                        <th scope="row">الحاله لحاليه</th>
                                                                        @if ($inv->Value_status == 1)
                                                                            <td><span
                                                                                    class="badge badge-pill badge-success">{{ $inv->status }}</span>
                                                                            </td>
                                                                        @elseif($inv->Value_status ==2)
                                                                            <td><span
                                                                                    class="badge badge-pill badge-danger">{{ $inv->status }}</span>
                                                                            </td>
                                                                        @else
                                                                            <td><span
                                                                                    class="badge badge-pill badge-warning">{{ $inv->status }}</span>
                                                                            </td>
                                                                        @endif
                                                                    </tr>
                                                                    <tr>
                                                                       <th scope="row">ملاحظات</th>
                                                                        <td>{{$inv->not}}</td>
                                                                    </tr>

                                                                </tbody>

                                                            </table>
                                                        </div><!-- bd -->
                                                    </div><!-- bd -->
                                                </div><!-- bd -->
                                            </div>
                                            <!--/div-->


                                    </div>

                                    <!--Pyment Casses-->

                                    <div class="tab-pane" id="tab5">
                                         <!--div-->

                                            <div class="col-xl-12">
                                                <div class="card">

                                                    <div class="card-body">
                                                        <div class="table-responsive mt-15">
                                                            <table class="table table-striped mg-b-0 text-md-nowrap">
                                                                <thead>
                                                                    <tr class="text-dark"></tr>
                                                                    <th>#</th>
                                                                    <th>رقم الفاتوره</th>
                                                                    <th>نوع المنتج</th>
                                                                    <th>القسم</th>
                                                                    <th>حاله الدفع</th>
                                                                    <th >المبلغ المدفوع</th>
                                                                    <th >باقى المبلغ</th>
                                                                    <th> تاريخ الدفع</th>
                                                                    <th> ملاحظات</th>
                                                                    <th>تاريخ الإضافه</th>
                                                                    <th>المستخدم</th>
                                                                </thead>

                                                                <tbody>
                                                                    <?php $i=0; ?>
                                                                    @foreach ($dtal as $data )
                                                                    <?php $i++;?>
                                                                    <tr>
                                                                        <td>{{$i}}</td>
                                                                        <td>{{$data->invoice_number}}</td>
                                                                        <td>{{$data->product}}</td>
                                                                        <td>{{$inv->section->section_name}}</td>
                                                                        @if ($data->Value_Status == 1)
                                                                            <td><span
                                                                                    class="badge badge-pill badge-success">{{ $data->Status }}</span>
                                                                            </td>
                                                                        @elseif($data->Value_Status ==2)
                                                                            <td><span
                                                                                    class="badge badge-pill badge-danger">{{ $data->Status }}</span>
                                                                            </td>
                                                                        @else
                                                                            <td><span
                                                                                    class="badge badge-pill badge-warning">{{ $data->Status }}</span>
                                                                            </td>
                                                                        @endif

                                                                        <td>{{$data->receivable}}</td>
                                                                        <td>{{$data->rest_payout}}</td>

                                                                        <td>{{$data->Payment_Date}}</td>
                                                                        <td>{{$data->note }}</td>
                                                                        <td>{{$data->created_at}}</td>
                                                                        <td>{{$data->user}}</td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div><!-- bd -->
                                                    </div><!-- bd -->
                                                </div><!-- bd -->
                                            </div>
                                            <!--/div-->
                                    </div>


                                    <!--Attachment-->
                                    <div class="tab-pane" id="tab6">

                                        <div class="col-xl-12">
                                                <div class="card">

                                                    <div class="card-body">
                                                        <div class="table-responsive mt-15">
                                                            <table class="table table-striped mg-b-0 text-md-nowrap">
                                                                <div class="card card-statistics">

                                                                          @can('اضافة مرفق')
                                                                            <div class="card-body">
                                                                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                                                <h5 class="card-title">اضافة مرفقات</h5>
                                                                                <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                                                    enctype="multipart/form-data">
                                                                                    {{ csrf_field() }}
                                                                                    <div class="custom-file">
                                                                                        <input type="file" class="custom-file-input" id="customFile"
                                                                                            name="file_name" required>
                                                                                        <input type="hidden" id="customFile" name="invoice_number"
                                                                                            value="{{ $inv->invoice_Number }}">
                                                                                        <input type="hidden" id="invoice_id" name="invoice_id"
                                                                                            value="{{ $inv->id }}">
                                                                                        <label class="custom-file-label" for="customFile">حدد
                                                                                            المرفق</label>
                                                                                    </div><br><br>
                                                                                    <button type="submit" class="btn btn-primary btn-sm "
                                                                                        name="uploadedFile">تاكيد</button>
                                                                                </form>
                                                                            </div>
                                                                            @endcan
                                                                </div>
                                                                <thead>
                                                                    <tr class="text-dark"></tr>
                                                                    <th>#</th>
                                                                    <th> أسم الملف</th>
                                                                    <th> قام بالإضافه</th>
                                                                    <th>تاريخ الإضافه</th>
                                                                    <th> العمليات</th>
                                                                </thead>

                                                                <tbody>
                                                                    <?php $i=0; ?>
                                                                    @foreach ($atta as $data )
                                                                    <?php $i++;?>
                                                                    <tr>
                                                                        <td>{{$i}}</td>
                                                                        <td>{{$data->file_name}}</td>
                                                                        <td>{{$data->Created_by}}</td>
                                                                        <td>{{$inv->section->created_at}}</td>
                                                                        <td colspan="2">
                                                                            <a href="{{ url('View_file') }}/{{$data->invoice_number}}/{{$data->file_name}}" class="btn btn-outline-success btn-sm"> عرض<i class="fas fa-eye"></i></a>
                                                                            <a href="{{ url('download') }}/{{$data->invoice_number}}/{{$data->file_name}}" class="btn btn-outline-info btn-sm">تحميل <i  class="fas fa-download"></i></a>

                                                                            @can('حذف المرفق')
                                                                            <button class="btn btn-outline-danger btn-sm"
                                                                                            data-toggle="modal"
                                                                                            data-file_name="{{ $data->file_name }}"
                                                                                            data-invoice_number="{{$data->invoice_number }}"
                                                                                            data-id_file="{{ $data->id }}"
                                                                                            data-target="#delete_file"><i class="fas fa-trash"></i> حذف
                                                                            </button>
                                                                            @endcan

                                                                        </td>

                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div><!-- bd -->

                                                    </div><!-- bd -->
                                                </div><!-- bd -->
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
            <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('delete_file') }}" method="post">

                            {{ csrf_field() }}
                            <div class="modal-body">
                                <p class="text-center">
                                <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                                </p>

                                <input type="hidden" name="id_file" id="id_file" value="">
                                <input type="hidden" name="file_name" id="file_name" value="">
                                <input type="hidden" name="invoice_number" id="invoice_number" value="">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    <!-- Container closed -->
    </div>


@endsection
@section('js')
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Jquery.mCustomScrollbar js-->
    <script src="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.concat.min.js') }}"></script>
    <!-- Internal Input tags js-->
    <script src="{{ URL::asset('assets/plugins/inputtags/inputtags.js') }}"></script>
    <!--- Tabs JS-->
    <script src="{{ URL::asset('assets/plugins/tabs/jquery.multipurpose_tabcontent.js') }}"></script>
    <script src="{{ URL::asset('assets/js/tabs.js') }}"></script>
    <!--Internal  Clipboard js-->
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/clipboard/clipboard.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>

    <script>
        $('#delete_file').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id_file = button.data('id_file')
            var file_name = button.data('file_name')
            var invoice_number = button.data('invoice_number')
            var modal = $(this)
            modal.find('.modal-body #id_file').val(id_file);
            modal.find('.modal-body #file_name').val(file_name);
            modal.find('.modal-body #invoice_number').val(invoice_number);
        })
    </script>


@endsection
