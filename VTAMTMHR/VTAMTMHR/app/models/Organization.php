<?php
/**
 * Description of Organization
 *
 * @author User
 */
class Organization extends Eloquent 
{
    protected $table ='organisation';
    protected $primaryKey ='id';
    public $timestamps = false;
    
    
//    public function Batch()
//    {
//        return $this->hasOne("batchstart","BS_ID");
//        
//    }
 /*   
    public function BatchStart()
    {
             
        return $this-> hasMany("Batchstart","OrgaId");   
		
                       
			
    }
   */ 
   public function BatchStart() {

        return $this->hasMany("Batchstart", "OrgaId");
    }

    public function getOrganisationType() {
        return $this->belongsTo("OrganisationType", "TypeId");
    }   
}
