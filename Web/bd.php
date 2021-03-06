<!-- 기본 설정 -->
<?php
  include("include.inc");
  mysql_query("set names euckr"); //데이터를 넘겨줄 때 모든 charset을 euckr로 통일
  $board_page_view_count = 10; //최대 페이지 수
  $board_record_view_count = 10; //한 페이지당 최대 레코드 수
  $line_distance = 13; //레코드마다 있는 선의 거리, 최소 14
  //현재 페이지
  $page = empty($_GET['page']) ? 1 : $_GET['page'];
  //검색 유형 : 제목, 내용, 작성자
  $smethod = empty($_POST['smethod']) ? (empty($_GET['smethod']) ? null : $_GET['smethod']) : $_POST['smethod'];
  //검색 텍스트
  $sstring = empty($_POST['sstring']) ? (empty($_GET['sstring']) ? null : $_GET['sstring']) : $_POST['sstring'];

  $view_query = "select * from board where reply = 0 ";
  if ($sstring != null)
  {
    $view_query .= "and ".$smethod." like '%".$sstring."%' ";
  }
  $view_query .= "order by root desc";

  $list_result = mysql_query($view_query, $conn);

  // 게시물의 총 갯수를 얻어온다.
  $totalCount = mysql_num_rows($list_result);
  //print "record no#=".$totalCount;
  // 얻어온 게시물로 전체 페이지 수를 계산한다.
?>
<html>
  <head>
    <title>게시판 ::::::::::</title>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
    <link rel="stylesheet" href="./board_style.css">
  </head>
  <body>
    <table width="760" cellspacing="0" cellpadding="0" height="100%">
      <tr>
        <td valign="top" colspan="6">
          <table width="700" border="0" cellspacing="0" cellpadding="0" height="370">
            <tr>
              <td width="139" valign="bottom" height="50" align="center" id="title"><b>게시판</b></td>
            </tr>
            <tr>
              <td align="center">
                <table cellspacing="0" cellpadding="0" width="630">
                  <tr align="right">
                    <td>게시글 수 : <?php print $totalCount; ?></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td valign="top" align="center">
      					<table cellspacing="0" cellpadding="0" width="630">
                  <!-- 제목 -->
      						<tr height="26" align="center" bgcolor="f0f8ff">
      							<td width="60">num</td>
      							<td width="330">제목</td>
      							<td width="110">글쓴이</td>
      							<td width="72">작성일자</td>
      							<td width="58">조회수</td>
      						</tr>
                  <!-- 리스트 출력 부분 -->
                  <tr>
                    <?php
                      $board_index = 0;
        							$record_index = 0;

        							while ($list = mysql_fetch_array($list_result))
        							{
                        $board_index++;

                        if ($board_index > ($page - 1) * $board_record_view_count)
                        {
                          $record_index++;

          								print "<tr height='16'>";
            								print "<td align='center'>".$list["root"]."</td>";
            								print "<td><a href='bd_view.php?page=".$page."&num=".$list["num"];
                            if ($sstring != null)
                            {
                              print "&smethod=".$smethod."&sstring=".$sstring;
                            }
                            print "'>".$list["title"]."</a></td>";
            								print "<td align='center'>".$list["writer"]."</td>";
            								print "<td align='center'>".$list["wdate"]."</td>";
            								print "<td align='center'>".$list["count"]."</td>";
                          print "</tr>";
          								print "<tr height='".$line_distance."'><td colspan='5'><hr></td></tr>"; //데이터 목록마다 줄로 구분

          								Sub_List($list["num"], 1, "board");

          								if ($record_index == $board_record_view_count && $page * $board_record_view_count <= $board_index)
          								{
          									print "<tr height='0'><td colspan=5><hr></td></tr>";
          								}

                          if ($record_index == $board_record_view_count) break;
                        }
        							}

                      //빈 행들이 있을 경우 빈칸으로 채워줌
        							if (0 < $record_index && $record_index < $board_record_view_count)
        							{
      									for ($temp = $record_index; $temp < $board_record_view_count; $temp++)
      									{
      										print "<tr height='16'><td colspan='5'>&nbsp;</td></tr>";
      										print "<tr><td colspan='5' align='center'><hr></td></tr>";
      									}
      								}

      								if ($record_index == 0)
      								{
      									print "<tr height='".(($board_record_view_count + $line_distance) * 14)."'><td colspan='5' align='center'>.......... 등록된 내용이 없습니다 ..........</td></tr>";
      									print "<tr><td colspan='5' align='center'><hr></td></tr>";
      								}
      							?>
                  </tr>
      					</table>
  					    <br>
  					    <table cellspacing="0" cellpadding="0" width="680">
                  <tr height="16" align="center" valign="center">
                    <!-- 이전 페이지목록 링크 -->
                    <td width="80">
                      <?php
                        $page_unit = floor(($page - 1) / $board_page_view_count) * $board_page_view_count + 1; //큰 페이지 구분

                        if ($page > $board_page_view_count)
                        {
                          print "<a href='bd.php?page=".($page_unit - $board_page_view_count);
                          if ($sstring != null)
                          {
                            print "&smethod=".$smethod."&sstring=".$sstring;
                          }
                          print "'>◀</a>";
                        }
                      ?>
                    </td>
                    <!-- 페이지 목록 출력 -->
                    <td width="350">
                      <?php
  											for ($page_index = $page_unit; $page_index <= $page_unit + $board_page_view_count - 1; $page_index++)
  											{
                          if ($page_index <> $page)
                          {
                            print "<a href='bd.php?&page=".$page_index;
                            if ($sstring != null)
                            {
                              print "&smethod=".$smethod."&sstring=".$sstring;
                            }
                            print "'>";
                          }
                          else
                          {
                            print "<font color='red'>".$page_index."</font>";
                          }

  												if ($page_index * $board_record_view_count >= $totalCount)
  												{
  													if ($page_index <> $page)
  													{
  														print $page_index."</a>";
  													}

  													break;
                            //레코드 있는 부분만 표시하고 싶으면 break
  												}
  												else
  												{
                            if ($page_index <> $page)
                            {
                              print "<font color='#006699'>".$page_index."</font></a>";
                            }
  												}

                          if ($page_index < $page_unit + $board_page_view_count - 1)
                          {
                            print " | ";
                          }
  											}
  										?>
                    </td>
                    <!-- 다음 페이지 목록 링크 -->
                    <td width="80">
                      <?php
                        if ($page_unit + $board_page_view_count< $totalCount / $board_record_view_count)
                        {
                          print "<a href='bd.php?page=".($page_unit + $board_page_view_count);
                          if ($sstring != null)
                          {
                            print "&smethod=".$smethod."&sstring=".$sstring;
                          }
                          print "'>▶</a>";
                        }
                      ?>
                    </td>
                    <!-- 검색 -->
                    <td width="320" valign="center">
                      <form name="search" method="post" action="bd.php">
                        <table cellspacing="3" cellpadding="0">
                          <tr>
                            <td>
                              <select name="smethod" class="formbox">
                                <?php
                                  print "<option value='title'";
                                  if ($smethod == "title") print " selected";
                                  print ">Title</option>";

                                  print "<option value='content'";
                                  if ($smethod == "content") print " selected";
                                  print ">Content</option>";

                                  print "<option value='writer'";
                                  if ($smethod == "writer") print " selected";
                                  print ">Writer</option>";
                                ?>
                              </select>
                            </td>
                            <td><input type="text" name="sstring" size="10" value="<?php print $sstring ?>" style="border: 1px dashed"></td>
                            <td><a href="javascript:document.search.submit()">[검색]</a></td>
                          </tr>
                        </table>
                      </form>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right">
                      <?php
                        print "<a href='bd_write.php?mode=insert&page=".$page;
                        if ($sstring != null)
                        {
                          print "&smethod=".$smethod."&sstring=".$sstring;
                        }
                        print "'>[글쓰기]</a>";
                      ?>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
