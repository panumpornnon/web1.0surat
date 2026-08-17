<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response_check'])) {
        
		$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
        $recaptcha_secret = '6LfJ7RYjAAAAAJR-qIcPbXzSdhD1AUHtTiNh-r7X';
        $recaptcha_response = $_POST['recaptcha_response_check'];

        // Make and decode POST request:
        $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response); // เรียกใช้งาน recaptcha API ของ Google
        /*$headers    	=[
							'accept: application/json'
						 ];
						 
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
		$recaptcha = curl_exec( $ch );
		
		if( $recaptcha === false) 
		{
			echo curl_error($ch);
			curl_close( $ch );
			exit;
		}
		curl_close( $ch );*/
		
		$recaptcha = json_decode($recaptcha); // แปลงค่ากลับมาเป็น object 
        
		print_r($recaptcha);
	
		// เช็คตรวจสอบผลเพื่อที่งานของเรา 
		if ($recaptcha->score >= 0.5) 
		{
			echo 'ผ่านการตรวจสอบ spam';  // TODO งานที่ต้องทำ
		} 
		else 
		{
			echo 'ไม่ผ่านการตรวจสอบ Spame';  // แจ้งข้อผิดพลาดกลับไปหน้าจอ
		}
    }
?>