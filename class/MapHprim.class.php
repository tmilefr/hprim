<?php

class MapHprim{

    protected $_map = [];
    protected $_debug = FALSE;

    function __construct()
    {
        $this->_map['H'] = [
            $this->_setObj('O'  ,1    ,'ST'   ,['H']  ,'Type de segment'),
            $this->_setObj('O'  ,5    ,'ST'   ,[] ,'Définition des séparateurs '),
            $this->_setObj('F'  ,12   ,'ST'   ,[] ,'Identification du message (nom du fichier)'),
            $this->_setObj('F'  ,12   ,'ST'   ,[] ,'Mot de passe'),
            $this->_setObj('O'  ,40   ,'SPEC' ,[] ,'Identification de l\'émetteur'),
            $this->_setObj('F'  ,100  ,'AD'   ,[] ,'Adresse de l\émetteur','~'),
            $this->_setObj('O'  ,7    ,'CM'   ,[] ,'Type de message (contexte)'),
            $this->_setObj('FR' ,40   ,'ST'   ,[] ,'Numéro de téléphone de l\'émetteur'),
            $this->_setObj('F'  ,40   ,'TN'   ,[] ,'Caractéristiques de la transmission'),
            $this->_setObj('O'  ,40   ,'SPEC' ,[] ,'Identification du récepteur'),
            $this->_setObj('F'  ,80   ,'ST'   ,[] ,'Commentaire'),
            $this->_setObj('F'  ,1    ,'ID'   ,['P','T','D'],'Mode de traitement'),
            $this->_setObj('O'  ,10   ,'SPEC' ,[] ,'Version et type'),
            $this->_setObj('O'  ,26   ,'TS'   ,[] ,'Date et heure de constitution du message')
        ];
        $this->_map['P'] = [
            $this->_setObj('O'  ,1    ,'ST'  ,['P'],'Type de segment'),
            $this->_setObj('O'  ,4    ,'NM'  ,[],'Rang du segment'),
            $this->_setObj('FC' ,16   ,'SPEC',[],'Identifiant du patient attribué par le demandeur'),
            $this->_setObj('E'  ,16   ,'ST'  ,[],'Identifiant du patient attribué par l\'exécutant'),
            $this->_setObj('FC' ,16   ,'SPEC',[],'Autre identifiant patient attribué par le demandeur'),
            $this->_setObj('FC' ,48   ,'PN'  ,[],'Nom du patient'),
            $this->_setObj('F' ,24   ,'ST'  ,[],'Nom de famille'),
            $this->_setObj('F' ,26   ,'TS'  ,[],'Date de naissance'),
            $this->_setObj('F' ,1    ,'ID'   ,['F','M','U'],'Sexe'),
            $this->_setObj('F' ,1   ,'ST'   ,[],'Race [INTERDIT]'),
            $this->_setObj('F' ,200 ,'AD'   ,[],'Adresse'),
            $this->_setObj('FR' ,120   ,'SPEC'   ,[],'INS-C / INS-A '),
            $this->_setObj('FR' ,40   ,'TN'   ,[],'Téléphone'),
            $this->_setObj('FR' ,60   ,'SPEC'   ,[],'Médecins'),
            $this->_setObj('F' ,60   ,'ST'   ,[],'Traitement local 1'),
            $this->_setObj('F' ,60   ,'ST'   ,[],'Traitement local 2'),
            $this->_setObj('F' ,10   ,'CQ'   ,[],'Taille'),
            $this->_setObj('F' ,10   ,'CQ'   ,[],'Poids'),
            $this->_setObj('FR',200  ,'CE'   ,[],'Diagnostic'),
            $this->_setObj('FR',200   ,'ST'   ,[],'Traitement'),
            $this->_setObj('F' ,200   ,'ST'   ,[],'Régime'),
            $this->_setObj('F' ,60   ,'ST'   ,[],'Commentaire 1 patient du demandeur'),
            $this->_setObj('F' ,60   ,'ST'   ,[],'Commentaire 2 patient du demandeur'),
            $this->_setObj('FR' ,53   ,'TS'   ,[],'Date de mouvement'),
            /*OP = Sortie
            IP = Entrée
            IO = Entrée – Sortie (externes ou ambulatoires)
            ER = Entrée urgence
            MP = Mouvement interne ou modification. Cette valeur est aussi utilisée dans un contexte ORM / ORA
            pour une modification des données du patient.
            PA = Pré-admission
            */
            $this->_setObj('F' ,2   ,'ID'     ,['OP','IP','ER','PA','MP'],'Statut de l\'admission'),
            $this->_setObj('F' ,100   ,'SPEC'   ,[],'Localisation'),
            $this->_setObj('F' ,100   ,'ST'   ,[],'Religion [INTERDIT]'),
            $this->_setObj('F' ,2   ,'ID'   ,[],'Situation maritale'),
            $this->_setObj('F' ,20   ,'ID'   ,[],'Précautions à prendre'),
            $this->_setObj('F' ,20   ,'ST'   ,[],'Langue'),
            $this->_setObj('F' ,20   ,'ID'   ,[],'Statut de confidentialité'),
            $this->_setObj('F' ,26   ,'TS'   ,[],'Date de dernière modification'),
            $this->_setObj('F' ,20   ,'TS'   ,[],'Date de décès'),
        ];
        $this->_map['OBR'] = [
            $this->_setObj('O'  ,3     ,'ST'  ,['OBR'],'Type de segment'),
            $this->_setObj('O'  ,4     ,'NM'  ,[],'Rang du segment '),
            $this->_setObj('C'  ,23    ,'CM'  ,[],'Id d\'échantillon et de demande pour le demandeur'),
            $this->_setObj('FE' ,23    ,'CM'  ,[],'Id d\'échantillon et de demande pour l\'exécutant'),
            $this->_setObj('OR' ,64000 ,'CE' ,[],'Analyses ou actes'),
            $this->_setObj('FR' ,2    ,'ID'  ,[],'Priorité'),
            $this->_setObj('F'  ,26    ,'TS'  ,[],'Date et heure de prise en compte'),
            $this->_setObj('FR' ,26   ,'TS'  ,[],'Date et heure des actes (prélèvement)'),
            $this->_setObj('F'  ,26    ,'TS'  ,[],'Date et heure de fin de prélèvement'),
            $this->_setObj('F'  ,20    ,'CQ'  ,[],'Volume du recueil (et unité)'),
            $this->_setObj('F'  ,60    ,'CNA' ,[],'Préleveur'),
            $this->_setObj('O'  ,1     ,'ID'  ,[],'Code action'),
            $this->_setObj('F'  ,60    ,'CNA' ,[],'Préleveur'),
            $this->_setObj('F'  ,60    ,'CM'  ,[],'Risque'),
            $this->_setObj('F'  ,300   ,'ST'  ,[],'4 Renseignements cliniques '),
            $this->_setObj('FE' ,26   ,'TS'  ,[],'Date et heure de réception de l\'échantillon chez l\'exécutant'),
            $this->_setObj('F'  ,300   ,'CM'  ,[],'Nature de l\'échantillon'),
            $this->_setObj('F'  ,60    ,'SPEC',[],'Prescripteur'),
            $this->_setObj('FR' ,40   ,'TN'  ,[],'Téléphone du prescripteur'),
            $this->_setObj('F'  ,60    ,'ST'  ,[],'Champ libre 1 demandeur'),
            $this->_setObj('F'  ,60    ,'ST'  ,[],'Champ libre 2 demandeur'),
            $this->_setObj('FE' ,60   ,'ST'  ,[],'Champ libre 1 exécutant'),
            $this->_setObj('FE' ,60   ,'ST'  ,[],'Champ libre 2 exécutant'),
            $this->_setObj('FE' ,26   ,'TS'  ,[],' Date et heure des résultats '),
            $this->_setObj('F'  ,60    ,'ST'  ,[],'Prix des actes [RESERVE]'),
            $this->_setObj('FE' ,10   ,'ID'  ,[],'Service exécutant'),
            $this->_setObj('FE' ,1    ,'ID'  ,[],'Statut des actes ou résultats'),
            $this->_setObj('F'  ,60    ,'ST'  ,[],'Résultats liés [RESERVE]'),
            $this->_setObj('F'  ,60    ,'ST'  ,[],'Cycle et épreuve fonctionnelle'),
            $this->_setObj('FR' ,150   ,'CNA' ,[],'Destinataire de la copie'),
            $this->_setObj('F'  ,150   ,'ST'  ,[],'Demande liée'),
            $this->_setObj('FE' ,20    ,'ID'  ,[],'Mode de transport du patient '),
            $this->_setObj('FR' ,300   ,'CE'  ,[],'Motif de la demande'),
            $this->_setObj('FE' ,60    ,'CNA' ,[],'Principal interpréteur des résultats'),
            $this->_setObj('FE' ,60    ,'CNA' ,[],'Assistant'),
            $this->_setObj('FE' ,60    ,'CNA' ,[],'Technicien'),
            $this->_setObj('FE' ,60    ,'CNA' ,[],'Opérateur de saisie'),
            $this->_setObj('F'  ,26    ,'TS'  ,[],'Date et heure prévisionnelles de rendu des examens')
        ];        
        
        
        $this->_map['OBX'] = [
            $this->_setObj('O'  ,3    ,'ST'  ,['OBX'],'Type de segment'),
        ];        



        $this->_map['L'] = [
            $this->_setObj('O'  ,1    ,'ST'  ,['L'],'Type de segment'),
        ];   




    }

    public function Process($lgn){
        $parsed = [];
        if ( $maps = $this->_GetMap($lgn[0]) ){
            foreach($maps AS $key => $map){
                $res = new StdClass();
                $res->key = $key;
                $res->error = false;
                $res->desc_error  = [];
                $res->descr = $map->descr;
                $res->value = trim($lgn[$key]);
                if ($map->prop == 'O'){
                    if (!$res->value){
                        $res->error = TRUE;
                        $res->desc_error[] = $map->prop;
                    }
                }
                if (strlen($res->value) > $map->size){
                    $res->error = TRUE;
                    $res->desc_error[] = ' FIELD OVERSIZE ('.strlen($res->value).' > '.$map->size.' )';
                }

                if ($res->value  && count($map->values) && !in_array($res->value, $map->values)){
                    $res->error = TRUE;
                    $res->desc_error[] = 'NOT IN ('.implode(',', $map->values).')';
                }                
                $res->value = str_replace('~', ' ', $res->value);
                $parsed[$key] = $this->_ParseType($res, $map);
            } 
        }
        //$this->_debug($parsed);
        return  $parsed;
    }

    private function _ParseType($obj, $map){
        
        try {
            switch($map->type){
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
        } catch (Exception $e) {
            echo 'Exception reçue : ',  $e->getMessage(), "\n";
        }        
        return $obj;
    }


    private function _GetMap($type){
        return  ((isset($this->_map[$type])) ? $this->_map[$type]:FALSE);
    }

    /*
    Type

    O : obligatoire
    F : facultatif
    E : renseigné par l'exécutant
    R : répétiteur autorisé
    C : consigné (à retourner à l'identique s'il a été renseigné par l'émetteur)


    */

    private function _setObj($prop, $size, $type , $values = [], $descr = '', $sep = ''){
        $obj = new stdClass();
        $obj->prop = $prop;
        $obj->size = $size;
        $obj->type = $type;
        $obj->values = $values;
        $obj->descr = $descr;
        $obj->sep = $sep;
        return $obj;
    }

	 /**
     * Method __destruct
     *
     * @return void
     */
    function __destruct()
    {
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
        if ($this->_debug)
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
