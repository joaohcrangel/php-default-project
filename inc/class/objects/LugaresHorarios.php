<?php

class LugaresHorarios extends Collection {

    protected $class = "LugarHorario";
    protected $saveQuery = "sp_lugareshorarios_save";
    protected $saveArgs = array("idhorario", "idlugar", "nrdia", "hrabre", "hrfecha");
    protected $pk = "idhorario";

    public function get(){}

    public function getByLugar(Lugar $lugar):LugaresHorarios
    {

        $this->loadFromQuery("CALL sp_lugareshorarios_list(?)", array(
            $lugar->getidlugar()
        ));

        $horariosTodos = Language::getWeekdays();

        $itens = $this->getItens();

        foreach ($itens as &$horario) {
            foreach ($horariosTodos as $h) {

                if ($h['nrweekday'] == $horario->getnrdia()) {

                    $horario->setnrweekday($h['nrweekday']);
                    $horario->setdesweekday($h['desweekday']);

                }

            }
        }

        $this->setItens($itens);

        return $this;

    }

}

?>