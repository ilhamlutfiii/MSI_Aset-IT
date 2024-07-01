@extends('frontend.layouts.master')

@section('title','MSI || Pinjam Track Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Pinjam Track</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
<section class="tracking_box_area section_gap py-5">
    <div class="container">
        <div class="tracking_box_inner">
            <p>To track your pinjam please enter your Pinjam ID in the box below and press the "Track" button. This was given
                to you on your receipt and in the confirmation email you should have received.</p>
            <form class="row tracking_form my-4" action="{{route('aset.track.pinjam')}}" method="post" novalidate="novalidate">
              @csrf
                <div class="col-md-8 form-group">
                    <input type="text" class="form-control p-2"  name="pinjam_number" placeholder="Enter your pinjam number">
                </div>
                <div class="col-md-8 form-group">
                    <button type="submit" value="submit" class="btn submit_btn">Track pinjam</button>
                </div>
            </form>
        </div>
    </div>

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
                            <th class="text-center">JUMLAH</th>
                            <th class="text-center">HAPUS</th>
                        </tr>
                    </thead>
                    <tbody id="cart_item_list">
                        <form action="{{route('cart.update')}}" method="POST">
                            @csrf
                            @if(Helper::getAllasetFromCart())
                                @foreach(Helper::getAllasetFromCart() as $key=>$cart)
                                    <tr>
                                        @php
                                        $photo=explode(',',$cart->aset['photo']);
                                        @endphp
                                        <td class="image" data-title="No"><img src="{{$photo[0]}}" alt="{{$photo[0]}}"></td>
                                        <td class="aset-des" data-title="Description">
                                            <p class="aset-name"><a href="{{route('aset-detail',$cart->aset['slug'])}}"  >{{$cart->aset['title']}}</a></p>
                                            <p class="aset-des">{!!($cart['summary']) !!}</p>
                                        </td>
                                        <td class="qty" data-title="Qty">
                                            <!-- Input pinjam -->
                                            <div class="input-group">
                                                <div class="button minus">
                                                    <button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[{{$key}}]">
                                                        <i class="ti-minus"></i>
                                                    </button>
                                                </div>
                                                <input type="text" name="quant[{{$key}}]" class="input-number"  data-min="1" data-max="100" value="{{$cart->quantity}}">
                                                <input type="hidden" name="qty_id[]" value="{{$cart->id}}">
                                                <div class="button plus">
                                                    <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{$key}}]">
                                                        <i class="ti-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!--/ End Input pinjam -->
                                        </td>

                                        <td class="action" data-title="Remove"><a href="{{route('cart-delete',$cart->id)}}"><i class="ti-trash remove-icon"></i></a></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="float-right">
                                        <button class="btn float-right" type="submit">Update</button>
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td class="text-center" colspan="4">
                                        There are no any carts available. <a href="{{route('aset-grids')}}" style="color:blue;">Continue shopping</a>
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
                <div class="total-amount">
                    <div class="row">
                        <div class="col-lg-8 col-md-5 col-12">
                            <!-- Additional Content Here -->
                        </div>
                        <div class="col-lg-4 col-md-7 col-12">
                            <div class="right">
                                <ul>
                                    
                                </ul>
                                <div class="button5">
                                    <a href="{{route('checkout')}}" class="btn">Pinjam</a>
                                    <a href="{{route('aset-grids')}}" class="btn">Kembali ke Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ End Total -->
            </div>
        </div>
    </div>
    </div>
</section>


@endsection