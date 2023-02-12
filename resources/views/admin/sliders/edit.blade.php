@extends('admin.layout')
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> {{ trans('labels.EditSliderImage') }} <small>{{ trans('labels.EditSliderImage') }}...</small> </h1>
    <ol class="breadcrumb">
       <li><a href="{{ URL::to('admin/dashboard/this_month') }}"><i class="fa fa-dashboard"></i> {{ trans('labels.breadcrumb_dashboard') }}</a></li>
      <li><a href="{{ URL::to('admin/sliders')}}"><i class="fa fa-bars"></i> {{ trans('labels.Sliders') }}</a></li>
      <li class="active">{{ trans('labels.EditSliderImage') }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Info boxes -->

    <!-- /.row -->
    <style>
      .selectedthumbnail {
          display: block;
          margin-bottom: 10px;
          padding: 0;
      }
      .thumbnail {
          padding: 0;
      }
      .closimage{
        position: relative
      }
      </style>

    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">{{ trans('labels.EditSliderImage') }} </h3>
          </div>

          <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12">
              		<div class="box box-info">
                    <br>
                        @if (count($errors) > 0)
                              @if($errors->any())
                                <div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                  {{$errors->first()}}
                                </div>
                              @endif
                          @endif
                        <!--<div class="box-header with-border">
                          <h3 class="box-title">Edit category</h3>
                        </div>-->
                        <!-- /.box-header -->
                        <!-- form start -->
                         <div class="box-body">

                            {!! Form::open(array('url' =>'admin/updateSlide', 'method'=>'post', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) !!}

                                {!! Form::hidden('id',  $result['sliders']->sliders_id , array('class'=>'form-control', 'id'=>'id')) !!}
                                {!! Form::hidden('oldImage',  $result['sliders']->sliders_image, array('id'=>'oldImage')) !!}

                                <input type="hidden" name="languages_id" value="1">
                                <div class="form-group" hidden>
                                  <label for="name" class="col-sm-2 col-md-3 control-label" hidden>{{ trans('labels.Slider Type') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control field-validate" name="carousel_id">
                                         <option value="1" @if($result['sliders']->carousel_id == 1) selected @endif >@lang('labels.Full Screen Slider (1600x420)')</option>
                                         <!-- <option value="2" @if($result['sliders']->carousel_id == 2) selected @endif>@lang('labels.Full Page Slider (1170x420)')</option>
                                         <option value="3" @if($result['sliders']->carousel_id == 3) selected @endif>@lang('labels.Right Slider with Thumbs (770x400)') </option>
                                         <option value="4" @if($result['sliders']->carousel_id == 4) selected @endif>@lang('labels.Right Slider with Navigation (770x400)')  </option>
                                         <option value="5" @if($result['sliders']->carousel_id == 5) selected @endif>@lang('labels.Left Slider with Thumbs (770x400)')</option> -->
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">{{ trans('labels.SliderTypeText') }}</span>
                                      <span class="help-block hidden">{{ trans('labels.textRequiredFieldMessage') }}</span>
                                  </div>
                              </div>

                              <div class="form-group">
                                <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Slider Image') }}</label>
                                <div class="col-sm-10 col-md-4">
                                    {{--{!! Form::file('newImage', array('id'=>'newImage')) !!}--}}
                                    <!-- Modal -->
                                        <div class="modal fade embed-images" id="Modalmanufactured" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" id ="closemodal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        <h3 class="modal-title text-primary" id="myModalLabel">{{ trans('labels.Choose Slider Image') }} </h3>
                                                    </div>
                                                    <div class="modal-body manufacturer-image-embed">
                                                        @if(isset($allimage))
                                                            <select class="image-picker show-html " name="image_id" id="select_img">
                                                                <option  value=""></option>
                                                                @foreach($allimage as $key=>$image)
                                                                    <option data-img-src="{{asset($image->path)}}"  class="imagedetail" data-img-alt="{{$key}}" value="{{$image->id}}"> {{$image->id}} </option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                      <a href="{{url('admin/media/add')}}" target="_blank" class="btn btn-primary pull-left" >{{ trans('labels.Slider Image') }}</a>
                                                      <button type="button" class="btn btn-default refresh-image"><i class="fa fa-refresh"></i></button>
                                                      <button type="button" class="btn btn-success" id="selectedICONE" data-dismiss="modal">{{ trans('labels.Done') }}</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div id ="imageselected">
                                            {!! Form::button(trans('labels.Add Image'), array('id'=>'newImage','class'=>"btn btn-primary", 'data-toggle'=>"modal", 'data-target'=>"#Modalmanufactured" )) !!}

                                            <div id="selectedthumbnailIcon" style="display:none" class="selectedthumbnail col-md-12"> </div>
                                            <div class="closimage">
                                                <button type="button" class="close pull-left image-close " id="image-Icone"
                                                style="display:none; position: absolute;left: -3px !important;top: 15px !important;background-color: black;color: white;opacity: 2.2;" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                        </div>

                                        <br>
                                        <div>
                                        <img width="200px" src="{{asset($result['sliders']->path)}}">
                                        </div>
                                </div>
                            </div>

                                {{-- <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.SliderNavigation') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="type" id="bannerType">
                                          <option value="category" @if($result['sliders']->type=='category') selected @endif>
                                          {{ trans('labels.Category') }}</option>
                                          <option value="product" @if($result['sliders']->type=='product') selected @endif>{{ trans('labels.Product') }}</option>
                                          <!-- <option value="topseller" @if($result['sliders']->type=='topseller') selected @endif>{{ trans('labels.TopSeller') }}</option>
                                          <option value="special" @if($result['sliders']->type=='special') selected @endif>{{ trans('labels.Deals') }}</option>
                                          <option value="mostliked" @if($result['sliders']->type=='mostliked') selected @endif>{{ trans('labels.MostLiked') }}</option> -->
                                      </select>
                                       <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.SliderNavigationText') }}</span>
                                  </div>
                                </div> --}}


                                {{-- <div class="form-group categoryContent" @if($result['sliders']->type!='category') style="display: none" @endif >
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Categories') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="categories_id" id="categories_id">
                                      @foreach($result['categories'] as $category)
                                		<option value="{{ $category->id}}" <?php if($result['sliders']->type=='category'){if($result['sliders']->sliders_url==$category->id){echo "selected";}} ?> >{{ $category->name}}</option>
                                      @endforeach
                                      </select>
                                      <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.CategoriessliderText') }}</span>
                                  </div>
                                </div> --}}

                                {{-- <div class="form-group productContent" @if($result['sliders']->type!='product') style="display: none" @endif>
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Products') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control select2" name="products_id" id="products_id">
                                      @foreach($result['products'] as $products_data)
                                		<option value="{{ $products_data->products_id }}" <?php if($result['sliders']->type=='product'){if($result['sliders']->sliders_url==$products_data->products_id){echo "selected";}} ?> >{{ $products_data->products_name }}</option>
                                      @endforeach
                                      </select>
                                     <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.ProductsSliderText') }}</span>
                                  </div>
                                </div> --}}


                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">Slider Title</label>
                                  <div class="col-sm-10 col-md-4">
                                    <input class="form-control field-validate" type="text" name="slider_title" value="{{ $result['sliders']->slider_title }}">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    Please enter Slider Title</span>
                                  </div>
                                </div>

                                {{-- <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">Slider Content</label>
                                  <div class="col-sm-10 col-md-4">
                                    <input class="form-control field-validate" type="text" name="slider_content" value="{{ $result['sliders']->slider_content }}">
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    Please enter Slider Content</span>
                                  </div>
                                </div> --}}

                                <div class="form-group">
                                  <label for="name" class="col-sm-2 col-md-3 control-label">Slider Description</label>
                                  <div class="col-sm-10 col-md-8">
                                    <textarea id="description" name="slider_content_dec" rows="4" cols="50">{{stripslashes( $result['sliders']->slider_content_dec)}}</textarea>
                                    {{-- <input class="form-control field-validate" type="text" name="slider_content_dec" value="{{ $result['sliders']->slider_content_dec }}"> --}}
                                    <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                    Please enter Content Description</span>
                                  </div>
                                </div>

                                <div class="form-group" hidden>
                                  <label for="name" class="col-sm-2 col-md-3 control-label">{{ trans('labels.Status') }}</label>
                                  <div class="col-sm-10 col-md-4">
                                      <select class="form-control" name="status">
                                          <option value="1" @if($result['sliders']->status==1) selected @endif>{{ trans('labels.Active') }}</option>
                                          <option value="0" @if($result['sliders']->status==0) selected @endif>{{ trans('labels.Inactive') }}</option>
                                      </select>
                                     <span class="help-block" style="font-weight: normal;font-size: 11px;margin-bottom: 0;">
                                      {{ trans('labels.StatusSliderText') }}</span>
                                  </div>
                                </div>


                              <!-- /.box-body -->
                              <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('labels.Submit') }}</button>
                                <a href="{{ URL::to('admin/sliders')}}" type="button" class="btn btn-default">{{ trans('labels.back') }}</a>
                              </div>
                              <!-- /.box-footer -->
                            {!! Form::close() !!}
                        </div>
                  </div>
              </div>
            </div>

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<script src="{!! asset('admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}"></script>
<script type="text/javascript">
    $(function () {

        CKEDITOR.replace('description');

    });
</script>
@endsection

