<?php
	$conn = mysql_connect("localhost", "root", "apmsetup");
	mysql_select_db("webdb", $conn);

	mysql_query("set names euckr");

	//file 업로드 관련 함수 - 확장자 제한, 파일명 검사
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
			print "alert('업로드가 금지된 첨부파일명입니다!');";
			print "</script>";
			print "<meta http-equiv='refresh' content='0; url=javascript:history.back(-1)'>";

			return false;
		}

		$board_save_dir = "./upload/board"; //서버에 upload할 폴더 정의 - 단 폴더가 없으면 path miss로 upload되지 않는다.
		if (file_exists($board_save_dir."/".$num."_".$full_filename.".".$extension))
		{
		  print "<script language='javascript'> ";
		  print "alert('업로드할 첨부파일의 파일명이 이미 존재합니다!'); ";
		  print "</script>";
		  print "<meta http-equiv='refresh' content='0; url=javascript:history.back(-1)'>";

		  return false;
		}
		if(!copy($addfile_name_temp, $board_save_dir."/".$num."_".$full_filename.".".$extension))
		{
		  print "<script language='javascript'> ";
		  print "alert('첨부파일을 업로드하는데 실패하였습니다!'); ";
		  print "</script>";
		  print "<meta http-equiv='refresh' content='0; url=javascript:history.back(-1)'>";

		  return false;
		}

		return true;
	}

	//게시판 List 출력 함수
	function Sub_List($num, $depth, $table_name)
	{
		//원본 글의 첫번째 수준 댓글정보를 검색함
		$sublist_query = "select num, root, reply, title, writer, wdate, count from ".$table_name." where abs(reply) = ".$num;
		$sublist_result = mysql_query($sublist_query);

		//댓글을 표시함
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
			print "<tr><td colspan='5'><hr></td></tr>"; //줄로 구분

			//그 이하 수준의 댓글이 있을 시 재귀함수로써 불러옴
			Sub_List($list["num"], $depth + 1, $table_name);
		}
	}
	//댓글 추적 시 그 원본 글의 num값을 댓글의 reply값과 비교하여 불러옴

	//게시글 삭제 시 관련 댓글 삭제 함수
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
