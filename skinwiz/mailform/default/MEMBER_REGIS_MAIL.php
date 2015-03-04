<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'>
<html>
<head>
<title>회원가입축하메일</title>
<link href="{url}/css/base.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
.body {width:650px;border:1px solid #dddddd;}
.content{padding:50px}
.subinfo{padding:20px;text-align:right;}
.bottominfo{padding:20px;text-align:right;border-top:1px solid #dddddd;}
.infobox{font-weight:bold}
</style>
</head>

<body>
    <div class="body">
        <img src="{url}/images/img_member.gif" width="650" height="118" />
        
        <div class="content">
            안녕하세요. <strong>{username}</strong> 고객님 <br />
            <br />
            <font color=#FF6600>{admin.title}</font> 회원이 되신것을 진심으로 환영합니다.<br>
            <br />
            {content}<br />
            <br />
            회원님이 가입하신 정보는 아래와 같습니다. <br>
            <br />
          <span class="infobox">아이디 : {userid}</span><br />
          <span class="infobox">비밀번호 : {userpwd}</span>
      </div>
        
        <div>
            <a href="{homeurl}" target="_blank"><img src="{url}/images/but_shopping.gif" width="122" height="48" border="0" /></a>
            <a href="{homeurl}/wizmember.php?query=info" target="_blank"><img src="{url}/images/but_info.gif" width="105" height="48" border="0" /></a>
        </div>
        
        <div class="subinfo">
            {admin.title}<br />
            {admin.name}
        </div>
        
        <div class="bottominfo">
            공정거래위원회 고시 제2000-1호에 따른 안내 사업자번호 : {admin.companynum}<br />
            주소 :{admin.companyaddress}상호 : {admin.companyname} 대표자명 : {admin.companyceo}<br />
            쇼핑몰명:{admin.title} ☎ 연락처 : {admin.companytel}, 팩스번호: {admin.companyfax}
        </div>
    </div>
</body>
</html>