<?php
class Page{
	

	protected $firstRow ;//分页起始行数
	
	protected $listRows ;//列表每页显示行数
	
	protected $parameter  ;//页数跳转时要带的参数
	
	protected $totalPages  ; //分页总页面数
	
	protected $totalRows  ;//总行数
	
	protected $nowPage    ;//当前页数
	
	protected $coolPages   ;//分页的栏的总页数
	
	// ----------------------------------------------------------
	
	protected $rollPage   ;//分页栏每页显示的页数
	
	protected $config   =   array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页');
	
	public function __construct($totalRows,$listRows='',$parameter='')
	{
		$this->totalRows = $totalRows;
		$this->parameter = $parameter;
		$this->rollPage = 5;
		$this->listRows = !empty($listRows)?$listRows:20;
		$this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
		$this->coolPages  = ceil($this->totalPages/$this->rollPage);
	
	
		if( (!empty($this->totalPages) && $_REQUEST[C('VAR_PAGE')]>$this->totalPages) || $_REQUEST[C('VAR_PAGE')]=='last' ) {
			$this->nowPage = $this->totalPages;
			$_REQUEST[C('VAR_PAGE')] = $this->totalPages;
		}else{
			$this->nowPage  = intval($_REQUEST[C('VAR_PAGE')])>0?intval($_REQUEST[C('VAR_PAGE')]):1;
		}
	
		$this->firstRow = $this->listRows*($this->nowPage-1);
	
	}
	
}