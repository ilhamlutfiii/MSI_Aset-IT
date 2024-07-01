@extends('user.layouts.master')

@section('title','Review Edit')

@section('main-content')
<div class="card shadow mb-4 mr-2 ml-2">
  <h5 class="card-header">Review Edit</h5>
  <div class="card-body">
    <form action="{{route('user.asetreview.update',$review->id)}}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="name">Review By:</label>
            <input type="text" disabled class="form-control" value="{{$review->user_info['user_nama']}}">
          </div>

          <div class="form-group">
            <label for="rate">Rate:</label><br>
            <div class="rating_box">
              <div class="star-rating">
                <div class="star-rating__wrap">
                  <input class="star-rating__input" id="star-rating-5" type="radio" name="rate" value="5" {{(($review->rate == 5) ? 'checked' : '')}}>
                  <label class="star-rating__ico fa fa-star" for="star-rating-5" title="5 out of 5 stars"></label>
                  <input class="star-rating__input" id="star-rating-4" type="radio" name="rate" value="4" {{(($review->rate == 4) ? 'checked' : '')}}>
                  <label class="star-rating__ico fa fa-star" for="star-rating-4" title="4 out of 4 stars"></label>
                  <input class="star-rating__input" id="star-rating-3" type="radio" name="rate" value="3" {{(($review->rate == 3) ? 'checked' : '')}}>
                  <label class="star-rating__ico fa fa-star" for="star-rating-3" title="3 out of 3 stars"></label>
                  <input class="star-rating__input" id="star-rating-2" type="radio" name="rate" value="2" {{(($review->rate == 2) ? 'checked' : '')}}>
                  <label class="star-rating__ico fa fa-star" for="star-rating-2" title="2 out of 2 stars"></label>
                  <input class="star-rating__input" id="star-rating-1" type="radio" name="rate" value="1" {{(($review->rate == 1) ? 'checked' : '')}}>
                  <label class="star-rating__ico fa fa-star" for="star-rating-1" title="1 out of 1 stars"></label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="inputPhoto" class="col-form-label">Foto <span class="text-danger">*</span></label>
            <div><img id="preview" src="{{ asset('photoStatus/' . $review->pinjams->photoStatus) }}" alt="Preview Image" style="max-width: 200px;"></div>
            <div class="input-group mt-2">
              <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary" style="color: white;">
                  <i class="fa fa-image"></i> Ganti
                </a>
              </span>
              <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$review->pinjams->photoStatus}}">
            </div>
            <div id="holder" style="margin-top:15px;max-height:100px;"></div>
            
            @error('photo')
            <span class="text-danger">{{$message}}</span>
            @enderror
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label for="review">Review</label>
            <textarea name="review" id="" cols="20" rows="10" class="form-control">{{$review->review}}</textarea>
          </div>
          <div class="form-group">
            <label for="status">Status :</label>
            <select name="status" id="" class="form-control">
              <option value="">--Select Status--</option>
              <option value="active" {{(($review->status=='active')? 'selected' : '')}}>Active</option>
              <option value="inactive" {{(($review->status=='inactive')? 'selected' : '')}}>Inactive</option>
            </select>
          </div>
        </div>
      </div>
      <div class="form-group mb-3 text-center">
      <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>
@endsection

@push('styles')
<style>
  .order-info,
  .shipping-info {
    background: #ECECEC;
    padding: 20px;
  }

  .order-info h4,
  .shipping-info h4 {
    text-decoration: underline;
  }

  /* Rating */
  .rating_box {
    display: inline-flex;
  }

  .star-rating {
    font-size: 0;
    padding-left: 10px;
    padding-right: 10px;
  }

  .star-rating__wrap {
    display: inline-block;
    font-size: 1rem;
  }

  .star-rating__wrap:after {
    content: "";
    display: table;
    clear: both;
  }

  .star-rating__ico {
    float: right;
    padding-left: 2px;
    cursor: pointer;
    color: #aaa;
    font-size: 16px;
    margin-top: 5px;
  }

  .star-rating__ico:last-child {
    padding-left: 0;
  }

  .star-rating__input {
    display: none;
  }

  .star-rating__ico:hover:before,
  .star-rating__ico:hover~.star-rating__ico:before,
  .star-rating__input:checked~.star-rating__ico:before,
  .star-rating__input:checked~.star-rating__ico:hover:before {
    content: "\F005";
    color: #F7941D;
    /* Warna kuning */
  }

  .custom-file-upload {
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #f8f9fa;
  }

  .custom-file-upload:hover {
    background-color: #e9ecef;
  }

  .custom-file-upload input[type="file"] {
    display: none;
  }
</style>
@endpush