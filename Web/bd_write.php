<!-- �⺻ ���� -->
<?php
  include("include.inc");
  mysql_query("set names euckr"); //�����͸� �Ѱ��� �� ��� charset�� euckr�� ����

  $num = empty($_GET['num']) ? null : $_GET['num'];
  $mode = $_GET['mode'];
  $page = $_GET['page'];
  $smethod = empty($_GET['smethod']) ? null : $_GET['smethod'];
  $sstring = empty($_GET['sstring']) ? null : $_GET['sstring'];

  $query = "select ";
  switch ($mode)
  {
    case "reply":
      $query .= "title, content";
      break;
    case "update":
      $query .= "writer, email, title, content";
      break;
  }
  $query .= " from board where num = ".$num;

  if ($result = mysql_query($query, $conn))
  {
    $list = mysql_fetch_array($result);
  }
?>
<html>
  <head>
    <title>�Խ��� �����__�Խ��� ����::::::::::</title>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
    <link rel="stylesheet" href="./board_style.css">
    <script language="JavaScript">
      function check(form)
      {
        if (form.writer.value == "")
        {
          alert("�۾��̸� �Է��� �ֽʽÿ�.");
          return;
        }

        if (form.title.value == "")
        {
          alert("������ �Է��� �ֽʽÿ�.");
          return;
        }

        if (form.pwd.value == "")
        {
          alert("��й�ȣ�� �Է��� �ֽʽÿ�.");
          return;
        }

        form.submit();
      }
    </script>
  </head>
  <body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table width="700" cellspacing="0" cellpadding="0" height="370">
      <tr>
        <td width="139" valign="bottom" height="55" align="center" id="title">
          <?php
            switch ($mode)
            {
              case "reply":
                print "��� ����";
                break;
              case "update":
                print "�Խù� ����";
                break;
              case "insert":
                print "�Խù� �ۼ�";
                break;
            }
          ?>
        </td>
      </tr>
      <tr>
        <td valign="top" align="center"><br>
          <form name="boardwrite" method="post" enctype="multipart/form-data" action="bd_save.php?mode=<?php print $mode ?>&num=<?php print $num ?>">
            <table border="1" cellpadding="3" cellspacing="0" width="630" bordercolor="faf0e6">
              <tr height="30">
                <td align="center" width="120" bgcolor="f0f8ff">Name</td>
                <td><input type="text" name="writer" size="30" value="<?php print empty($list["writer"]) ? null : $list["writer"] ?>"></td>
              </tr>
              <tr height="30">
                <td align="center" width="120" bgcolor="f0f8ff">E-mail</td>
                <td><input type="text" name="email" size="30" value="<?php print empty($list["email"]) ? null : $list["email"] ?>"></td>
              </tr>
              <tr height="30">
                <td align="center" width="120" bgcolor="f0f8ff">Title</td>
                <td><input type="text" name="title" size="80" value="<?php print empty($list["title"]) ? null : $list["title"] ?>" style="border: 1px dashed"></td>
              </tr>
              <tr	height="100">
                <td align="center" width="120" bgcolor="f0f8ff">Content</td>
                <td>
                  <textarea name="content" cols="78" rows="10" style="border: 1px dashed"><?php print empty($list["content"]) ? null : $list["content"] ?></textarea>
                </td>
              </tr>
              <tr height="30">
                <td align="center" width="120" bgcolor="f0f8ff">File</td>
                <td><input type="file" name="addfile" size="30" style="border: 1px dashed"></td>
              </tr>
              <tr>
                <td align="center" width="120" bgcolor="f0f8ff">Password</td>
                <td><input type="password" name="pwd" size="10" style="border: 1px dashed"></td>
              </tr>
            </table>
            <input type="hidden" name="num" value="<?php $num ?>">
            <input type="hidden" name="page" value="<?php $page ?>">
            <table cellpadding="3" cellspacing="0" width="630">
              <tr height="30">
                <td align="right">
                  <?php
                    print "<a href='bd.php?page=".$page;
                    if ($sstring != null)
                    {
                      print "&smethod=".$smethod."&sstring=".$sstring;
                    }
                    print "'>[���]</a>&nbsp;&nbsp;";
                  ?>
                  <a href="javascript:check(document.boardwrite)">[����]</a>
                </td>
              </tr>
            </table>
          </form>
        </td>
      </tr>
    </table>
  </body>
</html>
