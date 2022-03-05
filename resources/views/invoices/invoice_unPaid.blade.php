@extends('layouts.master')

@section('title')
 الفواتير المدفوعه
@stop

@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal  Font Awesome -->
<link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
<!--Internal   Notify -->
<link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
<!--Internal  treeview -->
<link href="{{URL::asset('assets/plugins/treeview/treeview.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمه الفواتير/الفواتير الغير مدفوعه</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">

					<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<div class="col-sm-6 col-md-4 col-xl-3 mg-t-20 mg-xl-t-0">
                                        <a class=" btn btn-primary "  href="{{ route('invoices.create')}}"> إضافه فاتوره</a>
									</div>
								</div>
							</div>
							<div class="card-body">

                            @if (Session::has('delet'))

                                <script>
                                    window.onload = function() {
                                        notif({
                                            msg: "تم حذف الفاتورة بنجاح",
                                            type: "error"
                                        })
                                    }
                                </script>


                            @endif
                            @if (Session::has('update'))
                                <script>
                                    window.onload = function() {
                                        notif({
                                            msg: "تم تحديث الفاتورة بنجاح",
                                            type: "success"
                                        })
                                    }
                                </script>
                            @endif

                            @if (Session::has('update_stut'))
                                <script>
                                    window.onload = function() {
                                        notif({
                                            msg: "تم تحديث حاله الفاتورة بنجاح",
                                            type: "success"
                                        })
                                    }
                                </script>
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

							<div class="table-responsive">
								<table id="example" class="table key-buttons text-md-nowrap">
									<thead>
										<tr>
												<th class="border-bottom-0">#</th>
												<th class="border-bottom-0">رقم الفاتوره</th>
												<th class="border-bottom-0">تاريخ الفاتوره</th>
												<th class="border-bottom-0">تاريخ الاستحقاق</th>
												<th class="border-bottom-0">المنتج</th>
												<th class="border-bottom-0">القسم</th>
                                                <th class="border-bottom-0">الخصم</th>
                                                <th class="border-bottom-0">نسبه الضريبه</th>
                                                <th class="border-bottom-0">قيمه الضريبه</th>
                                                <th class="border-bottom-0">الإجمالى</th>
                                                <th class="border-bottom-0">الحاله</th>
                                                <th class="border-bottom-0">ملاحظات</th>
                                                <th class="border-bottom-0">العمليات</th>


										</tr>
									</thead>
									<tbody>
                                            <?php $i=0;?>
                                             @foreach ($invoic as $Data )



                                                    <?php $i++;?>
											<tr>
												<td>{{$i}}</td>

												<td>{{$Data->invoice_Number}}</td>

												<td>{{$Data->invoice_Date}} </td>

												<td>{{$Data->due_Date}}</td>

												<td>{{$Data->product}}</td>



                                                <td><a
                                                    href="{{ url('invoices_dealse') }}/{{ $Data->id }}">{{ $Data->section->section_name }}</a>
                                                </td>

                                                <td>{{$Data->discount}}</td>

                                                <td>{{$Data->rate_vat}}</td>

                                                <td>{{$Data->value_vat}}</td>

                                                <td>{{$Data->total}}</td>



                                                <td>
                                                    @if ($Data->Value_status == 1)
                                                        <span class="text-success">{{$Data->status}}</span>
                                                    @elseif($Data->Value_status== 2)
                                                        <span class="text-danger">{{$Data->status}}</span>
                                                    @else
                                                        <span class="text-warning">{{$Data->status}}</span>
                                                    @endif

                                                </td>

                                                <td>{{$Data->not}}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button aria-expanded="false" aria-haspopup="true" class="btn btn btn-primary mg-t-5" ripple btn-warning
                                                        data-toggle="dropdown" type="button"> العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                                        <div class="dropdown-menu  tx-13">
                                                            <a class="dropdown-item btn btn-success mg-t-5" href="{{ route('invoices.edit',$Data->id ) }}">تعديل</a>
                                                            <a class="dropdown-item  btn btn-danger mg-t-5 " href="#" data-invoice_id="{{ $Data->id }}"
                                                                data-toggle="modal" data-target="#delet"><i
                                                                class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذفالفاتورة
                                                            </a>
                                                            <a class="dropdown-item btn btn-info mg-t-5 " href="{{ route('statuse_show',$Data->id) }}">تغير حاله الفاتوره</a>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            @endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--/div-->
				</div>
                <div class="modal fade" id="delet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <form action="{{route('invoices.destroy', 'test') }}" method="post">
                                    {{ method_field('delete') }}
                                    {{ csrf_field() }}
                            </div>
                            <div class="modal-body">
                                هل انت متاكد من عملية الحذف ؟
                                <input type="hidden" name="invoice_id" id="invoice_id" value="">
                            </div>
                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>

                                <button class="btn btn-danger ">تاكيد</button>


                            </div>
                            </form>
                        </div>
                    </div>
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
<!-- Internal Data tables -->

<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>
<script src="{{URL::asset('assets/plugins/notify/js/notifit-custom.js')}}"></script>
<script>
        $('#delet').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var invoice_id = button.data('invoice_id')
            var modal = $(this)
            modal.find('.modal-body #invoice_id').val(invoice_id);
        })
    </script>
@endsection
