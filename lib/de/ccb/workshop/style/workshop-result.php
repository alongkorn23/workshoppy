<?php
use Symfony\Component\VarDumper\Cloner\VarCloner;

$workshop = $data['workshop'];
$url_workshopResultPDF = $data['router']->generate('workshop_result_pdf', ['guid' => $workshop->guid]);

?>
<div id= "workshopResults" class="container">
	<h1 id="workshopTitle" class="col-xs-8 text-center">
        <?php echo sprintf($data['l10n']->get('results about the workshop %s'), htmlentities($workshop->title));?>
    </h1>
    <div id= "workshopsResultsTable" class="jumbotron">
    	<a id="pdf-button" class="btn btn-warning" href="&(url_workshopResultPDF);">
            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
            <?php echo $data['l10n']->get('download as pdf file')?>
    	</a>
    	<h4>
    		<?php 
    		function my_sort_function($a, $b) {
    		    switch (true){
    		        case (isset($a->category) && isset($b->category)):
    		            return $a->category < $b->category;
    		            break;
    		        case (isset($a->category) && !isset($b->category)):
    		            return $a->category;
    		            break;
    		        case (!isset($a->category) && isset($b->category)):
    		            return $b->category;
    		            break;
    		    }
    		}
    		
    		foreach ($data['sessions'] as $session) {
    		    echo "<h2 id='sessionTitle' class='col-xs-8 text-center'>" . htmlentities($session->question) . "</h2>";
    		    $session_data = json_decode($session->data);
    		    $categories_object = $session->get_categories();
    		    $categories = [];
    		    
    		      if($session_data != null){
    		          foreach ($categories_object as $category) {
    		              $categories[$category->id] = $category->title;    	         
    		    }
    		    usort($session_data, 'my_sort_function');
    		    ?>
    		    <table class="table table-striped">
  					<thead>
   						 <tr>
   						 	<?php 
   						 	    if (!empty($categories)) {
   						 	        echo "<th scope='col'>" . $data['l10n']->get('category') . "</th>";
   						 	        echo "<th scope='col'>" . $data['l10n']->get('username') . "</th>";
   						 	        echo "<th scope='col'>" . $data['l10n']->get('text') . "</th>";
   						 	    }
   						 	    else {
   						 	        echo "<th scope='col'>" . $data['l10n']->get('username') . "</th>";
   						 	        echo "<th scope='col'>" . $data['l10n']->get('text') . "</th>";
   						 	    }
  
    						 ?>
    					</tr>
  					</thead>
    		  
    		  	<tbody>
    		  	<?php 
    		  	$categories_repeat = [];
    		  	foreach ($session_data as $result) {
    		  	    if(!empty($categories)){
    		  	        $category = $data['l10n']->get('unsorted category');
    		  	        if (isset($result->category) && isset($categories[$result->category])) {
    		  	            $category = $categories[$result->category];
    		  	        }
    		  	        if(isset($categories_repeat[$category])){
    		  	            echo "<tr class='noCategoriesTitle'>";
    		  	            echo "<td class ='noCategoryData'></td>";
    		  	        }
    		  	        else {
    		  	            $categories_repeat[$category] = $category;
    		  	            echo "<tr class='withCategoriesTitle'>";
    		  	            echo "<td class='withCategoryData'>" . htmlentities($category) . "</td>";
    		  	        }
    		  	        echo "<td>" . htmlentities($result->user_id) . "</td>";
    		  	        echo "<td>" . htmlentities($result->msg) . "</td>";
    		  	        echo "</tr>";
    		  	    }
    		  	    else {
    		  	        echo "<tr class='noCategories'>";
    		  	        echo "<td>" . htmlentities($result->user_id) . "</td>";
    		  	        echo "<td>" . htmlentities($result->msg) . "</td>";
    		  	        echo "</tr>";
    		  	    }
    		  	}
    		  	?>
    		  	</tbody>
    			</table>
    			<br />
    		    <?php
    		    }
    		    else {
    		        echo "<p style='font-size: 21px;'>" . $data['l10n']->get('no data available yet') . "</p>";
    		    }
    		}
    		?>
    	</h4>
    </div>
</div>