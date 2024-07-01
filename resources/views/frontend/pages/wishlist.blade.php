@extends('frontend.layouts.master')
@section('title','MSI || Wishlist')
@section('main-content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="{{('home')}}">Home<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="javascript:void(0);">Wishlist</a></li>
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
			<div class="col-12 mx-auto">
				<!-- Pinjam -->
				<table class="table pinjam">
					<thead>
						<tr class="main-hading">
							<th>ASET</th>
							<th></th>
							<th>NAMA ASET</th>
							<th class="text-center">HAPUS</th>
						</tr>
					</thead>
					<tbody>
						@if(Helper::getAllAsetFromWishlist())
						@foreach(Helper::getAllAsetFromWishlist() as $key=>$wishlist)
						<tr>
							@php
							$photo=explode(',',$wishlist->aset['photo']);
							@endphp
							<td class="image" data-title="No"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></td>
							<td></td>
							<td class="aset-des" data-title="Description">
								<p class="aset-name"><a href="{{route('aset-detail',$wishlist->aset['slug'])}}">{{$wishlist->aset['title']}}</a></p>
								<p class="aset-des">{!!($wishlist['summary']) !!}</p>
							</td>
							<td class="action" data-title="Remove"><a href="{{route('wishlist-delete',$wishlist->id)}}"><i class="ti-trash remove-icon"></i></a></td>
						</tr>

						<track>
						<td></td>
						<td></td>
						<td></td>
						<td class="float-right">
							<a href="{{route('add-to-cart',$wishlist->aset['slug'])}}" class='btn text-white'>Tambah ke keranjang</a>
						</td>
						</track>
						@endforeach
						@else
						<tr>
							<td class="text-center">
								There are no any wishlist available. <a href="{{route('aset-grids')}}" style="color:blue;">Continue shopping</a>

							</td>
						</tr>
						@endif


					</tbody>
				</table>
				<!--/ End Pinjam -->
			</div>
		</div>
	</div>
</div>
<!--/ End Pinjaman -->

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endpush