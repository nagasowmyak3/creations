 <?php
include('../include/session.php');
ini_set("display_errors","on");error_reporting(E_ALL);
//$session->checkUserAccess("bed_creation");

if(isset($_REQUEST['addForm']))
{
 
  ?>
<!--      
     <div class="row">
    <div id="dates_list"> -->
	<div class="col-xl-12 col-lg-12">
			<div class="card border-0 shadow mb-4">
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
					<h4 class="m-0 font-weight-bold text-primary">BED</h4>
				</div>
                <?php   
	             $count=1;
	  
		
		          if(isset($_REQUEST['data4']))
	               {
			        $posdata1 = explode('^',rtrim($_POST['data4']));
			      foreach($posdata1 as $rowpost2)
			      {
			      if(strlen($rowpost2)>0)
			     {
					$rowpost = explode('_',$rowpost2);
					// echo '<pre>';
					// print_r($rowpost);
					// echo '</pre>';
					?>
					

				<div class="list" id="list<?php echo $count;?>">
				 <div class="row">
                   <div class="form-group col-sm-12">
					  <div class="card-body">
					

						 <div id="dates_list" class="col-md-12">
					       <div class="list" id="list<?php echo $count;?>"> 
								
							    <div class="row">
									<div class="col-md-3">
										<div class="form-group row">
												<label class="col-sm-12 col-form-label">Block </label>
											<div class="col-sm-12">
													<?php
													$data=$database->connection->query("SELECT * FROM block_creation");
													?>
													<select class="custom-select block " data-type="man" data-alias="block" id="block<?php echo $count?>" name="block<?php echo $count?>" 
													onChange="setState('floor<?php echo $count?>','<?php echo SECURE_PATH; ?>bed_creation/process.php','add_bed=1&block='+$('#block<?php echo $count?>').val())">
														<option value="">select</option>
														<?php
															while($row = $data->fetch(PDO::FETCH_ASSOC))
		
															{
																?>
																	<option value="<?= $row['block_number']?>" 
																	<?php 
																	if(isset($rowpost['0']))
																	{
																		if($rowpost['0']==$row['block_number']){ echo 'selected';}}

																	 ?>><?= $row['block_name']?></option>
																<?php
															}
															?>
													</select>
													<span class="text-danger"><?php if(isset($_SESSION['error']['block'.$count])){ echo $_SESSION['error']['block'.$count];}?></span>
												</div>
											</div>
										</div>	
										<!-- </div> -->

										<!-- <div class="row"> -->
										   <div class="col-md-3">
											 <div class="form-group row">
												<label class="col-sm-12 col-form-label">Floor </label>
												  <div class="col-sm-12">
													   <select class="custom-select floor" data-type="man" data-alias="floor" id="floor<?php echo $count?>" name="floor<?php echo $count?>" onChange="setState('ward<?php echo $count?>','<?php echo SECURE_PATH; ?>bed_creation/process.php','add_bed1=1&floor='+$('#floor<?php echo  $count?>').val()+'&block='+$('#block<?php echo $count?>').val())">
															<option value="" selected>select</option>
															<?php 
																//print_r($_REQUEST['district']);
																if(isset($rowpost[0]))
																{
																		$data1=$database->connection->query("SELECT DISTINCT floor_number,floor_name FROM floor_creation where block='".$rowpost[0]."'");
																	?>
																	
																	<?php
																	while($row1 = $data1->fetch(PDO::FETCH_ASSOC))
																	{
																		?>
							            											
																		<option value="<?= $row1['floor_number']?>" <?php if(isset($rowpost['1'])){ if($row1['floor_number']==$rowpost['1']){ echo 'selected';}} ?>><?= $row1['floor_name']?></option> 
																			<?php
																	}
																	
																}
															?>

														</select>
														<span class="text-danger"><?php if(isset($_SESSION['error']['floor'.$count])){ echo $_SESSION['error']['floor'.$count];}?></span>
														</div>
												</div>
											</div>
										
										
										 <div class="col-md-3">
											<div class="form-group row">
												<label class="col-sm-12 col-form-label">Ward </label>
												<div class="col-sm-12">
													<select class="custom-select ward" data-type="man" data-alias="ward" id="ward<?php echo $count?>" name="ward<?php echo $count?>" >
													<option value="">Select</option>
														<?php 
														if(isset($rowpost[0]))
														{
																$data1=$database->connection->query("SELECT DISTINCT ward_number,ward_name FROM ward_creation where block='".$rowpost[0]."' && floor='".$rowpost[1]."'");
																?>
															
															<?php
															while($row1 = $data1->fetch(PDO::FETCH_ASSOC))
															{
																
																?>
																
																<option value="<?= $row1['ward_number']?>" <?php if(isset($rowpost['2'])){if($row1['ward_number']==$rowpost['2']){ echo 'selected';}} ?>><?= $row1['ward_name']?></option> 
																	<?php
															}
															
														}
														?>

													</select>
													<span class="text-danger"><?php if(isset($_SESSION['error']['ward'.$count])){ echo $_SESSION['error']['ward'.$count];}?></span>
												</div>
												</div>
											
												</div>
											


									         <!-- <div class="row"> -->
										      <div class="col-md-3">
											     <div class="form-group row">
												<label class="col-sm-12 col-form-label">Bed Number</label>
												 <div class="col-sm-12">
													<input type="number" id="bed_number<?php echo $count?>" name="bed_number<?php echo $count?>" data-type="man"  data-alias="number" class="form-control bed_number" maxlength="" value="<?php  if(isset($rowpost['3'])){ echo $rowpost['3'];} ?>">
													
												</div>
											</div>
											<span class="text-danger"><?php if(isset($_SESSION['error']['bed_number'.$count])){ echo $_SESSION['error']['bed_number'.$count];}?></span>
										 </div>
										 <input type="hidden" name="comid" id="comid" class="comid" value="<?php if(isset($rowpost[3])) { echo $rowpost[3]; }?>" >

										 <div class="col-sm-12 form-group text-right" style="padding-top: 2rem;">
											<?php
											if($count == 1){
											?>
												<a class="btn btn-success text-white" onclick="addList()"><i class="fa fa-plus"></i></a>
											<?php
											}
											else
											{
												?>
													<a class="btn btn-success text-white" onclick="addList()"><i class="fa fa-plus"></i></a>
													<a class="btn btn-danger text-white" onclick="removeList('<?php echo $count; ?>')"><i class="fa fa-minus "></i></a>
												<?php
											}
											?>

										</div>
					
									</div>
						
			
	   </div>
			
					<?php
				$count++;
			}

			}
				?>
				<input type="hidden" id="session_list"  value="<?php echo  $count;?>"/>
				<?php
			}
		else{
			?>
			
			<div id="dates_list" class="col-md-10">
					<div class="list" id="list<?php echo $count;?>">

						<div class="card-body">
							<form id="form">
								<div class="row">
								
										<div class="col-md-3">
											<div class="form-group ">
												<label class="col-form-label"> Block </label>
												
													<?php
													$data=$database->connection->query("SELECT * FROM block_creation");
													?>
													<select class="custom-select block " data-type="man" data-alias="block" id="block<?php echo $count?>" name="block<?php echo $count?>" 
													onChange="setState('floor<?php echo $count?>','<?php echo SECURE_PATH; ?>bed_creation/process.php','add_bed=1&block='+$('#block<?php echo $count?>').val())">
														<option value="">select</option>
														<?php
															while($row = $data->fetch(PDO::FETCH_ASSOC))
		
															{
																?>
																	<option value="<?= $row['block_number']?>" 
																	<?php 
																	if(isset($_REQUEST['block']))
																	{
																		if($_REQUEST['block']==$row['block_number']){ echo 'selected';}}

																	 ?>><?= $row['block_name']?></option>
																<?php
															}
															?>
													</select>
													<span class="text-danger"><?php if(isset($_SESSION['error']['block'])){ echo $_SESSION['error']['block'];}?></span>
												
											</div>
										</div>	

										<div class="col-md-3">
											<div class="form-group ">
												<label class="col-form-label">Floor </label>
												
														<select class="custom-select floor" data-type="man" data-alias="floor" id="floor<?php echo $count?>" name="floor<?php echo $count?>" onChange="setState('ward<?php echo $count?>','<?php echo SECURE_PATH; ?>bed_creation/process.php','add_bed1=1&floor='+$('#floor<?php echo $count?>').val()+'&block='+$('#block<?php echo $count?>').val())">
															<option value="" selected>select</option>
															<?php 
																//print_r($_REQUEST['district']);
																if(isset($_REQUEST['block'.$count]))
																{
																		$data1=$database->connection->query("SELECT DISTINCT floor_number,floor_name FROM floor_creation where block='".$_REQUEST['block'.$count]."'");
																	?>
																	
																	<?php
																	while($row1 = $data1->fetch(PDO::FETCH_ASSOC))
																	{
																		?>
																		
																		<option value="<?= $row1['floor_number']?>" <?php if(isset($_REQUEST['floor'])){ if($_REQUEST['floor']==$row1['floor_number']){ echo 'selected';}} ?>><?= $row1['floor_name']?></option> 
																			<?php
																	}
																	
																}
															?>

														</select>
														<span class="text-danger"><?php if(isset($_SESSION['error']['floor'])){ echo $_SESSION['error']['floor'];}?></span>
												</div>
											</div>
										
									
										<div class="col-md-3">
											<div class="form-group ">
												<label class="col-form-label">Ward </label>
												
													<select class="custom-select ward" data-type="man" data-alias="ward" id="ward<?php echo $count?>" name="ward<?php echo $count?>" >
													<option value="">Select</option>
														<?php 
														if(isset($_REQUEST['block'.$count]))
														{
																$data1=$database->connection->query("SELECT DISTINCT ward_number,ward_name FROM ward_creation where block='".$_REQUEST['block'. $count]."' && floor='".$_REQUEST['floor'. $count]."'");
																?>
															
															<?php
															while($row1 = $data1->fetch(PDO::FETCH_ASSOC))
															{
																
																?>
																
																<option value="<?= $row1['ward_number']?>" <?php if($_REQUEST['ward'. $count]==$row1['ward_number']){ echo 'selected';} ?>><?= $row1['ward_name']?></option> 
																	<?php
															}
															
														}
														?>

													</select>
													<span class="text-danger"><?php if(isset($_SESSION['error']['ward'])){ echo $_SESSION['error']['ward'];}?></span>	
											
												</div>
											</div>	
										 
									
										<div class=" col-md-3">
											<div class="form-group ">
											<label class="col-form-label">Bed Number</label>
											
													<input type="number" id="bed_number<?php echo $count?>" name="bed_number<?php echo $count?>" data-type="man"  data-alias="number" class="form-control bed_number" maxlength="" value="<?php echo $form->value("ward_number".$count); ?>">
													<span class="text-danger"><?php if(isset($_SESSION['error']['bed_number'])){ echo $_SESSION['error']['bed_number'];}?></span>
												
											</div>

										</div>
										<input type="hidden" name="comid" id="comid" class="comid" value="<?php if(isset($rowpost[3])) { echo $rowpost[3]; }?>" >

										<div class="col-sm-12 form-group text-right" style="padding-top: 2rem;">
											<?php
											if($count == 1){
											?>
												<a class="btn btn-success text-white" onclick="addList()"><i class="fa fa-plus"></i></a>
											<?php
											}
											else
											{
												?>
													<a class="btn btn-success text-white" onclick="addList()"><i class="fa fa-plus"></i></a>
													<a class="btn btn-danger text-white" onclick="removeList('<?php echo $count; ?>')"><i class="fa fa-minus "></i></a>
												<?php
											}
											?>

										</div>
						
										</div>
									
									</div>
									</div>
			
								<input type="hidden" id="session_list"  value="<?php echo  $count;?>"/>

							</form>
				
							

						</div>
					</div>
				</div>
			<?php
					
				
				
			}
			?>
		
		<input type="button" class="btn btn-md btn-primary ml-3" onClick="setState('adminForm','<?php echo SECURE_PATH ?>bed_creation/process.php','validateForm=1&data4='+calconditions())"<?php if(isset($_POST['editform'])){ echo '&editform='.$_POST['editform'];}?> value="Submit" />
				
			</div>
		</div>



      <?php
      
	  unset($_SESSION['error']);
	}
	
//}




if(isset($_REQUEST['add_listing']))
{
	$get=$post = $_POST = $_REQUEST =  $session->cleanInput($_REQUEST);

   $count = $_REQUEST['add_listing'];
 
	?>
<div class="card-body">
	<div class="row">
					      <div class="col-lg-3 col-md-12">
						  <div class="form-group row">
							<label class="col-sm-12 col-form-label">Block </label>
								<div class="col-sm-12">
								<?php
							          $data=$database->connection->query("SELECT * FROM block_creation");
							        ?>
								<select class="custom-select block" data-type="man" data-alias="block"  id="block<?php echo $count?>" name="block<?php echo $count?>" 
									  onChange="setState('floor<?php echo $count?>','<?php echo SECURE_PATH; ?>bed_creation/process.php','add_bed=1&block='+$('#block<?php echo $count?>').val())">
									       <option value="">select</option>
										   <?php
							                 while($row = $data->fetch(PDO::FETCH_ASSOC))
							                 {
												 ?>
												<option value="<?= $row['block_number']?>" 
												<?php 
												if(isset($_REQUEST['block']))
												{
													if($_REQUEST['block']==$row['block_number']){ echo 'selected';}}

												 ?>><?= $row['block_name']?></option>
											<?php
										}
										?>
								</select>
								<span class="text-danger"><?php if(isset($_SESSION['error']['block'])){ echo $_SESSION['error']['block'];}?></span>
								</div>
                            </div>
                         </div>	


                         
					   <div class="col-lg-3 col-md-12">
						    <div class="form-group row">
							<label class="col-sm-12 col-form-label">Floor </label>
							  <div class="col-sm-12">
								<select class="custom-select floor" data-type="man" data-alias="floor" id="floor<?php echo $count?>" name="floor<?php echo $count?>" onChange="setState('ward<?php echo $count?>','<?php echo SECURE_PATH; ?>bed_creation/process.php','add_bed1=1&floor='+$('#floor<?php echo $count?>').val()+'&block='+$('#block<?php echo $count?>').val())">
										<option value="" selected>select</option>
										<?php 
										     //print_r($_REQUEST['district']);
										if(isset($_REQUEST['block'.$count]))
											 {
												$data1=$database->connection->query("SELECT DISTINCT floor_number,floor_name FROM floor_creation where block='".$_REQUEST['block'.$count]."'");
												//echo "SELECT DISTINCT facility_id,facility_type FROM mss_facility_name";
											
											?>
											
											<?php
											while($row1 = $data1->fetch(PDO::FETCH_ASSOC)){
												
												?>
												
					    					<option value="<?= $row1['floor_number']?>" <?php if($_REQUEST['floor '. $count]==$row1['floor_number']){ echo 'selected';} ?>><?= $row1['floor_name']?></option> 
													<?php
												}
											
										}
											?>

									</select>
									<span class="text-danger"><?php if(isset($_SESSION['error']['floor'])){ echo $_SESSION['error']['floor'];}?></span>	</div>
                            </div>
                         </div>	
                         
					   <div class="col-lg-3 col-md-12">
						    <div class="form-group row">
							<label class="col-sm-12 col-form-label">Ward </label>
												<div class="col-sm-12">
												  <select class="custom-select ward" data-type="man" data-alias="ward" id="ward<?php echo $count?>"name="ward<?php echo $count?>" >
													 <option value="">Select</option>
														<?php 
														if(isset($_REQUEST['block'.$count]))
														{
																$data1=$database->connection->query("SELECT DISTINCT ward_number,ward_name FROM ward_creation where block='".$_REQUEST['block'. $count]."' && floor='".$_REQUEST['floor'. $count]."'");
																?>
															
															<?php
															while($row1 = $data1->fetch(PDO::FETCH_ASSOC))
															{
																
																?>
																
																<option value="<?= $row1['ward_number']?>" <?php if($_REQUEST['ward'. $count]==$row1['ward_number']){ echo 'selected';} ?>><?= $row1['ward_name']?></option> 
																	<?php
															}
															
														}
														?>

													</select>
													<span class="text-danger"><?php if(isset($_SESSION['error']['ward'])){ echo $_SESSION['error']['ward'];}?></span>	</div>
                            </div>
                         </div>	
						 
						
						 
						 <div class="col-lg-3 col-md-12">
						    <div class="form-group row">
							  <label class="col-sm-12 col-form-label">Bed Number</label>
								<div class="col-sm-12">
								<input type="number" id="bed_number<?php echo $count?>" name="bed_number<?php echo $count?>" data-type="man"  data-alias="number" class="form-control bed_number" maxlength="" value="<?php echo $form->value("ward_number".$count); ?>">
								<span class="text-danger"><?php if(isset($_SESSION['error']['bed_number'])){ echo $_SESSION['error']['bed_number'];}?></span>
                            </div>
                         </div>	
						
						</div> 
						<input type="hidden" name="comid" id="comid" class="comid" value="<?php if(isset($rowpost[3])) { echo $rowpost[3]; }?>" >

								<div class="col-sm-12 form-group text-right" style="padding-top: 2rem;">
								<?php
								if($count == 1){
								?>
									<a class="btn btn-success text-white" onclick="addList()"><i class="fa fa-plus"></i></a>
								<?php
								}
								else{
								?>
									<a class="btn btn-success text-white" onclick="addList()"><i class="fa fa-plus"></i></a>
									<a class="btn btn-danger text-white" onclick="removeList('<?php echo $count; ?>')"><i class="fa fa-minus "></i></a>
								<?php
								}
								?>

								</div>
               
              </div>
			  </div>
			  </div>	  
	</div>

	<!--Addrow end-->
	<?php
}



if(isset($_POST['validateForm']))
{
	$_SESSION['error'] = array();
  $post = $session->cleanInput($_POST);
  $id = 'NULL';

  if(isset($post['editform']))
	{
	  $id = $post['editform'];
    }


	$abcd = 1;
	$list = explode("^",rtrim($post['data4'],'^'));
		//print_r($list);
		//exit;
    if(count($list)>0)
    {
    foreach ($list as $k)
    {

      $r = explode('_',$k);
      if(strlen(trim($r['0'])) == 0 ){
        $_SESSION['error']['block'.$abcd] = "Please select block";
      }

		if(strlen(trim($r['1'])) == 0 ){
			$_SESSION['error']['floor'.$abcd] = "Please select floor";
		  }

		 if(strlen(trim($r['2'])) == 0 ){
			$_SESSION['error']['ward'.$abcd] = "Please select ward";
		  }
		  if(strlen(trim($r['3'])) == 0 ){
			$_SESSION['error']['bed_number'.$abcd] = "Please enter bed number";
		  }

		

      $abcd++;
    }
  }
   
    
	
	  
  if(count($_SESSION['error']) > 0 || $post['validateForm'] == 2)
	{
		
		
		?>
		<script type="text/javascript">

		setState('adminForm','<?php echo SECURE_PATH;?>bed_creation/process.php','addForm=1&data4=<?php echo $_REQUEST['data4']?>');

		</script>
		<?php
	}
	else
	{
		if(count($list)>0)
		{
			foreach ($list as $k)
			{

				$r = explode('_',$k);
			
	
		$ins=$database->connection->prepare("INSERT INTO bed_creation VALUES (NULL,:block,:floor,:ward,:bed_no)");
        $ins->execute(array(
        'block' => $r[0],
        'floor' => $r[1],
        'ward' => $r[2],
	   'bed_no' => $r[3],  
	   
       
	));
}}
	
	?>
	<script type="text/javascript">
         alert('Data Insert Successfully');
		setState('adminForm','<?php echo SECURE_PATH;?>bed_creation/process.php','addForm=1');
		setState('adminTable','<?php echo SECURE_PATH;?>bed_creation/process.php','tableDisplay=1');

		</script>
	<?php
	}
}
?>

<?php 
if(isset($_REQUEST['add_bed']))
{

	$data2=$database->connection->query("SELECT * FROM floor_creation where block='".$_REQUEST['block']."'");
	?>

	<option value="">Select</option>
	<?php
	while($row2 = $data2->fetch(PDO::FETCH_ASSOC)){

	?>

	<option value="<?= $row2['floor_number']?>"<?php 
	if(isset($_REQUEST['floor']))
	{
		if($_REQUEST['floor']==$row2['floor_number']){ echo 'selected';}} ?>><?= $row2['floor_name']?></option>
		<?php
		}
}
	  
?>
<?php 
if(isset($_REQUEST['add_bed1']))
{
	
	$data2=$database->connection->query("SELECT * FROM ward_creation where block='".$_REQUEST['block']."' and floor='".$_REQUEST['floor']."'");
	?>

	<option value="">Select</option>
	<?php
	while($row2 = $data2->fetch(PDO::FETCH_ASSOC)){
	
	?>
	
	<option value="<?= $row2['ward_number']?>"<?php if(isset($_REQUEST['ward'])){if($_REQUEST['ward']==$row2['ward_number']){ echo 'selected';}} ?>><?= $row2['ward_name']?></option>
		<?php
	}
}

?>

<?php
if(isset($_REQUEST['tableDisplay']))
{
	$start = 0;  //if no page var is given, set start to 0
	$page=0;$limit=20;
	if(isset($_REQUEST['page']))
    {
		
        $start = ($_REQUEST['page'] - 1) * $limit;     //first item to display on this page
        $page=$_REQUEST['page'];
    }
	$tableName = 'bed_creation';
	$select_fields="*";
	$conditions= " order by id ASC";
	$post_vars=array();
	$q = "SELECT $select_fields FROM $tableName ".$conditions;
	$_SESSION['pagination_q']=$q;
    // echo $_SESSION['pagination_q'];exit;
	$result_sel = $database->connection->query($q);
	$numres = $result_sel->rowCount();
    
	$query = $_SESSION['pagination_q']." LIMIT $start,$limit ";
	$data_sel = $database->connection->query($query);

	$_SESSION['query'] = $query;
	$pagename=SECURE_PATH.'bed_creation/process.php';
	$method="tableDisplay"; 
	$pagination=showPagination(SECURE_PATH."bed_creation/process.php?tableDisplay=1&",$tableName,$start,$limit,$page,$conditions);
	
	if(($start+$limit) > $numres){
        $onpage = $numres;
    }
    else{
        $onpage = $start+$limit;
    }

	?>
		
		
		<div class="row">
	<div class="col-xl-12 col-lg-12">
		<div class="card border-0 shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h5 class="m-0 font-weight-bold text-primary">Bed Details</h5>
				<input type="button" class="btn btn-primary" onclick="setState('adminForm','<?php echo SECURE_PATH; ?>bed_creation/process.php','addForm=1');" value="Add Bed">
			</div>
			<div class="card-body">
		      <div style="text-align:center"> <?php echo $pagination ;?></div>
		        <table class="table table-condensed table-bordered">
					<thead class="bg-primary">
		
					<tr>
						<th>S.NO</th>
						<th>BLOCK NO.</th>
						<th>FLOOR NO.</th>
						<th>WARD NO.</th>
						<th>BED NO.</th>
						
					</tr>

					<?php
						      if(isset($_REQUEST['page']))
							  {
								  if($_REQUEST['page']==1)
									  $i=1;
								  else
									  $i=(($_REQUEST['page']-1)*50)+1;
							  }
							  else
									$i=1;
							$n=$start+1;
						     	while($row = $data_sel->fetch(PDO::FETCH_ASSOC))
								 {  
									
						   ?>
			<tbody>
			
			<tr>
				<td><?php echo $n?></td>
				<td><?php echo $row['block']?></td>
				<td><?php echo $row['floor']?></td>
				<td><?php echo $row['ward']?></td>
				<td><?php echo $row['bed_no']?></td>
				


			</tr>

	                 <?php
					   $n++;
						} 
					  ?>

	</tbody>
	</table>
	</div>
	</div>
	</div></div>
	
	</thead>
		

	<?php
}
function showPagination($pagename,$tbl_name,$start,$limit,$page,$condition)
{
	  global $database;

	  // How many adjacent pages should be shown on each side?
	  $adjacents = 3;

	  /*
	  First get total number of rows in data table.
	  If you have a WHERE clause in your query, make sure you mirror it here.
	  */
	  
	  $query = "SELECT COUNT(*) as num FROM $tbl_name $condition ";

	  //echo $query;

	  $tpq = $database->query($query);
	  $tp=$tpq->fetch(PDO::FETCH_ASSOC);
      // echo $total_pages['num'].',';
	  $total_pages = $tp['num'];

	  /* Setup vars for query. */
	  $targetpage = $pagename;     //your file name  (the name of this file)
	  //how many items to show per page


	  /* Setup page vars for display. */
	  if ($page == 0) $page = 1;                    //if no page var is given, default to 1.
	  $prev = $page - 1;                            //previous page is page - 1
	  $next = $page + 1;                            //next page is page + 1
	  $lastpage = ceil($total_pages/$limit);        //lastpage is = total pages / items per page, rounded up.
	  $lpm1 = $lastpage - 1;                        //last page minus 1



	  /*
	  Now we apply our rules and draw the pagination object.
	  We're actually saving the code to a variable in case we want to draw it more than once.
	  */
	  $pagination = "";
	  if($lastpage > 1)
	  {

	  $pagination .= "<ul class=\"pagination\">";
	  //previous button
	  if ($page > 1)
	  {

		  $pagination.= " <li class=\"page-item\">
		  <a class=\"page-link\" onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=".$prev."')\">Previous</a></li>";

	  }
	  else
	  {
		  $pagination.= "<li class=\"page-item disabled\">
		  <a class=\"page-link\">Previous</a></li>";
	  }
	  //pages
	  if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
	  {
		  for ($counter = 1; $counter <= $lastpage; $counter++)
		  {
			  if ($counter == $page)
				  $pagination.= "<li class=\"page-item active\"><a class=\"page-link\" >$counter <span class=\"sr-only\">(current)</span></a></li>";
			  else
				  $pagination.= "<li class=\"page-item \"><a class=\"page-link\" onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=".$counter."')\">$counter</a></li>";
		  }
	  }
	  elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
	  {
		  //close to beginning; only hide later pages
		  if($page < 1 + ($adjacents * 2))
		  {
			  for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
			  {
				  if ($counter == $page)
					  $pagination.= "<li class=\"page-item active\"><a class=\"page-link\" >$counter <span class=\"sr-only\">(current)</span></a></li>";
				  else
					  $pagination.= "<li class=\"page-item \"><a class=\"page-link\" onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=".$counter."')\">$counter</a></li>";
			  }
			  $pagination.= "...";
			  $pagination.= "<li class=\"page-item \"><a class=\"page-link\" onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=".$lpm1."')\">$lpm1</a></li>";
			  $pagination.= "<li class=\"page-item \"><a  class=\"page-link\" onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=".$lastpage."')\">$lastpage</a></li>";
		  }
		  //in middle; hide some front and some back
		  elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
		  {
			  $pagination.= "<li class=\"page-item \"><a  class=\"page-link\"  onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=1')\">1</a></li>";
			  $pagination.= "<li class=\"page-item \"><a  class=\"page-link\" onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=2')\">2</a></li>";
			  $pagination.= "...";
			  for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
			  {
				  if ($counter == $page)
					  $pagination.= "<li class=\"page-item active\"><a class=\"page-link\" >$counter <span class=\"sr-only\">(current)</span></a></li>";
				  else
					  $pagination.= "<li class=\"page-item \"><a  class=\"page-link\" onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=".$counter."')\">$counter</a></li>";
			  }
			  $pagination.= "...";
			  $pagination.= "<li class=\"page-item \"><a  class=\"page-link\">$lpm1</a></li>";
			  $pagination.= "<li class=\"page-item \"><a  class=\"page-link\" onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=".$lastpage."')\">$lastpage</a></li>";
		  }
		  //close to end; only hide early pages
		  else
		  {
			  $pagination.= "<li class=\"page-item \"><a  class=\"page-link\" onclick=\"setStateGet('adminTable','".$targetpage."','page=1')\">1</a></li>";
			  $pagination.= "<li class=\"page-item \"><a  class=\"page-link\"  onclick=\"setStateGet('adminTable','".$targetpage."','page=2')\">2</a></li>";
			  $pagination.= "...";
			  for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
			  {
				  if ($counter == $page)
					  $pagination.= "<li class=\"page-item active\"><a class=\"page-link\" >$counter <span class=\"sr-only\">(current)</span></a></li>";
				  else
					  $pagination.= "<li class=\"page-item active\"><a class=\"page-link\"  onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=".$counter."')\">$counter</a></li>";
			  }
		  }
		  }

	  //next button
	  if ($page < $counter - 1)
		  $pagination.= "<li class=\"page-item active\"><a class=\"page-link\"  onclick=\"setStateGet('adminTable','".$targetpage."','tableDisplay=1&page=".$next."')\">Next</a></li>";
	  else
		  $pagination.= "<li class=\"page-item disabled\">
		  <a class=\"page-link\">Next</a></li>";
		  $pagination.= "</ul>\n";
	  }


	  return $pagination;


}

?>
<link href="http://code.jquery.com/ui/1.9.2/themes/smoothness/jquery-ui.css" rel="stylesheet" />

<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>




