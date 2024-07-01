@extends('frontend.layouts.master')
@section('title','MSI || HOME PAGE')
@section('main-content')

<!-- Start aset Area -->
<div class="aset-area section" style="background-color: #F6F7FB;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>MSI Aset IT</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="aset-info">
                    <div class="nav-main">
                        <!-- Tab Nav -->
                        <ul class="nav nav-tabs filter-tope-group" id="myTab" role="tablist">
                            @php
                            $categories=DB::table('categories')->where('status','active')->where('is_parent',1)->get();
                            @endphp
                            @if($categories)
                            <button class="btn" data-filter="*" style="border-radius:20%;">
                                Semua Aset IT
                            </button>
                            @foreach($categories as $key=>$cat)

                            <button class="btn" data-filter=".{{$cat->id}}" style="border-radius:20%;">
                                {{$cat->title}}
                            </button>
                            @endforeach
                            @endif
                        </ul>
                        <!--/ End Tab Nav -->
                    </div>


                    <div class="tab-content isotope-grid mt-5 mb-5" id="myTabContent">
                        <!-- Start Single Tab -->
                        @if($aset_lists)
                        @foreach($aset_lists as $key=>$aset)
                        @php
                        $mainStatus = DB::table('maintenances')->where('aset_id', $aset->id)->value('mainStatus');
                        @endphp
                        @if(!$mainStatus || $mainStatus != 'Diperbaiki' && $mainStatus != 'Sedang Diproses' && $mainStatus != 'Maintenance' && $mainStatus != 'Repair')
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 mt-2 isotope-item {{$aset->cat_id}}" >
                            <div class="single-aset">
                                <div class="aset-img">
                                    <a href="{{route('aset-detail',$aset->slug)}}" class="mt-2 mb-5">
                                        @php
                                        $photo=explode(',',$aset->photo);
                                        // dd($photo);
                                        @endphp
                                        <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                        

                                    </a>
                                    <div class="button-head">
                                        <div class="aset-action-2">
                                            <a title="Tambah ke keranjang" href="{{route('add-to-cart',$aset->slug)}}"><i class="ti-shopping-cart"></i> Tambah ke keranjang</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="aset-content ml-2 mb-3">
                                    <h3><a href="{{route('aset-detail',$aset->slug)}}" style="color: black;">{{$aset->title}}</a></h3>
                                    <h6><a href="{{route('aset-detail',$aset->stock)}}">Stok: {{$aset->stock}}</a></h6>
                                </div>
                            </div>
                            @endif
                        </div>

                        @endforeach


                        <!--/ End Single Tab -->
                        @endif

                        <!--/ End Single Tab -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End aset Area -->

@endsection

@push('styles')
<style>
    .btn.active {
        background-color: #007bff;
        /* Warna biru */
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $(".btn").click(function() {
            $(".btn").removeClass("active");
            $(this).addClass("active");
        });
    });
</script>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    /*==================================================================
        [ Isotope ]*/
    var $topeContainer = $('.isotope-grid');
    var $filter = $('.filter-tope-group');

    // filter items on button click
    $filter.each(function() {
        $filter.on('click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $topeContainer.isotope({
                filter: filterValue
            });
        });

    });

    // init Isotope
    $(window).on('load', function() {
        var $grid = $topeContainer.each(function() {
            $(this).isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows',
                percentPosition: true,
                animationEngine: 'best-available',
                masonry: {
                    columnWidth: '.isotope-item'
                }
            });
        });
    });

    var isotopeButton = $('.filter-tope-group button');

    $(isotopeButton).each(function() {
        $(this).on('click', function() {
            for (var i = 0; i < isotopeButton.length; i++) {
                $(isotopeButton[i]).removeClass('how-active1');
            }

            $(this).addClass('how-active1');
        });
    });
</script>
<script>
    function cancelFullScreen(el) {
        var requestMethod = el.cancelFullScreen || el.webkitCancelFullScreen || el.mozCancelFullScreen || el.exitFullscreen;
        if (requestMethod) { // cancel full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
    }

    function requestFullScreen(el) {
        // Supports most browsers and their versions.
        var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

        if (requestMethod) { // Native full screen.
            requestMethod.call(el);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
        return false
    }
</script>
@endpush