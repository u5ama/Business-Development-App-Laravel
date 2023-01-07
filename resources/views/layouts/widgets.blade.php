@extends('index')

@section('pageTitle', 'Widgets')

@section('content')

<div class="app-content widgets-list">
    <div class="side-app">
        <div class="main-content">
            <div class="p-2 d-block d-sm-none navbar-sm-search">
                <!-- Form -->
                <form class="navbar-search navbar-search-dark form-inline ml-lg-auto">
                    <div class="form-group mb-0">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div><input class="form-control" placeholder="Search" type="text">
                        </div>
                    </div>
                </form>
            </div>

            <div class="container-fluid pt-30px">
                @include('partials.topnavbar')

                <div class="row">
                    <div class="col-sm-12">
                        <div class="d-flex mb-30" style="align-items: baseline;" id="res-box">
                            <div class="d-flex" style="align-items: baseline">
                                <h1 class="m-0">Widgets</h1> <span class="text-muted text-nowrap">&nbsp; <span
                                        id="total_widgets">0</span> Total</span>
                            </div>
                            <div class="side-input-box">

                                <div class="form-group mr-2 mb-0 hide">
                                    <button id="delete_widgets_button" class="btn btn-default header-info-btn hide">
                                        <i class="fas fa-trash-alt" aria-hidden="true" style="font-size: 18px;"></i>
                                    </button>
                                </div>

                                <div class="form-group d-inline-block mr-2 mb-0">
                                    <div class="widget-search">
                                        
                                        <input id="searchRecords" type="text" class="search-user"
                                            placeholder="Search Widget">
                                    </div>
                                </div>

                            <a href="{{ route('createWidget') }}" class="btn btn-green text-white" style="padding: 7px 15px;">
                                    <i class="fas fa-plus"></i>
                                    Add Widgets</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <div class="card shadow">

                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table id="widgets-list"
                                        class="custom-table table text-nowrap widget-view-table"
                                        style="border: none;">
                                        <thead>
                                            <tr>
                                                <th>

                                                </th>
                                                <th>
                                                    <span>Name</span>
                                                </th>
                                                <th>
                                                    <span>Type</span>
                                                </th>
                                                <th>
                                                    <span>Code</span>
                                                </th>
                                                <th>
                                                    <span>Created Date</span>
                                                </th>
                                                <th>
                                                    <span>Actions</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('partials.footer')
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#showEmbedCodeModal">
    Launch demo modal
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="showEmbedCodeModal" tabindex="-1" role="dialog" aria-labelledby="showEmbedCodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="showEmbedCodeModalLabel" class="font-weight-bold">Embeded Code</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <textarea  id="showEmbedCodeTextarea" class="form-control" cols="30" rows="5"></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" onclick="copyClipBoard()" class="btn btn-primary">Copy Embed Code</button>
        </div>
      </div>
    </div>
  </div>
@endsection


@section('css')
<style>
    /*#countryCodesList{*/
    /*opacity: 1;*/
    /*}*/
    .bootstrap-select.btn-group.disabled,
    .bootstrap-select.btn-group>.disabled {
        cursor: default;
    }
    .bootstrap-select.disabled button.disabled{
        background-color: #ffffff;
        cursor: default;
    }
    .bootstrap-select .filter-option{
        font-weight: 600;
    }
    .bootstrap-select.disabled .filter-option{
        font-weight: 700;
    }

    /*.btn-default:hover,*/
    /*.btn-default.disabled:hover,*/
    /*.btn-default:focus,*/
    /*.btn-default.disabled:focus,*/
    /*.btn-default.focus,*/
    /*.btn-default.disabled.focus {*/
    /*opacity: 1;*/
    /*border: 1px solid #e4e7ea;*/
    /*background: #ffffff;*/
    /*}*/
</style>
<style>
    .widget-search {
    padding: 7px;
    border-radius: 5px;
    border: none;
    background: #fff;
    outline: none;
    box-shadow: none;
    position: relative;
    display: inline-block;
}
.widget-search input {
    border: none;
    background-color: transparent;
    outline: none;
    box-shadow: none;
    padding-left: 25px;
}
</style>

<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/scroller/2.0.0/css/scroller.dataTables.min.css" />
<link type="text/css" rel="stylesheet" href="{{ asset('public/plugins/toastr/toastr.min.css') }}">
<link type="text/css" rel="stylesheet" href="{{ asset('public/css/widgets/widgets.css?ver='.$appFileVersion) }}" />
@endsection

@section('js')

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="{{ asset('public/plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/tableHeadFixer.js?ver='.$appFileVersion) }}"></script>
<script type="text/javascript" src="{{ asset('public/js/widgets/widgets.js?ver='.$appFileVersion) }}"></script>

@endsection
