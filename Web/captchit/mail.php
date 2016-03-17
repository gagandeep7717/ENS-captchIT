<?php
	class maillib {
		public function sendmail($to, $subject, $body)
		{	
			$message = "<div style='background-color:#1c8dff'>
				<table width='100%' style='border:3px groove #FFFFFF;padding:2px;'>
				<tr bgcolor='#F0F0F0'>
				
					<td style='color:#660099;font-family:Verdana;padding-top:5px;'>
						<h1>Captchit</h1>
					</td>
				</tr>
				
				<tr>
					<td colspan='2' style='padding:15px;line-height:170%;font-size:13px;font-family:Verdana;' bgcolor='white'>
						$body 
					</td>
				</tr>
				
				</table>
				</div>";	
			$headers  	= 'From: emergency@gaganr.in'. "\r\n" .
						'Reply-To: emergency@gaganr.in'. "\r\n" .
						'MIME-Version: 1.0' . "\r\n" .
						'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
						
						mail($to, $subject, $message, $headers);
		/*	if(mail($to, $subject, $message, $headers))
				echo "<h3>Email sent</h3>";
			else
				echo "<h3>Email sending failed</h3>";*/
		}
		public function sendsms($to, $sms)
		{
			$url = 'http://54.254.154.166/api/sendhttp.php?authkey=63786AbcGiWLI78t534ccb86&mobiles=#mobile&message=#sms&sender=Captchit';
			$url = str_replace('#mobile',$to, $url);
			$url = str_replace('#sms',urlencode($sms), $url);	
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			echo "<br /><br />".$result;
		}
	}

?>
