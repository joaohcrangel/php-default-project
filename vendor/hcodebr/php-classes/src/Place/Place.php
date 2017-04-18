<?php

namespace Hcode\Place;

use Hcode\Model;
use Hcode\Exception;
use Hcode\Locale\Language;
use Hcode\Address\Coordinate;
use Hcode\Address\Address;
use Hcode\Address\Addresses;
use Hcode\Place\Schedule;
use Hcode\Place\Schedules;
use Hcode\FileSystem\File;
use Hcode\FileSystem\Files;

class Place extends Model {

    public $required = array('desplace', 'idplacetype');
    protected $pk = "idplace";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_places_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_places_save(?, ?, ?, ?, ?, ?, ?);", array(
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

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_places_remove", array(
            $this->getidplace()
        ));

        return true;
        
    }

    public function setCoordinate(Coordinate $c):Coordinate
    {

        $c->save();

        $this->execute("CALL sp_placescoordinates_add(?, ?);", array(
            $this->getidplace(),
            $c->getidcoordinate()
        ));

        return $c;

    }

    public function setAddress(Address $e):Address
    {

        $e->save();

        $this->execute("CALL sp_placesaddresses_add(?, ?);", array(
            $this->getidplace(),
            $e->getidaddress()
        ));

        return $e;

    }

    public function getSchedules():Schedules
    {

        return new Schedules($this);

    }

    public function getAddresses():Addresses
    {

        return new Addresses($this);

    }

    public function getFiles():Files
    {

        return new Files($this);

    }

    public function removeSchedules()
    {

        return $this->execute("CALL sp_placesschedulesall_remove(?)", array(
            $this->getidplace()
        ));

    }

    public function setSchedules(Schedules $schedules):Schedules
    {

        $this->removeSchedules();

        $itens = $schedules->getItens();

        $schedulesAll = Language::getWeekdays();

        foreach ($itens as &$item) {
            $item->setidplace($this->getidplace());
        }

        $missingDays = array();

        foreach ($schedulesAll as $h) {

            $has = false;

            foreach ($itens as $schedule) {

                if ($schedule->getnrday() == $h['nrweekday']) {
                    $has = true;
                }

            }

            if (!$has) {
                array_push($missingDays, $h['nrweekday']);
            }

        }

        $schedules->setItens($itens);

        foreach ($missingDays as $day) {
            $schedules->add(new Schedule(array(
                'nrday'=>$day,
                'idplace'=>$this->getidplace(),
                'hropen'=>'00:00:00',
                'hrclose'=>'00:00:00'
            )));
        }

        $schedules->save();

        return $this->getSchedules();

    }

    public function addFile(File $file):File
    {

        $file->save();

        $this->execute("CALL sp_placesfiles_add(?, ?);", array(
            $this->getidplace(),
            $file->getidfile()
        ));

        return $file;

    }

}

?>