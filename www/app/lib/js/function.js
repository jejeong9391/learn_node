//rest 호출
async function request(endpoint, query, data) {

    var sessionVal = localStorage.getItem('u_token');
    //alert(endpoint);
    if (endpoint != 'json/login.php')chk_session(); //로그인이 아닐경우 세션체크 먼저
 
    try {
        let t0 = performance.now()
        //
        let url = 'http://oil.mesoft.kr/' + endpoint + '/' + query
        // let url = 'http://prape.co.kr/' + endpoint + '/' + query
        console.log('>> request', endpoint, url, data)
        let resp = await axios.post(url, data)
        //
        let t1 = performance.now()
        console.log('<< respond', endpoint, parseInt(t1 - t0), 'ms', resp.data)

        //console.log(resp.data);    
        return resp
    } catch (e) {
        console.error('request error', e);
    }
}
/*  } else {
            //chk_session();
            alert('세션없음요');
        }
*/



//세션체크
function chk_session() {
    try {
        if (window.localStorage) {

            //localStorage.getItem(key); //key명 입력 시, 해당 value 출력됨 
            var sessionVal = localStorage.getItem('u_token');
            if (!sessionVal) {
                console.log('0. token없음');
                //alert('로그아웃 되었습니다. 다시 로그인해주세요.');
                alertBox('로그아웃 되었습니다. 다시 로그인해주세요.', goLogin);

                /* msgToast('로그아웃 되었습니다. <br> 다시 로그인해주세요.');
                 setTimeout(function() {
                       location.href = "/menu_setting/login.html";
                 }, 1200);*/
                /// alert, confirm 플러그인 쓸까...?
            } else {
                console.log('세션값 있음 : ' + sessionVal);
                console.log('u_idx : ' + localStorage.getItem('u_idx'));
                console.log('rider_idx : ' + localStorage.getItem('rider_idx'));
                console.log('center : ' + localStorage.getItem('center_idx'));

                return sessionVal;
            }
        } else {
            //alert("세션을 사용할 수 없는 브라우저입니다.");
            alertBox("세션을 사용할 수 없는 브라우저입니다.");
        }
    } catch (e) {
        console.error('check error', e);
        //세션없는경우 로그인페이지로 이동처리 
        //alert('ddd');
        //goLogin();
        alertBox('로그아웃 되었습니다. 다시 로그인해주세요.', goLogin);
    }
}


//toast div 띄우기
/* <div class='toast' style='display:none'></div> 추가해서 사용 */
function msgToast(msg) {
    $('.toast').html(msg);
    /*  $('.toast').fadeIn(400).delay(1000).fadeOut(400);*/
    $('.toast').fadeIn(200).delay(800).fadeOut(200);
}
$(function () {
   /* var path = window.location.pathname;
    // alert(path);
       console.log('function.js');
    if (path != '/app/menu_setting/login.html') {
    chk_session();
    }
    */
});

// get 파라미터로 넘긴 값 구하기
function getParamByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


//수량조절



//오늘 날짜 구하기
var date = new Date();
var gDay = date.getDay(); //요일구하기
var today = makeDate(date); //오늘날짜 반환

function lastWeek() {
    var d = new Date();
    var dayOfMonth = d.getDate();
    d.setDate(dayOfMonth + 7);
    return makeDate(d);
}

//날짜형식 만들기 (2020-03-17)
function makeDate(objDate) {
    return (objDate.getFullYear() + '-' + ("0" + (objDate.getMonth() + 1)).slice(-2) + '-' + ("0" + objDate.getDate()).slice(-2))
}



//========== datePicker /// 공통으로 사용하면 쓰지않는 페이지에서 오류발생함============
/*$(function () {
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
        showMonthAfterYear: true,
        yearSuffix: ""
    };
    $.datepicker.setDefaults($.datepicker.regional["ko"]);

    // Today 버튼 코드 추가
    $.datepicker._gotoToday = function (id) {
        $(id).datepicker('setDate', new Date());
        $(".ui-datepicker").hide().blur();
    };
});*/
function goLogin() {
    location.href = "/app/menu_setting/login.html";
}
//====================== alert 플러그인 사용
function alertBox(txt, callbackMethod, jsonData) {
    modal({
        type: 'alert',
         title: '알림',
        //title: 'Alert',
        text: txt,
        callback: function (result) {
            if (callbackMethod) {
                callbackMethod(jsonData);
            }
        }
    });
}

function alertBoxFocus(txt, obj) {
    modal({
        type: 'alert',
        title: '알림',
        //title: 'Alert',
        text: txt,
        callback: function (result) {
            obj.focus();
        }
    });
}


function confirmBox(txt, callbackMethod, jsonData) {
    modal({
        type: 'confirm',
        title: '알림',
       // title: 'Alert',
        text: txt,
        callback: function (result) {
            if (result) {
                callbackMethod(jsonData);
               
            }
        }
    });
}

function promptBox(txt, callbackMethod, jsonData) {
    modal({
        type: 'prompt',
        title: 'Prompt',
        text: txt,
        callback: function (result) {
            if (result) {
                callbackMethod(jsonData);
            }
        }
    });
}

function successBox(txt) {
    modal({
        type: 'success',
        title: 'Success',
        text: txt
    });
}

function warningBox(txt) {
    modal({
        type: 'warning',
        title: 'Warning',
        text: txt,
        center: false
    });
}

function infoBox(txt) {
    modal({
        type: 'info',
        title: 'Info',
        text: txt,
        autoclose: false,
        closable: false

    });
}

function errorBox(txt) {
    modal({
        type: 'error',
        title: 'Error',
        text: txt
    });
}

function invertedBox(txt) {
    modal({
        type: 'inverted',
        title: 'Inverted',
        text: txt
    });
}

function primaryBox(txt) {
    modal({
        type: 'primary',
        title: 'Primary',
        text: txt
    });
}
