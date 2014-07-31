<?php
class SinaAppUseResultService extends ServiceObject{
/* (non-PHPdoc)
	 * @see DataBoundObject::DefineTableName()
	 */
	
	protected function DefineTableName() {
		return("sina_app_use_result");
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
		require_once JHORM_VO_FACTORY_DIR.'SinaAppUseResultFactory.php';
		return (new SinaAppUseResultFactory());
		// TODO Auto-generated method stub
	}

}