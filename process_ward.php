<?php

ini_set("display_errors", "on");
error_reporting(E_ALL);

include('../include/session.php');

$session->checkUserAccess("ward_creation");

if (isset($_REQUEST['addForm'])) {
	//print_r($form->errors);
	?>

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card border-0 shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h4 class="m-0 font-weight-bold text-primary">Ward</h4>
                </div>
                <div class="card-body">
                    <form id="form">
                        <div class="row">
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Block </label>
                                    <div class="col-sm-12">
                                        <?php
										$data = $database->connection->query("SELECT * FROM block_creation");
										?>
                                        <select class="custom-select" data-type="man" data-alias="block" id="block" name="block" 
													onChange="setState('floor','<?php echo SECURE_PATH; ?>bed_creation/process.php','add_bed=1&block='+$('#block').val())">
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
                                        <span class="error"><?php echo $form->error("block"); ?></span>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-3 col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Floor </label>
                                    <div class="col-sm-12">
                                        <?php
										$data = $database->connection->query("SELECT * FROM floor_creation");
										?>
                                        <select class="custom-select" data-type="man" data-alias="floor" id="floor" name="floor" onChange="setState('ward','<?php echo SECURE_PATH; ?>ward_creation/process.php','add_bed1=1&floor='+$('#floor').val()+'&block='+$('#block').val())">
										<option value="" selected>select</option>
										<?php 
										     //print_r($_REQUEST['district']);
										if(isset($_REQUEST['block']))
											 {
												$data1=$database->connection->query("SELECT DISTINCT floor_number,floor_name FROM floor_creation where block='".$_REQUEST['block']."'");
												//echo "SELECT DISTINCT facility_id,facility_type FROM mss_facility_name";
											
											?>
											
											<?php
											while($row1 = $data1->fetch(PDO::FETCH_ASSOC)){
												
												?>
												
					    					<option value="<?= $row1['floor_number']?>" <?php if($_REQUEST['floor']==$row1['floor_number']){ echo 'selected';} ?>><?= $row1['floor_name']?></option> 
													<?php
												}
											
										}
											?>

									</select>
                                        <span class="error"><?php echo $form->error("floor"); ?></span>
                                    </div>
                                </div>
                            </div>



                            <div class="col-lg-3 col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Ward Number</label>
                                    <div class="col-sm-12">
                                        <input type="number" id="ward_number" name="ward_number" data-type="man" data-alias="ward_number" class="form-control" maxlength="" value="<?php echo $form->value("ward_number"); ?>">
                                        <span class="error"><?php echo $form->error("ward_number"); ?></span>
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-3 col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">Ward Name</label>
                                    <div class="col-sm-12">
                                        <input type="text" id="wname" name="wname" data-type="man" data-alias="Name" class="form-control" maxlength="30" value="<?php echo $form->value("wname"); ?>">
                                        <span class="error"><?php echo $form->error("wname"); ?></span>
                                    </div>
                                </div>
                            </div>

                        </div>



                        <div class="form-group row mt-4 text-center">
                             <div class="col-md-12">
                                 <button class="btn btn-md btn-success" type="button" onClick="setState('adminForm','<?php echo SECURE_PATH; ?>ward_creation/process.php','validateForm=1'+sendData())">
                                  Submit</button>

                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php
}

if (isset($_REQUEST['validateForm'])) {

	//echo $form->value('panchayat')."hiii";
	//exit;
	$return_var = '';
	$_REQUEST = $session->cleanInput($_REQUEST);

	unset($_REQUEST['validateForm']);
	foreach ($_REQUEST as $key => $value) {

		$val = explode('~!@', $value);
		//echo $key;

		//echo $key."-".$val[0].",".$val[1].",".$val[2]."<br>";
		$value = $val[3];

		$form->setValue($key, $value);
		if ($val[1] == "man") {

			if (strlen($value) == 0) {
				if (in_array($val[0], array("text", "textarea", "number", "date", "checkbox", "datetime-local", "email", "month", "password", "radio", "tel", "time", "file"))) {
					$form->setError($key, $val[2] . " Cannot not be empty");
				} elseif ($val[0] == "select-one") {
					$form->setError($key, " Please Select " . $val[2]);
				}
			}
		}
		$return_var .= '&' . $key . '=' . $value;
	}

	if ($form->num_errors > 0 || $post['validateForm'] == 2) {


	?>
        <script type="text/javascript">
            setState('adminForm', '<?php echo SECURE_PATH; ?>ward_creation/process.php', 'addForm=1<?php echo $return_var; ?><?php if (isset($_REQUEST['editform'])) {
																																echo '&editform=' . $post['editform'];
																															} ?>');

        </script>
    <?php
	} else {



		$ins = $database->connection->prepare("INSERT INTO ward_creation VALUES (NULL,:block,:floor,:ward_number,:ward_name)");
		$ins->execute(array(
			'block' => $form->value('block'),
			'floor' => $form->value('floor'),
			'ward_number' => $form->value('ward_number'),
			'ward_name'   => $form->value('wname'),
		));

	 ?>
        <script type="text/javascript">
           alert('Data Inserted Successfully');
		   setState('adminForm','<?php echo SECURE_PATH;?>ward_creation/process.php','addForm=1<?php echo $return_var; ?><?php if(isset($_REQUEST['editform'])){ echo '&editform='.$post['editform'];}?>');
		    setState('adminTable','<?php echo SECURE_PATH;?>ward_creation/process.php','tableDisplay=1<?php echo $return_var; ?><?php if(isset($_REQUEST['editform'])){ echo '&editform='.$post['editform'];}?>');

		</script>
 <?php
	}
  }
 ?>


<?php
if (isset($_REQUEST['tableDisplay'])) {
	$start = 0;  //if no page var is given, set start to 0
	$page = 0;
	$limit = 50;
	if (isset($_REQUEST['page'])) {

		$start = ($_REQUEST['page'] - 1) * $limit;     //first item to display on this page
		$page = $_REQUEST['page'];
	}
	$tableName = 'ward_creation';
	$select_fields = "*";
	$conditions = " order by id ASC";
	$post_vars = array();
	$q = "SELECT $select_fields FROM $tableName " . $conditions;
	$_SESSION['pagination_q'] = $q;
	// echo $_SESSION['pagination_q'];exit;
	$result_sel = $database->connection->query($q);
	$numres = $result_sel->rowCount();

	$query = $_SESSION['pagination_q'] . " LIMIT $start,$limit ";
	$data_sel = $database->connection->query($query);

	$_SESSION['query'] = $query;
	$pagename = SECURE_PATH . 'ward_creation/process.php';
	$method = "tableDisplay";
	$pagination = showPagination(SECURE_PATH . "ward_creation/process.php?tableDisplay=1&", $tableName, $start, $limit, $page, $conditions);

	if (($start + $limit) > $numres) {
		$onpage = $numres;
	} else {
		$onpage = $start + $limit;
	}

	if (isset($_REQUEST['page'])) {
		if ($_REQUEST['page'] == 1)
			$i = 1;
		else
			$i = (($_REQUEST['page'] - 1) * 50) + 1;
	} else
		$i = 1;
	$n = $start + 1;

?>

<div class="row">
	<div class="col-xl-12 col-lg-12">
		<div class="card border-0 shadow mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h5 class="m-0 font-weight-bold text-primary">Ward Details</h5>
				<input type="button" class="btn btn-primary" onclick="setState('adminForm','<?php echo SECURE_PATH; ?>ward_creation/process.php','addForm=1');" value="Add Ward">
			</div>
			<div class="card-body">
				<div style="text-align:center"> <?php echo $pagination; ?></div>
				<table class="table table-condensed table-bordered">
					<thead class="bg-primary">

						<tr>
							<th>S.No</th>
							<th>Block No</th>
							<th>Fllor</th>
							<th>Ward No</th>
							<th>Ward Name</th>

						</tr>
					</thead>
					<tbody>
						<?php
						while ($row = $data_sel->fetch(PDO::FETCH_ASSOC))
						{
							?>
							<tr>
								<td><?php echo $n ?></td>
								<td><?php echo $row['block'] ?></td>
								<td><?php echo $row['floor'] ?></td>
								<td><?php echo $row['ward_number'] ?></td>
								<td><?php echo $row['ward_name'] ?></td>
							</tr>
							<?php
							$n++;
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php
}
function showPagination($pagename, $tbl_name, $start, $limit, $page, $condition)
{
	global $database;

	// How many adjacent pages should be shown on each side?
	$adjacents = 3;

	/*
	  First get total number of rows in data table.
	  If you have a WHERE clause in your query, make sure you mirror it here.
	  */
	//echo "SELECT COUNT(*) as num FROM $tbl_name $condition ";
	$query = "SELECT COUNT(*) as num FROM $tbl_name $condition ";

	//echo $query;

	$tpq = $database->query($query);
	$tp = $tpq->fetch(PDO::FETCH_ASSOC);
	//        echo $total_pages['num'].',';
	$total_pages = $tp['num'];




	/* Setup vars for query. */
	$targetpage = $pagename;     //your file name  (the name of this file)
	//how many items to show per page




	/* Setup page vars for display. */
	if ($page == 0) $page = 1;                    //if no page var is given, default to 1.
	$prev = $page - 1;                            //previous page is page - 1
	$next = $page + 1;                            //next page is page + 1
	$lastpage = ceil($total_pages / $limit);        //lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;                        //last page minus 1



	/*
	  Now we apply our rules and draw the pagination object.
	  We're actually saving the code to a variable in case we want to draw it more than once.
	  */
	$pagination = "";
	if ($lastpage > 1) {

		$pagination .= "<ul class=\"pagination\">";
		//previous button
		if ($page > 1) {

			$pagination .= " <li class=\"page-item\">
		  <a class=\"page-link\" onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=" . $prev . "')\">Previous</a></li>";
		} else {
			$pagination .= "<li class=\"page-item disabled\">
		  <a class=\"page-link\">Previous</a></li>";
		}
		//pages
		if ($lastpage < 7 + ($adjacents * 2))    //not enough pages to bother breaking it up
		{
			for ($counter = 1; $counter <= $lastpage; $counter++) {
				if ($counter == $page)
					$pagination .= "<li class=\"page-item active\"><a class=\"page-link\" >$counter <span class=\"sr-only\">(current)</span></a></li>";
				else
					$pagination .= "<li class=\"page-item \"><a class=\"page-link\" onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=" . $counter . "')\">$counter</a></li>";
			}
		} elseif ($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
		{
			//close to beginning; only hide later pages
			if ($page < 1 + ($adjacents * 2)) {
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
					if ($counter == $page)
						$pagination .= "<li class=\"page-item active\"><a class=\"page-link\" >$counter <span class=\"sr-only\">(current)</span></a></li>";
					else
						$pagination .= "<li class=\"page-item \"><a class=\"page-link\" onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=" . $counter . "')\">$counter</a></li>";
				}
				$pagination .= "...";
				$pagination .= "<li class=\"page-item \"><a class=\"page-link\" onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=" . $lpm1 . "')\">$lpm1</a></li>";
				$pagination .= "<li class=\"page-item \"><a  class=\"page-link\" onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=" . $lastpage . "')\">$lastpage</a></li>";
			}
			//in middle; hide some front and some back
			elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
				$pagination .= "<li class=\"page-item \"><a  class=\"page-link\"  onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=1')\">1</a></li>";
				$pagination .= "<li class=\"page-item \"><a  class=\"page-link\" onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=2')\">2</a></li>";
				$pagination .= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
					if ($counter == $page)
						$pagination .= "<li class=\"page-item active\"><a class=\"page-link\" >$counter <span class=\"sr-only\">(current)</span></a></li>";
					else
						$pagination .= "<li class=\"page-item \"><a  class=\"page-link\" onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=" . $counter . "')\">$counter</a></li>";
				}
				$pagination .= "...";
				$pagination .= "<li class=\"page-item \"><a  class=\"page-link\">$lpm1</a></li>";
				$pagination .= "<li class=\"page-item \"><a  class=\"page-link\" onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=" . $lastpage . "')\">$lastpage</a></li>";
			}
			//close to end; only hide early pages
			else {
				$pagination .= "<li class=\"page-item \"><a  class=\"page-link\" onclick=\"setStateGet('adminTable','" . $targetpage . "','page=1')\">1</a></li>";
				$pagination .= "<li class=\"page-item \"><a  class=\"page-link\"  onclick=\"setStateGet('adminTable','" . $targetpage . "','page=2')\">2</a></li>";
				$pagination .= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
					if ($counter == $page)
						$pagination .= "<li class=\"page-item active\"><a class=\"page-link\" >$counter <span class=\"sr-only\">(current)</span></a></li>";
					else
						$pagination .= "<li class=\"page-item active\"><a class=\"page-link\"  onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=" . $counter . "')\">$counter</a></li>";
				}
			}
		}

		//next button
		if ($page < $counter - 1)
			$pagination .= "<li class=\"page-item active\"><a class=\"page-link\"  onclick=\"setStateGet('adminTable','" . $targetpage . "','tableDisplay=1&page=" . $next . "')\">Next</a></li>";
		else
			$pagination .= "<li class=\"page-item disabled\">
		  <a class=\"page-link\">Next</a></li>";
		$pagination .= "</ul>\n";
	}


	return $pagination;
}

?>
<link href="http://code.jquery.com/ui/1.9.2/themes/smoothness/jquery-ui.css" rel="stylesheet" />

<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>