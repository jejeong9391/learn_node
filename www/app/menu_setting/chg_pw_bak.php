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
    <!--구글아이콘-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--alert플러그인-->
    <link href="../lib/plugin/modal-master/css/jquery.modal.css" type="text/css" rel="stylesheet" />
    <link href="../lib/plugin/modal-master/css/jquery.modal.theme-xenon.css" type="text/css" rel="stylesheet" />
    <link href="../lib/plugin/modal-master/css/jquery.modal.theme-atlant.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="../lib/plugin/modal-master/js/jquery.modal.js"></script>
    <!--rest-->
    <script type="text/javascript" src="./../lib/js/function.js"></script>

    <!--main_list 공통js-->
    <link href="../reset.css" rel="stylesheet">
    <link href="./login.css" rel="stylesheet">

</head>
<style>
    .left {
        /*왼쪽 화살표 만들기*/
        margin: 20px;
        transform: rotate(135deg);
        -webkit-transform: rotate(135deg);
        border: solid;
        border-width: 0 1px 1px 0;
        display: inline-block;
        padding: 8px;
    }
</style>

<body>
    <header id="header" style="background: #fff;">
        <!--         <div class="btnBack" id="topBack" onclick="history.back();" style="padding-left: 10px;"><i class="material-icons" style="display: block; line-height: 50px; ">arrow_back</i></div> -->
    </header>
    <!--#header-->
    <div style="height: 50px; border-bottom: 0;">
    </div>
    <div id="mb_login" class="mbskin">
        <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post" id="flogin" style="margin:0;">
            <input type="hidden" name="url" value="<?php echo $login_url ?>">

            <div style="width:100%;">
                <h2 class="login_title">비밀번호 변경</h2>
            </div>

            <div id="login_frm">
                <!--   <label for="login_id" class="sound_only">아이디</label>-->

                <input type="password" name="chg_pw" id="chg_pw" placeholder=" 새 비밀번호 (4자이상 입력)" class="frm_input">
                <p id="pw_noti" class="pw_notice">*4자리 이상 입력해주세요.</p>
                <!-- <label for="login_pw" class="sound_only">비밀번호</label>-->
                <input type="password" name="chg_pw2" id="chg_pw2" placeholder="비밀번호 확인" class="frm_input">
                <p id="pw2_noti" class="pw_notice">*비밀번호가 일치하지 않습니다.</p>
            </div>
            <div id="udt_pw" class="dis_btn" style="margin:0">
                <span>변경하기</span>
            </div>
        </form>
        <div class="loginNotice">
            <!--            <span style="text-align:center;">로그인 정보 분실 시, 관리자에게 문의하세요.</span>-->
            <!-- &nbsp;&nbsp;&nbsp; -->
        </div>
    </div>
    <div class="toast" style="display:none; position: absolute; bottom: 0;height: 30px; line-height: 30px;"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
    <script type="text/javascript">
        //로그아웃 상태이면 로그인 선행 
        if (localStorage.getItem('u_idx') == null) {
            alertBox('로그인 후 진행해주세요.', goLogin);
        }

        console.log(localStorage.getItem('u_idx'));
        $(function() {

            //비밀번호 4자이상 입력 확인
            $("#chg_pw").on('blur', function() {
                var pw_lng = $(this).val().length;
                if ((0 < pw_lng) && (pw_lng < 4)) {
                    $("#pw_noti").css('display', 'block');
                    $(this).focus();
                } else {
                    $("#pw_noti").css('display', 'none');
                    $("#chg_pw2").focus();
                }
            });
            //비밀번호 일치 확인
            $("#chg_pw2").keyup(function(key) { //keydown은 늦게 감지되어 한번더 쳐야 체크되는 문제가 있음. 
                if ($(this).val() != $("#chg_pw").val()) {
                    $("#pw2_noti").css('display', 'block');
                    $("#udt_pw").attr('class', 'dis_btn');
                    $(this).focus();
                } else {
                    $("#pw2_noti").css('display', 'none');
                    //$("#pw2_noti").css('visibility', 'hidden');
                    $("#udt_pw").attr('class', 'btn_sub');
                }
            });

            $("#udt_pw").on('click', function() {
                // idx가져오려면 common가져와야함. 
                //업뎃하기전 세션에 저장된 로그인 id 또는 idx + 변경 pw 보내서 유효성 검사진행하고 update처리할 것 
                // 업데이트하면 로그인 다시하라고 보내고! 
                updatePw();
            });
        });

        //샵스타일목록 rest호출
        function updatePw(u_id, u_pass) {
            var pw1 = $("#chg_pw").val();
            var pw2 = $("#chg_pw2").val();

            if ((pw1 == '') || (pw2 == '')) {
                alertBox("새 비밀번호를 입력해주세요.");
                return false;
            } else if (pw1 != pw2) {
                alertBox("비밀번호가 일치하지않습니다. 다시 입력해주세요.", emtpyPw2);

                function emtpyPw2() { $("#chg_pw2").val(''); }

            } else {
                request('json/pw-update.php', '', {
                    "flag": "PUT",
                    "u_token": localStorage.getItem('u_token'),
                    "u_idx": localStorage.getItem('u_idx'),
                    "new_pw": $("#chg_pw2").val()

                }).then(function(resp) {
                    //   var rowsNum = resp.data.meta.rows;
                    var result = resp.data.data.row;
                    if (result > 0) {
                      //  logout();
                        alertBox('비밀번호가 변경되었습니다. 다시 로그인해주세요', goLogin);
                       localStorage.clear();

                    } else {
                        alertBox("비밀번호 변경에 실패하였습니다. 다시 시도해주세요.");
                        $("#chg_pw").val('');
                        $("#chg_pw2").val('');
                    }
                });
            }
        }
    </script>
</body></html>
