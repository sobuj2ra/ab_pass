@extends('admin.master')
<!--Page Title-->
@section('page-title')
   Edit Passport Receive Center
@endsection

<!--Page Header-->
@section('page-header')
Edit Passport Receive Center

@endsection

<!--Page Content Start Here-->
@section('page-content')

    <!--Calling Controller here-->
    <div class="row" style="margin-left: 0px !important;margin-right: 0px !important; padding-top: 20px;padding-left:20px; padding-bottom: 20px">
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
                            <form action="{{URL::to('passport/receive/edit-store')}}" method="post" class="">
                                {{csrf_field()}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <h3>Passport Info</h3>
                                        <hr>
                                        <div class="form-group">
                                            <label for="webfileNoId">Webfile No.</label>
                                            <input type="text" name="WebFile_no" value="{{@$readyEditData->WebFile_no}}" id="webfileNoId" class="form-control">
                                            <input type="hidden" name="_id" value="{{$readyEditData->app_sl}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="passportNoId">Passport No.</label>
                                            <input type="text" name="Passport" value="{{@$readyEditData->Passport}}" id="passportNoId" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="visatypeId">Visa Type:</label>
                                            <select name="Visa_type" id="visatypeId" class="form-control">
                                                @foreach($visaTypeData as $visaItem)
                                                    <option value="{{$visaItem->visa_type}}" <?php if($readyEditData->Visa_type == $visaItem->visa_type){ echo 'selected'; }?>  >{{$visaItem->visa_type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="oldPassportId">Old Passport:</label>
                                            <input type="text" name="OldPassQty" value="{{@$readyEditData->OldPassQty}}" id="oldPassportId" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <h3>Personal Info</h3>
                                        <hr>
                                        <div class="form-group">
                                            <label for="nameId">Name: </label>
                                            <input type="text" name="Applicant_name" value="{{@$readyEditData->Applicant_name}}" id="nameId" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="contactNoId">Contact No.</label>
                                            <input type="text" name="Contact" value="{{@$readyEditData->Contact}}" id="contactNoId" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>Center Info</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="centerNameId">Center Name.</label>
                                                    <select name="center" id="centerNameId" class="form-control">
                                                        <option value="{{@$readyEditData->center}}">{{@$readyEditData->center}}</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="counterNoId">Counter No.</label>
                                                    <input type="text" name="counter" value="{{@$readyEditData->counter}}" id="counterNoId" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="tokenNoId">Token No.</label>
                                                    <input type="text" name="token" value="{{@$readyEditData->token}}" id="tokenNoId" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="RoundStickerId">Round Stiker: </label>
                                                    <input type="text" name="RoundSticker" value="{{@$readyEditData->RoundSticker}}" id="RoundStickerId" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="stikerTypeId">Stiker Type: </label>
                                                    <select name="Sticker_type" id="stikerTypeId" class="form-control">
                                                        @foreach($allSticker as $sticker)
                                                            @if($sticker->StickerSymbol == $readyEditData->Sticker_type)
                                                                <option value="{{$sticker->StickerSymbol}}" selected>{{$sticker->StickerSymbol}}</option>
                                                            @else
                                                                <option value="{{$sticker->StickerSymbol}}">{{$sticker->StickerSymbol}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="serviceDateId">Service Date:</label>
                                                    <input type="text" name="Service_Date" value="{{Date('d-m-Y',strtotime($readyEditData->Service_Date))}}" id="serviceDateId"  data-date-format="dd/mm/yyyy" autocomplete="off" class="form-control datepicker">
                                                </div>
                                                <div class="form-group">
                                                    <label for="tddDateId">TDD Date:</label>
                                                    <input type="text" name="appx_Del_Date" value="<?php  if(isset($readyEditData->appx_Del_Date)){ echo Date('d-m-Y',strtotime($readyEditData->appx_Del_Date)); } ?>" id="tddDateId"  data-date-format="dd/mm/yyyy"  autocomplete="off" class="form-control datepicker">
                                                </div>
                                                <div class="form-group">
                                                    <label for="serviceById">Service By:</label>
                                                    <select name="service_by" id="serviceById" class="form-control">
                                                        @foreach($allUsers as $user)
                                                            @if($user->user_id == $readyEditData->service_by)
                                                                <option value="{{$user->user_id}}" selected>{{$user->user_id}}</option>
                                                            @else
                                                                <option value="{{$user->user_id}}">{{$user->user_id}}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <h3>Payment Info</h3>
                                        <hr>
                                        <div class="form-group">
                                            <label for="procFeeId">Processing fee:</label>
                                            <input type="number" name="proc_fee" value="{{@$readyEditData->proc_fee}}" id="procFeeId" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="specialFeeId">Special fee.</label>
                                            <input type="number" name="sp_fee" value="{{@$readyEditData->sp_fee}}" id="specialFeeId" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="corrFee">Correction fee: </label>
                                            <input type="number" name="corrFee" value="{{@$readyEditData->corrFee}}" id="nameId" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="uCashTxnId">uCashTxn: </label>
                                            <input type="text" name="uCashtxn" value="{{@$readyEditData->uCashtxn}}" id="uCashTxnId" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="payMethodId">Pay Method: </label>
                                            <select name="Pmethod" id="payMethodId" value="" class="form-control">
                                                <option value="" <?php if($readyEditData->Pmethod == ''){ echo 'selected'; }?>  ></option>
                                                <option value="Cash/Manual" <?php if($readyEditData->Pmethod == 'Cash/Manual'){ echo 'selected'; }?> >Cash/Manual</option>
                                                <option value="ONLINE" <?php if($readyEditData->Pmethod == 'ONLINE'){ echo 'selected'; }?> >ONLINE</option>
                                                <option value="WAIVE" <?php if($readyEditData->Pmethod == 'WAIVE'){ echo 'selected'; }?>>WAIVE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <input type="submit" name="submit" value="Update" class="btn btn-primary" style="padding:6px 30px;"> <a  onclick="return confirm('Are you sure! Do you want to Delete?')" href="{{URL::to('passport/receive/edit-destroy').'/'.$readyEditData->WebFile_no}}" name="delete" value="Delete" class="btn btn-danger">Delete</a>
                                        <p></p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="col-md-4" style="padding: 30px 30px 100px 30px">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Please Fill up the below field
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        {!! Form::open(['url' => '/edit-receive-passport','id' => 'applicant_edit_form']) !!}
                                        <div class="form-group">
                                            <input class="form-control" name="webfile_no" placeholder="Enter Webfile No"
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
                        <a href="{{URL::to('/edit-receive-passport')}}" style="padding-left: 16px"><button type="submit" class="btn btn-outline-info"> Refresh &nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></button></a>
                    </div>
                    <div class="col-md-8"></div>

                @endif
            </div>
        </div>
    </div>



@endsection