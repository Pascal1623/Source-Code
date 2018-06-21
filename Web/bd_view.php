<!-- 기본 설정 -->
<?php
  $conn = mysql_connect("localhost", "root", "apmsetup");
  mysql_select_db("webdb", $conn);
  mysql_query("set names euckr"); //데이터를 넘겨줄 때 모든 charset을 euckr로 통일

  //페이지당 보여지는 게시물의 갯수
  $board_page_view_count = 10;
  //목록에 선택되어 있는 페이지
  $page = empty($_GET['page']) ? 1 : $_GET['page'];
  //검색 유형 : 제목, 내용, 작성자
  $smethod = empty($_GET['smethod']) ? null : $_GET['smethod'];
  //검색 텍스트
  $sstring = empty($_GET['sstring']) ? null : $_GET['sstring'];
  //보여줄 게시물 번호
  $num = $_GET['num'];

  $count_query = "update board set count = count + 1 where num =".$num;
  mysql_query($count_query);

  $view_query = "select * from board where num = ".$num;
  $view_result = mysql_query($view_query, $conn);
  $list = mysql_fetch_array($view_result);
?>
<html>
  <head>
    <title>게시판 만들기__게시물 보기(View) :::::::::</title>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
    <link rel="stylesheet" href="./board_style.css">
  </head>
  <body>
    <div id="Layer1">
      <br><br><br><br><br><br>
      <table width="760" border="0" cellspacing="0" cellpadding="0" height="100%">
        <tr>
          <td valign="top" colspan="6">
            <table width="700" border="0" cellspacing="0" cellpadding="0" height="370">
              <tr>
                <td valign="top" align=center>
                  <!-- 정보 표시 -->
                  <table border="1" cellpadding="3" cellspacing="0" width="630" bordercolor="faf0e6">
                    <tr height="30">
                      <td align="center" width="120" bgcolor="f0f8ff">Name</td><td><?php print $list["writer"] ?></td>
                      <td align="center" width="120" bgcolor="f0f8ff">E-mail</td><td><a href="mailto:<?php $list["email"] ?>"><?php print $list["email"] ?></a></td>
                    </tr>
                    <tr height="30">
                      <td align="center" width="120" bgcolor="f0f8ff">Title</td><td colspan="3"><?php print $list["title"] ?></td>
                    </tr>
                    <tr	height="30">
                      <td colspan="4" align="center" bgcolor="f0f8ff">Content</td>
                    </tr>
                    <tr height="300">
                      <td colspan="4"><?php print str_replace(chr(13), "<br>", $list["content"]) ?></td>
                    </tr>
                    <tr height="30">
                      <td align="center" width="120" bgcolor="f0f8ff">Date / Time</td><td><?php print $list["wdate"] ?> / <?php print $list["wtime"] ?></td>
                      <td align="center" width="120" bgcolor="f0f8ff">Connect IP</td><td><?php print $list["connect_ip"] ?></td>
                    </tr>
                    <tr height="30">
                      <td align="center" width="120" bgcolor="f0f8ff">File</td><td colspan="3"><a href="./upload/board/<?php print $list["num"]."_".$list["filename"] ?>"><?php print $list["filename"] ?></a></td>
                    </tr>
                  </table>
                  <!-- 각각의 링크 -->
                  <table border="0" cellpadding="3" cellspacing="0" width="630">
                    <tr height="30">
                      <td align="right">
                        <?php
                          print "<a href='bd.php?page=".$page;
                          if ($sstring != null)
                          {
                            print "&smethod=".$smethod."&sstring=".$sstring;
                          }
                          print "'>목록</a>&nbsp;&nbsp";
                        ?>
                        <a href="bd_write.php?mode=update&num=<?php print $num ?>&page=<?php print $page ?>">수정</a>&nbsp;&nbsp;
                        <a href="bd_write.php?mode=reply&num=<?php print $num ?>&page=<?php print $page ?>">댓글달기</a>&nbsp;&nbsp;
                        <a href="bd_delete.php?mode=delete&num=<?php print $num ?>&page=<?php print $page ?>">삭제</a>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
  </body>
</html>
