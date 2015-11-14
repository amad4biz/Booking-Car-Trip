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
				$textBodyContent = $qryAutoEmailEvent['textBody'];
				$htmlBodyContent = $qryAutoEmailEvent['htmlBody'];
				$textBodyContent = str_replace('[[headerText]]', '' , $textBodyContent);
				$htmlBodyContent = str_replace('[[headerText]]', '' , $htmlBodyContent);
				if($data['autoEmailEventID'] == $qryAutoEmailEvent['autoEmailEventID']){
					$this->send(
						$qryAutoEmailEvent['autoEmailID'],
						$data['bookingID'],
						$data['toEmail'],
						$qryAutoEmailEvent['ccEmail'],
						$qryAutoEmailEvent['bccEmail'],
						$this->replacePlaceholder($data,$qryAutoEmailEvent['subject']),
						$this->replacePlaceholder($data,$textBodyContent),
						$this->replacePlaceholder($data,$htmlBodyContent)
					);
				}	
			}
		}
	}
	public function getAutoEmailHTML($data){
		if(isset($data['autoEmailEventID']) && $data['autoEmailEventID'] > 0){
			$qryAutoEmailEvents = $this->getAutoEmails(1);
			// loop over events
			foreach($qryAutoEmailEvents as $qryAutoEmailEvent){
				if($data['autoEmailEventID'] == $qryAutoEmailEvent['autoEmailEventID']){
					
						$data['emailHTML'] = $this->replacePlaceholder($data,$qryAutoEmailEvent['htmlBody']);
					
				}	
			}
		}
		return $data;
	}
	public function replacePlaceholder($data,$text = NULL){
		$content = $text;
		if(isset($data['placeHolderData']))
		{
			foreach ($data['placeHolderData'] as $key => $value) {
				
					$content = str_replace('[['.$key.']]', $value , $content);
				
			} 
		}
		elseif(isset($data['bookingID']) && $data['bookingID'] > 0){
			$qryBooking=(array)$this->reservation_model->get_booking($data['bookingID'])->row();
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
	public function get_autoemails(){
		$sqlQuery = "SELECT autoemail.* , autoemailevents.eventName
					 FROM 
						autoemail
						INNER JOIN autoemailevents ON autoemail.autoEmailEventID = autoemailevents.autoEmailEventID
					 ORDER BY
					 	autoemail.subject";
		return  $this->db->query($sqlQuery)->result_array();
	}
	public function get_autoemail($autoEmailID){
		$sqlQuery = "SELECT autoemail.* FROM  autoemail WHERE autoEmailID = " . $autoEmailID;
		return  $this->db->query($sqlQuery);
	}
	public function get_autoEmailEvents($isActive = NULL){
		$sqlQuery = "SELECT		 *
					FROM 		autoemailevents";
					if(isset($isActive) && !is_null($isActive)){
					$sqlQuery .= " WHERE isActive = " . $isActive; 
					}
		$query = $this->db->query($sqlQuery)->result_array();
		return $query;	
	}
	public function insert_autoEmail($autoEmail_info){
		$data = array(
			'autoEmailEventID' => $autoEmail_info['autoEmailEventID'],
			'subject' => $autoEmail_info['subject'],
			'ccEmail' => $autoEmail_info['ccEmail'],
			'bccEmail' => $autoEmail_info['bccEmail'],
			'textBody' => $autoEmail_info['textBody'],			
			'htmlBody' => $autoEmail_info['htmlBody'],
			'isActive' => $autoEmail_info['isActive'],			
			'dateCreated' => 'now()'
		);
		$this->db->insert('autoemail', $data);
	}
	public function update_autoEmail($autoEmail_info){
		$sql = "UPDATE	autoemail
				SET		 autoEmailEventID = '{$autoEmail_info['autoEmailEventID']}'
						,subject	= '{$autoEmail_info['subject']}'
						,ccEmail	= '{$autoEmail_info['ccEmail']}'
						,bccEmail	= '{$autoEmail_info['bccEmail']}'
						,textBody	= '{$autoEmail_info['textBody']}'
						,htmlBody	= '{$autoEmail_info['htmlBody']}'
						,isActive	= '{$autoEmail_info['isActive']}'
						
				WHERE	autoEmailID		= '{$autoEmail_info['autoEmailID']}'
				";
		$query=$this->db->query($sql, array());
		return $query;
	}
	public function delete_autoemail($autoEmailID){
		$sql = "DELETE FROM	autoemail
				WHERE	autoEmailID		= '{$autoEmailID}'";
		$query=$this->db->query($sql);
		return true;
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
		$from = 'Xpress Shuttles <noreply@xpressshuttles.com>';
		$headers   = array();
		$headers[] = "MIME-Version: 1.0";
		$headers[] = "Content-type: text/html; charset=iso-8859-1";
		$headers[] = "From: " . $from;
		$headers[] = "Cc: " . $ccEmail;
		$headers[] = "Bcc: " . $bccEmail;
		$headers[] = "Reply-To: " . $from;
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
		$email_setting  = array('mailtype'=>'html');
		$this->email->initialize($email_setting);
		$this->email->from('noreply@xpressshuttles.com', 'Xpress Shuttles');
		$this->email->to($to);
		$this->email->cc($ccEmail);
		$this->email->bcc($bccEmail);		
		$this->email->subject($subject);
		$this->email->message($htmlBody);		
		$this->email->send();
	
	}
	public function getSentEmailContent($sentEmailContentID){
		$sqlQuery = "SELECT		 *
					 FROM 		sentemailcontent 
					 WHERE sentEmailContentID = ?"; 
		$query=$this->db->query($sqlQuery, array($sentEmailContentID));
		return $query;
	}
	
}

?>