<?php

class PlacesSchedules extends Collection {

    protected $class = "PlaceSchedule";
    protected $saveQuery = "sp_placeesschedules_save";
    protected $saveArgs = array("idschedule", "idplace", "nrday", "hropen", "hrclose");
    protected $pk = "idschedule";

    public function get(){}

    public function getByPlace(Place $place):PlacesSchedules
    {

        $this->loadFromQuery("CALL sp_placeesschedules_list(?)", array(
            $lugar->getidplace()
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