<?php
namespace DB\SQLite;
require_once dirname(__FILE__) . '/Schema.php';

	class Table extends \DB\SQLite\Schema {
		
		protected $_name = '';
		protected $_columns;
		protected $_defaults_query;
		
		function __construct($dns) {
			list($this->_name, $dir, $file_name) = $this->_prepareTable($dns);
			parent::__construct($file_name, $dir);
			
			if(is_string($this->_name))
				$this->_defaults_query = array(
					'from' => $this->_name
				);
			else
				throw new \SystemException('WrongTableName');
		}
		
		/****/
		public function columns() {
			if($this->_columns) return $this->_columns;
			
			// fetch the table structure
			$_sql = "SELECT `sql` FROM `sqlite_master` WHERE `tbl_name` = :tbl_name;";
			$_sth = $this->prepare($_sql);
			$_sth->bindParam(":tbl_name", $this->name());
			$_sth->execute();
			$_sql = $_sth->fetchColumn();
			$_sql = strtolower($_sql);
			
			$_res = array();
			
			$_sql = preg_replace("/([^>]+\()/", '', $_sql);
			$_sql = preg_replace("/\)([^>]*)/", '', $_sql);
			$_sql = preg_replace("/[\f\n\r\t\v]*/", '', $_sql);
			$_strs = explode(',', $_sql);
			
			foreach($_strs as $_str) {
				// preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, 3);
				preg_match('/`([\w]+)`/', $_str, $_matches_name);
				if(is_string($_matches_name[1]))
					$_name = $_matches_name[1];
				
				$_type = strpos($_str, 'integer primary key') ? 'pk' : NULL;
				if(!$_type)
					foreach ($this->columnTypes as $columnType=>$needle) {
						$_type = strpos($_str, $needle) ? $columnType : NULL;
						if($_type) break;
					}
				$this->_columns[$_name]['_str'] = $_str;
				$this->_columns[$_name]['type'] = $_type;
			}
			
			//$this->query("SELECT `sql` FROM `sqlite_master` WHERE `tbl_name` = :tbl_name;");
			return $this->_columns;
		}
		
		/****/
		public function columnType($column_name) {
			if(!$this->_columns)
				$this->columns();
			
			return
				$this->hasColumn($column_name) ? $this->_columns[$column_name]['type'] : NULL;
		}
		
		/****/
		public function hasColumn($column_name) {
			if(!$this->_columns)
				$this->columns();
			
			return
				array_key_exists($column_name, $this->_columns);
		}
		
		/****/
		public function fetchColumn() {
			$this->from($this->_name);
			return parent::fetchColumn();
		}
		
		/****/
		public function fetchAll($fetch_style = \PDO::FETCH_OBJ) {
			$this->from($this->_name);
			return parent::fetchAll($fetch_style);
		}
		
		public function drop() { return $this->dropTable($this->_name); }
		public function name() { return $this->_name; }
		
		private function _prepareTable($dns) {
			$_parts = explode('.', str_replace(array('sqlite:'), '', $dns));
			
			$_name = $_parts[1];
			$_file_name = trim(substr($_parts[0], strrpos($_parts[0], '/')), '/');
			$_dir = str_replace(('/' . $_file_name), '', $_parts[0]);
			
			return array( $_name, $_dir, $_file_name );
		}
	}
?>