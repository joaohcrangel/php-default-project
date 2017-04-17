<?php

namespace Hcode\Place;

use Hcode\Collection;
use Hcode\Place\Place;
use Hcode\Locale\Language;

class Schedules extends Collection {

    protected $class = "Hcode\Place\Schedule";
    protected $saveQuery = "sp_placesschedules_save";
    protected $saveArgs = array("idschedule", "idplace", "nrday", "hropen", "hrclose");
    protected $pk = "idschedule";

    public function get(){}

    public function getByPlace(Place $place):Schedules
    {

        $this->loadFromQuery("CALL sp_placesschedules_list(?)", array(
            $place->getidplace()
        ));

        $schedulesAll = Language::getWeekdays();

        $itens = $this->getItens();

        foreach ($itens as &$schedule) {
            foreach ($schedulesAll as $h) {

                if ($h['nrweekday'] == $schedule->getnrday()) {

                    $schedule->setnrweekday($h['nrweekday']);
                    $schedule->setdesweekday($h['desweekday']);

                }

            }
        }

        $this->setItens($itens);

        return $this;

    }

}

?>