@extends('admin.master')
<!--Page Title-->
@section('page-title')
    Counter
@endsection

<!--Page Header-->
@section('page-header')
    @if(isset($counter_no) && $counter_no > 0)
        <div id="page-header">
            Counter: <span class="bold_text">{{$counter_no}}</span> &nbsp;&nbsp;&nbsp; Floor No: <span class="bold_text">{{$floor_id}}</span> &nbsp;&nbsp;&nbsp; User ID: <span class="bold_text" >{{$user_id}}</span> &nbsp;&nbsp;&nbsp; Center: <span class="bold_text" >{{@$center_name->center_name}}</span> &nbsp;&nbsp;&nbsp; Service Fee: <span class="bold_text" >{{$ivac_svc_fee->Svc_Fee}}Tk</span> <span class="time float-right ">Time: <span class="bold_text">@{{ time }}</span></span></p>

        <!-- <p class="date">@{{ date }}</p> -->


        </div>
        <script>
            var clock = new Vue({
                el: '#page-header',
                data: {
                    time: '',
                    date: ''
                }
            });
            var week = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
            var timerID = setInterval(updateTime, 1000);
            updateTime();
            function updateTime() {
                var cd = new Date();
                clock.time = zeroPadding(cd.getHours(), 2) + ':' + zeroPadding(cd.getMinutes(), 2) + ':' + zeroPadding(cd.getSeconds(), 2);
                clock.date = zeroPadding(cd.getFullYear(), 4) + '-' + zeroPadding(cd.getMonth()+1, 2) + '-' + zeroPadding(cd.getDate(), 2) + ' ' + week[cd.getDay()];
            };

            function zeroPadding(num, digit) {
                var zero = '';
                for(var i = 0; i < digit; i++) {
                    zero += '0';
                }
                return (zero + num).slice(-digit);
            }
        </script>
    @else
        <h1 class="text-center">Opps! This Counter Not Regwebistered</h1>
    @endif

@endsection

<!--Page Content Start Here-->
@section('page-content')
    @if(isset($counter_no) && $counter_no > 0)
    <div id="app1">
        <section class="content ">
            <div class="row">
                <div class="col-md-12">
                    <div class="main_part countercall-area" >
                        <br>
                        @if(Session::has('message'))
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4 alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</div>
                            </div>
                    @endif
                    <!-- Code Here.... -->

                        <div class="row">
                            <div class="col-md-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="service_type" style="font-weight:normal">Service Type</label>
                                        <select @change="svcNameFunc($event)" name="service_type" id="service_type" class="form-control">
                                            <option value=""></option>
                                            @foreach($counter_services as $service)
                                                <option value="{{$service}}">{{$service}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input id="counter_id" type="hidden" value="{{$counter_no}}">
                                    <input id="center_name" type="hidden" value="{{$center_name->center_name}}">
                                    <input id="user_id" type="hidden" value="{{$user_id}}">
                                    <input id="curSvcFee" type="hidden" value="{{$ivac_svc_fee->Svc_Fee}}">
                                    <input id="floor_id" type="hidden" value="{{$floor_id}}">
                                </div>
                                <div class="single-datadisplaybox-left">
                                    <div @click="regularAreaCLickFunc" class="single-datadisplaybox">
                                        <p class="datadisplaybox-header regular-header">Current Q</p>
                                        <div class="regular-area datadisplaybox-regular">
                                            <li v-for="regular in regularDataList">@{{ regular.token_number }}</li>
                                        </div>
                                    </div>
                                </div>

                                <div  class="single-datadisplaybox-right">
                                    <div class="single-datadisplaybox">
                                        <button @click="sendToWaitingFunc"  class="btn btn-info">To Wait</button>
                                        <p class="datadisplaybox-header waiting-header">Waiting Q</p>
                                        <div id="waiting_list" class="waiting-area datadisplaybox-waiting">
                                            <li v-for="waiting in waitingDataList"><a @click="waitingItemClick">@{{ waiting.token_number }}</a></li>

                                        </div>
                                    </div>
                                    <div  class="single-datadisplaybox">
                                        <input @keyup.enter="sendToRecallFunc" style="width:70px" type="text" id="send_recall_id" placeholder="Press Enter">
                                        <p class="datadisplaybox-header recall-header">Recall Q</p>
                                        <div class="recall-area datadisplaybox-recall">
                                            <li v-for="recall in recallDataList"><a @click="recallItemClick">@{{ recall.token_number }}</a></li>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="calltoken-area-center">
                                    <div v-show="webfilePreloader" class="webfile-preloader"><img class="preloader" src="{{asset("public/assets/img/preloader.gif")}}" alt=""></div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="calltoken-right-content">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div style=" margin-bottom:30px;"><span  style="width:200px;display:inline-block;color:#000;font-size:25px;font-weight:300">Token No: &nbsp;<b id="selectedTokenDisplay">@{{selectedTokenval}}</b></span> &nbsp;&nbsp;&nbsp; <span style="font-size:14px;">Qty: <b >@{{selectedTokenQty}}</b></span> </div>
                                                        <div class="calltoken-sticker-area">
                                                            <table>
                                                                <tr>
                                                                    <td>Sticker Type: </td>
                                                                    <td style="width:20px">
                                                                        <select name="" id="sticker_type" class="" style="width:100px;height:26px" required>
                                                                            <option value=""> </option>
                                                                            @foreach($stickers as $sticker)
                                                                                <option value="{{$sticker->StickerSymbol}}">{{$sticker->StickerSymbol}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </td>
                                                                    <td><input v-model="stkr_str" id="sticker_no_from" type="number" style="width:65px" required autocomplete="off"> </td>
                                                                    <td> To: </td>
                                                                    <td><input v-model="stkr_end"  id="sticker_no_to" type="number"  style="width:65px" required autocomplete="off"> </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <br>
                                                        <span v-show="selectedToken">
                                                            <p v-if="passportSearch == false">WebFile: <input @keyup.enter="webfileSubmit" name="webfile" id="webfile" style="width:200px;" required autocomplete="off"></p>
                                                            <p v-show="passportSearch">Passport: <input  name="PassportNo2" id="PassportNo2" style="width:200px" required autocomplete="off"></p>
                                                        </span>
                                                        <br>
                                                        <div  class="webfile-bottom-area">
                                                            <div class="webfile-success-area">
                                                                <span v-show="selectedToken">
                                                                    <p v-bind:style="{position:styleRelative,zIndex:styleIndex}" >Webfile: <input @keyup.enter="webfileSubmit2" v-model="webfile2Value" name="webfile2" id="webfileNo2" style="width:200px;background:#ffff87" required autocomplete="off"></p>
                                                                </span>
                                                                <div v-show="webfileData">
                                                                    <p v-if="passportSearch == false">Passport: <input name="passport" id="passportNo" style="width:200px" required autocomplete="off"> &nbsp; <span id="passport_show"></span> <span id="old-passport" style="float:right">Old Pass: <input type="number" id="old_pass" name="old_pass" style="width:70px" autocomplete="off"></span></p>
                                                                    <p v-if="passportSearch == false">Name: <input name="cust_name" id="name" style="width:200px" required  autocomplete="off"></p>
                                                                    <div class="col-md-8">
                                                                        <p v-if="passportSearch == false">Visa Type:
                                                                            <select @change="visaTypeOnChange" name="visa_type" id="visa_type" style="width:200px;height:26px" required>
                                                                                <option value=""> </option>
                                                                                @foreach($visa_types as $visa_type)
                                                                                    <option value="{{$visa_type->visa_type}}">{{$visa_type->visa_type}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </p>
                                                                        <p v-if="passportSearch == false">Contact: <input type="number" name="contact" id="contact" style="width:200px" required  autocomplete="off"></p>
                                                                        <p v-if="passportSearch == false" >Pay Type: <select name="paytype" id="paytype" style="width:100px;height:26px" >
                                                                                <option value=""></option>
                                                                            </select>
                                                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <button @click="rejectBtnFunc" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">Reject</button>
                                                                        </p>


                                                                        <!-- Modal -->
                                                                        <div v-show="rejectModalShow" class="custom-modal-area">
                                                                            <div class="custom-modal">
                                                                                <div class="custom-modal-header">
                                                                                    <p>SELECT REJECT CAUSES</p>
                                                                                </div>
                                                                                <div class="custom-modal-body">
                                                                                    <div  class="reject-cause-area">
                                                                                        <p><input id="reject-select-all" @click="selectRejectAllFunc" v-model="selectRejectAll" type="checkbox"> <label for="reject-select-all">SELECT ALL</label></p>
                                                                                        <div class="reject-box">
                                                                                            <p v-for="item in rejectCauseData"><input :id="item.Sl"  type="checkbox" v-model="rejectItem" :value="item.reason"> <label :for="item.Sl">@{{ item.reason }}</label></p>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="custom-modal-footer">
                                                                                    <button @click="rejectSubmitFunc" class="btn btn-danger float-left">Reject</button>
                                                                                    <button @click="rejectModalShow = !rejectModalShow" class="btn btn-warning float-right">Cancel</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <p v-if="passportSearch == false" >Proc Fee: <b><input id="proc_fee" class="inputBtnStyleNon" type="button" value="0.00"  autocomplete="off"></b></p>
                                                                        <p v-if="passportSearch == false">Spfee: <input type="number" name="Spfee" id="Spfee" style="width:100px" required  autocomplete="off"><span v-if="correctionShow"  style=""> Correction fee: <b><input v-if="corItem == ''" name="" class="inputBtnStyleNon" type="button" id="corFee" value="0" width="70px"><input v-else="corItem == ''" class="inputBtnStyleNon" name="correctionfee" id="corFee" type="button" :value="correctionFee"  width="70px"></b></span>
                                                                            <input v-if="!correctionShow" id="corFee" type="hidden" value="0"></p>
                                                                        <p v-if="passportSearch == false">Sticker No: <input type="number" name="validStkr" id="validStkr" style="width:100px" required  autocomplete="off"></p>
                                                                    </div>
                                                                    <div class="col-md-4 padding-none">
                                                                        <span  style="height:10px;display: inline-block;">@{{ttdDelDate}}</span>
                                                                        <input id="ttdDelDate" type="hidden" :value="ttdDelDate">
                                                                        <br><br>
                                                                        <div v-if="webfileData" class="correction-area">
                                                                            <p><input @click="correctionShowFunc" id="correction-box" type="checkbox"> <label for="correction-box">CORRECTION</label></p>
                                                                            <div v-if="correctionShow" class="correction-box">
                                                                                <p v-for="correctionItem in correctionList"><input :id="correctionItem.Correction"  type="checkbox" v-model="corItem" :value="correctionItem.Correction"> <label :for="correctionItem.Correction">@{{ correctionItem.Correction }}</label></p>
                                                                            </div>
                                                                            <p v-if="correctionShow" ><input id="correction-all-select" @click="corrSelectAllFunc" v-model="corAllSelected" type="checkbox"> <label for="correction-all-select">SELECT ALL</label></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="webfile-not-found">
                                                                <h3 v-if="webfileDataNull" class="text-center">Opps! Data Not Found</h3>
                                                            </div>
                                                            <div class="webfile-not-found">
                                                                <h3 v-if="storeResStatus" class="text-center">@{{ storeResMsg }}</h3>
                                                                <h3 v-if="rejectResStatus" class="text-center">@{{ rejectResMsg }}</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-12">
                                                        <div class="webfile-submit-area">
                                                            <p><button v-if="submitBtn" @click="submitFunc" type="button" class="btn btn-info" data-toggle="modal" data-target="#submitModal">Submit</button> &nbsp;&nbsp;&nbsp;&nbsp;<button v-if="cleanBtn" @click="clearBtnFunc" type="button" class="btn btn-warning" style="margin-left:260px;">Clear</button></p>

                                                            <!-- Modal -->
                                                            <div v-show="submitModalShow" class="custom-modal-area">
                                                                <div class="custom-modal">
                                                                    <div class="custom-modal-header">
                                                                        <p>CHECK BEFORE THE SUBMIT</p>
                                                                    </div>
                                                                    <div class="custom-modal-body">
                                                                        <table>
                                                                            <tr v-for="vcItem in visaChecklist">
                                                                                <td><span>@{{ vcItem.parameter }}</span></td>
                                                                            </tr>
                                                                        </table>

                                                                    </div>
                                                                    <div class="custom-modal-footer">
                                                                        <button @click="DataSubmitFunc" class="btn btn-info float-left">YES</button>
                                                                        <button @click="submitModalShow = !submitModalShow" class="btn btn-warning float-right">NO</button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="col-md-12">
                                                        <div v-if="webfileData" class="sslapi-res-area">
                                                            <h4><b>@{{ sslResMessage }}</b></h4>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="calltoken-area-right">
                                    <span style=""><button class="btn btn-primary tdd-text"  data-toggle="modal" data-target="#tddModal">TDD</button> &nbsp;&nbsp;&nbsp; <span class="total-save">Total Save: <b id="total_save_count">0</b></span></span>
                                    <br><span style="margin-left:91px;" class="total-rejected total-save ">Rejected: <b id="total_reject_count">0</b></span>
                                    <!-- Modal -->
                                    <div  class="modal fade" id="tddModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel" style="display:inline-block;font-weight:bold">TDD LIST</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div  class="reject-cause-area">
                                                        <table class="table table-responsive  table-hover">
                                                            <thead>
                                                                <th>Serial</th>
                                                                <th>Delivery Date</th>
                                                                <th>Symbol</th>
                                                                <th>Visa Type</th>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($tdd_list as $tdd)
                                                                    <tr>
                                                                        <td><span>{{$loop->iteration}}</span></td>
                                                                        <td><span>{{date('Y-m-d',strtotime($tdd->tdd))}}</span><input id="{{'tdd_'.$tdd->visa_type}}" type="hidden" value="{{date('Y-m-d',strtotime($tdd->tdd))}}"></td>
                                                                        <td><span>{{$tdd->symbol}}</span></td>
                                                                        <td><span>{{$tdd->visa_type}}</span></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>

        var app = new Vue({
            el:'#app1',
            data:{
                selectedToken:true,
                svc_name:'',
                regular:true,
                stkr_str:'',
                stkr_end:'',
                regularData:'',
                regularDataList:[],
                waitingDataList:[],
                recallDataList:[],
                passType:0,
                tokenNumber:'',
                test:'',
                webfileData:false,
                webfileDataNull:false,
                webfilePreloader:false,
                passportSearch:false,
                webfileUC:'',
                webfile2Value:'',
                cleanBtn:false,
                submitBtn:false,
                correctionShow:false,
                correctionList:[],
                corAllSelected:false,
                corItem:[],
                paytypeOptions:[],
                rejectCauseData:[],
                rejectItem:[],
                selectRejectAll: false,
                sslResMessage:'',
                submitModalShow:false,
                rejectModalShow:false,
                ivac_svc_fee:0,
                ttdDelDate:'',
                correctionFee:'',
                visaChecklist:[],
                txnNumber:'',
                txnDate:'',
                storeResMsg:'',
                storeResStatus:false,
                rejectResMsg:'',
                rejectResStatus:false,
                selectedTokenval:'',
                selectedTokenQty:'',
                styleRelative:'relative',
                styleIndex:'-2',

            },
            methods: {

                svcNameFunc: function (event) {
                    this.svc_name = event.target.value;
                    this.getdataserver = true;
                    //console.log(event.target.value);
                },
                clickFunc: function (event) {
                    console.log(event);
                },
                regularAreaCLickFunc: function () {
                    _this = this;
                    var service_type = document.getElementById('service_type').value;
                    var counter_id = document.getElementById('counter_id').value;
                    var user_id = document.getElementById('user_id').value;

                    axios.get('call_token_data_axios', {
                        params: {
                            svc_name: service_type,
                            token_type: '1',
                            counter_id: counter_id,
                            user_id: user_id
                        }
                    })
                        .then(function (res) {
                            //_this.tokenNumber = res.token_res[0];
                            var obj = res.data.token_res[0];
                            const resultArray = Object.keys(obj).map(function (key) {
                                return [Number(key), obj[key]];
                            });
                            _this.selectedTokenval = resultArray[0][1];
                            _this.selectedTokenQty = resultArray[1][1];
                        })
                        .catch(function (error) {
                            console.log(error);
                        })

                },
                waitingItemClick: function () {
                    _this = this;
                    var wattkn_no = event.target;
                    wattkn_no = wattkn_no.innerHTML;
                    var service_type = document.getElementById('service_type').value;
                    var counter_id = document.getElementById('counter_id').value;
                    var user_id = document.getElementById('user_id').value;

                    axios.get('call_token_data_axios', {
                        params: {
                            svc_name: service_type,
                            token_type: '2',
                            counter_id: counter_id,
                            user_id: user_id,
                            tkn_no: wattkn_no
                        }
                    })
                        .then(function (res) {
                            var obj = res.data.token_res[0];
                            const resultArray = Object.keys(obj).map(function (key) {
                                return [Number(key), obj[key]];
                            });
                            _this.selectedTokenval = resultArray[0][1];
                            _this.selectedTokenQty = resultArray[1][1];
                        })
                        .catch(function (error) {
                            console.log(error);
                        })
                },
                recallItemClick: function () {
                    _this = this;
                    var retkn_no = event.target;
                    retkn_no = retkn_no.innerHTML;
                    var service_type = document.getElementById('service_type').value;
                    var counter_id = document.getElementById('counter_id').value;
                    var user_id = document.getElementById('user_id').value;

                    axios.get('call_token_data_axios', {
                        params: {
                            svc_name: service_type,
                            token_type: '2',
                            counter_id: counter_id,
                            user_id: user_id,
                            tkn_no: retkn_no
                        }
                    })
                        .then(function (res) {
                            var obj = res.data.token_res[0];
                            const resultArray = Object.keys(obj).map(function (key) {
                                return [Number(key), obj[key]];
                            });
                            _this.selectedTokenval = resultArray[0][1];
                            _this.selectedTokenQty = resultArray[1][1];
                        })
                        .catch(function (error) {
                            console.log(error);
                        })
                },
                webfileSubmit: function () {

                    this.webfileDataNull = false;
                    this.webfileData = false;
                    this.submitBtn = false;
                    this.cleanBtn = false;
                    this.cleanBtn = false;
                    this.passportSearch = false;
                    this.storeResStatus = false,
                        this.rejectResStatus = false,
                        this.styleIndex = '-2';
                    document.getElementById('visa_type').value = '';
                    document.getElementById('name').value = '';
                    document.getElementById('passportNo').value = '';
                    document.getElementById('validStkr').value = '';
                    document.getElementById('proc_fee').value = '';
                    document.getElementById('Spfee').value = '';
                    document.getElementById('visa_type').value = '';
                    document.getElementById('contact').value = '';
                    this.txnNumber = '';
                    this.txnDate = '';
                    this.ttdDelDate = '';
                    //var correctionFee = this.correctionFee;
                    document.getElementById('old_pass').value = '';
                    document.getElementById('paytype').value = '';


                    _this = this;
                    var sticker = document.getElementById('sticker_type').value;
                    var stkrNumST = Number(this.stkr_str);
                    var stkrNumEND = Number(this.stkr_end);
                    if (sticker == '') {
                        alert('Please Select Sticker Type')
                    }
                    else if (stkrNumST == '' || stkrNumEND == '') {
                        alert('Please Input Sticker Starting and Ending Number');
                    }
                    else if (stkrNumST >= stkrNumEND) {
                        alert('Please Input Valid Sticker Number');
                    }
                    else {
                        var webfile = document.getElementById('webfile').value;
                        var webfile = webfile.split(' ').join('');
                        if (!webfile == '') {
                            this.webfileUC = webfile.toUpperCase();
                            //this.webfileUC = webfile;
                            var webfileCheck = this.webfileUC.substring(0, 3);
                            this.webfile2focus = true;
                            if (webfileCheck == 'BGD') {
                                this.passportSearch = false;
                                this.styleIndex = '-2';
                                document.getElementById('webfile').value = this.webfileUC;
                                var user_id = document.getElementById('user_id').value;
                                axios.get('get_app_list_for_rcvd_by_webfile', {
                                    params: {
                                        webfile: this.webfileUC,
                                        user: user_id,
                                        save: 'N'
                                    }
                                }, this.webfilePreloader = true)
                                    .then(function (res) {
                                        //console.log(res);
                                        var webfileData = res.data.webfileData;
                                        if (!webfileData == '') {
                                            _this.webfileData = true;
                                            _this.webfileDataNull = false;
                                            _this.submitBtn = true;
                                            _this.cleanBtn = true;

                                            document.getElementById('webfile').value = res.data.webfileData.WebFile_no;
                                            document.getElementById('name').value = res.data.webfileData.Applicant_name;
                                            document.getElementById('passport_show').innerText = res.data.webfileData.Passport;
                                            document.getElementById('contact').value = res.data.webfileData.Contact;
                                            document.getElementById('paytype').value = res.data.webfileData.Applicant_name;


                                            var ssldata = res.data.sllData.split(',');
                                            document.getElementById('paytype').innerHTML = res.data.paytype;

                                            //console.log(ssldata[6]);
                                            //console.log(ssldata[3]);
                                            _this.txnNumber = ssldata[3];
                                            _this.txnDate = ssldata[4];
                                            if (ssldata[0] == 'Yes') {
                                                if (ssldata[2] == '') {
                                                    _this.sslResMessage = ssldata[3] + ' ' + ssldata[4];
                                                    document.getElementById('proc_fee').value = ssldata[6];
                                                }
                                                else if (!ssldata[1] == '0') {
                                                    _this.sslResMessage = 'Already checked ' + ssldata[1] + ' on ' + ssldata[2] + ' amount ' + ssldata[6];
                                                    document.getElementById('proc_fee').value = ssldata[6];
                                                }


                                            }
                                            else if (ssldata[0] == 'No') {
                                                _this.sslResMessage = 'No Payment Data Found';
                                                document.getElementById('proc_fee').value = '0.00';
                                            }
                                            else {
                                                _this.sslResMessage = 'SSL Server Not Found';
                                            }

                                            //document.getElementById('webfileNo2').value = '';

                                        }
                                        else {
                                            _this.webfileDataNull = true;
                                            _this.webfileData = false;
                                            _this.submitBtn = false;
                                            _this.cleanBtn = false;
                                            document.getElementById('webfile').value = '';
                                            //document.getElementById('webfileNo2').value = '';
                                        }
                                        _this.webfilePreloader = false;

                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                        _this.webfilePreloader = false;
                                        _this.cleanBtn = true;
                                    });

                            }
                            else {
                                //this.$refs.webfileref.$el.focus();

                                this.webfile2Value = '';
                                this.passportSearch = true;
                                this.styleIndex = '1';
                                document.getElementById('PassportNo2').value = this.webfileUC;
                                //document.getElementById('webfileNo2').focus();
                                this.cleanBtn = true;
                                this.submitBtn = false;
                                this.webfileDataNull = false;
                                $('#webfileNo2').focus();
                            }
                        }
                    }
                },
                webfileSubmit2: function () {
                    this.storeResStatus = false,
                        this.rejectResStatus = false,
                        _this = this;


                    var sticker = document.getElementById('sticker_type').value;
                    var sticker_no_from = document.getElementById('sticker_no_from').value;
                    var sticker_no_to = document.getElementById('sticker_no_to').value;
                    var stkrNumST = Number(this.stkr_str);
                    var stkrNumEND = Number(this.stkr_end);

                    if (sticker == '') {
                        alert('Please Select Sticker Type')
                    }
                    else if (stkrNumST == '' || stkrNumEND == '') {
                        alert('Please Input Sticker Starting and Ending Number');
                    }
                    else if (stkrNumST >= stkrNumEND) {
                        alert('Please Input Valid Sticker Number');
                    }
                    else {
                        var webfileNo2 = document.getElementById('webfileNo2').value;
                        webfileNo2 = webfileNo2.split(' ').join('');
                        if (!webfileNo2 == '') {
                            var webfileNo2 = webfileNo2.toUpperCase();
                            //this.webfileUC = webfile;
                            var webfile2Check = webfileNo2.substring(0, 3);
                            document.getElementById('webfileNo2').value = webfileNo2;
                            if (webfile2Check == 'BGD') {
                                //document.getElementById('webfileNo2').value = '';
                                this.passportSearch = false;
                                this.styleIndex = '-2';
                                var user_id = document.getElementById('user_id').value;


                                axios.get('get_app_list_for_rcvd_by_webfile', {
                                    params: {
                                        webfile: webfileNo2,
                                        user: user_id,
                                        save: 'N'
                                    }
                                }, this.webfilePreloader = true)
                                    .then(function (res) {
                                        console.log(res.data);


                                        var webfileData = res.data.webfileData;
                                        if (!webfileData == '') {
                                            _this.webfileData = true;
                                            _this.webfileDataNull = false;
                                            _this.submitBtn = true;
                                            _this.cleanBtn = true;

                                            document.getElementById('webfile').value = res.data.webfileData.WebFile_no;
                                            document.getElementById('name').value = res.data.webfileData.Applicant_name;
                                            document.getElementById('passport_show').innerText = res.data.webfileData.Passport;
                                            document.getElementById('contact').value = res.data.webfileData.Contact;
                                            document.getElementById('paytype').value = res.data.webfileData.Applicant_name;

                                            var ssldata = res.data.sllData.split(',');
                                            document.getElementById('paytype').innerHTML = res.data.paytype;
                                            _this.txnNumber = ssldata[3];
                                            _this.txnDate = ssldata[4];

                                            console.log(ssldata[0]);
                                            ///console.log(res);
                                            if (ssldata[0] == 'Yes') {
                                                if (ssldata[2] == '') {
                                                    _this.sslResMessage = ssldata[3] + ' ' + ssldata[4];
                                                    document.getElementById('proc_fee').value = ssldata[6];
                                                }
                                                else if (!ssldata[1] == '0') {
                                                    _this.sslResMessage = 'Already checked ' + ssldata[1] + ' on ' + ssldata[2] + ' amount ' + ssldata[6];
                                                    document.getElementById('proc_fee').value = ssldata[6];
                                                }

                                            }
                                            else if (ssldata[0] == 'No') {
                                                _this.sslResMessage = 'No Payment Data Found';
                                                document.getElementById('proc_fee').value = '0.00';
                                            }
                                            else {
                                                _this.sslResMessage = 'SSL Server Not Found';
                                            }
                                        }
                                        else {
                                            _this.webfileDataNull = true;
                                            _this.webfileData = false;
                                            _this.submitBtn = false;
                                            _this.cleanBtn = false;
                                            _this.selectedTokenval = '';
                                            _this.selectedTokenQty = '';

                                            document.getElementById('webfile').value = '';
                                            //document.getElementById('webfileNo2').value = '';

                                        }
                                        _this.webfilePreloader = false;

                                    })
                                    .catch(function (error) {
                                        console.log(error);
                                        _this.webfilePreloader = false;
                                        _this.cleanBtn = true;
                                        console.log('hello');
                                    })
                            }
                            else {
                                alert('Please Provide Proper Webfile/Passport');
                            }

                        }
                    }
                },


                corrSelectAllFunc: function () {
                    this.corItem = [];
                    if (!this.corAllSelected) {
                        for (item in this.correctionList) {
                            this.corItem.push(this.correctionList[item].Correction);
                            console.log(this.correctionList[item].Correction)
                        }
                    }
                },
                correctionShowFunc: function () {
                    this.correctionShow = !this.correctionShow;
                    if (!this.correctionShow) {
                        this.corItem = [];
                        this.corAllSelected = false;
                    }
                },

                selectRejectAllFunc: function () {
                    this.rejectItem = [];
                    if (!this.selectRejectAll) {
                        for (item in this.rejectCauseData) {
                            this.rejectItem.push(this.rejectCauseData[item].reason);
                            console.log(this.rejectCauseData[item].reason);
                        }
                    }
                },
                rejectBtnFunc: function () {
                    this.rejectModalShow = true;
                    this.rejectItem = [];
                    if (this.rejectItem == '') {
                        this.selectRejectAll = false;
                    }
                },
                visaTypeOnChange: function () {
                    var visa_type = document.getElementById('visa_type').value;
                    if (!visa_type == '') {
                        var tdd_date = document.getElementById('tdd_' + visa_type).value;
                        this.ttdDelDate = tdd_date;
                        console.log(tdd_date);
                        axios.get('visatype-check-axios', {params: {visa_type: visa_type}})
                            .then(function (res) {
                                _this.visaChecklist = res.data.visaChecklist;
                                console.log(res);
                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                    }
                    else {
                        this.ttdDelDate = '';
                    }
                },

                submitFunc: function () {
                    this.submitModalShow = false;
                    var getPass = document.getElementById('passportNo').value;
                    var passNo = getPass.trim();
                    passNo = passNo.toUpperCase();
                    passNo = passNo.split(' ').join('');
                    //console.log(passNo);

                    var getShowPass = document.getElementById('passport_show').innerText;
                    getShowPass = getShowPass.trim();
                    var showPass = getShowPass.split(' ').join('');
                    //console.log(showPass);
                    if (passNo == showPass)
                    {
                        var old_pass = document.getElementById('old_pass').value;
                        if(!old_pass == '')
                        {
                            var visa_type = document.getElementById('visa_type').value;
                            if (!visa_type == '')
                            {
                                var contact_num = document.getElementById('contact').value;
                                if(contact_num.length == 10)
                                {
                                    var paytype = document.getElementById('paytype').value;
                                    if (!paytype == '')
                                    {

                                        var curSvcFee = document.getElementById('curSvcFee').value;
                                        var proc_fee = document.getElementById('proc_fee').value;
                                        var Spfee = document.getElementById('Spfee').value;
                                        curSvcFee = Number(curSvcFee);
                                        proc_fee = Number(proc_fee);
                                        Spfee = Number(Spfee);
                                        var old_svc = 0;
                                        old_svc = (proc_fee + Spfee);
                                        //console.log(old_svc);
                                        //console.log(curSvcFee);

                                        if(curSvcFee == old_svc)
                                        {
                                            var validStkr = document.getElementById('validStkr').value;
                                            var validStkrF = Number(validStkr);
                                            var inputTSt = Number(this.stkr_str);

                                            if(inputTSt <= validStkrF){

                                                var validStkr2 = document.getElementById('validStkr').value;
                                                var validStkr2F = Number(validStkr2);
                                                var InputTE = Number(this.stkr_end);

                                                if(InputTE >= validStkr2F)
                                                {
                                                    var validSticker = document.getElementById('validStkr').value;
                                                    var validStikerType = document.getElementById('sticker_type').value;
                                                    _this = this;
                                                    axios.get('check_valid_sticker_axios',{params:{validSticker:validSticker,validStikerType:validStikerType}})
                                                        .then(function(res){
                                                            console.log(res.data.validStatus);
                                                            if(res.data.validStatus == 'Yes'){
                                                                _this.submitModalShow = true;
                                                            }
                                                            else{
                                                                alert('This sticker number already used');
                                                            }
                                                        })
                                                        .catch(function(error){
                                                            console.log(error);
                                                        })
                                                }
                                                else
                                                {
                                                    alert('Please Input Valid Sticker Number');
                                                }

                                            }
                                            else
                                            {
                                                alert('Please Input Valid Sticker Number');
                                            }
                                        }
                                        else
                                        {
                                            this.submitModalShow = false;
                                            alert('Payment Not Valid');
                                        }
                                    }
                                    else
                                    {
                                        this.submitModalShow = false;
                                        alert('Please Select Payment Type');
                                    }
                                }
                                else
                                {
                                    alert('Please Enter Valid Contact Number');
                                }
                            }
                            else
                            {
                                this.submitModalShow = false;
                                alert('Please Select Visa Type');
                            }
                        }
                        else
                        {
                            alert('Please Enter Old Passport Qty');
                        }

                    }
                    else
                    {
                        this.submitModalShow = false;
                        alert('Please Enter Valid Passport Number');
                    }

                    validStkr = '';
                    validStkr2 = '';

                },
                DataSubmitFunc: function () {
                    this.submitModalShow = false;
                    _this = this;
                    var cust_name = document.getElementById('name').value;
                    var webfile = document.getElementById('webfile').value;
                    var passportNo = document.getElementById('passportNo').value;
                    var passport = passportNo.toUpperCase();
                    passport = passport.split(' ').join('');
                    var user_id = document.getElementById('user_id').value;
                    var counter_id = document.getElementById('counter_id').value;
                    var curSvcFee = document.getElementById('curSvcFee').value;
                    var selectedTokenDisplay = document.getElementById('selectedTokenDisplay').innerText;
                    var validStkr = document.getElementById('validStkr').value;
                    var proc_fee = document.getElementById('proc_fee').value;
                    var Spfee = document.getElementById('Spfee').value;
                    var visa_type = document.getElementById('visa_type').value;
                    var contact = document.getElementById('contact').value;
                    var sticker_type = document.getElementById('sticker_type').value;
                    var txnNumber = this.txnNumber;
                    var remark = this.txnDate + '-' + proc_fee+'|';
                    var center_name = document.getElementById('center_name').value;
                    var ttdDelDate = document.getElementById('ttdDelDate').value;
                    var corFee = document.getElementById('corFee').value;
                    //var correctionFee = this.correctionFee;
                    var old_pass = document.getElementById('old_pass').value;
                    var paytype = document.getElementById('paytype').value;
                    var corItem = this.corItem;

                    axios.get('webfile-data-save-axios', {
                        params: {
                            cust_name: cust_name,
                            webfile: webfile,
                            passport: passport,
                            user_id: user_id,
                            counter_id: counter_id,
                            curSvcFee: curSvcFee,
                            selectedTokenDisplay: selectedTokenDisplay,
                            validStkr: validStkr,
                            proc_fee: proc_fee,
                            Spfee: Spfee,
                            visa_type: visa_type,
                            contact: contact,
                            sticker_type: sticker_type,
                            txnNumber: txnNumber,
                            remark: remark,
                            center_name: center_name,
                            ttdDelDate: ttdDelDate,
                            corFee: corFee,
                            old_pass: old_pass,
                            corItem: corItem,
                            paytype: paytype
                        }
                    }, this.webfilePreloader = true)
                        .then(function (res) {
                            _this.webfilePreloader = false;
                            _this.clearBtnFunc();

                            _this.cleanBtn = false;
                            _this.storeResStatus = true;
                            _this.storeResMsg = res.data.status;
                            console.log(res);
                            var last_id = res.data.store_id;
                            var saves = res.data.save;
                            if(saves == 'yes'){
//                            _this.selectedTokenQty = '';
//                            _this.selectedTokenval = '';
                                document.getElementById('total_save_count').innerText = res.data.saveCount;
                                if(last_id == ''){
                                }else{
                                    window.open('pass-receive-print/'+last_id, '_blank');
                                }
                            }

                        })
                        .catch(function (error) {

                        });
                },
                clearBtnFunc: function () {
                    if (this.passportSearch == true) {
                        this.styleIndex = '-2';
                        this.passportSearch = false;
                        this.webfile2Value = '';
                        //document.getElementById('webfileNo2').value = '';
                        ///document.getElementById('webfile').value = '';
//                        document.getElementById('name').value = '';

                    }
                    document.getElementById('name').value = '';
                    document.getElementById('passportNo').value = '';
                    document.getElementById('validStkr').value = '';
                    document.getElementById('proc_fee').value = '';
                    document.getElementById('Spfee').value = '';
                    document.getElementById('visa_type').value = '';
                    document.getElementById('contact').value = '';
                    this.txnNumber = '';
                    this.txnDate = '';
                    document.getElementById('ttdDelDate').value = '';
                    //var correctionFee = this.correctionFee;
                    document.getElementById('old_pass').value = '';
                    document.getElementById('paytype').value = '';


                    this.webfileData = false;
                    this.submitBtn = false;
                    this.selectRejectAll = false;
                    this.corItem = [];
                    this.rejectItem = [];
                    this.sslResMessage = '';
                    document.getElementById('webfile').value = '';
                },
                rejectSubmitFunc: function () {
                    this.rejectModalShow = false;
                    _this = this;
                    axios.get('reject-submit-axios', {
                        params: {
                            webfile: this.webfileUC,
                            rejectedCauses: this.rejectItem,
                            save: 'Y'
                        }
                    }, this.webfilePreloader = true)
                        .then(function (res) {
                            _this.webfilePreloader = false;
                            console.log(res);
                            if (res.data.status = 'yes') {
                                _this.rejectModalShow = false;
                                document.getElementById('total_reject_count').innerText = res.data.rejectCount;
                                //console.log('d')
                                _this.rejectResStatus = true;
                                _this.rejectResMsg = res.data.statusMsg;
                                _this.selectedTokenval = '';
                                _this.selectedTokenQty = '';
                                _this.clearBtnFunc();
                                _this.cleanBtn = false;

                            }

                        })
                        .catch(function (error) {

                        })
                },
                sendToWaitingFunc: function () {
                    if (this.selectedTokenval != '') {
                        console.log(this.selectedTokenval);
                        var service_type = document.getElementById('service_type').value
                        var floor_id = document.getElementById('floor_id').value
                        axios.get('send-token-to-waiting-axios', {
                            params: {
                                token: this.selectedTokenval,
                                type: '2',
                                service_type: service_type,
                                floor_id: floor_id
                            }
                        })
                            .then(function (res) {
                                console.log(res);
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                    else {
                        alert('Please Select Token')
                    }
                },
                sendToRecallFunc: function () {
                    //console.log(this.selectedTokenval);
                    var recallVal = document.getElementById('send_recall_id').value;
                    var service_type = document.getElementById('service_type').value;
                    var floor_id = document.getElementById('floor_id').value;
                    if(service_type != ''){
                        axios.get('send-token-to-recall-axios', {
                            params: {
                                token: recallVal,
                                type: '3',
                                service_type: service_type,
                                floor_id: floor_id
                            }
                        })
                            .then(function (res) {
                                console.log(res);
                                document.getElementById('send_recall_id').value = '';
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                    else{
                        alert('Please Select Service Type');
                    }

                }
            },
            created:function(){

                var _this = this;
                this.svc_name = document.getElementById('service_type').value;
                //this.selectedToken = false;


                setInterval(function(){
                    var svc_isset = _this.svc_name;
                    if(!svc_isset == ''){
                        axios.get('counter_call_get_data',{params:{svc_name:_this.svc_name}})
                            .then(function(res){
                                _this.regularDataList = res.data.regulars;
                                _this.waitingDataList = res.data.waitings;
                                _this.recallDataList = res.data.recalls;
                                //console.log(res.data);
                                //console.log(res.data.regulars);
                            })
                            .catch(function(error){
                                console.log(error);
                            })
                    }

                    //_this.selectedTokenval

                    if(_this.selectedTokenval == ''){
                        _this.selectedToken = false;
                    }else{
                        _this.selectedToken = true;
                    }

                },5000);

                _this = this;
                axios.get('get_data_onload_axios').then(function(res){
                    _this.rejectCauseData = res.data.rejectCause;
                    _this.correctionList = res.data.correctionFee;
                    _this.correctionFee = res.data.corFee.Svc_Fee;
                    document.getElementById('total_save_count').innerText = res.data.total_save;
                    document.getElementById('total_reject_count').innerText = res.data.rejectCount;

                    //console.log(res.data);
                })
                .catch(function(error){
                    console.log(error);
                })
            }

        });

    </script>
    <script>
        $("#sticker_no_from").on("keypress keyup blur", function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $("#sticker_no_from").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
        });


        $("#sticker_no_to").on("keypress keyup blur", function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $("#sticker_no_to").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
        });


        $("#validStkr").on("keypress keyup blur", function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $("#validStkr").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
        });


        $("#Spfee").on("keypress keyup blur", function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
            $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
        $("#Spfee").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
        });
    </script>


    @endif
@endsection