<?php

class Place extends Model {

    public $required = array('desplace', 'idplacetype');
    protected $pk = "idplace";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_placees_get(".$args[0].");");
                
    }

    public function save(){

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_placees_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidplace(),
                $this->getidplacefather(),
                $this->getdesplace(),
                $this->getidplacetype(),
                $this->getdescontent(),
                $this->getnrviews(),
                $this->getvlreview()
            ));

            return $this->getidplace();

        }else{

            return false;

        }
        
    }

    public function remove(){

        $this->exec("sp_placees_remove", array(
            $this->getidplace()
        ));

        return true;
        
    }

    public function setCoordinate(Coordinate $c):Coordinate
    {

        $c->save();

        $this->execute("CALL sp_placeescoordinates_add(?, ?);", array(
            $this->getidplace(),
            $c->getidcoordinate()
        ));

        return $c;

    }

    public function setAddress(Address $e):Address
    {

        $e->save();

        $this->execute("CALL sp_placeesadresses_add(?, ?);", array(
            $this->getidplace(),
            $e->getidaddress()
        ));

        return $e;

    }

    public function getPlacesSchedules():PlacesSchedules
    {

        return new PlacesSchedules($this);

    }

    public function getAdresses():Adresses
    {

        return new Adresses($this);

    }

    public function getFiles():Files
    {

        return new Files($this);

    }

    public function removeSchedules()
    {

        return $this->execute("CALL sp_placeesschedulesall_remove(?)", array(
            $this->getidplace()
        ));

    }

    public function setSchedules(PlacesSchedules $schedules):PlacesSchedules
    {

        $this->removeSchedules();

        $itens = $schedules->getItens();

        $schedulesAll = Language::getWeekdays();

        foreach ($itens as &$item) {
            $item->setidplace($this->getidlugar());
        }

        $faltaDias = array();

        foreach ($schedulesAll as $h) {

            $has = false;

            foreach ($itens as $schedules) {

                if ($schedules->getnrday() == $h['nrweekday']) {
                    $has = true;
                }

            }

            if (!$has) {
                array_push($lackDays, $h['nrweekday']);
            }

        }

        $schedules->setItens($itens);

        foreach ($lackDays as $dia) {
            $schedules->add(new PlaceSchedule(array(
                'nrday'=>$day,
                'idplace'=>$this->getidplace(),
                'hropen'=>'00:00:00',
                'hrclose'=>'00:00:00'
            )));
        }

        $schedules->save();

        return $this->getPlacesSchedules();

    }

    public function addFile(File $file):File
    {

        $file->save();

        $this->execute("CALL sp_placeesfiles_add(?, ?);", array(
            $this->getidplace(),
            $file->getidfile()
        ));

        return $file;

    }

}

?>