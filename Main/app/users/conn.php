<?php
class opmysql{
	private $host = 'localhost';
	private $name = 'root';	
	private $pwd = '';	
	private $dBase = 'inforobot';
	private $conn = '';						//���ݿ�������Դ
	private $result = '';					//�����
	private $msg = '';						//���ؽ��
	private $rowsNum = 0;					//���ؽ����
	private $rowsArray = array();			//���ؽ������
	//��ʼ����
	function __construct(){
		$this->init_conn();
	}
	//�������ݿ�
	public function init_conn(){
		$this->conn=mysql_connect($this->host,$this->name,$this->pwd);
		mysql_select_db($this->dBase,$this->conn);
	}
	//��ѯ���
	public function mysql_query_rst($sql){
		if($this->conn == ''){
			$this->init_conn();
		}
		$this->result = mysql_query($sql,$this->conn);
	}
	//ȡ�ò�ѯ�����
	public function getRowsNum($sql){
		$this->mysql_query_rst($sql);
		if(mysql_errno() == 0){
			return @mysql_num_rows($this->result);
		}else{
			return '';
		}	
	}
	//ȡ�ü�¼���飨������¼��
	public function getRowsRst($sql){
		$this->mysql_query_rst($sql);
		if(mysql_error() == 0){
			$this->rowsRst = mysql_fetch_array($this->result,MYSQL_ASSOC);
			return $this->rowsRst;
		}else{
			return '';
		}
	}
	//ȡ�ü�¼���飨������¼��
	public function getRowsArray($sql){
		$this->mysql_query_rst($sql);
		if(mysql_errno() == 0){
			while($row = mysql_fetch_array($this->result,MYSQL_ASSOC)) {
				$this->rowsArray[] = $row;
			}
			return $this->rowsArray;
		}else{
			return '';
		}
	}
	//���¡�ɾ������Ӽ�¼��
	public function uidRst($sql){
		if($this->conn == ''){
			$this->init_conn();
		}
		mysql_query($sql);
		$this->rowsNum = mysql_affected_rows();
		if(mysql_errno() == 0){
			return $this->rowsNum;
		}else{
			return '';
		}
	}
	
	//������Ϣ
	public function msg_error(){
		if(mysql_errno() != 0) {
			$this->msg = mysql_error();
		}
		return $this->msg;
	}

	//�ر����ݿ�
	public function close_conn(){
		$this->close_rst();
		mysql_close($this->conn);
		$this->conn = '';
	}
}
