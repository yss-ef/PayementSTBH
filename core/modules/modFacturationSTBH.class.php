<?php
include_once DOL_DOCUMENT_ROOT.'/core/modules/DolibarrModules.class.php';

class modFacturationSTBH extends DolibarrModules
{

	public function __construct($db)
	{
		global $conf, $langs;

		$this->db = $db;
		$this->numero = 500000; 
		$this->rights_class = 'facturationstbh';
		$this->family = "financial";
		$this->name = preg_replace('/^mod/i', '', get_class($this));
		$this->description = "Module qui permet la gestion des payement international";
		$this->editor_name = 'Youssef Fellah';
		$this->version = '1.0';
		$this->const_name = 'MAIN_MODULE_'.strtoupper($this->name);
		$this->picto = 'fa-file';
		$this->module_parts = array(
			'js' => array(
			   '/facturationstbh/js/card.js.php' 
			),
		);
	}
	
	public function init($options = '') { $sql = array(); return $this->_init($sql, $options); }
    public function remove($options = '') { $sql = array(); return $this->_remove($sql, $options); }

	public function run_trigger($action, $object, User $user, Translate $langs, Conf $conf)
    {
        if ($action == 'LINE_CREATE' || $action == 'LINE_UPDATE') {
            
            require_once DOL_DOCUMENT_ROOT.'/compta/facture/class/facture.class.php';
            $invoice = new Facture($this->db);
            $invoice->fetch($object->fk_facture);
            $invoice->fetch_optionals();

            if (!empty($invoice->array_options['options_is_international'])) {
                
                $tax_name = GETPOST('tsr_name', 'alpha');
                
                $object->array_options['options_tsr_name_line'] = $tax_name;
                $object->array_options['options_tsr_rate_line'] = $object->tva_tx;
            }
        }
        return 0;
    }
}
