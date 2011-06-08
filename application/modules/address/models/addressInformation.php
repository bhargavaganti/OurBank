<?php
/*
############################################################################
#  This file is part of OurBank.
############################################################################
#  OurBank is free software: you can redistribute it and/or modify
#  it under the terms of the GNU Affero General Public License as
#  published by the Free Software Foundation, either version 3 of the
#  License, or (at your option) any later version.
############################################################################
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU Affero General Public License for more details.
############################################################################
#  You should have received a copy of the GNU Affero General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
############################################################################
*/
?>

<?php
class Address_Model_addressInformation  extends Zend_Db_Table {
    protected $_name = 'ourbank_member';

//getting module record with respective submodule id...
    public function getmodule($subId)
    {
        $select=$this->select()
        ->setIntegrityCheck(false)
        ->from('ourbank_modules')
        ->where('module_id=?',$subId);
        $result = $this->fetchAll($select);
        return $result->toArray();
        //die ($select->__toString($select));
    }

//getting ourbank_address details with respective record id and submodule id
    public function getourbank_address($id,$sub_id)
    {
        $select=$this->select()
        ->setIntegrityCheck(false)
        ->join(array('a' => 'ourbank_address'),array('id'))
        ->where('a.submodule_id='.$sub_id)
        ->where('a.id = '.$id);
	 $result=$this->fetchAll($select);
	 return $result->toArray();
  	// die ($select->__toString($select));

    }

//getting contact details with respective record id and submodule id ...
    public function getcontact($id,$sub_id)
    {
        $select=$this->select()
        ->setIntegrityCheck(false)
        ->join(array('a' => 'ourbank_contact'),array('id'))
        ->where('a.submodule_id='.$sub_id)
        ->where('a.id = '.$id);
        $result=$this->fetchAll($select);
        return $result->toArray();
  	 //die ($select->__toString($select));

    }

//getting address details with respective record id and submodule id ...
    public function getaddress($id,$sub_id)
    {
        $select=$this->select()
        ->setIntegrityCheck(false)
        ->join(array('a' => 'ourbank_address'),array('id'))
        ->where('a.submodule_id='.$sub_id)
        ->where('a.id = '.$id);
        $result=$this->fetchAll($select);
        return $result->toArray();
  	 //die ($select->__toString($select));

    }

//update records with respective four different arguments 
    public function updateRecord($table,$param,$data,$sub1)  
    {
        $db = $this->getAdapter();
        $db->update($table, $data , array('id = '.$param,'submodule_id='.$sub1));
        return;
    }

}
