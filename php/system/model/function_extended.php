<?php
	require_once("connect_db.php");

	function add_computer($state)
	{
		global $con;
		$query = "INSERT INTO computer (state,isUsed) values ('$state',0)";
		mysqli_query($con,$query);
	}

	function show_computer_isUsed($limit)
	{
		global $con;
		$query = "SELECT * FROM computer ORDER BY ID DESC";
		$result = mysqli_query($con,$query);
		$num_computers = mysqli_num_rows($result);
		if($limit<$num_computers)
		{
			for($i=0;$i<($num_computers-$limit);$i++)
			{
				$row = mysqli_fetch_assoc($result);
			}
			$num_computers = $limit;
		}
		$num_groups = $num_computers/4;
		$num_others = $num_computers%4;
	
		for($i=0;$i<$num_groups;$i++)
		{
			$row = mysqli_fetch_assoc($result);
			echo '<div class="col-lg-6 col-md-6 col-sm-12 onetable_computer">
              <div>
                <label class="switch switch-text switch-pill switch-primary-outline-alt switch-modified">
                  <input type="checkbox" class="switch-input"';
            if($row['isUsed'])
            {
            	echo ' checked';
            }       
            echo ' onclick="update_state('.$row['ID'].');"><span class="switch-label" data-on="On" data-off="Off"></span>
                  <span class="switch-handle"></span>
                </label>'.$row['ID'].'
                <img src="../src/icon/computer_condition.png" class="icon-condition">';
            $row = mysqli_fetch_assoc($result);
            echo '<img src="../src/icon/computer_condition.png" class="icon-condition">
                '.$row['ID'].'
                <label class="switch switch-text switch-pill switch-primary-outline-alt switch-modified">
                  <input type="checkbox" class="switch-input"';
            if($row['isUsed'])
            {
            	echo ' checked';
            }       
            echo ' onclick="update_state('.$row['ID'].');"><span class="switch-label" data-on="On" data-off="Off"></span>
                  <span class="switch-handle"></span>
                </label>
              </div>';
            $row = mysqli_fetch_assoc($result);
            echo '<div style="margin-top: 10px;">
                <label class="switch switch-text switch-pill switch-primary-outline-alt switch-modified">
                  <input type="checkbox" class="switch-input"';
            if($row['isUsed'])
            {
            	echo ' checked';
            }       
            echo ' onclick="update_state('.$row['ID'].');"><span class="switch-label" data-on="On" data-off="Off"></span>
                  <span class="switch-handle"></span>
                </label>'.$row['ID'].'
                <img src="../src/icon/computer_condition.png" class="icon-condition">';
            $row = mysqli_fetch_assoc($result);
            echo '<img src="../src/icon/computer_condition.png" class="icon-condition">
                '.$row['ID'].'
                <label class="switch switch-text switch-pill switch-primary-outline-alt switch-modified">
                  <input type="checkbox" class="switch-input"';
            if($row['isUsed'])
            {
            	echo ' checked';
            }       
            echo ' onclick="update_state('.$row['ID'].');"><span class="switch-label" data-on="On" data-off="Off"></span>
                  <span class="switch-handle"></span>
                </label>
              </div>
            </div>';
		}
	}

  function show_list_of_peripheral()
  {
    global $con;
    $query = "SELECT * FROM peripheral";
    $result = mysqli_query($con,$query);
    while($row = mysqli_fetch_assoc($result))
    {
      echo '<div class="col-md-3 col-sm-6">
              <div class="social-box">
                <img src="../src/'.$row['image'].'" class="peripheral_img">
                <div>
                  <font size="7">'.$row['name'].'</font>
                </div>
                <ul>
                  <li>
                    <strong>'.$row['number_used'].'</strong>
                    <span>使用中</span>
                  </li>
                  <li>
                    <strong>'.($row['number_total']-$row['number_used']).'</strong>
                    <span>備品</span>
                  </li>
                </ul>
                <div class="card-body">
                  <div class="progress progress-xs mt-3 mb-0">
                    <div class="progress-bar bg-info" role="progressbar" style="width: '.(100*$row['number_used']/$row['number_total']).'%" aria-valuenow="'.$row['number_used'].'" aria-valuemin="0" aria-valuemax="'.$row['number_total'].'"></div>
                  </div>
                </div>
                <div class="peripheral_sum">總共：'.$row['number_total'].'</div>
              </div>
            </div>';
    }
  }

  function update_computer_isUsed($id)
  {
    global $con;
    $query = "SELECT isUsed FROM computer WHERE id=$id";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_row($result);
    $isUsed = $row[0];
    $isUsed = !$isUsed;
    $query2 = "UPDATE computer SET isUsed='$isUsed' WHERE id=$id";
    $result2 = mysqli_query($con,$query2);
  }

  function paging($page_name,$index_page,$num_of_page)
  {
    if($index_page>1 && $index_page<=$num_of_page)
    {
      echo '<li class="page-item"><a class="page-link" href="'.$page_name.'?i='.($index_page-1).'">Prev</a></li>';
    }
    $active = array();
    for($i=0;$i<$num_of_page;$i++)
    {
      $active[$i]="";
    }
    $active[$index_page-1] = " active";
    for($i=0;$i<$num_of_page;$i++)
    {
      echo '<li class="page-item'.$active[$i].'"><a class="page-link" href="'.$page_name.'?i='.($i+1).'">'.($i+1).'</a></li>';
    }
    if($index_page<$num_of_page)
    {
      echo '<li class="page-item"><a class="page-link" href="'.$page_name.'?i='.($index_page+1).'">Next</a></li>';
    }
  }

  function paging_with_id($page_name,$index_page,$num_of_page,$id)
  {
    if($index_page>1 && $index_page<=$num_of_page)
    {
      echo '<li class="page-item"><a class="page-link" href="'.$page_name.'?i='.($index_page-1).'&id='.$id.'">Prev</a></li>';
    }
    $active = array();
    for($i=0;$i<$num_of_page;$i++)
    {
      $active[$i]="";
    }
    $active[$index_page-1] = " active";
    for($i=0;$i<$num_of_page;$i++)
    {
      echo '<li class="page-item'.$active[$i].'"><a class="page-link" href="'.$page_name.'?i='.($i+1).'&id='.$id.'">'.($i+1).'</a></li>';
    }
    if($index_page<$num_of_page)
    {
      echo '<li class="page-item"><a class="page-link" href="'.$page_name.'?i='.($index_page+1).'&id='.$id.'">Next</a></li>';
    }
  }
?>
