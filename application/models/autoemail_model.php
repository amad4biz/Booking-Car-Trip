<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Autoemail_model extends CI_Model {

	public function __construct(){
		$this->load->database();
	}
	public function sendAutoEmail($data){
		if(isset($data['autoEmailEventID']) && $data['autoEmailEventID'] > 0){
			$qryAutoEmailEvents = $this->getAutoEmails(1);
			// loop over events
			foreach($qryAutoEmailEvents as $qryAutoEmailEvent){  
				if($data['autoEmailEventID'] == $qryAutoEmailEvent['autoEmailEventID']){
					$subjectLine = $qryAutoEmailEvent['subject'];
					$textBodyContent = $qryAutoEmailEvent['textBody'];
					$htmlBodyContent = $qryAutoEmailEvent['htmlBody'];
                    if($data['trip'] == 2)
                    {
					    if($data['autoEmailEventID'] == 1 && isset($data['lessThen12Hours']) && $data['lessThen12Hours'] == true){
						    $subjectLine = $subjectLine . ' (Pending)'; 
						    $textBodyContent = str_replace('[[headerText]]', 'This booking was made less than 12 hours ago. Your reservation is pending. You will receive a confirmation  call from our office or you may call us at 866.805.4234',$textBodyContent);
						    $htmlBodyContent = str_replace('[[headerText]]', '<p><B>This booking was made less than 12 hours ago.</B></p><p>Your reservation is pending. You will receive a confirmation  call from our office or you may call us at 866.805.4234</p><p>Pickup Location: '.$data['pickUp_address'].'</p><p>Dropoff Location: '.$data['dropOff_address'].'</p><p>Pickup Return Location: '.$data['pickUp_address2'].'</p><p>Dropoff Return Location: '.$data['dropOff_address2'].'</p>',$htmlBodyContent);
					    }
					    else if($data['autoEmailEventID'] == 5 && isset($data['lessThen12Hours']) && $data['lessThen12Hours'] == true){
                            $subjectLine = $subjectLine . ' (Pending)'; 
                            $textBodyContent = str_replace('[[headerText]]', 'This booking was made less than 12 hours ago. Your reservation is pending. You will receive a confirmation  call from our office or you may call us at 866.805.4234',$textBodyContent);
                            $htmlBodyContent = str_replace('[[headerText]]', '<p><B>This booking was made less than 12 hours ago.</B></p><p>Your reservation is pending. You will receive a confirmation  call from our office or you may call us at 866.805.4234</p><p>Pickup Location: '.$data['pickUp_address'].'</p><p>Dropoff Location: '.$data['dropOff_address'].'</p><p>Pickup Return Location: '.$data['pickUp_address2'].'</p><p>Dropoff Return Location: '.$data['dropOff_address2'].'</p>',$htmlBodyContent);
                        }
                        else {
						    $textBodyContent = str_replace('[[headerText]]', '' , $textBodyContent);
						    $htmlBodyContent = str_replace('[[headerText]]', '' , $htmlBodyContent);
					    }
                    } else {
                        if($data['autoEmailEventID'] == 1 && isset($data['lessThen12Hours']) && $data['lessThen12Hours'] == true){
                            $subjectLine = $subjectLine . ' (Pending)'; 
                            $textBodyContent = str_replace('[[headerText]]', 'This booking was made less than 12 hours ago. Your reservation is pending. You will receive a confirmation  call from our office or you may call us at 866.805.4234',$textBodyContent);
                            $htmlBodyContent = str_replace('[[headerText]]', '<p><B>This booking was made less than 12 hours ago.</B></p><p>Your reservation is pending. You will receive a confirmation  call from our office or you may call us at 866.805.4234</p>',$htmlBodyContent);
                        }
                        else if($data['autoEmailEventID'] == 5 && isset($data['lessThen12Hours']) && $data['lessThen12Hours'] == true){
                            $subjectLine = $subjectLine . ' (Pending)'; 
                            $textBodyContent = str_replace('[[headerText]]', 'This booking was made less than 12 hours ago. Your reservation is pending. You will receive a confirmation  call from our office or you may call us at 866.805.4234',$textBodyContent);
                            $htmlBodyContent = str_replace('[[headerText]]', '<p><B>This booking was made less than 12 hours ago.</B></p><p>Your reservation is pending. You will receive a confirmation  call from our office or you may call us at 866.805.4234</p>',$htmlBodyContent);
                        }
                        else {
                            $textBodyContent = str_replace('[[headerText]]', '' , $textBodyContent);
                            $htmlBodyContent = str_replace('[[headerText]]', '' , $htmlBodyContent);
                        }
                    } 
                    $this->send(
						$qryAutoEmailEvent['autoEmailID'],
						$bookingID = $data['bookingID'],
						$data['toEmail'],
						$qryAutoEmailEvent['ccEmail'],
						$qryAutoEmailEvent['bccEmail'],
						$this->replacePlaceholder($data,$subjectLine),
						$this->replacePlaceholder($data,$textBodyContent),
						$this->replacePlaceholder($data,$htmlBodyContent)
					);
				}	
			}
		}
	}
	public function replacePlaceholder($data,$text = NULL){
		$content = $text;
		if(isset($data['qryVehicle']) && count($data['qryVehicle']) > 0){
			$content = str_replace('[[vehicleType]]', $data['qryVehicle'][0]['vehicleName'] , $content);					
		}
		if(isset($data['bookingID']) && $data['bookingID'] > 0){
			$qryBooking=(array)$this->Reservation_model->get_booking($data['bookingID'])->row();
			foreach ($qryBooking as $key => $value) {
				$content = str_replace('[['.$key.']]', $value , $content);
			} 
		}
		$qryPlaceholders = $this->get_placeholders();
		foreach($qryPlaceholders as $qryPlaceholder){
			$content = str_replace($qryPlaceholder['code'], '' , $content);
		}
		return $content;
	}
	public function getAutoEmails($isActive = NULL){
		$sqlQuery = "SELECT		 *
					FROM 		autoemail";
					if(isset($isActive) && !is_null($isActive)){
					$sqlQuery .= " WHERE isActive = " . $isActive; 
					}
		$query = $this->db->query($sqlQuery)->result_array();
		return $query;	
	}
	public function get_placeholders(){
		$sqlQuery = "SELECT placeholder.*,placeholderType.placeholderType
					 FROM 
						placeholders placeholder
						INNER JOIN placeholderType ON placeholder.placeHolderTypeID = placeholderType.placeHolderTypeID
					WHERE
						placeholder.isActive = 1	
					 ORDER BY
					 	placeholderType.sortOrder , placeholder.label";
		return  $this->db->query($sqlQuery)->result_array();
	}
	public function send($autoEmailID,$bookingID = NULL,$to,$ccEmail,$bccEmail,$subject,$textBody,$htmlBody){
		/*
		$from = 'Xpress Shuttles <booking@xpressshuttles.com>';
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/html; charset=iso-8859-1";
		$headers[] = "From: " . $from;
		$headers[] = "Cc: " . $ccEmail; 
		$headers[] = "Bcc: " . $bccEmail;
		$headers[] = "Reply-To: xpressshuttle@hotmail.com";
		$headers[] = "Subject: {$subject}";
		$headers[] = "X-Mailer: PHP/".phpversion();
		$data = array(
			'autoEmailID' => $autoEmailID,
			'bookingID' => $bookingID,
			'from' => $from,
			'to' => $to,
			'subject' => $subject,			
			'textBody' => $textBody,
			'htmlBody' => $htmlBody
		);
		$this->db->insert('sentemailcontent', $data);
		mail($to, $subject, $htmlBody, implode("\r\n", $headers));
		*/
	
		$this->load->library('email');	
		$email_setting = array('mailtype'=>'html');
		$this->email->initialize($email_setting);
		$this->email->from('noreply@xpressshuttles.com', 'Xpress Shuttles');
		$this->email->to($to);
		$this->email->cc($ccEmail);
		$this->email->bcc($bccEmail);		
		$this->email->subject($subject);
		$this->email->message($htmlBody);		
		$this->email->send();
	}
	
	
}

?>