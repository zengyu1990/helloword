<?php
class AppService extends ServiceObject{
/* (non-PHPdoc)
	 * @see DataBoundObject::DefineTableName()
	 */
	
	protected function DefineTableName() {
		return("app");
		// TODO Auto-generated method stub
	}

/* (non-PHPdoc)
	 * @see DataBoundObject::DefineRelationMap()
	 */
	protected function DefineRelationMap() {
		// TODO Auto-generated method stub
		return null;
	}
/* (non-PHPdoc)
	 * @see ServiceObject::DefinePersistenceFactory()
	 */
	protected function DefinePersistenceFactory() {
		require_once JHORM_VO_FACTORY_DIR.'AppFactory.php';
		return (new AppFactory());
		// TODO Auto-generated method stub
	}
	
	public function getObjectByIsbn($isbn){
		$dsql = $this->createDetachedSQL();
		$dsql->add(Restrictions::eq('isbn',$isbn));
		$obj = $this->findByDetachedSQL($dsql);
		return $obj;
	}

}