@extends('frontend.layouts.master')

@section('meta')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name='copyright' content=''>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
@endsection
@section('title','MSI || Aset DETAIL')
@section('main-content')

<!-- Breadcrumbs -->
<div class="breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="bread-inner">
					<ul class="bread-list">
						<li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
						<li class="active"><a href="">Aset Details</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Breadcrumbs -->

<!-- Shop Single -->
<section class="asetit single section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="row">
					<div class="col-lg-6 col-12">
						<!-- aset Slider -->
						<div class="aset-gallery">
							<!-- Images slider -->
							<div class="flexslider-thumbnails">
								<ul class="slides">
									@php
									$photo=explode(',',$aset_detail->photo);
									// dd($photo);
									@endphp
									@foreach($photo as $data)
									<li data-thumb="{{$data}}" rel="adjustX:10, adjustY:">
										<img src="{{$data}}" alt="{{$data}}">
									</li>
									@endforeach
								</ul>
							</div>
							<!-- End Images slider -->
						</div>
						<!-- End aset slider -->
					</div>
					<div class="col-lg-6 col-12">
						<div class="aset-des">
							<!-- Description -->
							<div class="short">
								<h4>{{$aset_detail->title}}</h4>
								<div class="rating-main">
									<ul class="rating">
										@php
										$rate=ceil($aset_detail->getReview->avg('rate'))
										@endphp
										@for($i=1; $i<=5; $i++) @if($rate>=$i)
											<li><i class="fa fa-star"></i></li>
											@else
											<li><i class="fa fa-star-o"></i></li>
											@endif
											@endfor
									</ul>
									<a href="#" class="total-review">({{$aset_detail['getReview']->count()}}) Review</a>
								</div>

								<p class="description">{!!($aset_detail->summary)!!}</p>
							</div>
							<!--/ End Description -->

							<!-- aset -->
							<div class="aset-buy">
								<form action="{{route('single-add-to-cart')}}" method="POST">
									@csrf
									<div class="add-to-cart mt-4">
										<button type="submit" class="btn">Tambahkan Ke Keranjang</button>
										<!-- <a href="{{route('add-to-wishlist',$aset_detail->slug)}}" class="btn min"><i class="ti-heart"></i></a> -->
									</div>
								</form>

								<p class="cat">Kategori :<a href="{{route('aset-cat',$aset_detail->cat_info['slug'])}}">{{$aset_detail->cat_info['title']}}</a></p>
								@if($aset_detail->sub_cat_info)
								<p class="cat mt-1">Sub-Kategori :<a href="{{route('aset-sub-cat',[$aset_detail->cat_info['slug'],$aset_detail->sub_cat_info['slug']])}}">{{$aset_detail->sub_cat_info['title']}}</a></p>
								@endif
								<p class="availability">Stok : @if($aset_detail->stock>0)<span class="badge badge-success">{{$aset_detail->stock}}</span>@else <span class="badge badge-danger">{{$aset_detail->stock}}</span> @endif</p>
							</div>
							<!--/ End aset Buy -->
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="aset-info">
							<div class="nav-main">
								<!-- Tab Nav -->
								<ul class="nav nav-tabs" id="myTab" role="tablist">
									<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#description" role="tab">Deskripsi</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Review</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#logs" role="tab">History Maintenance</a></li>
								</ul>
								<!--/ End Tab Nav -->
							</div>
							<div class="tab-content" id="myTabContent">
								<!-- Description Tab -->
								<div class="tab-pane fade show active" id="description" role="tabpanel">
									<div class="tab-single">
										<div class="row">
											<div class="col-12">
												<div class="single-des">
													<p>{!! ($aset_detail->description) !!}</p>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!--/ End Description Tab -->
								<!-- Reviews Tab -->
								<div class="tab-pane fade" id="reviews" role="tabpanel">
									<div class="tab-single review-panel">
										<div class="row">
											<div class="col-12">

												<!-- Review -->

												<div class="ratting-main">
													<div class="avg-ratting">
														<h4>{{ceil($aset_detail->getReview->avg('rate'))}} <span>(Rata-Rata Bintang)</span></h4>
														<span>Berdasarkan {{$aset_detail->getReview->count()}} Komentar</span>
													</div>
													@foreach($aset_detail['getReview'] as $data)
													<!-- Single Rating -->
													<div class="single-rating">
														<div class="rating-author">
															@if($data->user_info['photo'])
															<img src="{{$data->user_info['photo']}}" alt="{{$data->user_info['photo']}}">
															@else
															<img src="{{asset('backend/img/avatar.png')}}" alt="Profile.jpg">
															@endif
														</div>
														<div class="rating-des">
															<h6>{{$data->user_info['user_nama']}}</h6>
															<div class="ratings">

																<ul class="rating">
																	@for($i=1; $i<=5; $i++) @if($data->rate>=$i)
																		<li><i class="fa fa-star"></i></li>
																		@else
																		<li><i class="fa fa-star-o"></i></li>
																		@endif
																		@endfor
																</ul>
																<div class="rate-count">(<span>{{$data->rate}}</span> Bintang)</div>
															</div>
															<p>{{$data->review}}</p>
														</div>
													</div>
													<!--/ End Single Rating -->
													@endforeach
												</div>

												<!--/ End Review -->

											</div>
										</div>
									</div>
								</div>
								<!--/ End Reviews Tab -->

								<!-- Logs Tab -->
								<div class="tab-pane fade" id="logs" role="tabpanel">
									<div class="tab-single log-panel">
										<div class="row">
											<div class="col-12">

												<!-- Logs -->
												<div class="comment-review">
													<div class="ratting-main">
														<div class="avg-ratting">
															<span>
																<h4> {{$aset_detail->getMainLog->count()}} History Maintenance</h4>
															</span>
														</div>
														@foreach($aset_detail['getMainLog'] as $data)
														<!-- History -->
														<div class="single-rating">
															<div class="log-author">
																@if($data->mainPhoto)
																<img src="{{ asset('mainPhoto/' . $data->mainPhoto) }}" class="img-fluid zoom" alt="{{$data->mainPhoto}}">
																@else
																<img src="{{asset('backend/img/avatar.png')}}" alt="Profile.jpg">
																@endif
															</div>
															<div class="log-des">
																<h6>{{$data->ket_main}}</h6>
																<br>
																<p>{{$data->created_at}}</p>
															</div>
														</div>
														<!--/ End History -->
														@endforeach
													</div>

													<!--/ End Logs -->

												</div>
											</div>
										</div>
									</div>
									<!--/ End Logs Tab -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</section>
<!--/ End Shop Single -->

<!-- Start Related -->
<div class="aset-area most-popular related-aset section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title">
					<h2>Aset yang serupa</h2>
				</div>
			</div>
		</div>
		<div class="row">
			{{-- {{$aset_detail->rel_prods}} --}}

			<div class="col-12">
				<div class="owl-carousel popular-slider">
					@foreach($aset_detail->rel_prods as $data)
					@if($data->id !==$aset_detail->id)
					@php
					$mainStatus = DB::table('maintenances')->where('aset_id', $data->id)->value('mainStatus');
					@endphp
					@if(!$mainStatus || $mainStatus != 'Diperbaiki' && $mainStatus != 'Sedang Diproses' && $mainStatus != 'Maintenance' && $mainStatus != 'Repair')

					<!-- Start Single aset -->
					<div class="single-aset">
						<div class="aset-img">
							<a href="{{route('aset-detail',$data->slug)}}">
								@php
								$photo=explode(',',$data->photo);
								@endphp
								<img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
								<img class="hover-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">

							</a>
							<div class="button-head">
								<div class="aset-action">
									<a data-toggle="modal" data-target="#modelExample" title="Quick View" href="#"><i class=" ti-eye"></i><span>Quick Pinjam</span></a>
									<!-- <a title="Wishlist" href="#"><i class=" ti-heart "></i><span>Tambahkan Ke Wishlist</span></a> -->
								</div>
								<div class="aset-action-2">
									<a title="Tambahkan Ke Keranjang" href="#">Tambahkan Ke Keranjang</a>
								</div>
							</div>
						</div>
						<div class="aset-content">
							<h3><a href="{{route('aset-detail',$data->slug)}}">{{$data->title}}</a></h3>
						</div>
					</div>
					<!-- End Single aset -->
					@endif
					@endif
					@endforeach
				</div>
			</div>

		</div>
	</div>
</div>
<!-- End Most Popular Area -->

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

{{-- <script>
        $('.cart').click(function(){
            var quantity=$('#quantity').val();
            var pro_id=$(this).data('id');
            // alert(quantity);
            $.ajax({
                url:"{{route('add-to-cart')}}",
type:"POST",
data:{
_token:"{{csrf_token()}}",
quantity:quantity,
pro_id:pro_id
},
success:function(response){
console.log(response);
if(typeof(response)!='object'){
response=$.parseJSON(response);
}
if(response.status){
swal('success',response.msg,'success').then(function(){
document.location.href=document.location.href;
});
}
else{
swal('error',response.msg,'error').then(function(){
document.location.href=document.location.href;
});
}
}
})
});
</script> --}}

@endpush