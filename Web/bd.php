<!-- �⺻ ���� -->
<?php
  include("include.inc");
  mysql_query("set names euckr"); //�����͸� �Ѱ��� �� ��� charset�� euckr�� ����
  $board_page_view_count = 10; //�ִ� ������ ��
  $board_record_view_count = 10; //�� �������� �ִ� ���ڵ� ��
  $line_distance = 13; //���ڵ帶�� �ִ� ���� �Ÿ�, �ּ� 14
  //���� ������
  $page = empty($_GET['page']) ? 1 : $_GET['page'];
  //�˻� ���� : ����, ����, �ۼ���
  $smethod = empty($_POST['smethod']) ? (empty($_GET['smethod']) ? null : $_GET['smethod']) : $_POST['smethod'];
  //�˻� �ؽ�Ʈ
  $sstring = empty($_POST['sstring']) ? (empty($_GET['sstring']) ? null : $_GET['sstring']) : $_POST['sstring'];

  $view_query = "select * from board where reply = 0 ";
  if ($sstring != null)
  {
    $view_query .= "and ".$smethod." like '%".$sstring."%' ";
  }
  $view_query .= "order by root desc";

  $list_result = mysql_query($view_query, $conn);

  // �Խù��� �� ������ ���´�.
  $totalCount = mysql_num_rows($list_result);
  //print "record no#=".$totalCount;
  // ���� �Խù��� ��ü ������ ���� ����Ѵ�.
?>
<html>
  <head>
    <title>�Խ��� ::::::::::</title>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
    <link rel="stylesheet" href="./board_style.css">
  </head>
  <body>
    <table width="760" cellspacing="0" cellpadding="0" height="100%">
      <tr>
        <td valign="top" colspan="6">
          <table width="700" border="0" cellspacing="0" cellpadding="0" height="370">
            <tr>
              <td width="139" valign="bottom" height="50" align="center" id="title"><b>�Խ���</b></td>
            </tr>
            <tr>
              <td align="center">
                <table cellspacing="0" cellpadding="0" width="630">
                  <tr align="right">
                    <td>�Խñ� �� : <?php print $totalCount; ?></td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td valign="top" align="center">
      					<table cellspacing="0" cellpadding="0" width="630">
                  <!-- ���� -->
      						<tr height="26" align="center" bgcolor="f0f8ff">
      							<td width="60">num</td>
      							<td width="330">����</td>
      							<td width="110">�۾���</td>
      							<td width="72">�ۼ�����</td>
      							<td width="58">��ȸ��</td>
      						</tr>
                  <!-- ����Ʈ ��� �κ� -->
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
          								print "<tr height='".$line_distance."'><td colspan='5'><hr></td></tr>"; //������ ��ϸ��� �ٷ� ����

          								Sub_List($list["num"], 1, "board");

          								if ($record_index == $board_record_view_count && $page * $board_record_view_count <= $board_index)
          								{
          									print "<tr height='0'><td colspan=5><hr></td></tr>";
          								}

                          if ($record_index == $board_record_view_count) break;
                        }
        							}

                      //�� ����� ���� ��� ��ĭ���� ä����
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
      									print "<tr height='".(($board_record_view_count + $line_distance) * 14)."'><td colspan='5' align='center'>.......... ��ϵ� ������ �����ϴ� ..........</td></tr>";
      									print "<tr><td colspan='5' align='center'><hr></td></tr>";
      								}
      							?>
                  </tr>
      					</table>
  					    <br>
  					    <table cellspacing="0" cellpadding="0" width="680">
                  <tr height="16" align="center" valign="center">
                    <!-- ���� ��������� ��ũ -->
                    <td width="80">
                      <?php
                        $page_unit = floor(($page - 1) / $board_page_view_count) * $board_page_view_count + 1; //ū ������ ����

                        if ($page > $board_page_view_count)
                        {
                          print "<a href='bd.php?page=".($page_unit - $board_page_view_count);
                          if ($sstring != null)
                          {
                            print "&smethod=".$smethod."&sstring=".$sstring;
                          }
                          print "'>��</a>";
                        }
                      ?>
                    </td>
                    <!-- ������ ��� ��� -->
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
                            //���ڵ� �ִ� �κи� ǥ���ϰ� ������ break
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
                    <!-- ���� ������ ��� ��ũ -->
                    <td width="80">
                      <?php
                        if ($page_unit + $board_page_view_count< $totalCount / $board_record_view_count)
                        {
                          print "<a href='bd.php?page=".($page_unit + $board_page_view_count);
                          if ($sstring != null)
                          {
                            print "&smethod=".$smethod."&sstring=".$sstring;
                          }
                          print "'>��</a>";
                        }
                      ?>
                    </td>
                    <!-- �˻� -->
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
                            <td><a href="javascript:document.search.submit()">[�˻�]</a></td>
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
                        print "'>[�۾���]</a>";
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
