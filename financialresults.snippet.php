<script>
	
	function fetchdata(){
		var search = jQuery('#search').val();
		var post_type = jQuery('#post_type').val();
		var value = parseInt(document.getElementById('number').value);
		// var no_post = incrementer();
		var tableWraps = jQuery('#table');
		//alert(search+' - '+ post_type);
		//console.log("<?= site_url() ?>/wp-admin/admin-ajax.php");
		jQuery.post("<?= site_url() ?>/wp-admin/admin-ajax.php",{'action':'my_action','search': search, 'post_type' : post_type,'number': value },function(resp){					
			if(resp.status == 'error'){
				//alert(resp.msg)
				var output = '';				
				output += `<tr>`;
				output += `<td colspan='2'>${resp.msg}</td>`;
				output += `</tr>`;
				jQuery('#table tbody').html(output);
			}

			if(resp.status == 'success'){
				var datas = resp.data.length;					
				if(datas >= 1 ){
					var output = '';
					for(i=0;i<datas; i++){
						output += `<tr>`;
						output += `<td> ${resp.data[i].title}</td>`;
						output += `<td> ${resp.data[i].contents} </td>`;						
						output += `</tr>`;
					}
					jQuery('#table tbody').html(output);	
				} 
			}			
		})
	}
</script>

<input type="text" name="search" id="search" placeholder="search" onchange="fetchdata(); "> 
<!-- <input type="checkbox" name="post_type" id="post_type"  value="page" > Page -->
<select name="post_type" id="post_type" onchange="fetchdata(); " >
	<option value="">Select Service</option>
	<?php 
	$categories = get_categories();
	foreach($categories as $category) {?>
		<option value="<?php echo $category->term_id; ?>"><?php echo $category->name; ?></option>
	<?php } ?>
		
</select>

<!-- Blog results -->
<table class="" id='table'>
	<thead>
		<tr>
			<th>Title</th>
			<th>Contents</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$args =  array(
				'post_type' => 'post',
				'posts_per_page' => -1,
				'order' => 'DESC',				
			);
			$query = new WP_Query($args);
			while($query->have_posts() ):$query->the_post();
		?>

		<tr>
			<td><?php the_title(); ?></td>
			<td><?php the_content(); ?></td>
		</tr>
	<?php endwhile; ?>
	</tbody>	
</table>
<!-- Blog results -->
   <input type="hidden" id="number" name='number'value="5"/>
   <input type="button" onclick="incrementValue()" value="Read More" />

<!-- <div class="button">
  <button type="button" class="btn" id="btn" onclick="fetchdata()">read more</button>
</div> -->

<script>
	

value = 5
function incrementValue()
{
    var value = parseInt(document.getElementById('number').value,10);
    alert(value)
    value = isNaN(value) ? 0 : value;
    value+= 5;
    document.getElementById('number').value = value;
    console.log(value);
    fetchdata();
}


// var buttonTarget = document.getElementsByClassName("btn")[0];
// var counter = 5;

// function incrementer(){
// //document.getElementById("btn").innerHTML = counter.toString();
//   buttonTarget.innerHTML  = counter.toString();
//   counter+=5;
//   //return counter;
//   console.log(counter)
// }

</script>






<?php 




$arg =  array(
	'post_type' => 'post',
	'posts_per_page' => -1,
	'order' => 'DESC'
);

$query  =  new WP_Query($arg);

while( $query->have_posts() ): $query -> the_post(); ?>
	
	
<?php endwhile; ?>




<br><br><br><hr />


<?php 
    
    // $args = new WP_Query(array(
    //         'post_type'  => 'cb_downloadlink',
    //         'posts_per_page'  => -1,
    //         'order' => 'DESC'
    //     ));
    // $postquery = new WP_Query( $args );
    
    // // echo "<pre>";
    // // print_r($postquery);

    // while ($postquery->have_posts()) {
    //         $postquery->the_post();
            
    //         the_title();
    //         echo 'hello';


    //     }
    
?>

<?php 
date_default_timezone_set('Asia/Kolkata'); 
?>
<?php $db = mysqli_connect("localhost","dbo_indigrid","In098di$#","db_indigrid")or die('Opps!, Try after some time.'); 

if($db){
    echo "connecting";

}else{
    echo "not connecting ...";
}

?>
<html>
<head>
<title>Create A Link That Expires</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
<link href="style.css" rel="stylesheet" type="text/css" >
</head>
<body>
<?php  
if(isset($_POST['submit'])){     
    $path = "./files/testing.jpeg";
    
    //Show filename
    $file_name_name = basename($path);
    //no of time downloads
    $counting = 2;
    $current_time  = time();
    $update_time  = $current_time+10;
    $my_curr_time = date('m-d-Y H:i', $update_time);
    $link = sha1(uniqid($file_name_name, true));
    $tstamp=$_SERVER["REQUEST_TIME"];
  /*  $query = "INSERT INTO links(id,link,file, counting, expire, tstamp) VALUES (0'$link', '$file_name_name', '$counting','$update_time','$current_time')";
   $insert =  mysqli_query($db,$query);
   if($insert){
    echo "inserted";
   }else{
    echo "not inserted";
   }*/
   $query = "insert into links(id,link,file, counting, expire, tstamp) values(0,'$link', '$file_name_name', '$counting','$update_time','$current_time');";
   if(mysqli_query($db,$query)){
    echo "inserted";
   }else{
    echo "inserted not... ";
   }

    $two= '<a href="'.esc_url(home_url( '/' )).'download.php?link='.$link.' " target="_NEW"> Link</a>';
}
?>

<form method="post" action="<?php echo esc_url(home_url( '/' )).'download1.php'; ?>" id='search_form' >
	<div class="row">
    <div class="col-sm-4">
    	<div class="form-group">
   		<input type='text' name='user_email' class="form-control" placeholder="Enter your email "> 		
   		<input type='date' name='dob' class="form-control" placeholder="Enter your email "> 		
   		<input type='submit' value="submit">
    	</div>
    </div>    
    </div>	
</form>
<?php 
	if(isset($_POST['user_email'])){
		echo "set";

	}else{
		echo 'not set';
	}
	

?>




	<script>

	jQuery("#search_form").submit(function(e) {
		//alert('hi');
    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = jQuery(this);
    var actionUrl = form.attr('action');
    alert(actionUrl);
    jQuery.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
        	alert(data);
        	if(data == 'OK'){
        		jQuery('#mylink_container').css('display','block');
        	}else{
        		jQuery('#mylink_container').css('display','none');
        		//alert('please enter valid details');
        	}
          
          //alert(data); // show response from the php script.
        }
    });
    
});
</script>
<div class="container" id='mylink_container' style="display:none;">
<div class="jumbotron" id='display_link' ><p class="text-xl-center"><?php if(isset($my_curr_time)){echo $my_curr_time.$two;};?></p></div>
<h1 class="animated bounce"><span class="glyphicon glyphicon-link"></span>Generate A Link That Expires</h1>
<div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">  
    <form method="post" role="form" enctype="multipart/form-data">  
       <input type="submit" name="submit" class="btn btn-success btn-lg" value="submit" />
    </form>
    </div>
    <div class="col-sm-4"></div>
</div>
</div>
</body>
</html>
<?php 
$db->close();
?>



<?php 
 
 // create PDF by using database .
 // create PDF by using database .
 // create PDF by using database .


$conn = mysqli_connect('localhost','dbo_indigrid','In098di$#','db_indigrid') or die('unable to connect ');
$fp = fopen("laxman.txt", "w") or die("Unable to open file!");

$query = "SELECT * FROM wp_users";
$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result) > 0){
	while($rows = mysqli_fetch_array($result)){
		//print_r($rows);
		//echo $rows['id'].'<br>';
		fwrite($fp,$rows['ID'].';'.$rows['user_login']."\n");
	}		
}else{
	echo "Not Data found!";
}
fclose($fp);

?>
<?php
require('fpdf/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();
$row=file('laxman.txt');
$pdf->SetFont('Arial','B',12);	
foreach($row as $rowValue) {
	$data=explode(';',$rowValue);
	foreach($data as $columnValue)
		$pdf->Cell(90,12,$columnValue,1);
		$pdf->SetFont('Arial','',12);		
		$pdf->Ln();
}
$pdf->Output('my_file1.pdf','F');
 $name = esc_url(home_url( '/' )).'/my_file1.pdf';
// $mypdf =  __DIR__.'/'.$name;
// echo $mypdf;
?>

<a href="<?php echo $name; ?>" >Download</a>




<!-- end fdf functionality -->
<!-- end fdf functionality -->
<!-- end fdf functionality -->



<?php 
// current will change if the financial month is 04 April.
$month =  date('m');
if($month == '04'){
	$currentYear = date('Y').'-'.date('y',  strtotime("+1 year"));
	echo "financial Year1".$currentYear;
}else{
	$prev_year = date('Y')-1;
	$curr_year = date('y');
	$currentYear = $prev_year.'-'.$curr_year;
	echo $currentYear;
}

//$currentYear = date('Y').'-'.date('y',  strtotime("+1 year"));
//echo $currentYear;
?>
<div class="investors-result-wrap">	
<?php
    // BOF News  display    
    $query = new WP_Query(array(
       'post_type'  => 'cb_investor',
       'posts_per_page'  =>  -1,
       'order' => 'ASC'
    ));
    $counter = 1;
    $maxSize = sizeof($query->posts);
?>
<div class="row">
<div class="col-lg-2 col-md-2 investors-result-left">
<ul class="investors-result-left-list">
<?php 
 while ($query->have_posts()) { $query->the_post(); ?>
	<li class="investors-result-left-list-inner">
		<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
	</li>
<?php  } ?>
</ul>
</div>
<div class="col-lg-10 col-md-10 investors-result-right">
	<div class="investors-result-right-inner">
		<h2>Financial Results</h2>
		<ul class="investors-result-right-list">
		<?php 
		$counter = 0;		
		$terms = get_terms('financialresults_type'); 
		foreach ($terms as $application) {			
			if($counter == 0){ ?>
				<li class="investors-result-right-list-inner active-tab" data-title="investor-result-<?php echo $counter; ?>">
			<?php }else{ ?>				
				<li class="investors-result-right-list-inner" data-title="investor-result-<?php echo $counter; ?>">
				<?php } echo $application->name; ?>
				</li>
		<?php 
		$counter++;
		}	
		?>
		</ul>
			<div class="investors-result-right-list-ctn">
			<?php 
			wp_reset_query();
			$terms = get_terms('financialresults_type'); 
			$term = get_queried_object();
			$counter1 = 0;
			$divTypeLayout = [14,15];
			foreach ($terms as $application) {
				$layout = 'tableStyle';
				if(in_array($application->term_id, $divTypeLayout)) {
					$layout = 'divStyle';
				}
			 ?>
			<?php	
			// $nextYear = date('Y', strtotime('+1 year'));
			// $f_year = substr($nextYear, -2); // get future year's two letters.
			// $year = date('Y'); 
			// $yearField=$year.'-'.$f_year;					
			$args = array(
			'post_type' => 'cb_financialresults',
			'order' => 'ASC',
			'post_per_page' => -1,
							
			'tax_query' => array(array(
			    'taxonomy' => 'financialresults_type',
			    'field' => 'term_id',
			    'terms' => array($application->term_id),
			)),
			'meta_query' => array(
				array(
					'key' => 'financial_year',
					'value' => $currentYear,
					'compare' => '='
				)
			)
			
			);
			// if($yearField != "") {
			// 	$args['meta_query'][] = array(
			// 			'key' => 'financial_year',
			//'value' => $yearField,
			//'compare' => '='
			// 	);
			// }
			$post_solutions = new WP_Query($args);
			$my_post_count = $post_solutions->post_count;
			//print_r($application);
			if($counter1 == 0){ ?>
			<div class="investors-result-right-list-ctn-inner investor-result-<?php echo $counter1; ?> active-content">
			<?php } else{ ?>
			<div class="investors-result-right-list-ctn-inner investor-result-<?php echo $counter1; ?>">
			<?php } ?>
			<!--images start-->
			<?php $subCatId = $application->term_id;
			if( $subCatId == 13){ ?>
					<div class="investors-result-right-list-ctn-inner-wrap">
							<div class="investors-result-right-list-ctn-inner-desc">
								<ul class="investors-result-right-list-ctn-inner-list">
									<li class="investors-result-right-list-ctn-inner-list-inner">
										<?php $quarter = get_term_link( $application ); ?>
											<?php $quarter_name = get_field('quarter', $application); if($quarter_name) : ?>
												<?php $quarter = get_term_link( $application );
					                                if( is_wp_error( $application ) ){ continue; }
					                                echo "";
					                            ?><div class="investors-result-right-list-ctn-inner-list-inner-div">
												<img src="https://development.ikf.in/indigrid/wp-content/uploads/2021/10/finance-icon1.png" alt="finance-icon1">
												<h4><?php echo $quarter_name; ?></h4></div>
										<?php endif; ?>
									</li>
									<li class="investors-result-right-list-ctn-inner-list-inner">
										<?php $presentation = get_term_link( $application ); ?>
											<?php $presentation_new = get_field('presentation', $application); if($presentation_new) : ?>
												<?php $presentation = get_term_link( $application );
					                                if( is_wp_error( $application ) ){ continue; }
					                                echo "<a target='_blank' href=".esc_url( $presentation_new ).">";
					                            ?><div class="investors-result-right-list-ctn-inner-list-inner-div"><img src="https://development.ikf.in/indigrid/wp-content/uploads/2021/10/finance-icon2.png" alt="finance-icon2">
												<h4>Presentation</h4></div></a>
										<?php endif; ?>
									</li>
									<li class="investors-result-right-list-ctn-inner-list-inner">
										<?php $press_release = get_term_link( $application ); ?>
											<?php $press_release_pdf = get_field('press_release', $application); if($press_release_pdf) : ?>
												<?php $press_release = get_term_link( $application );
					                                if( is_wp_error( $application ) ){ continue; }
					                                echo "<a target='_blank' href=".esc_url( $press_release_pdf ).">";
					                            ?><div class="investors-result-right-list-ctn-inner-list-inner-div">
												<img src="https://development.ikf.in/indigrid/wp-content/uploads/2021/10/finance-icon3.png" alt="finance-icon3">
												<h4>Earnings Release</h4></div></a>
										<?php endif; ?>
									</li>
									<li class="investors-result-right-list-ctn-inner-list-inner">
										<?php $consolidated = get_term_link( $application ); ?>
											<?php $consolidated_pdf = get_field('consolidated', $application); if($consolidated_pdf) : ?>
												<?php $consolidated = get_term_link( $application );
					                                if( is_wp_error( $application ) ){ continue; }
					                                echo "<a target='_blank' href=".esc_url( $consolidated_pdf ).">";
					                            ?><div class="investors-result-right-list-ctn-inner-list-inner-div">
												<img src="https://development.ikf.in/indigrid/wp-content/uploads/2021/10/finance-icon4.png" alt="finance-icon4">
												<h4>Financials</h4></div></a>
										<?php endif; ?>
									</li>
									<li class="investors-result-right-list-ctn-inner-list-inner">
										<?php $valuation_report = get_term_link( $application ); ?>
											<?php $valuation_report_pdf = get_field('valuation_report', $application); if($valuation_report_pdf) : ?>
												<?php $valuation_report = get_term_link( $application );
					                                if( is_wp_error( $application ) ){ continue; }
					                                echo "<a target='_blank' href=".esc_url( $valuation_report_pdf ).">";
					                            ?><div class="investors-result-right-list-ctn-inner-list-inner-div">
												<img src="https://development.ikf.in/indigrid/wp-content/uploads/2021/10/finance-icon5.png" alt="finance-icon5">
												<h4>Valuation Report</h4></div></a>
										<?php endif; ?>
									</li>
									<li class="investors-result-right-list-ctn-inner-list-inner">
										<?php $call_transcript = get_term_link( $application ); ?>
											<?php $call_transcript_pdf = get_field('call_transcript', $application); if($call_transcript_pdf) : ?>
												<?php $call_transcript = get_term_link( $application );
					                                if( is_wp_error( $application ) ){ continue; }
					                                echo "<a target='_blank' href=".esc_url( $call_transcript_pdf ).">";
					                            ?><div class="investors-result-right-list-ctn-inner-list-inner-div">
												<img src="https://development.ikf.in/indigrid/wp-content/uploads/2021/10/finance-icon6.png" alt="finance-icon6">
												<h4>Call Transcript</h4></div></a>
										<?php endif; ?>
									</li>
								</ul>
							</div>
							<p><?php echo $application->description; ?></p>
							<!--  Year Filter here --> 
				<?php 
					// Year filter code
					global $wpdb;
					$fin_year = $wpdb->get_results( 'SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key LIKE "financial_year" ORDER BY wp_postmeta.meta_value DESC', OBJECT );
					$curr_year = date('Y'); ?>									
							<div class="investor-filer">
								<form name="debtForm<?= $counter1 ?>" id="debtForm<?= $counter1 ?>" method="get" action='' class="year-form">	
									<div class="f-dropdown-years">
										<?php // $current_year = date('Y');
										 ?>
										<select onchange="filterData('debtForm<?= $counter1 ?>')" id="submit-here" name='select_year_box' class="invest-year">											
											<?php foreach($fin_year as $row) { ?>												
												<?php if($currentYear == $row->meta_value){?><option value="<?= $row->meta_value ?>" selected>Current Year</option><?php continue; } ?>
												<?php if($currentYear == $row->meta_value) { ?>
												 	<option value="<?= $row->meta_value ?>" selected><?= $row->meta_value ?></option>
												<?php } else { ?>							
													<option value="<?= $row->meta_value ?>"><?= $row->meta_value ?></option>
												<?php } ?>						
											<?php } ?>										
						        		</select>
							    	</div>	
									<input type="hidden" name="action" value="financial_filter_action">
									<input type="hidden" name="term_id" value="<?= $application->term_id ?>">
									<input type="hidden" name="layout" value="<?= $layout; ?>">
									<input type="hidden" name="counter" value="<?= $counter1 ?>">
								</form>
					        </div>
					       
			        		<div class="investors-table">
								<table class="table invest-table" id="table<?= $counter1 ?>">
									<thead>
										<tr>
											<th width="40%">Title</th>
											<th width="15%" class="table2-th">Q1</th>
											<th width="15%"class="table2-th">Q2</th>
											<th width="15%" class="table2-th">Q3</th>
											<th width="15%" class="table2-th">Q4</th>
										</tr>
									</thead>
									<tbody>

										<?php while($post_solutions->have_posts()){
					                       $post_solutions->the_post();
					                       
					                       



					           ?>
					           <tr>		            
					            <td data-label="Title" class="investor-title" ><?php the_title(); ?></td>
					            <td data-label="Q1">
							<?php 
							$pdf_link = get_field('q1_pdf'); 
							$audio_link = get_field('q1_audio'); 
							if($pdf_link || $audio_link){

								if($pdf_link){ ?>
									<a target="_blank" href="<?php echo the_field('q1_pdf'); ?>"><img src="<?php echo cb_theme_url('assets/images/pdf.png') ?>" alt="pdf"></a>
							<?php } ?>
							<?php if($audio_link){ ?>
									<a target="_blank" href="<?php echo the_field('q1_audio'); ?>"><img src="<?php echo cb_theme_url('assets/images/audio.png') ?>" alt="audio"></a>
							<?php } 
							} else{ ?>
							-
							<?php } ?>
						</td>
						<td data-label="Q2">
							<?php $pdf_link = get_field('q2_pdf'); 
							$audio_link = get_field('q2_audio'); 
							if($pdf_link || $audio_link){

								if($pdf_link){ ?>
									<a target="_blank" href="<?php echo the_field('q2_pdf'); ?>"><img src="<?php echo cb_theme_url('assets/images/pdf.png') ?>" alt="pdf"></a>
							<?php } ?>
							<?php if($audio_link){ ?>
									<a target="_blank" href="<?php echo the_field('q2_audio'); ?>"><img src="<?php echo cb_theme_url('assets/images/audio.png') ?>" alt="audio"></a>
							<?php } 
							} else{ ?>
							-
							<?php } ?>
						</td>
						<td data-label="Q3">
							<?php $pdf_link = get_field('q3_pdf'); 
							$audio_link = get_field('q3_audio'); 
							if($pdf_link || $audio_link){

								if($pdf_link){ ?>
									<a target="_blank" href="<?php echo the_field('q3_pdf'); ?>"><img src="<?php echo cb_theme_url('assets/images/pdf.png') ?>" alt="pdf"></a>
							<?php } ?>
							<?php if($audio_link){ ?>
									<a target="_blank" href="<?php echo the_field('q3_audio'); ?>"><img src="<?php echo cb_theme_url('assets/images/audio.png') ?>" alt="audio"></a>
							<?php } 
							} else{ ?>
							-
							<?php } ?>
						</td>
						<td data-label="Q4">
							<?php $pdf_link = get_field('q4_pdf'); 
							$audio_link = get_field('q4_audio'); 
							if($pdf_link || $audio_link){

								if($pdf_link){ ?>
									<a target="_blank" href="<?php echo the_field('q4_pdf'); ?>"><img src="<?php echo cb_theme_url('assets/images/pdf.png') ?>" alt="pdf"></a>
							<?php } ?>
							<?php if($audio_link){ ?>
									<a target="_blank" href="<?php echo the_field('q4_audio'); ?>"><img src="<?php echo cb_theme_url('assets/images/audio.png') ?>" alt="audio"></a>
							<?php } 
							} else{ ?>
							-
							<?php } ?>
						</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
						</div>	
						<?php
					}else{
						?>

						<!--  Year Filter here --> 
					<?php 
						// Year filter code
						global $wpdb;
						$fin_year = $wpdb->get_results( 'SELECT DISTINCT meta_value FROM wp_postmeta WHERE meta_key LIKE "financial_year" ORDER BY wp_postmeta.meta_value DESC', OBJECT );

					?>
				
					<div class="investor-filer">
					<form name="debtForm<?= $counter1 ?>" id="debtForm<?= $counter1 ?>" method="get" action='' class="year-form">	
						<div class="f-dropdown-years">
							<?php $current_year = date('Y');
							 ?>
							<select onchange="filterData('debtForm<?= $counter1 ?>')" id="submit-here" name='select_year_box' class="invest-year">
								
								<?php foreach($fin_year as $row) { ?>
									<?php if($currentYear == $row->meta_value){?><option value="<?= $row->meta_value ?>" selected>Current Year</option><?php continue; } ?>
									<?php if($currentYear == $row->meta_value && $isYearSet) { ?>
									 	<option value="<?= $row->meta_value ?>" selected><?= $row->meta_value ?></option>
									<?php } else { ?>							
										<option value="<?= $row->meta_value ?>"><?= $row->meta_value ?></option>
									<?php } ?>						
								<?php } ?>										
			        		</select>
				    	</div>	
						<input type="hidden" name="action" value="financial_filter_action">
						<input type="hidden" name="term_id" value="<?= $application->term_id ?>">
						<input type="hidden" name="layout" value="<?= $layout ?>">
						<input type="hidden" name="counter" value="<?= $counter1 ?>">
					</form>
		        </div>
		       
        		<div class="investors-table">
					<div class="financial-pdfimg-listing" id="table<?= $counter1 ?>">
						<div class="row">
						<?php while($post_solutions->have_posts()){
	                       $post_solutions->the_post(); //the_post_thumbnail_url('full');
	                       $custom_link = get_field('custom_link'); 
	                       $upload_pdf = get_field('upload_pdf');
	                       //print_r($upload_pdf);
	                       if($upload_pdf ){ ?>
	                       	<div class="col-lg-3">
				        		<div class="financialpdfimginner">
				        			<div class="fpdfthumb"><a href="<?php echo the_field('upload_pdf'); ?>" target='_blank' ><img src="<?php  echo the_field('thumbnail_img'); ?>"></a></div>
				        			<h3><?php the_title(); ?></h3>
				        			<span class="fimgpdfdate"><?php echo the_field('investor_date'); ?></span>
				        			<a href="<?php echo the_field('upload_pdf'); ?>" target='_blank'>VIEW REPORT</a>
				        		</div>
				        	</div>
	                       <?php }else{ ?>
	                       	<div class="col-lg-3">
				        		<div class="financialpdfimginner">
				        			<div class="fpdfthumb"><a href="<?php echo the_field('custom_link'); ?>" target='_blank' ><img src="<?php  echo the_field('thumbnail_img'); ?>"></a></div>
				        			<h3><?php the_title(); ?></h3>
				        			<span class="fimgpdfdate"><?php echo the_field('investor_date'); ?></span>
				        			<a href="<?php echo the_field('custom_link'); ?>" target='_blank' >VIEW REPORT</a>
				        		</div>
				        	</div>


	                       <?php } 	?>

			           
				        	
						<?php } ?>
						</div>
					</div>
				</div>
			<?php 
			}

			?>
			<!--images end-->
					
			</div>
			<?php 
				$counter1++;
			} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	
function filterData(formId) {
	alert('Hi');


	alert(formId);
	var myForm = jQuery(`#${formId}`)[0];
    var formData = new FormData(myForm);
    //alert(formData);    
    var formNumber = jQuery(`#${formId} input[name="counter"]`).val();
    var tableWrap = `#table${formNumber}`;
     jQuery.ajax({
            method: "POST",
            // enctype: 'multipart/form-data',
            url: "<?= site_url() ?>/wp-admin/admin-ajax.php",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 800000,
            beforeSend: function() {
              loadingOverlay(tableWrap, 'show');
            },
            success: function (data) {
            	
 			   var targetWrapper = `#table${formNumber}`;		
               // console.log(targetWrapper);
               if(data.status == 'error') {
                  alert(data.msg);
                  jQuery(`${targetWrapper} tbody`).html("");
                  return false;
               }
               var output = '';
               var laoutType = data.layoutType;
               jQuery.each(data.data, function(key, value){
               	// console.log(value);
               		if(laoutType == 'tableStyle') {
               			output += `<tr>`;  
               			output += `<td data-label="Title" class="investor-post-title">${value.title}</td>`;
               			output += `<td data-label="Date" class="investor-date">`;
               			if(value.q1_pdf_link) {
               				output += `<a target="_blank" href="${value.q1_pdf_link}" download><img src="<?php echo cb_theme_url('assets/images/pdf.png') ?>" alt="pdf"></a>`;	
               			}
               			if(value.q1_audio_link) {
               				output += `<a target="_blank" href="${value.q1_audio_link}" download><img src="<?php echo cb_theme_url('assets/images/audio.png') ?>" alt="audio"></a>`;	
               			}
               			output+=`</td>`;
               			output += `<td data-label="PDF" class="pdf-icon">`;
               			if(value.q2_pdf_link) {
               				output += `<a target="_blank" href="${value.q2_pdf_link}" download><img src="<?php echo cb_theme_url('assets/images/pdf.png') ?>" alt="pdf"></a>`;	
               			}
               			if(value.q2_audio_link) {
               				output += `<a target="_blank" href="${value.q2_audio_link}" download><img src="<?php echo cb_theme_url('assets/images/audio.png') ?>" alt="audio"></a>`;	
               			}
               			output += `</td>`;
               			//output+=`</td>`;
               			output += `<td data-label="PDF" class="pdf-icon">`;
               			if(value.q3_pdf_link) {
               				output += `<a target="_blank" href="${value.q3_pdf_link}" download><img src="<?php echo cb_theme_url('assets/images/pdf.png') ?>" alt="pdf"></a>`;	
               			}
               			if(value.q3_audio_link) {
               				output += `<a target="_blank" href="${value.q3_audio_link}" download><img src="<?php echo cb_theme_url('assets/images/audio.png') ?>" alt="audio"></a>`;	
               			}
               			output += `</td>`;               			
               			output += `<td data-label="PDF" class="pdf-icon">`;
               			if(value.q4_pdf_link) {
               				output += `<a target="_blank" href="${value.q4_pdf_link}" download><img src="<?php echo cb_theme_url('assets/images/pdf.png') ?>" alt="pdf"></a>`;	
               			}
               			if(value.q4_audio_link) {
               				output += `<a target="_blank" href="${value.q4_audio_link}" download><img src="<?php echo cb_theme_url('assets/images/audio.png') ?>" alt="audio"></a>`;	
               			}
               			output += `</td>`;
               			 output += `</tr>`;	
               		} else {               			
               			//output = 'Div style';
               			//output +=`<div data-label="Title" class="investor-post-title">${value.title}</div>`;
               			if(value.updf_link) {
               				output += `<div class="col-lg-3"><div class="financialpdfimginner">
				        			<div class="fpdfthumb"><a href="${value.updf_link}" target='_blank'><img src="${value.thumbnail_img}"></a></div><h3>${value.title}</h3><span class="fimgpdfdate">${value.investor_date}</span>
				        			<a href="${value.updf_link}" target='_blank'>VIEW REPORT</a></div></div>`;
               			}else{
               				output += `<div class="col-lg-3"><div class="financialpdfimginner">
				        			<div class="fpdfthumb"><a href="${value.custom_link}" target='_blank'><img src="${value.thumbnail_img}"></a></div><h3>${value.title}</h3><span class="fimgpdfdate">${value.investor_date}</span>
				        			<a href="${value.custom_link}" target='_blank'>VIEW REPORT</a></div></div>`;               				
               			}

               			
               		}
               		
               }); 

               if(laoutType == 'tableStyle') {
               	jQuery(`${targetWrapper} tbody`).html(output);	
               } else {
               	jQuery(`${targetWrapper} .row`).html(output);
               }
               
            },
            error: function (e) { 
               console.log(e); 
            },
            complete: function() {
              loadingOverlay(tableWrap, 'hide');
            }
        });
}
jQuery('.investors-result-right-list-inner').hover(function(){
    jQuery('.investors-result-right-list-inner').removeClass('active-tab');
    jQuery('.investors-result-right-list-ctn-inner').removeClass('active-content');
    var getdatatitle = jQuery(this).attr('data-title'); 
    jQuery(this).addClass('active-tab'); 
    jQuery('.investors-result-right-list-ctn-inner.'+getdatatitle).addClass('active-content')
});


</script>
