@extends('frontend.layouts.master')

@section('title','MSI || ASET IT')

@section('main-content')
<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                        <li class="active">Aset IT</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Aset Style -->
<form action="{{route('asetit.filter')}}" method="POST">
    @csrf
    <section class="aset-area asetit-sidebar asetit section" style="background-color: #F6F7FB;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="asetit-sidebar">
                        <!-- Single Widget -->
                        <ul class="navbar-nav bg-white accordion" id="accordionSidebar">
                            <div class="single-widget category">
                                <h3 class="title">Kategori</h3>
                                <ul class="category-list">
                                    @php
                                    $menu = App\Models\Category::getAllParentWithChild();
                                    @endphp
                                    @foreach($menu as $cat_info)
                                    <li class="nav-item">
                                        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#categorysCollapse{{$cat_info->id}}" aria-expanded="true" aria-controls="categorysCollapse{{$cat_info->id}}">
                                            <span>{{$cat_info->title}}</span>
                                            <span class="arrow-icon"><i class="fas fa-chevron-right"></i></span>
                                        </a>
                                        <div id="categorysCollapse{{$cat_info->id}}" class="collapse" aria-labelledby="heading{{$cat_info->id}}" data-parent="#accordionSidebar">
                                            <div class="bg-white py-2 collapse-inner rounded">
                                                @if($cat_info->child_cat->count() > 0)
                                                <ul>
                                                    @foreach($cat_info->child_cat as $sub_menu)
                                                    <li><a class="collapse-item" href="{{route('aset-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">{{$sub_menu->title}}</a></li>
                                                    @endforeach
                                                </ul>
                                                @else
                                                <a class="collapse-item" href="#">{{$cat_info->title}}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </ul>

                        <!--/ End Single Widget -->
                    </div>
                </div>
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="row">
                        <div class="col-12">
                            <!-- Top -->
                            <div class="asetit-top">
                                <div class="asetit-shorter">
                                    <div class="single-shorter">
                                        <label>Show :</label>
                                        <select class="show" name="show" onchange="this.form.submit();">
                                            <option value="">Default</option>
                                            @foreach([9, 15, 21, 30] as $val)
                                            <option value="{{$val}}" @if(!empty($_GET['show']) && $_GET['show']==$val ) selected @endif>{{$val}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="single-shorter">
                                        <label>Sort By :</label>
                                        <select class='sortBy' name='sortBy' onchange="this.form.submit();">
                                            <option value="">Default</option>
                                            <option value="title" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title' ) selected @endif>Name</option>
                                            <option value="stock" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='stock' ) selected @endif>Stock</option>
                                            <option value="category" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='category' ) selected @endif>Category</option>
                                        </select>
                                    </div>
                                </div>
                                <ul class="view-mode">
                                    <li class="active"><a href="javascript:void(0)"><i class="fa fa-th-large"></i></a></li>
                                    <li><a href="{{route('aset-lists')}}"><i class="fa fa-th-list"></i></a></li>
                                </ul>
                            </div>
                            <!--/ End Top -->
                        </div>
                    </div>
                    <div class="row">
                        @if(count($asets)>0)
                        @foreach($asets as $aset)
                        @php
                        $mainStatus = DB::table('maintenances')->where('aset_id', $aset->id)->value('mainStatus');
                        @endphp
                        @if(!$mainStatus || $mainStatus != 'Diperbaiki' && $mainStatus != 'Sedang Diproses' && $mainStatus != 'Maintenance' && $mainStatus != 'Repair')
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="single-aset">
                                <div class="aset-img">
                                    <a href="{{route('aset-detail',$aset->slug)}}" class="mt-2 mb-5">
                                        @php $photo = explode(',',$aset->photo); @endphp
                                        <img class="default-img" src="{{$photo[0]}}" alt="{{$photo[0]}}">
                                    </a>
                                    <div class="button-head">
                                        <!-- <div class="aset-action">
                                            <a title="Wishlist" href="{{route('add-to-wishlist',$aset->slug)}}" class="wishlist" data-id="{{$aset->id}}" style="margin-right: 10px;">
                                                <i class="ti-heart"></i><span>Tambah ke Wishlist</span></a>
                                        </div> -->
                                        <div class="aset-action-2">
                                            <a title="Tambah ke Keranjang" href="{{route('add-to-cart',$aset->slug)}}">Tambah ke keranjang</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="aset-content">
                                    <h3><a href="{{route('aset-detail',$aset->slug)}}">{{$aset->title}}</a></h3>
                                    <h6>Stok: {{$aset->stock}}</h6>
                                </div>
                            </div>
                        </div>
                        @else
                        <h4 class="text-warning" style="margin:100px auto;">Aset Sedang Dimaintenance.</h4>
                        @endif
                        @endforeach
                        @else
                        <h4 class="text-warning" style="margin:100px auto;">Tidak Ada Aset.</h4>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12 justify-content-center d-flex">
                            <ul class="pagination justify-content-end">
                                <li class="page-item {{ $asets->previousPageUrl() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $asets->previousPageUrl() ?? '#' }}" rel="prev">Previous</a>
                                </li>

                                @for ($i = 1; $i <= $asets->lastPage(); $i++)
                                    <li class="page-item {{ ($i == $asets->currentPage()) ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $asets->url($i) }}">{{ $i }}</a>
                                    </li>
                                    @endfor

                                    <li class="page-item {{ $asets->nextPageUrl() ? '' : 'disabled' }}">
                                        <a class="page-link" href="{{ $asets->nextPageUrl() ?? '#' }}" rel="next">Next</a>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
<!--/ End Aset Style -->

@endsection

@push('styles')
<style>
    .pagination {
        display: inline-flex;
    }

    .collapse-item {
        padding: .5rem 1rem;
        margin: 0 .5rem;
        display: block;
        color: #3a3b45;
        text-decoration: none;
        border-radius: .35rem;
        white-space: nowrap;
    }

    .collapse-item:hover {
        background-color: #eaecf4
    }

    collapse-item:active {
        background-color: #dddfeb;
        color: #4e73df;
        font-weight: 700;
    }

    .arrow-icon {
        float: right;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.nav-link').click(function() {
            var $icon = $(this).find('.arrow-icon i');
            if ($(this).hasClass('collapsed')) {
                $icon.removeClass('fas fa-chevron-right').addClass('fas fa-chevron-down');
            } else {
                $icon.removeClass('fas fa-chevron-down').addClass('fas fa-chevron-right');
            }
        });
    });
</script>
@endpush