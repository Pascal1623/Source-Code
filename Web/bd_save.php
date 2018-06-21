<?php
	include("include.inc");
	mysql_query("set names euckr"); //데이터를 넘겨줄 때 모든 charset을 euckr로 통일

	$board_save_dir = "./upload/board"; //서버에 upload할 폴더 정의
	$mode = $_GET['mode'];

	if ($mode == "insert")
	{
		$max_num_query = "select max(num) as tnum from board";
		$max_num_result = mysql_query($max_num_query);
		$max_num_list = mysql_fetch_array($max_num_result);
		$num = $max_num_list["tnum"] + 1;

		$max_root_query = "select max(root) as troot from board";
		$max_root_result = mysql_query($max_root_query);
		$max_root_list = mysql_fetch_array($max_root_result);
		$root = $max_root_list["troot"] + 1;

		if ($_FILES['addfile']['name'] != "")
		{
			if (upload_file($_FILES['addfile']['tmp_name'], $_FILES['addfile']['name'], $num))
			{
				$query = "insert into board(num, root, reply, title, email, content, writer, password, filename, wdate, wtime, connect_ip, count)
							values(".$num.", ".$root.", 0, '".$_POST['title']."', '".$_POST['email']."', '".$_POST['content']."', '".$_POST['writer']."', '"
							.$_POST['pwd']."', '".$_FILES['addfile']['name']."', '".date("Y-m-d")."', '".date("H:i:s")."', '".getenv("REMOTE_ADDR")."', 0)";

				$query_res = mysql_query($query);
			}
		}
		else
		{
			$query = "insert into board(num, root, reply, title, email, content, writer, password, filename, wdate, wtime, connect_ip, count)
					values(".$num.", ".$root.", 0, '".$_POST['title']."', '".$_POST['email']."', '".$_POST['content']."', '".$_POST['writer']."', '".
					$_POST['pwd']."', '', '".date("Y-m-d")."', '".date("H:i:s")."', '".getenv("REMOTE_ADDR")."', 0)";
			$query_res = mysql_query($query);
		}
	}
	else if ($mode == "reply")
	{
		$question_num = $_GET['num'];

		$question_info_query = "select num, root, reply from board where num = ".$question_num;
		$question_info_result = mysql_query($question_info_query);
		$question_info = mysql_fetch_array($question_info_result);

		if ($question_info["reply"] != 0)
		{
			$update_reply_value = abs($question_info["reply"]) * (-1);
			$update_query = "update board set reply = ".$update_reply_value." where num = ".$question_num;
			mysql_query($update_query);
		}
		$reply = $question_info["num"];

		$max_num_query = "select max(num) as tnum from board";
		$max_num_result = mysql_query($max_num_query);
		$max_num_list = mysql_fetch_array($max_num_result);
		$num = $max_num_list["tnum"] + 1;

		if ($_FILES['addfile']['name'] != "")
		{
			if (upload_file($_FILES['addfile']['tmp_name'], $_FILES['addfile']['name'], $num))
			{
				$query = "insert into board(num, root, reply, title, email, content, writer, password, filename, wdate, wtime, connect_ip, count)
						values(".$num.", ".$question_info["root"].", ".$reply.", '".$_POST['title']."', '".$_POST['email']."', '".$_POST['content']."', '".$_POST['writer']."', '"
						.$_POST['pwd']."', '".$_FILES['addfile']['name']."', '".date("Y-m-d")."', '".date("H:i:s")."', '".getenv("REMOTE_ADDR")."', 0)";
				mysql_query($query);
			}
		}
		else
		{
			$query = "insert into board(num, root, reply, title, email, content, writer, password, filename, wdate, wtime, connect_ip, count)
					values(".$num.", ".$question_info["root"].", ".$reply.", '".$_POST['title']."', '".$_POST['email']."', '".$_POST['content']."', '".$_POST['writer']."', '"
					.$_POST['pwd']."', '', '".date("Y-m-d")."', '".date("H:i:s")."', '".getenv("REMOTE_ADDR")."', 0)";
			mysql_query($query);
		}
	}
	else if ($mode == "update")
	{
		$num = $_GET['num'];
		$pwd = $_POST['pwd'];
		$pwd_query = "select password from board where num = ".$num;
		$pwd_result = mysql_query($pwd_query);
		$pwd_list = mysql_fetch_array($pwd_result);
		$old_pwd = $pwd_list["password"];

		if ($old_pwd != $pwd)
		{
			print "<script>";
				print "alert('암호가 틀립니다. 다시 확인을......');";
				print "history.back(-1);";
			print "</script>";

			exit;
		}

		if ($_FILES['addfile']['name'] != "")
		{
			$filename_query = "select filename from board where num = ".$num;
			$filename_result = mysql_query($filename_query);
			$filename_list = mysql_fetch_array($filename_result);
			$filename = $filename_list["filename"];

			if ($filename != "") unlink($board_save_dir."/".$num."_".$filename);

			if (upload_file($_FILES['addfile']['tmp_name'], $_FILES['addfile']['name'], $num))
			{
				$query = "update board set title = '".$_POST['title']."', email = '".$_POST['email']."', writer = '".$_POST['writer']."', content = '".$_POST['content']
						."', filename = '".$_FILES['addfile']['name']."', connect_ip = '".getenv("REMOTE_ADDR")."' where num = ".$num;
				$query_res = mysql_query($query);
			}
		}
		else
		{
			$query = "update board set title = '".$_POST['title']."', email = '".$_POST['email']."', writer = '".$_POST['writer']
					."', content = '".$_POST['content']."', connect_ip = '".getenv("REMOTE_ADDR")."' where num = ".$num;
			$query_res = mysql_query($query);
		}
	}
	else if ($mode == "delete")
	{
		$num = $_GET['num'];
		$pwd = $_POST['pwd'];
		$pwd_query = "select password from board where num = ".$num;
		$pwd_result = mysql_query($pwd_query);
		$pwd_list = mysql_fetch_array($pwd_result);
		$old_pwd = $pwd_list["password"];

		if ($old_pwd != $pwd)
		{
			print "<script>";
				print "alert('암호가 틀립니다. 다시 확인을......');";
				print "history.back(-1);";
			print "</script>";

			exit;
		}
		else
		{
			$delete_query = "select filename, root, reply from board where num = ".$num;
			$delete_result = mysql_query($delete_query);
			$delete_list = mysql_fetch_array($delete_result);

			if ($delete_list["filename"] != "") unlink($board_save_dir."/".$num."_".$delete_list["filename"]);

			$del_query = "delete from board where num = ".$num;
			mysql_query($del_query);

			Delete_sub_list($num, "board");
		}
	}

	print "<meta http-equiv='refresh' content='0; url=bd.php'>";
?>
