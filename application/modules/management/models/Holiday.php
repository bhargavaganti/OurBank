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
class Management_Model_Holiday extends Zend_Db_Table {
     protected $_name = 'ourbank_holidayupdates';
        public function getHoliday() {
                    $select = $this->select()
                               ->setIntegrityCheck(false)  
                               ->join(array('h' => 'ourbank_holidayupdates'),array('office_id'))
                               ->where('h.recordstatus_id = 3')
                               ->join(array('o'=>'ourbank_officenames'),'h.office_id = o.office_id')
                               ->where('o.recordstatus_id = 3');
            $result = $this->fetchAll($select);
            return $result->toArray();
			}
						         

			public function viewholiday($holidayupdate_id) {
			$select = $this->select()
			->setIntegrityCheck(false)  
			->join(array('a' => 'ourbank_holidayupdates'),array('holidayupdate_id'))
			->where('a.holidayupdate_id = ?',$holidayupdate_id)
			->where('a.recordstatus_id = 3')
			->join(array('b' => 'ourbank_officenames'),'a.office_id = b.office_id') 
			->where('b.recordstatus_id = 3');
			//        die($select->__toString());
			$result = $this->fetchAll($select);
			return $result->toArray();
			}

        public function insertHoliday($post,$createdby,$holiday_id) {

            $data = array('holidayupdate_id'=> '',
                          'holiday_id'=> $holiday_id,
                          'recordstatus_id'=>'3',
                          'holidayname'=>$post['holidayname'],
                          'office_id'=>$post['office_id'],
                          'holidayfrom'=>$post['holidayfrom'],
                          'holidayupto'=>$post['holidayupto'],
                          'repayment_date'=>$post['repayment_date'],
						  'createdby'=> $createdby,
						  'createddate'=>date('Y-m-d'));
            $this->insert($data);
        }

        public function deleteHoliday($holidayupdate_id,$remarks) {
		$data = array('recordstatus_id'=> 1,'remarks' => $remarks);
            $where = 'holidayupdate_id = '.$holidayupdate_id;
            $this->update($data , $where );
			}
			
	public function UpdateHoliday($holidayupdate_id) {
		$data = array('recordstatus_id'=> 2);
		$where = 'holidayupdate_id = '.$holidayupdate_id;
		$this->update($data , $where );
		}
		
		public function SearchHoliday($post = array()) {
            $select = $this->select()
		            ->setIntegrityCheck(false)  
					->join(array('a' => 'ourbank_holidayupdates'),array('holidayupdate_id'))
		            ->where('a.recordstatus_id = 3')
					->where('a.holidayname like "%" ? "%"',$post['field3'])
					->where('a.holidayfrom like "%" ? "%"',$post['field2'])
					->where('a.holidayupto like "%" ? "%"',$post['field4'])
					->join(array('b'=>'ourbank_officenames'),'a.office_id = b.office_id')
					->where('b.office_id like "%" ? "%"',$post['field1']);
		$result = $this->fetchAll($select);
		return $result->toArray();
		}
		Public function fetchAllOffice() {

					   $select = $this->select()

					   ->setIntegrityCheck(false)  

					   ->join(array('a' => 'ourbank_officenames'),array('office_id'))

					   ->where('a.recordstatus_id =3 OR a.recordstatus_id = 1');

					   $result = $this->fetchAll($select);

					   return $result->toArray();

					   }//After Trying for Change Log
    public function editHoliday($hUpdateId)
    {
    $db = $this->getAdapter();
    $sql = 'SELECT * FROM 
                ourbank_holidayupdates A,
                ourbank_officenames B
                where
                (A.holidayupdate_id=? AND
                 A.office_id = B.office_id) ';
    return $db->fetchAll($sql,array($hUpdateId));

    }

    public function insertUpdates($previous,$current,$hId,$createdby)
    {
    $db = $this->getAdapter();
        $result=array_keys (array_diff($previous,$current));
        foreach($result as $holiday) {
            $table_name='ourbank_holidayupdates ';
            $holidayupdates = array('holidayupdates_id'=>'',
                             'holiday_id'=>$hId,
                            'fieldname'=>$holiday,
                               'table_name'=>$table_name,
                           'previous_data'=>$previous[$holiday],
                            'current_data'=>$current[$holiday],
                            'modified_by' => $createdby,
                            'modified_date'=>date("Y-m-d"));
            $db->insert('ourbank_holidayfieldupdates',$holidayupdates);
    }
    return;
    }

    public function insertHoliday1($input)
    {

        $db = $this->getAdapter();
        $db->insert('ourbank_holidayupdates',$input);
        return;
    }

    public function holidayUpdate($hUpdateId,$input = array())
    {
        $db = $this->getAdapter();
        $where[] = "holidayupdate_id = '".$hUpdateId."'";
        $result = $db->update('ourbank_holidayupdates',$input,$where);
        //  echo $result;
    }

    public function getChangelog() {
                    $select = $this->select()
                               ->setIntegrityCheck(false)  
                               ->join(array('h' =>'ourbank_holidayfieldupdates'),array('holidayupdates_id'))
                               ->join(array('o'=>'ourbank_userloginupdates'),'h.modified_by = o.user_id')
                               ->where('o.recordstatus_id = 3 OR o.recordstatus_id = 1');

            $result = $this->fetchAll($select);
            return $result->toArray();
    }

}
