<?php

namespace Hcode\Stand;

use Hcode\Collection;

class Projects extends Collection {

    protected $class = "Project";
    protected $saveQuery = "sp_projects_save";
    protected $saveArgs = array(&quot;idproject&quot;, &quot;desproject&quot;, &quot;descode&quot;, &quot;idclient&quot;, &quot;idsalesman&quot;, &quot;dtdue&quot;, &quot;dtdelivery&quot;, &quot;idcalendar&quot;, &quot;idformat&quot;, &quot;idstandtype&quot;, &quot;vlsum&quot;, &quot;desdescription&quot;, &quot;dtregister&quot;);
    protected $pk = "idproject";

    public function get(){}

}

?>