@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Edit Delivery Center
@endsection

<!--Page Header-->
@section('page-header')
    Edit Delivery Center

@endsection

<!--Page Content Start Here-->
@section('page-content')

    <!--Calling Controller here-->
    <div class="row" style="margin-left: 0px !important;margin-right: 0px !important; padding-top: 0px;padding-left:20px; padding-bottom: 20px">
        <div class="col-md-12">
            <div class="row" style="padding: 10px;margin-right: 0px;margin-left: 0px;">
                <div class="col-md-6">
                    @if (Session::has('message'))
                        <div class="alert {{ Session::get('msgType') }}">{{ Session::get('message') }}</div>
                    @endif
                </div>
            </div>
            <div class="row main_part">
                @if(isset($readyEditData))
                    <div class="col-md-12">
                        <div class="edit-receive-pass-area">
                            <form action="{{URL::to('delivery-center/edit-store')}}" method="post" class="">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="contactNoId">Passport No.</label>
                                            <input type="text" name="DelFinalBy" value="{{@$readyEditData->Passport}}" id="contactNoId" class="form-control" disabled="disabled">
                                        </div>
                                        <div class="form-group">
                                            <label for="contactNoId">Received By:</label>
                                            <input type="text" name="DelFinalBy" value="{{@$readyEditData->DelFinalBy}}" id="contactNoId" class="form-control" disabled="disabled">
                                        </div>
                                        <div class="form-group">
                                            <label for="serviceDateId">Received Date:</label>
                                            <input type="text" name="DelFinaltime" value="{{Date('d-m-Y',strtotime(@$readyEditData->DelFinaltime))}}"  class="form-control datepicker" disabled="disabled">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <a  onclick="return confirm('Are you sure! Do you want to Delete?')" href="{{URL::to('delivery-center/edit-destroy').'/'.$readyEditData->WebFile_no}}" name="delete" value="Delete" class="btn btn-danger">Delete</a> &nbsp;<a
                                                href="{{URL::to('/edit-delivery-center')}}" class="btn btn-info">Cancel</a>
                                        <p></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif(isset($status))
                    <h3 class="text-center">{{$status}}</h3>
                    <p class="text-center"><a href="{{URL::to('/edit-delivery-center')}}" class="btn btn-primary">Search Again</a></p>
                @else
                    <div class="col-md-4" style="padding: 30px 30px 100px 30px">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Please Fill up the below field
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        {!! Form::open(['url' => '/edit-delivery-center','id' => 'applicant_edit_form']) !!}
                                        <div class="form-group">
                                            <label for="passDate">Select Date</label>
                                            <input type="text" name="passDate" id="passDate" value="<?php echo Date('d-m-Y'); ?>" id="tddDateId"  data-date-format="dd/mm/yyyy"  autocomplete="off" class="form-control datepicker">
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control" name="PassportNo" placeholder="Enter Passport No"
                                                   required="required">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Search</button>
                                        <button type="reset" class="btn btn-default">Reset</button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>

                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <br>
                        <a href="{{URL::to('/edit-delivery-center')}}" style="padding-left: 16px"><button type="submit" class="btn btn-outline-info"> Refresh &nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></button></a>
                    </div>
                    <div class="col-md-8"></div>

                @endif
            </div>
        </div>
    </div>



@endsection