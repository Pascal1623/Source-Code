<?php
	$conn = mysql_connect("localhost", "root", "apmsetup");
	mysql_select_db("webdb", $conn);

	mysql_query("set names euckr");

	//file ���ε� ���� �Լ� - Ȯ���� ����, ���ϸ� �˻�
	function upload_file($addfile_name_temp, $addfile_name, $num)
	{
		$dotpos = strpos($addfile_name, ".");
		$full_filename = substr($addfile_name, 0, $dotpos);
		$extension = substr($addfile_name, $dotpos + 1, strlen($addfile_name) - $dotpos);

		if (!strcmp($extension, "html") || !strcmp($extension, "htm") || !strcmp($extension, "php") ||
			  !strcmp($extension, "php3") || !strcmp($extension, "inc") || !strcmp($extension, "pl") ||
			  !strcmp($extension, "cgi") || !strcmp($extension, "asp") || !strcmp($extension, ""))
		{
			print "<script language='javascript'>";
			print "alert('���ε尡 ������ ÷�����ϸ��Դϴ�!');";
			print "</script>";
			print "<meta http-equiv='refresh' content='0; url=javascript:history.back(-1)'>";

			return false;
		}

		$board_save_dir = "./upload/board"; //������ upload�� ���� ���� - �� ������ ������ path miss�� upload���� �ʴ´�.
		if (file_exists($board_save_dir."/".$num."_".$full_filename.".".$extension))
		{
		  print "<script language='javascript'> ";
		  print "alert('���ε��� ÷�������� ���ϸ��� �̹� �����մϴ�!'); ";
		  print "</script>";
		  print "<meta http-equiv='refresh' content='0; url=javascript:history.back(-1)'>";

		  return false;
		}
		if(!copy($addfile_name_temp, $board_save_dir."/".$num."_".$full_filename.".".$extension))
		{
		  print "<script language='javascript'> ";
		  print "alert('÷�������� ���ε��ϴµ� �����Ͽ����ϴ�!'); ";
		  print "</script>";
		  print "<meta http-equiv='refresh' content='0; url=javascript:history.back(-1)'>";

		  return false;
		}

		return true;
	}

	//�Խ��� List ��� �Լ�
	function Sub_List($num, $depth, $table_name)
	{
		//���� ���� ù��° ���� ��������� �˻���
		$sublist_query = "select num, root, reply, title, writer, wdate, count from ".$table_name." where abs(reply) = ".$num;
		$sublist_result = mysql_query($sublist_query);

		//����� ǥ����
		while ($list = mysql_fetch_array($sublist_result))
		{
			print "<tr height='16'>";
			print "<td align='center'>&nbsp;</td>";
			print "<td>";
			for($i = 0; $i < $depth; $i++)
			{
				print "&nbsp;&nbsp;";
			}
			print "<font color='green'>[Re]</font>";
			print "<a href='bd_view.php?&num=".$list["num"]."'>".$list["title"]."</a></td>";
			print "<td align='center'>".$list["writer"]."</td>";
			print "<td align='center'>".$list["wdate"]."</td>";
			print "<td align='center'>".$list["count"]."</td>";
			print "</tr>";
			print "<tr><td colspan='5'><hr></td></tr>"; //�ٷ� ����

			//�� ���� ������ ����� ���� �� ����Լ��ν� �ҷ���
			Sub_List($list["num"], $depth + 1, $table_name);
		}
	}
	//��� ���� �� �� ���� ���� num���� ����� reply���� ���Ͽ� �ҷ���

	//�Խñ� ���� �� ���� ��� ���� �Լ�
	function Delete_sub_list($num, $table_name)
	{
		$delete_query = "select filename, root, reply from ".$table_name." where abs(reply) = ".$num;
		$delete_result = mysql_query($delete_query);
		$delete_list = mysql_fetch_array($delete_result);

		if ($delete_list["filename"] != "") unlink($board_save_dir."/".$num."_".$delete_list["filename"]);

		$del_query = "delete from board where num = ".$num;
		mysql_query($del_query);

		while ($list = mysql_fetch_array($delete_result))
		{
			Delete_sub_list($list["num"], $table_name);
		}
	}
?>