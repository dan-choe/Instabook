<?
include ("./includes.php");

if($_SESSION[user_id]){
    ?>
     <script>
        alert("You are already logged in");
        history.back();
    </script>
    <?
}
?>
<br/>
<table style="width:100%; height:50px;border:5px #CCCCCC solid;">
    <tr>
        <td align="center" valign="middle" style="font-size:15px;font-weight:bold;">
		상담일지 기록하기</td>
    </tr>
</table>
<br/>
<form name="registForm" method="post" action="./writehistory_save.php" style="margin:0px;">
<table style="width:100%;height:50px;border:0px;">
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">방문일시</td>
        <td align="left" valign="middle" style="height:50px;">자동생성</td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">고객 성명</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="r_name" style="width:100%;"></td>
    </tr>
	<tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">휴대폰번호</td>
        <td align="left" valign="middle" style="height:50px;"><input type="text" name="r_phone" style="width:100%;"></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">매수 의뢰내용</td>
        <td align="left" valign="middle" style="height:50px;"><textarea rows='4' cols='80' name='r_content1'></textarea></td>
    </tr>
    <tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">매도 의뢰내용</td>
        <td align="left" valign="middle" style="height:50px;"><textarea rows='4' cols='80' name='r_content2'></textarea></td>
    </tr>


	<tr>
        <td align="center" valign="middle" style="height:50px;background-color:#CCCCCC;">기타 의뢰내용</td>
        <td align="left" valign="middle" style="height:50px;"><textarea rows='4' cols='80' name='r_content3'></textarea></td>
    </tr>
	

	<tr>
    <td>부동산 종류</td>
    <td>
	<input type="checkbox" name="rtype[]" value="땅" /><label for="cbox2">땅</label>
	<input type="checkbox" name="rtype[]" value="원룸" /><label for="cbox2">원룸</label>
	<input type="checkbox" name="rtype[]" value="아파트" /><label for="cbox2">아파트</label>
	
	<input type="checkbox" name="rtype[]" value="기타주택" /><label for="cbox2">기타주택</label>
	<input type="checkbox" name="rtype[]" value="상가" /><label for="cbox2">상가</label>
	<input type="checkbox" name="rtype[]" value="공장" /> <label for="cbox2">공장</label>
	
	<input type="checkbox" name="rtype[]" value="빌딩" /><label for="cbox2">빌딩</label>
	<input type="checkbox" name="rtype[]" value="기타" /><label for="cbox2">기타</label>
	
	
	
    </td>
  </tr>


    <tr>
        <td align="center" valign="middle" colspan="2"><input type="button" value=" 저장하기 " onClick="member_save();"></td>
    </tr>
</table>
</form>
<script>
function member_save()
{
    var f = document.registForm;

    if(f.r_name.value == ""){
        alert("이름을 입력하세요.");
        return false;
    }
    f.submit();

}
</script>
