@extends('frontend.layouts.master')
@section('title','MSI || Keranjang')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{('home')}}">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="">Cart</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- Pinjaman -->
	<div class="pinjaman section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<!-- Pinjam -->
					<table class="table pinjam">
						<thead>
							<tr class="main-hading">
								<th>ASET</th>
								<th>NAMA ASET</th>
								<th>JUMLAH ASET</th>
								<th class="text-center">HAPUS</th>
							</tr>
						</thead>
						<tbody id="cart_item_list">
							<form action="{{route('cart.update')}}" method="POST">
								@csrf
								@if(Helper::getAllAsetFromCart())
									@foreach(Helper::getAllAsetFromCart() as $key=>$cart)
										<tr>
											@php
											$photo=explode(',',$cart->aset['photo']);
											@endphp
											<td class="image" data-title="No"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></td>
											<td class="aset-des" data-title="Description">
												<p class="aset-name"><a href="{{route('aset-detail',$cart->aset['slug'])}}"  >{{$cart->aset['title']}}</a></p>
												<p class="aset-des">{!!($cart['summary']) !!}</p>
											</td>
											<td class="qty" data-title="Qty"><!-- Input Order -->
												<div class="input-group">
													<div class="button minus">
														<button type="button" class="btn btn-primary btn-number" data-type="minus" data-field="quant[{{$key}}]">
															<i class="ti-minus"></i>
														</button>
													</div>
													<input type="text" name="quant[{{$key}}]" class="input-number"  data-min="1" data-max="{{$cart->aset->stock}}" value="{{$cart->quantity}}">
													<input type="hidden" name="qty_id[]" value="{{$cart->id}}">
													<div class="button plus">
														<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{$key}}]">
															<i class="ti-plus"></i>
														</button>
													</div>
												</div>
											</td>
											<td class="action" data-title="Remove"><a href="{{route('cart-delete',$cart->id)}}"><i class="ti-trash remove-icon"></i></a></td>
										</tr>
									@endforeach
									<track>
										<td></td>
										<td></td>
										<td></td>
										<td class="float-right">
											<button class="btn float-right" type="submit">Update</button>
										</td>
									</track>
								@else
										<tr>
											<td class="text-center">
												There are no any carts available. <a href="{{route('aset-grids')}}" style="color:blue;">Kembali Ke Home</a>

											</td>
										</tr>
								@endif

							</form>
						</tbody>
					</table>
					<!--/ End Pinjam -->
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<!-- Total -->
                    <form class="form" method="POST" action="{{route('cart.pinjam')}}">
					@csrf
                    <div class="total-amount">
                        <div class="row">
                            <div class="col-lg-8 col-md-5 col-12">
                                
                            </div>
                            <div class="col-lg-4 col-md-7 col-12">
                                <div class="right">
                                    <ul>
                                        <li class="pinjam_subtotal" >Total Item:<span>{{ Helper::cartCount() }} Item</span></li>
                                    </ul>
                                    <div class="button5">
                                        <button type="submit" class="btn">Pinjam</button>
                                        <a href="{{route('aset-grids')}}" class="btn">Kembali ke Home</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                    <!--/ End Total -->
				</div>
			</div>
		</div>
	</div>
	<!--/ End Pinjaman -->

@endsection
@push('styles')
	<style>
		li.shipping{
			display: inline-flex;
			width: 100%;
			font-size: 14px;
		}
		li.shipping .input-group-icon {
			width: 100%;
			margin-left: 10px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;
		}
		.form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#F7941D !important;
			color:white !important;
		}
		.form-select .nice-select::after {
			top: 14px;
		}
	</style>
@endpush
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
@endpush
