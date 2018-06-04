<?php

	$conn=mysql_connect("localhost", "root", "apmsetup");
	mysql_select_db("webdb", $conn);
	mysql_query("set names euckr");

	$board_save_dir="./upload/board";   //	$board_save_dir="./upload/........ 서버에 upload할 폴더 정의";

// 페이지당 보여지는 게시물의 갯수
	$board_page_view_count=10;

// file 업로드 관련 합수
	function upload_file($saveDir,$addfile, $addfile_name, $num)
	{
		$dotpos=strpos($addfile_name,".");
		$full_filename=substr($addfile_name,0,$dotpos);
		$extension=substr($addfile_name,$dotpos+1,strlen($addfile_name)-$dotpos);
	
		if(!strcmp($extension,"html")||!strcmp($extension,"htm")||!strcmp($extension,"php")||!strcmp($extension,"php3")||!strcmp($extension,"inc")
		      ||!strcmp($extension,"pl")||!strcmp($extension,"cgi")||!strcmp($extension,"asp")||!strcmp($extension,""))
		{
			echo "<script language='javascript'> ";
			echo "alert('업로드가 금지된 첨부파일명입니다!'); ";
			echo "</script>";
			echo "<meta http-equiv='refresh' content='0; url=javascript:history.back(-1)'>";
			echo "</head>";
			echo "</html>";
			return false;
		}

		$exist=file_exists($saveDir."/".$num."_".$full_filename.".".$extension);
		if($exist)
		{
		  echo "<script language='javascript'> ";
		  echo "alert('업로드할 첨부파일의 파일명이 이미 존재합니다!'); ";
		  echo "</script>";
		  echo "<meta http-equiv='refresh' content='0; url=javascript:history.back(-1)'>";
		  echo "</head>";
		  echo "</html>";
		  return false;
		}
		if(!copy($addfile,$saveDir."/".$num."_".$full_filename.".".$extension))
		{
		  echo "<script language='javascript'> ";
		  echo "alert('첨부파일을 업로드하는데 실패하였습니다!'); ";
		  echo "</script>";
		  echo "<meta http-equiv='refresh' content='0; url=javascript:history.back(-1)'>";
		  echo "</head>";
		  echo "</html>";
		  return false;
		}
		return true;
	}


// 게시판 List 출력 함수

	function Sub_List($num, $depth, $now_num, $table_name, $today)
	{

		if ($depth!=0)
			$sublist_query="select num, root, reply, title, writer, wdate, count from ".$table_name." where abs(reply)=".$num;
		else
			$sublist_query="select num, root, reply, title, writer, wdate, count from ".$table_name." where num=".$num;
		
		$sublist_result=mysql_query($sublist_query);

		while($list=mysql_fetch_array($sublist_result))
		{
			print "<tr height=16>
					<td align=center>&nbsp;</td>";

			print "<td>";
					

			for($i=0; $i<$depth; $i++)
			{
				print "&nbsp;&nbsp;";
			}
			print "<font color=green>[Re]</font>";
			
			print "<a href=bd_view.html?page=".$page."&num=".$list["num"].">".$list["title"]."</a></td>";
			
			print "		<td align=center>".$list["writer"]."</td>";

			print "<td align=center>".$list["wdate"]."</td>";	

			print "<td align=center>".$list["count"]."</td></tr>";

			print "<tr><td colspan=5><hr></td></tr>";

			if ($num==abs($list["reply"]))
			{
				Sub_List($list["num"], $depth+1, $now_num, $table_name, $today);
			}
		}


	}


?>