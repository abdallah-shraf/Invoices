@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات / تعديل المنتج  </span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
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
				<div class="">
                    <div class="card key-buttons text-md-nowrap">
                        <div class="card-body">
                            <form action="{{ route('products.update',$pro->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label >أسم المنتج</label>
                                    <input type="text" name="Product_name" value="{{$pro->Product_name}}"  class="form-control">
                                </div>

                                <div class="form-group">
                                        <label for="exampleInputEmail1">أسم القسم</label>
                                        <select name="section_id"  id="section_id" class="form-control" required >
                                            <option value=""select disabled> ---حددالقسم-----</option>
                                            @foreach ( $section as $Data  )
                                                <option value="{{$Data->id}}">{{$Data->section_name}}</option>
                                            @endforeach
                                        </select>
                                </div>

                                <div class="form-group">
                                    <label >الملاحظات</label>
                                    <input type="text" name="description" value="{{$pro->description}}" class="form-control">
                                </div>


                                {{method_field('PUT')}}

                                <button type="submit" class="btn btn-primary btn-block">إضافه منتج</button>

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
@endsection
