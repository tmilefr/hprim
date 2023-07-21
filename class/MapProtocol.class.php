<?php

class MapProtocol{

    protected $_map          = [];
    protected $_debug        = FALSE;
    protected $processed     = [];
    protected $lgnFileParsed = [];

    function __construct($protocol = 'hprim')
    {
        switch($protocol){
            case 'hl7':
                $filename = dirname(__FILE__).'/protocol/Hl7_defs.json';
            break;
            case 'hprim':   
                $filename = dirname(__FILE__).'/protocol/HPRIM_defs.json';
            break;
            default:
                die('protocol non implémenté');
        }

       $json = file_get_contents($filename);
       if ($json) 
            $this->_map = json_decode($json,true);
       else 
            echo '<p>erreur de chargement de la définition</p>';

    }

    public function Process(){
        if (count($this->lgnFileParsed) > 0){
            foreach($this->lgnFileParsed AS $lgnkey=>$lgn){
                $parsed = [];
                if ( $maps = $this->_GetMap($lgn[0])){
                    foreach($maps AS $key => $map){
                        $res = new StdClass();
                        $res->key = $key;
                        $res->error = false;
                        $res->desc_error  = [];
                        $res->descr = $map['descr'];
                        $res->value = trim($lgn[$key]);
                        if ($map['prop'] == 'O'){
                            if (!$res->value){
                                $res->error = TRUE;
                                $res->desc_error[] = $map['prop'];
                            }
                        }
                        if (strlen($res->value) > $map['size']){
                            $res->error = TRUE;
                            $res->desc_error[] = ' FIELD OVERSIZE ('.strlen($res->value).' > '.$map['size'].' )';
                        }

                        if ($res->value  && count($map['values']) && !in_array($res->value, $map['values'])){
                            $res->error = TRUE;
                            $res->desc_error[] = 'NOT IN ('.implode(',', $map['values']).')';
                        }                
                        $res->value = str_replace('~', ' ', $res->value); 
                        $parsed[$key] = $this->_ParseType($res, $map);
                    } 
                }
                $this->processed[$lgnkey] =$parsed;
            }
        }
    }
    
    /**
     * Method _ParseType : travail sur les champs en fonction des séparateurs
     *
     * @param $obj object [explicite description]
     * @param $map array() [explicite description]
     *
     * @return $obj
     */
    private function _ParseType($obj, $map){
        try {
            switch($map['type']){
                case 'AD':
                     $obj->sep_value = explode('~', $obj->value);
                    /* AD (Adresse) :
                    1 er sous-champ : ligne 1 de l'adresse
                    2 eme sous-champ : ligne 2 de l'adresse
                    3 eme sous-champ : ville
                    4 eme sous-champ : libellé département (ou état ou province)
                    5 eme sous-champ : code postal
                    6 eme sous-champ : Pays
                    */
                break;
                case 'PN':
                    $obj->sep_value = explode('~', $obj->value);                    
                    /* PN (Nom, prénom et qualité) : Ce champ est décomposé en 6 sous-champs :                   
                    1 er sous-champ : Nom usuel
                    2 eme sous-champ : Prénom
                    3 eme sous-champ : Deuxième prénom
                    4 eme sous-champ : Sobriquet ou alias
                    5 eme sous-champ : Civilité
                    6 eme sous-champ : Diplôme
                    */
                break;
                case 'TS':
                    /* TS (date et heure) : Ce champ est présenté sous la forme AAAAMMJJ pour la date, ou AAAAMMJJHHmm pour la date et l'heure, 
                    voire AAAAMMJJHHmmSS si les secondes sont nécessaires. */

                break;
            }
            return $obj;
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }        
       
    }

    
    /**
     * Method _GetMap
     *
     * @param $type $type [explicite description]
     *
     * @return array
     */
    private function _GetMap($type){
        return  ((isset($this->_map[$type])) ? $this->_map[$type]:FALSE);
    }

    /**
     * Method __destruct
     *
     * @return void
     */
    function __destruct()
    {
        if ($this->_debug)
            $this->_debug($this);
    }
    
    /**
     * Method _debug
     *
     * @param $obj $obj [explicite description]
     *
     * @return void
     */
    private function _debug($obj){
        echo '<pre>'.print_r($obj, 'TRUE').'</pre>';
    }

    /**
	 * @brief Generic SETTER
	 * @param $field 
	 * @param $value 
	 * @returns 
	 * 
	 * 
	 */
	public function _set($field,$value){
		$this->$field = $value;
	}

	/**
	 * @brief Generic GETTER
	 * @param $field 
	 * @returns 
	 * 
	 * 
	 */
	public function _get($field){
		return $this->$field;
	}
}
