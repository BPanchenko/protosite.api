<?php
	class AppException extends Exception {
		private $_type;
		private $_data;
		private $error;
		
		private $_hash = array(
			'EmailExists' => array(
				'code' => 409,
				'message' => "Email is already registered"
			),
            'MethodNotAllowed' => array(
                'code' => 405,
                'message' => "Method is not supported"
            ),
			'ManyRequestCheckpoints' => array(
				'code' => 405,
				'message' => "Many checkpoints in the request"
			),
			'WrongEmail' => array(
				'code' => 400,
				'message' => "Invalid email"
			),
			'WrongFileType' => array(
				'code' => 400,
				'message' => "Not registered file type"
			),
			'WrongPassword' => array(
				'code' => 400,
				'message' => "Invalid password"
			),
			'Unauthorized' => array(
				'code' => 401,
				'message' => "Access denied"
			),
			'UnknownError' => array(
				'code' => 400,
				'message' => "Unknown Error"
			),
			'UnprocessableEntity' => array(
				'code' => 422,
				'message' => "Unprocessable Entity"
			)
		);
		
		public function __construct($type = 'ApiUnknownError', $data = null) {
			parent::__construct($type);
			
			$this->_type = $type;
			$this->_data = $data;
			
			if(array_key_exists($this->_type, $this->_hash))
				$this->error = $this->_hash[$this->_type];
		}

		public function code(): int {
			return $this->error ? $this->error['code'] : 400;
		}

		public function data() {
			return $this->_data;
		}
		
		public function message(): string {
			return $this->error ? $this->error['message'] : $this->_hash['UnknownError']['message'];
		}
		
		public function toArray(): array {
			$result = array();
			$result['code'] = 400;
			$result['error_type'] = $this->_type;
			
			if($this->_data) $result['error_data'] = $this->_data;
			
			if(array_key_exists($this->_type, $this->_hash))
				$result = array_merge($result, $this->_hash[$this->_type]);
			
			return $result;
		}

		public function type(): string {
			return $this->_type;
		}
		
		public function __toString(): string {
			return $this->_type;
		}
	}
?>