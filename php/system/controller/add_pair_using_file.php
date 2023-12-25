<?php
	require_once("../model/get_pair_info.php");
	//[student,subject,day,starting,ending,companion]
	//中寮
	$file8 = array(
		['胡容琪','英',4,'17:50','19:20','林芯瑜'],
		['陳宏祐','英',3,'17:50','19:20','廖先翌'],
		['廖志家','英',4,'17:50','19:20','林建廷'],
		['張琇瑜','英',4,'17:50','19:20','鄭曼君'],
	);
	//中寮
	$file7 = array(
		['張洋榜','英',2,'17:30','19:00','董承鑫'],
		['張洋榜','英',5,'17:30','19:00','董承鑫'],
		['葉芳伃','英',2,'17:30','19:00','NONE'],
		['葉芳伃','英',5,'17:30','19:00','NONE'],
		['林苡喬','英',2,'17:30','19:00','NONE'],
		['林苡喬','英',5,'17:30','19:00','NONE'],
		['陳馨','英',2,'17:30','19:00','許芳慈'],
		['陳馨','英',5,'17:30','19:00','許芳慈'],
	);
	//瑞豐國中
	$file6 = array(
		['陳如慧','英',2,'17:00','18:30','吳佩宸'],
		['黃佳豪','數',2,'17:00','18:30','林建廷'],
		['游祥豪','數',2,'17:00','18:30','閰斯亭'],
		['劉菀庭','英',3,'17:00','18:30','吳佩宸'],
	);
	//力行
	$file5 = array(
		['宋育哲','英',2,'17:10','18:40','廖先翌'],
		['溫愷蕾','國',4,'17:10','18:40','謝佳霖'],
		['徐紹殷','英',4,'17:10','18:40','鄭仰呈'],
		['張智楷','英',4,'17:10','18:40','黃品蓉'],
	);
	//仁愛
	$file4 = array(
		['洪予彤','數',2,'18:30','20:00','鐘翊婷'],
		['何昱緹','數',4,'18:30','20:00','林佳珊'],
		['孫沁嬣','國',4,'18:30','20:00','黃靖瑜'],
		['許俞靜','數',4,'18:30','20:00','蘇順德'],
		['孫奕','數',2,'18:30','20:00','林韋'],
		['呂元劭','數',4,'18:30','20:00','陳郁均'],
		['黃愉庭','數',4,'18:30','20:00','洪暘嘉'],
	);
	//魚池
	$file3 = array(
		['林慧珊','英',1,'18:30','20:00','林立婷'],
	);
	//法治
	$file2 = array(
		['李湘君','國',1,'18:00','19:30','黃毓淳'],
		['柯昊喆','數',1,'18:00','19:30','王治閎'],
	);
	//都達
	$file = array(
		['曾瑞祥','國',4,'18:30','20:00','卓蓁伶'],
		['黃妤慈','數',4,'18:30','20:00','施筱宣'],
		['李筱婷','數',1,'18:30','20:00','陳巧萱'],
		['陳鵬羽','數',4,'18:30','20:00','陳自均'],
		['李夢璇','國',4,'18:30','20:00','黃雯琪'],
	);
	for($i=0;$i<count($file);$i++)
	{
		$companion_ID = get_companion_ID_by_name($file[$i][5]);
		$student_ID = get_student_ID_by_name($file[$i][0]);
		if(strcmp($file[$i][1],'國')==0)
		{
			$subject_ID=1;
		}
		else if(strcmp($file[$i][1],'英')==0)
		{
			$subject_ID=2;
		}
		else if(strcmp($file[$i][1],'數')==0)
		{
			$subject_ID=3;
		}
		$starting_time = $file[$i][3].":00";
		$ending_time = $file[$i][4].":00";
		add_pair_info($companion_ID,$student_ID,$subject_ID,$file[$i][2],$starting_time,$ending_time,$note);
	}
?>