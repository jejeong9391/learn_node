<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maxium-scale=1.0, minimun-scale=1.0, width=device-width">
    <title>신일푸드</title>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
    <!--fontawesome-->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.12.1/css/all.css" integrity="sha384-TxKWSXbsweFt0o2WqfkfJRRNVaPdzXJ/YLqgStggBVRREXkwU7OKz+xXtqOU4u8+" crossorigin="anonymous">

    <!-- <script src="./script.js"></script>-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--alert플러그인-->
    <link href="../lib/plugin/modal-master/css/jquery.modal.css" type="text/css" rel="stylesheet" />
    <link href="../lib/plugin/modal-master/css/jquery.modal.theme-xenon.css" type="text/css" rel="stylesheet" />
    <link href="../lib/plugin/modal-master/css/jquery.modal.theme-atlant.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="../lib/plugin/modal-master/js/jquery.modal.js"></script>
    <!--rest-->
    <script type="text/javascript" src="./../lib/js/function.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <!--main_list 공통js-->
    <link href="../reset.css" rel="stylesheet">
    <link href="./list_style.css" rel="stylesheet">
    <link href="./style_set.css" rel="stylesheet">
</head>

<body>
    <div id="wrap">
        <header id="header">
            <div class="hdLeft" onclick="history.back();">
                <a href="#">
                    <!-- <i class="fas fa-chevron-left"></i>-->
                    <i class="material-icons">keyboard_arrow_left</i>
                </a>
            </div>
            <h3 class="textLogo"><a href="#">지점명</a></h3>
            <div href="#" class="btnMenu">
                <input type="hidden" class="tel">
                <!--  <img src="./../img/icons/icon_02.png" alt="메뉴열기">-->
                <i class="fas fa-phone-alt rightIcon" style="line-height: 30px;"></i>
            </div>
        </header>

        <!--#header-->
        <div id="container" style="background: #ddd;  height: 90vh;">
            <!-- <div class="topBlank"></div>-->
            <!--  -->
            <!--배달완료 여부 (기본값 = 주문접수 = 0 )-->
            <input type="hidden" name="io_status" value="0">
            <input type="hidden" name="store_idx">
            <input type="hidden" name="deli_deadDate" class="deli_deadDate">

            <!--기존입고일자-->

            <!--배송기사 마감값 -->
            <!--    <input type="hidden" name="del_idx[]" value="">-->

            <div class="indate dateWrap">
                <span>입고일자 :&nbsp;&nbsp;</span>
                <input type="hidden" name="before_ioDate" id="before_ioDate">
                <!--기존입고일자-->
                <input type="text" id="io_date" name="io_date" class="io_date" readonly>
                <!-- <div class="dayWrap">
                    <div class="eachDay">일</div>
                    <div class="eachDay">화</div>
                    <div class="eachDay">목</div>
                </div>-->
                &nbsp;&nbsp;<span id="ioDays">
                    <!--일,화,목-->
                </span>
            </div>

            <!--  추가 버튼 클릭 시, 생성됨-->
            <div class="addPro" style="display: none;">
                <div class="proAll" style="height: 100%;">
                    <div class="close">
                        <div class="closeBtn"><i class="fas fa-times"></i></div>
                    </div>
                    <!--상품list -->
                    <div class="noPro">
                        <p>등록된 상품이 없습니다.</p>
                    </div>
                    <ul class="addProduct">
                        <!-- <li class="proWrap"></li>-->
                        <!--상품반복-->
                        <!--상품반복 끝-->
                    </ul>
                </div>
            </div>
            <!--상품 추가 div 끝 -->
            <form name="write_form" id="write_form" autocomplete="off">
                <div class="outWrap">
                    <div class="outHdWrap">
                        <div class="outHd">
                            <span>출고상품</span>
                            <span>(0)</span>
                        </div>
                        <div class="addBtnWrap">
                            <div id="-1" class="addBtn">추가</div>
                        </div>
                    </div>

                    <ul id="setOutList" class="listUl">
                        <input type="hidden" class="outCnt" value="0">
                        <!--   <li class="outProduct"></li>-->
                        <!--반복시작-->
                        <!--반복끝-->
                    </ul>
                    <div id="outTotal" class="totalWrap">
                        <div class="totalTxt">
                            <span> 합계 :&nbsp; </span>
                            <span> 0 </span>
                            <span>원</span>
                        </div>
                    </div>
                </div>
                <!-- .outWrap -->

                <!--입고상품-->
                <div class="outWrap">
                    <div class="outHdWrap">
                        <div class="inHd">
                            <span>입고상품</span>
                            <span>(0)</span>
                        </div>
                        <div class="addBtnWrap">
                            <div id="1" class="addBtn">추가</div>
                        </div>
                    </div>
                    <ul id="setInList" class="listUl">
                        <input type="hidden" class="inCnt" value="90">
                        <!-- <li class="outProduct"></li>-->
                        <!--반복시작-->
                        <!--반복끝-->
                    </ul>
                    <div class="totalWrap">
                        <div id="inTotal" class="totalTxt">
                            <span> 합계 :&nbsp; </span>
                            <span> 0 </span>
                            <span>원</span>
                        </div>
                    </div>
                </div>
            </form>
            <!--입고상품끝-->
            <div id="delMemo" class="outWrap" style="height: 180px;  margin-bottom: 100px;">
                <div class="outHdWrap">
                    <div class="inHd">
                        <span>배송메모</span>
                    </div>
                </div>
                <div id="memoWrap" class="listUl">
                    <textarea name="memo" id="memo" class="ordMemo" cols="30" rows="10" placeholder="배송메모를 입력하세요." maxlength="100"></textarea>
                </div>
            </div>

            <!--배송메모 끝-->
            <div class="inoutTotal">
                <div class="totalWrap">
                    <div id="del_io" class="totalTxt" style="  float: left;padding-left: 26px;">

                        <span> 전표삭제</span>

                        <input type="hidden" name="io_amt">
                        <!--총합계 : db용-->
                    </div>
                </div>
                <div class="totalWrap">
                    <div class="totalTxt">
                        <span> 합계 :&nbsp; </span>
                        <span> 0</span>
                        <span>원</span>
                        <input type="hidden" name="io_amt">
                        <!--총합계 : db용-->
                    </div>
                </div>
            </div>
            <!--se인경우, 입고상품 잘림. 여유div필요 -->
            <div class="blank" style="height: 100px; display: none;"></div>
            <div class="newOrd saveWrap">
                <div id="chkDeli" class="sBtn chkDeli"><i id="chkIcon" class="material-icons chkIcon">check</i><span>배송완료</span></div>
                <div id="saveBtn" class="sBtn saveBtn">저장하기</div>
            </div>
            <!--  -->
        </div>
        <!--container-->

        <!-- toast div(alert창 대신사용) -->
        <div class="toast" style="display:none;"></div>

    </div>
    <!-- rest -->
    <!-- <script src="https://unpkg.com/axios/dist/axios.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
    <script type="text/javascript">
        var page = 1;
        var out_id = 0; // 출고 li id
        var in_id = 0; // 입고 li id
        var del_idx = []; //삭제한 idx 배열 
        var chkSave = 0; //저장 상태값 
        // url 주소값 받기
        var io_idx = getParamByName('io_idx');
        var st_idx = getParamByName('st_idx');
        var st_name = getParamByName('st_name');
        if (!st_idx) {
            alertBox('지점정보가 없습니다.');
            history.back();
        } else {
            $("input[name='store_idx']").val(st_idx);
        }
        //전표있으면 삭제기능 
        if (io_idx) {
            console.log(io_idx);
            $("#del_io span").text("전표삭제");
            $(".textLogo a").text(st_name + "_" + io_idx); //헤더에 지점명 삽입
        } else {
            $("#del_io span").text("");
            $(".textLogo a").text(st_name); //헤더에 지점명 삽입
        }
        if (localStorage.getItem('store_idx') > 0) {
            $("#delMemo").css("display", "none");
            $(".blank").css("display", "block");

        }

        $(function() {
            getOrdList(io_idx, st_idx);

            // $('.cntInput').attr('readOnly', true);


            //통화기능 
            $(".btnMenu").on('click', function() {
                if ($(".tel").val() != '') {
                    document.location.href = 'tel:' + $(".tel").val();
                } else {
                    msgToast('등록된 전화번호가 없습니다.');
                    //alert('등록된 전화번호가 없습니다.');
                }
            });
            //삭제기능 
            //1. 전표idx가 있으면 아이콘 생성 //2.삭제할거냐 confirm 3. io_idx 로 삭제rest호출 
            $("#del_io").on('click', function() {

                //지점은 배송변경할 수 없음.

                if (io_idx) {
                    confirmBox('삭제된 주문정보는 복구할수 없습니다. \n\n정말 삭제하시겠습니까?', delIos, io_idx);
                    //삭제
                    function delIos(io_idx) {
                        var chk_result = chk_deadline($("#before_ioDate").val()); //마감확인
                        if (chk_result == true) {
                            insertOrder("DELETE", io_idx);
                        } else {
                            alertBox("마감완료된 전표는 삭제할 수 없습니다.");
                        }
                    }
                }
            });

            //상품추가
            $(".addBtnWrap").on('click', function() {
                var proType = $(this).children().attr('id');
                getProduct(st_idx, proType);
                $(".addPro").css("display", "block");
            });
            //상품추가창 닫기
            $(document).on("click", ".proAll, .closeBtn", function() {
                $(".addPro").css("display", "none");
            });
            /*$(".closeBtn").on('click', function() {
                $(".addPro").css("display", "none");
            });*/

            //상품삭제 처리 //동적으로 생긴 ui 일경우 document사용해야함. 
            $(document).on("click", ".delBtn", function() {
                //$(".delBtn").on('click', function() { 작동X

                var thisId = $(this).attr("id");
                var thisLi = $(this).parents('li');
                var thisliId = thisLi.attr('id');
                var thisIop = thisLi.find("input[name='iop_idx[]']").val(); //삭제한 iop_idx

                // 선택한 li제거 
                if (thisId == thisliId) {
                    del_idx.push(thisIop); // 삭제한 iop_idx 배열에 넣기
                    thisLi.remove(); //li제거
                    getTotal(); //총합 재계산 

                    //상품 총개수 출력
                    $(".outHd span:nth-child(2)").text("(" + $('#setOutList>li').length + ")");
                    $(".inHd span:nth-child(2)").text("(" + $('#setInList>li').length + ")");
                }

            });


            //수량조절 
            $(document).on("click", ".cntBtn", function() {
                // $(".outProduct").on('click', function() {
                var liIdx = $(this).parents('li').attr('id');
                if (liIdx < 90) {
                    sel(liIdx, $(this).attr('id'), -1); // 출고
                } else {
                    sel(liIdx, $(this).attr('id'), 1); //입고
                }

            });
            //배송메모 클릭 시, 화면 하단으로 스크롤 이동 
            $(".ordMemo").on("click", function() {
                $('html').animate({
                    scrollTop: $(this).offset().top
                }, 500);
            });

            //배송상태 체크
            $("#chkDeli").on('click', function() {
                // var iconTag = $(this).children("#chkIcon");

                if (localStorage.getItem('store_idx') > 0) {
                    alertBox("지점에서는 배송처리 변경 할 수 없습니다.");
                    event.preventdefault();
                } else {

                    $(this).children("#chkIcon").toggle();
                    $(this).toggleClass("clickDeli");

                    var io_status = $('input[name="io_status"]');
                    if (io_status.val() == '0') { //주문상태
                        io_status.val('1');
                    } else { //배달완료 상태 / 상태값 없음
                        io_status.val('0');
                    }
                }
            });

            //저장 
            $("#saveBtn").on("click", function() {

                $(this).css("background", "#efefef");
                if (chkSave == '1') { //저장버튼 이미 클릭했을경우 중복저장 방지
                    e.stopPropagation();
                    e.preventDefault();
                } else {
                    //지점일경우 , 당일 저장이 안되도록 해야함. 
                    if (localStorage.getItem('store_idx') > 0) {

                        if ($("#io_date").val() <= today) {
                            alertBox("익일 이전 날짜로는 저장할 수 없습니다.");

                            //저장버튼 활성화
                            chkSave = 0;
                            $(this).css("background", "rgb(241, 121, 126)");
                            return false;
                        }

                    } //2020-05-11 기사 마감
                    else {
                        var io_date = $("#io_date").val(); //입고일자 
                        var before_ioDate = $("#before_ioDate").val(); //수정전, 기존입고일자

                        var chk_result = chk_deadline(io_date);
                        if (chk_result == true) {
                            //저장처리   
                            if (before_ioDate != '') {
                                if (before_ioDate == io_date) {} else {
                                    chk_result = chk_deadline(before_ioDate); //기존입고일자로 수정가능여부 확인 
                                    if (chk_result == false) {
                                        alertBox('마감 완료된 전표는 수정할 수 없습니다.');
										chkSave = 1;
                                        return false;
                                    }
                                }
                            }

                        } else {
                            alertBox('입고일자를 마감일 이전으로 등록/수정 할 수 없습니다. 관리자에게 문의하세요.');
							chkSave = 1;
                            return false;
                        }

                        //저장처리 
                        if (io_idx) { //수정
                            insertOrder("PUT", io_idx);
                        } else { // insert
                            //console.log($("input[name='out_total[]']").val());
                            insertOrder("POST", '');
                        }
                    }
                }
            }); /*save 끝*/

        }); /*$(function()끝*/
        function chk_deadline(io_date) {

            var deli_deadDate = $(".deli_deadDate").val(); //기사 마감설정값 
            // var deli_deadDate = '5';


            //1. 입고일자 날짜형태로 변경 
            var io_dateArr = io_date.split('-');
            var yy = io_dateArr[0];
            var mm = Number(io_dateArr[1]) - 1; //날짜 변환시 +1로 변환하므로 -해줘야함 
            var dd = io_dateArr[2];

            var cmpr_ioDate = new Date(yy, mm, dd); //입고일변환
            var endMonth = new Date(yy, mm + 1, 0); //입고일자의 월말 
            var d = new Date();
            //    console.log(endMonth + "===== 입고일 기준 마감일과 오늘을 비교 ==========" + cmpr_ioDate);

            /* 마감날짜 구하기
            해당월의 마지막 날을 계산후 값만큼 Addday처리함
            30일만 따로 처리 -마지막일자에서 한달 더하고 하루를 빼*/

            if (deli_deadDate == '30') { //다음달 말일구하기 
                endMonth.setMonth(endMonth.getMonth() + 2).setDate(0);
                //날짜객체에서 1월==0임 따라서 해당 달을 구하려면 +1해야함. 다음달이니 +2

            } else {
                endMonth.setDate(endMonth.getDate() + Number(deli_deadDate));
            }

            if (endMonth < d) { //정산일 5/5 < 현재 5/25  --- 수정불가 
                console.log("입고일 : " + cmpr_ioDate + "  || 마감일 : " + endMonth + "  ||  오늘 : " + d);
                return false;
            }
            return true;
        }


        function sel(liIdx, type, pro) { // type: 덧/뺄 pro: 입출고

            var li = $("#" + liIdx);
            var amt = Number(li.find('.cntInput').val()); // 수량 .cntInput
            var price = Number(li.find('input[name="amt_price"]').val()); //단가 .amt_price
            var sumPrice = $(".sum").text();
            //            / alert("li는 :"+liIdx+"|| 수량은 : "+amt+"|| 단가는 : "+price);

            var sum;

            if (type == 'add') {
                if (pro == '1') amt += 0.5;
                else amt++;

            } else {
                if (pro == '1') amt -= 0.5;
                else amt--;
            }

            if (amt > 0) {
                // alert(typeof(amt));
                sum = amt * price;
            } else {
                if (pro < 0) { //출고
                    amt = 1;
                    sum = 1;
                } else {
                    amt = 0.5;
                    sum = 0.5;
                }


                /*  amt = 0;
                 sum = 0;
                 setTimeout(function() {
                                 msgToast('수량');
                             }, 200);*/
            }
            li.find('.cntInput').val(amt); //수량변경 
            if (pro == '-1') {
                li.find('input[name="out_amt[]"]').val(amt);
            } else {
                li.find('input[name="in_amt[]"]').val(amt);

            }
            /*  li.find('input[name="out_total[]"]').val(sum);

              var prTotal = Number(sum).toLocaleString('en');

              if (liIdx < 90) { //출고
                  $("#outTotal span:nth-child(2)").text(prTotal);
              } else { //입고
                  $("#inTotal span:nth-child(2)").text(prTotal);
              }*/
            //console.log('출고합계 : ' + sum);
            // console.log('total 값 :' + $('input[name="out_total[]"]').val());
            getTotal();
        }

        function getTotal() {
            // 출고 내역 합계 뿌림

            var outTotal = $('input[name="out_total[]"]'); //출고 금액 
            var outAmt = $('input[name="out_amt[]"]'); // 출고 수량
            var inTotal = $('input[name="in_total[]"]');
            var inAmt = $('input[name="in_amt[]"]');
            var outSum = 0;
            var inSum = 0;

            //출고 합계 
            for (var i = 0; i < outTotal.length; i++) {
                if (Number(outTotal.eq(i).val()) > 0) {
                    outSum += Number(outTotal.eq(i).val()) * Number(outAmt.eq(i).val());
                }
            }
            //입고합계 
            for (var i = 0; i < inTotal.length; i++) {
                if (Number(inTotal.eq(i).val()) > 0) {
                    inSum += Number(inTotal.eq(i).val()) * Number(inAmt.eq(i).val());
                }
            }

            //합계 입력 
            $("#outTotal span:nth-child(2)").text(Number(outSum).toLocaleString('en')); //출고합계
            $("#inTotal span:nth-child(2)").text(Number(inSum).toLocaleString('en')); //입고합계
            //총합계 

            $(".inoutTotal span:nth-child(2)").text(Number(outSum - inSum).toLocaleString('en')); //총합계
            $("input[name='io_amt']").val(outSum - inSum); //db용

        }


        function getOrdList(io_idx, st_idx) {

            request('json/order-detail.php', io_idx, {
                "flag": "GET",
                "u_idx": localStorage.getItem('u_idx'),
                "rider_idx": localStorage.getItem('rider_idx'),
                "u_token": localStorage.getItem('u_token'),
                "center_idx": localStorage.getItem('center_idx'),
                "st_idx": st_idx

            }).then(function(resp) {
                var rowsNum = resp.data.meta.rows;

                if (rowsNum > 0) {
                    //화면에 나타내기

                    //  var html = "";
                    //rest로 받아온 리뷰데이터를 forEach문으로 리뷰ul에 추가하기
                    var headList = resp.data.data;
                    // alert(resp.data.data.io_status);
                    var isFirst = false;

                    headList.forEach(function(item) {
                        var html = "";
                        if (!isFirst) { //inout 정보는 한번만 뿌리도록 구분값 //전역에 false하고 foreach한번돌고나면 true니까 반복하지않음.
                            isFirst = true;

                            $(".deli_deadDate").val(item.cfg_value); // 기사 마감설정값 (5,7...)
                            $(".tel").val(item.tel); // 매장 전화번호
                            $(".ordMemo").val(item.remark); // 매장 전화번호
                            if (item.io_idx) $("input[name='io_status']").val(item.io_status); // 전표있는경우, 배송여부 

                            if (item.visit_day != '') { //입고요일 구하기
                                //입고요일배열
                                var Arr = item.visit_day.split('|'); // |0|9|2|9|...이렇게 시작해서 split한 Arr[0]은 빈값임.
                                Arr.shift(); //Arr[0] 요소는 빈값이므로 제거 
                                var dayArr = []; // 한글 요일 배열 

                                //특정 날짜의 요일 구하기 
                                Arr.forEach(function(d) {
                                    if (d < 9) {
                                        //입고요일 출력 
                                        var week = new Array(' 일', ' 월', ' 화', ' 수', ' 목', ' 금', ' 토');
                                        var todayLabel = week[d];
                                        dayArr.push(todayLabel);
                                    };
                                });

                                $("#ioDays").text(dayArr); //입고요일 입력

                                //입고일자 입력 
                                if (item.io_date) {
                                    $("#before_ioDate").val(item.io_date); //기존 입고일자 저장 
                                    $("#io_date").val(item.io_date); //입고일자

                                } else { //저장된 입고일자 없을 때 

                                    if (dayArr.length > 0) { //설정한 요일이 있으면 입고 요일에 맞는 날짜 찾기 

                                        //******* indexof는 배열에서 다르게 작동한다 . 문자열일때 아래처럼 작동함 !!!!!
                                        var roop = 0; // while 무한루프 방지 
                                        while (item.visit_day.indexOf(gDay) < 0) { //|9|1|2|9|9|9|9 전체에서 오늘 요일(2)가있는지 확인 // 일치값이 없으면 -1리턴     //위 조건이 배열일때에는 indexOf 작동안함
                                            //일치값이 없으면 날짜 하루씩 더해서 요일 구하고 다시 while 조건으로 이동
                                            date.setDate(date.getDate() + 1); //날짜 하루 더하기
                                            gDay = date.getDay(); //요일 구하기 

                                            //확인코드 및 무한루프 방지 
                                            console.log("배열 요일 : " + gDay + "|| 더한 요일 : " + date);
                                            if (roop < 30) roop++;
                                            else break; // while 지옥에서 벗어나는방법 

                                        } //일치값이 있으면 setDate한 값으로 입고일자 만들기 
                                        var thiio_date = makeDate(date);
                                        $("#io_date").val(thiio_date);

                                    } else { // 설정한 요일이 없으면 오늘날짜 리턴 |9|9|9|9|9|9|9
                                        $("#io_date").val(makeDate(date));
                                    }
                                }
                            }
                            if (item.io_status == '1') { //배송완료 
                                $("#chkDeli").addClass('clickDeli');
                                $("#chkIcon").show();
                            }
                        }

                        if (item.p_num == null) { //2020-04-09
                            return true;
                        }
                        if (item.p_idx != null) { // 상품이 있는경우 // 없으면 전표정보만 출력 

                            //정수일때 소수점 제거
                            var amt = item.amount.split('.');
                            if (amt[1] < 1) item.amount = amt[0]; // 정수일 경우 소수점이하 출력되지않도록 함. 

                            // 입출고에 따라 id_num ai로 부여 
                            if (item.io_type == '-1') {
                                var li_id = Number($(".outCnt").val()) + 1;
                            } else {
                                var li_id = Number($(".inCnt").val()) + 1;
                            }


                            //전표 유무에 따라 단가 컬럼명 다르게 적용 
                            // var proPrice='';
                            if (item.iop_idx) {
                                var proPrice = item.amt_price; //io_pro의 판매단가
                                var iop_idx = item.iop_idx;
                            } else {
                                var proPrice = item.p_amt_out; // product의 출고가 
                                var iop_idx = '';
                            }
                            //규격없는 상품은 상품명만 출력
                            if (item.p_stand) {
                                var p_stand = " (" + item.p_stand + ")";
                            } else {
                                var p_stand = '';
                            }


                            /*마지막 요소 ID에 1 추가하여 id 생성 
                             //alert( '마지막 li id : '+ $('#setOutList > li').last().attr('id'));
                            var li_id = Number($('#setOutList > li').last().attr('id')) + 1;
                            if (isNaN(li_id)) li_id = 0;
                            if (li_id < 0) li_id = 0;
                            */


                            //숫자 콤마처리 
                            //    html += '<input type="hidden" id="' + li_id + '"  name="del_idx[]" value="2">';
                            html += '<li id="' + li_id + '" class="outProduct">';
                            // html += ' <input type="hidden" name="del_idx[]">';
                            html += ' <input type="hidden"  name="p_idx[]" value="' + item.p_idx + '">';
                            html += ' <input type="hidden"  name="iop_idx[]" value="' + iop_idx + '">';
                            html += ' <input type="hidden"  name="io_type[]" value="' + item.io_type + '">';
                            // html += ' <input type="hidden"  name="io_status" value="' + item.io_status + '">'; //배송완료 여부
                            html += '   <div class="opWrap">';
                            html += '       <div class="opLeft">';

                            if (item.p_name == null) { // 삭제된 상품일 경우 
                                html += '           <div class="opTitle"><span>삭제된 상품</span></div>';
                            } else {
                                html += '           <div class="opTitle"><span>' + item.p_name + p_stand + '</span></div>';
                            }

                            html += '           <div class="opTitle priceTxt">';

                            //전표가 있을 경우, 판매단가
                            html += '               <input type="hidden"  name="amt_price[]" value="' + proPrice + '">'; //필요한건가? js에서 값 가져다쓸때 쓰나?

                            //입출고 구분에 따라 total 다르게 입력 
                            if (item.io_type == '-1') {
                                html += '               <input type="hidden"  name="out_amt[]" value="' + item.amount + '">';
                                html += '               <input type="hidden"  name="out_total[]" value="' + parseInt(proPrice) + '">';
                                html += '               <input type="hidden"  name="in_amt[]" value="0">';
                                html += '               <input type="hidden"  name="in_total[]" value="0">';
                            } else {
                                html += '               <input type="hidden"  name="out_amt[]" value="0">';
                                html += '               <input type="hidden"  name="out_total[]" value="0">';
                                html += '               <input type="hidden"  name="in_amt[]" value="' + item.amount + '">';
                                html += '               <input type="hidden"  name="in_total[]" value="' + parseInt(proPrice) + '">';
                            }

                            html += '               <p>' + Number(proPrice).toLocaleString('en') + '</p>';
                            html += '           </div>';
                            html += '       </div>';
                            html += '    <div class="opRight">';
                            html += '       <div class="cntWrap">';
                            html += '           <div id="del" class="cntBtn minus">-</div>';
                            html += '           <input type="text" class="cntInput" value="' + item.amount + '" readonly>';
                            html += '           <div id="add" class="cntBtn plus ">+</div>';
                            html += '       </div>';
                            html += '     </div>';
                            // html+='<div class="delBtnWrap"><div id="1" class="delBtn" style=" border-radius: 15px; border: 1px solid rgb(241, 121, 126); color:#1f1f1f;">X</div></div>';
                            html += '<div class="delBtnWrap"><div  id="' + li_id + '" class="delBtn">삭제</div></div>';
                            html += '   </div>';
                            html += '</li>';

                            if (item.io_type == '-1') { //출고

                                $("#setOutList").append(html);
                                $(".outCnt").val(li_id);
                                $(".outHd span:nth-child(2)").text("(" + $('#setOutList>li').length + ")"); //추가한 상품개수 
                                $("#outTotal span:nth-child(2)").text(item.amt_total);


                            } else {
                                $("#setInList").append(html);
                                $(".inCnt").val(li_id);
                                $(".inHd span:nth-child(2)").text("(" + $('#setInList>li').length + ")"); //추가한 상품개수 
                                $("#inTotal span:nth-child(2)").text(item.amt_total);
                            } //입고

                        } else {
                            if (item.io_idx) { //전표는 있는데, 주문상품이 없는경우
                                setTimeout(function() {
                                    msgToast('주문 상품이 없습니다.');
                                }, 200);
                            }


                        } //상품 있는경우 
                    }); //foreach rowsNum>0 끝 ///\

                    // toal계산 
                    getTotal();

                } else { //row가 없는경우 == 처음주문인데 기본 셋팅(head_product)이 없는 경우 

                    $("#io_date").val(today); //입고일자
                    /*    setTimeout(function() {
                            msgToast('기본 상품이 없습니다.');
                        }, 200);*/
                }
            });
        }

        //상품추가 시, 상품list 가져오기 
        function getProduct(st_idx, io_type) {

            /*   //열려있는 li가 있으면 닫기
               var clickLi = $("#" + idx).children("li");
               // if (clickLi.css("display")=="none") {
               if (clickLi.length) {
                   clickLi.slideToggle("fast");
                   return false;
               }*/

            //li 초기화
            $('.proWrap').remove();

            request('json/product-list.php', st_idx, {
                "flag": "GET",
                "u_idx": localStorage.getItem('u_idx'),
                "rider_idx": localStorage.getItem('rider_idx'),
                "u_token": localStorage.getItem('u_token'),
                "center_idx": localStorage.getItem('center_idx'),
                "io_type": io_type,

            }).then(function(resp) {
                var rowsNum = resp.data.meta.rows;

                if (rowsNum > 0) {
                    $(".noPro").hide();
                    $(".addProduct").show();

                    //화면에 나타내기
                    var p_html = "";
                    var html = "";
                    //rest로 받아온 리뷰데이터를 forEach문으로 리뷰ul에 추가하기
                    var pro = resp.data.data;
                    pro.forEach(function(item) {
                        //규격없는 상품은 상품명만 출력
                        if (item.p_stand) {
                            var p_stand = " (" + item.p_stand + ")";
                        } else {
                            var p_stand = '';
                        }

                        p_html += '<li class="proWrap">';
                        p_html += ' <input type="hidden"  name="add_p_idx" value="' + item.p_idx + '">';
                        p_html += ' <input type="hidden"  name="p_type" value="' + item.p_type + '">';
                        p_html += '   <div class="addLeft">';
                        p_html += '      <p id="p_name">' + item.p_name + p_stand + '</p>';
                        p_html += '    </div>';
                        p_html += '   <div class="addRight">';
                        p_html += ' <input type="hidden"  class="p_amt_out" value="' + item.p_amt_out + '">';
                        p_html += '      <p id="p_amt">' + Number(item.p_amt_out).toLocaleString('en') + '</p>';
                        p_html += '    </div>';
                        p_html += '</li>';


                    });

                    $(".addProduct").append(p_html);
                    $(".proWrap").on("click", function() {

                        //상품 입출고 타입 ("200002"== 폐유(입고))
                        var addProType = $(this).children('input[name="p_type"]').val();


                        if (addProType != "200002") { //출고
                            var io_type = '-1';
                            var li_id = Number($(".outCnt").val()) + 1;
                        } else {
                            var io_type = '1';
                            var li_id = Number($(".inCnt").val()) + 1;
                        }

                        html += '<li id="' + li_id + '" class="outProduct">';
                        html += ' <input type="hidden"  name="io_type[]" value="' + io_type + '">';
                        html += ' <input type="hidden"  name="p_idx[]" value="' + $(this).find('input[name="add_p_idx"]').val() + '">';
                        html += ' <input type="hidden"  name="iop_idx[]" value="0">';
                        html += '   <div class="opWrap">';
                        html += '       <div class="opLeft">';
                        html += '           <div class="opTitle"><span>' + $(this).find('.addLeft p').text() + '</span></div>';
                        html += '           <div class="opTitle priceTxt">';
                        html += '               <input type="hidden"  name="amt_price[]" value="' + Number($(this).find('.p_amt_out').val()) + '">';

                        if (addProType != "200002") { //출고
                            html += '           <input type="hidden"  name="out_amt[]" value="1">';
                            html += '           <input type="hidden"  name="out_total[]" value="' + Number($(this).find('.p_amt_out').val()) + '">';
                            html += '           <input type="hidden"  name="in_amt[]" value="0">';
                            html += '           <input type="hidden"  name="in_total[]" value="0">';
                        } else {
                            html += '           <input type="hidden"  name="out_amt[]" value="0">';
                            html += '           <input type="hidden"  name="out_total[]" value="0">';
                            html += '           <input type="hidden"  name="in_amt[]" value="1">';
                            html += '           <input type="hidden"  name="in_total[]" value="' + Number($(this).find('.p_amt_out').val()) + '">';

                        }


                        html += '               <p>' + $(this).find('.addRight p').text() + '</p>';
                        html += '           </div>';
                        html += '       </div>';
                        html += '    <div class="opRight">';
                        html += '       <div class="cntWrap">';
                        html += '           <div id="del" class="cntBtn minus">-</div>';
                        html += '           <input type="text" class="cntInput" value="1" readonly>';
                        html += '           <div id="add" class="cntBtn plus ">+</div>';
                        html += '       </div>';
                        html += '     </div>';
                        html += '<div class="delBtnWrap"><div  id="' + li_id + '" class="delBtn">삭제</div></div>';
                        html += '   </div>';

                        html += '</li>';

                        if (addProType != "200002") { //출고
                            $("#setOutList").append(html);
                            $(".outCnt").val(li_id);
                            $(".outHd span:nth-child(2)").text("(" + $('#setOutList>li').length + ")"); //추가한 상품개수 
                            //$(".outHd span:last-child").text("("+li_id+")");
                            //$('#setOutList > li').last().attr('id')

                        } else {
                            $("#setInList").append(html);
                            $(".inCnt").val(li_id);
                            $(".inHd span:nth-child(2)").text("(" + $('#setInList>li').length + ")"); //추가한 상품개수 
                            // $(".inHd span:last-child").text("("+(li_id-90)+")");

                        }
                        //총합계 구하기
                        getTotal();

                        $(".addPro").css("display", "none");
                    });
                } else {
                    $(".noPro").show();
                    $(".addProduct").hide();
                }
            }); // e.preventDefault;


            // }
        }

        function insertOrder(flag, io_idx) {
            chkSave = 1;

            //  console.log($('#write_form').serialize());
            //POST rest호출
            var p_idx = [];
            var io_type = [];
            var iop_idx = [];
            var amt_price = [];
            var out_amt = [];
            var out_total = [];
            var in_amt = [];
            var in_total = [];

            for (var i = 0; i < $('input[name="p_idx[]"]').length; i++) {
                //list.push($(item).val());
                p_idx.push($('input[name="p_idx[]"]').eq(i).val());
                io_type.push($('input[name="io_type[]"]').eq(i).val());
                iop_idx.push($('input[name="iop_idx[]"]').eq(i).val());
                amt_price.push($('input[name="amt_price[]"]').eq(i).val());
                out_amt.push($('input[name="out_amt[]"]').eq(i).val());
                out_total.push($('input[name="out_total[]"]').eq(i).val());
                in_amt.push($('input[name="in_amt[]"]').eq(i).val());
                in_total.push($('input[name="in_total[]"]').eq(i).val());
            }
            //삭제한 상품수만큼 iop_idx 배열생성 
            /*  for (var i = 0; i < $('input[name="del_idx[]"]').length; i++) {
                  del_idx.push($('input[name="del_idx[]"]').eq(i).val());
              }*/

            //console.log(del_idx);

            //alert(flag);

            request('json/order-update.php', io_idx, {
                "flag": flag,
                "u_idx": localStorage.getItem('u_idx'),
                "rider_idx": localStorage.getItem('rider_idx'),
                "u_token": localStorage.getItem('u_token'),
                "center_idx": localStorage.getItem('center_idx'),
                "io_date": $("input[name='io_date']").val(),
                "io_status": $('input[name="io_status"]').val(),
                "store_idx": $("input[name='store_idx']").val(),
                "io_amt": $("input[name='io_amt']").val(),
                "memo": $(".ordMemo").val(),
                // "data_all": $('#write_form').serializeArray(),
                "io_idx": io_idx,
                "p_idx": p_idx,
                "io_type": io_type,
                "iop_idx": iop_idx,
                "amt_price": amt_price,
                "out_amt": out_amt,
                "out_total": out_total,
                "in_amt": in_amt,
                "in_total": in_total,
                "del_idx": del_idx

            }).then(function(resp) {
                //     console.log(resp);
                // var insertNum = resp.data.data.num; //insert된 리뷰num(이미지전송시에도 사용)

                var insertNum = resp.data.data.row;
                // console.log(pet_num);
                if (insertNum) {
                    if (flag == 'DELETE') {
                        msgToast('삭제되었습니다.');
                    } else if (insertNum > 0) {
                        msgToast('저장되었습니다.');
                    }


                    setTimeout(function() {
                        location.href = "order_list.html";
                    }, 1500);
                } else {
                    chkSave = 0;
                    alertBox('저장되지 않았습니다. 관리자에게 문의하세요');
                    // return false;
                }
            });

        }
    </script>
    <!-- 데이트피커 js/css -->
    <link rel="stylesheet" href="./datepicker.css">

    <script>
        $(function() {

            //jQuery(function($){
            $.datepicker.regional["ko"] = {
                closeText: "취소",
                prevText: "이전달",
                nextText: "다음달",
                currentText: "오늘",
                monthNames: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
                monthNamesShort: ["1월", "2월", "3월", "4월", "5월", "6월", "7월", "8월", "9월", "10월", "11월", "12월"],
                dayNames: ["일", "월", "화", "수", "목", "금", "토"],
                dayNamesShort: ["일", "월", "화", "수", "목", "금", "토"],
                dayNamesMin: ["일", "월", "화", "수", "목", "금", "토"],
                changeMonth: true, // month 셀렉트박스 사용
                changeYear: true, // year 셀렉트박스 사용
                weekHeader: "Wk",
                dateFormat: "yy-mm-dd",
                firstDay: 0,
                isRTL: false,
                showOtherMonths: true, //월 1일 이전, 월 말일 이후 빈칸에 이전달, 다음달 날짜 출력 여부
                selectOtherMonths: true, //showOtherMonths 선택가능
                showMonthAfterYear: true, //연도선택이 왼쪽에 위치 
                yearSuffix: ""
            };
            $.datepicker.setDefaults($.datepicker.regional["ko"]);

            // Today 버튼 코드 추가
            $.datepicker._gotoToday = function(id) {
                $(id).datepicker('setDate', new Date()).datepicker('hide').blur();
                $(".ui-datepicker").hide().blur();
            };
        });

        $("input[name=io_date]").change(function() {
            //저장버튼 활성화
            chkSave = 0;
            $("#saveBtn").css("background", "rgb(241, 121, 126)");
        });

        $('#io_date,#edate').datepicker({
            closeText: '취소',
            showButtonPanel: true,
            onClose: function() {
                if ($(window.event.srcElement).hasClass('ui-datepicker-close')) {
                    // $(this).val('');
                }
            },
            beforeShow: function() { // z-index 부여 
                setTimeout(function() {
                    $('.ui-datepicker').css('z-index', 999);
                }, 0);
            }
        });
        //});
    </script>
    <!--#wrap-->






</body></html>
