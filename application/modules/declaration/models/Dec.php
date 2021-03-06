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
class Declaration_Model_Dec  extends Zend_Db_Table {
    protected $_name = 'ourbank_declaration';


public function getmember($memcode) 
            {
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a' => 'ourbank_familymember'),array('id','age','created_date'))
			->where('a.familycode = ?',$memcode)
                        ->join(array('b' => 'ourbank_family'),'a.family_id=b.id',array('b.street'))

                        ->join(array('e' => 'ourbank_office'),'a.family_id=e.id',array('e.name as village'))

                        ->join(array('c' => 'ourbank_agriculture'),'a.id=c.family_id',array('c.landowner_name'));

//   die($select->__toString($select));

		$result = $this->fetchAll($select);
		return $result->toArray();
	}
public function getrelation($familyid) 
            {
		$select = $this->select()
			->setIntegrityCheck(false)
                        ->join(array('b' => 'ourbank_familymember'),array('b.id'),array('b.name as membername','b.age'))
                        ->where('b.family_id='.$familyid)
                        ->join(array('c' => 'ourbank_master_realtionshiptype'),'b.relationship_id=c.id', array('c.name as relaname'));

//  die($select->__toString($select));

		$result = $this->fetchAll($select);
		return $result->toArray();
            }
public function getmembers($groupcode) 
            {
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a' => 'ourbank_group'),array('a.id','a.created_date'))
			->where('a.groupcode = ?',$groupcode)

                        ->join(array('b' => 'ourbank_familymember'),'a.head=b.id',array('b.name as head'))
                        ->join(array('c' => 'ourbank_office'),'a.village_id=c.id',array('name as village'))
                        ->join(array('d' => 'ourbank_family'),'a.village_id=d.village_id',array('d.street'))
                        ->join(array('e' => 'ourbank_agriculture'),'b.id=e.family_id',array('e.landowner_name'));

//   die($select->__toString($select));

		$result = $this->fetchAll($select);
		return $result->toArray();
	}

public function getrelations($groupcode)
            {
		$select = $this->select()
			->setIntegrityCheck(false)
			->join(array('a' => 'ourbank_group'),array('a.id,a.village_id'))
			->where('a.groupcode = ?',$groupcode)

                        ->join(array('b' => 'ourbank_familymember'),'a.village_id=b.village_id', array('b.name as membername','b.age'))
                        ->join(array('c' => 'ourbank_master_realtionshiptype'),'b.relationship_id=c.id', array('c.name as relaname'));

//   die($select->__toString($select));

		$result = $this->fetchAll($select);
		return $result->toArray();
	}

}
