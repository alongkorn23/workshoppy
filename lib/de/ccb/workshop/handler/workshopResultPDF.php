<?php
use Mpdf\Output\Destination;

/**
 *
 * @copyright CONTENT CONTROL GmbH, http://www.contentcontrol-berlin.de
 * @package de.ccb.workshop
 */

/**
 * @package de.ccb.workshop
 */

class de_ccb_workshop_handler_workshopResultPDF extends midcom_baseclasses_components_handler
{
    public function _handler_workshopResultPDF(array $args, array &$data) 
    {
        $workshop = de_ccb_workshop_dba_workshop::get_cached($args[0]);
        $sessions_qb = de_ccb_workshop_dba_session::new_query_builder();
        $sessions_qb->add_constraint('workshop', '=', $workshop->id);
        $data['sessions'] = $sessions_qb->execute();
        $data['workshop'] = $workshop;
        
        $workshopTitle = sprintf($data['l10n']->get('results about the workshop %s'), htmlentities($workshop->title));
        $html = '<h1 class="col-xs-8" style="font-family: Sans-Serif; text-align: center;">' . $workshopTitle . '</h1>' ;
        foreach ($data['sessions'] as $session) {
            $html .= '<h2 class="col-xs-8" style="font-family: Sans-Serif; text-align: center;">' . htmlentities($session->question) . '</h2>';
            $session_data = json_decode($session->data);
            $categories_object = $session->get_categories();
            $categories = [];
            
            if($session_data != null){
                foreach ($categories_object as $category) {
                    $categories[$category->id] = $category->title;
                }
                //sort all session data
                usort($session_data, function ($a, $b) {
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
                });
                    //show table header row
                    $html .=
                    '<table class="table table-striped" cellspacing="0">
                        <thead>
                            <tr>';
                                if (!empty($categories)) {
                                    $html .= '<th scope="col">' . $this->_l10n->get('category') . '</th>';
                                    $html .= '<th scope="col">' . $this->_l10n->get('username') . '</th>';
                                    $html .= '<th scope="col">' . $this->_l10n->get('text') . '</th>';
                                }
                                else {
                                    $html .= '<th scope="col">' . $this->_l10n->get('username') . '</th>';
                                    $html .= '<th scope="col">' . $this->_l10n->get('text') . '</th>';
                                }
                                $html .=
                           '</tr>
                        </thead>';
                    $html .= 
                        '<tbody>';
            	           $categories_repeat = [];
            	   
            	           //show the whole table body
                           foreach ($session_data as $result) {
                                if(!empty($categories)){
                                    $category = $data['l10n']->get('unsorted category');
            	                    if (isset($result->category) && isset($categories[$result->category])) {
            	                       $category = $categories[$result->category];
            	                    }
            	                    if(isset($categories_repeat[$category])){
            	                       $html .= '<tr class="noCategoriesTitle">';
            		                   $html .= '<td class ="noCategoryData"></td>';
            		                   $html .= '<td>' . htmlentities($result->user_id) . '</td>';
            		                   $html .= '<td>' . htmlentities($result->msg) . '</td>';
            		                   $html .= '</tr>';
            		      
            	                   }
            	                   else {
            	                       $categories_repeat[$category] = $category;
            		                   $html .= '<tr class="withCategoriesTitle">';
            		                   $html .= '<td class="withCategoryData">' . htmlentities($category) . '</td>';
            		                   $html .= '<td>' . htmlentities($result->user_id) . '</td>';
            		                   $html .= '<td>' . htmlentities($result->msg) . '</td>';
            		                   $html .= '</tr>';
            	                   }

                                }
                                else {
            	                   $html .= '<tr class="noCategories">';
            	                   $html .= '<td>' . htmlentities($result->user_id) . '</td>';
            	                   $html .= '<td>' . htmlentities($result->msg) . '</td>';
            	                   $html .= '</tr>';
                    }					   
                }
                    $html .= 
                        '</tbody>';
                    $html .= 
                    '</table>';
                    $html .=
                    '<br />';
          }
          //if the session data is empty, then show the message below
          else {
            $html .= '<p style="font-size: 15px; font-family: Sans-Serif;">' . $data['l10n']->get('no data available yet') . '</p>';
          }
        }
        //styling css
        $html .= 
        '<style>

            table tr.withCategoriesTitle td {
                border-top: 1px solid black;
            }

            td {
                font-family: Sans-Serif;
                padding-top: 0.75rem;
                padding-bottom: 0.75rem;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            .table thead th { 
                font-family: Sans-Serif;
                border-bottom: 2px solid white;
                text-align: left;
            }

        </style>';
        
        //create a pdf file
        $mpdf = new \Mpdf\Mpdf();
        
        //Write HTML code to the document
        $mpdf->WriteHTML($html);
        
        //name the pdf file as
        $fileName = midcom_helper_misc::urlize($workshopTitle);
        $fileName .= '.pdf';
        
        //output in browser
        $mpdf->Output($fileName, Destination::INLINE);
                
    }           
}
