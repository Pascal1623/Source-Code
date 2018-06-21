<!-- 기본 설정 -->
<?php
  include("include.inc");
  mysql_query("set names euckr"); //데이터를 넘겨줄 때 모든 charset을 euckr로 통일

  $num = $_GET['num'];

  $view_query = "select * from board where num = ".$num;
  $view_result = mysql_query($view_query, $conn);
  $list = mysql_fetch_array($view_result);
?>
<html>
  <head>
    <title>게시판 만들기__글 삭제 ::::::::::</title>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
    <link rel="stylesheet" href="./board_style.css">
  </head>
  <body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table width="700" cellspacing="0" cellpadding="0" height="370">
      <tr><td width="139" valign="bottom" height="55" align="center" id="title">게시판 글 삭제 화면</td></tr>
      <tr>
        <td valign="top" align="center"><br>
          <form name="pwddoc" method="post" action="bd_save.php?mode=delete&num=<?php print $num ?>">
            <table border="1" cellpadding="3" cellspacing="0" width="630" bordercolor="faf0e6">
              <tr height="30"><td align="center" width="120" bgcolor="f0f8ff">Name</td><td><?php print $list["writer"] ?></td></tr>
              <tr height="30"><td align="center" width="120" bgcolor="f0f8ff">E-mail</td><td><?php print $list["email"] ?></td></tr>
              <tr height="30"><td align="center" width="120" bgcolor="f0f8ff">Title</td><td><?php print $list["title"] ?></td></tr>
              <tr	height="200"><td align="center" width="120" bgcolor="f0f8ff">Content</td><td><?php print str_replace(chr(13), "<br>", $list["content"]) ?></td></tr>
              <tr height="30"><td align="center" width="120" bgcolor="f0f8ff">Date / Time</td><td><?php print $list["wdate"] ?> / <?php print $list["wtime"] ?></td></tr>
              <tr height="30"><td align="center" width="120" bgcolor="f0f8ff">Connect IP</td><td><?php print $list["connect_ip"] ?></td></tr>
              <tr height="30"><td align="center" width="120" bgcolor="f0f8ff">File</td><td><?php print $list["filename"] ?></td></tr>
              <tr height="30">
                <td align="center" width="120" bgcolor="f0f8ff">Password</td><td><input type="password" name="pwd" size="10" style="border: 1px dashed"></td>
              </tr>
            </table>
            <table cellpadding="3" cellspacing="0" width="630">
              <tr height="30">
                <td align="right">
                  <a href="bd.php">[목록]</a>&nbsp;&nbsp;
                  <a href="javascript:history.back(-1)">[삭제 취소]</a>&nbsp;&nbsp;
                  <a href="javascript:document.pwddoc.submit()">[삭제 실행]</a>
                </td>
              </tr>
            </table>
          </form>
        </td>
      </tr>
    </table>
  </body>
</html>
