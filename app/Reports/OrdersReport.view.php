

<?php
use \koolreport\widgets\koolphp\Table;
// use \koolreport\widgets\google\ColumnChart;
// use \koolreport\widgets\google\BarChart;
//use \koolreport\chartjs\LineChart;
?>

    <?php
    // BarChart::create(array(
    //     "dataStore"=>$this->dataStore('users'),  
    //     "columns"=>array(
    //         "created_at"=>array(
    //             "label"=>"Month",
    //             "type"=>"datetime",
    //             "format"=>"Y-n",
    //             "displayFormat"=>"F, Y",
    //         ),
    //         "id"=>array(
    //             "label"=>"id",
    //             "type"=>"number",
    //             //"prefix"=>"$",
    //         )
    //     ),
    //     "width"=>"100%",
    // ));
    ?>

        <?php
        Table::create([
            "dataSource"=>$this->dataStore("orders"),
            "themeBase"=>"bs4", // Optional option to work with Bootsrap 4
            "cssClass"=>array(
                "table"=>"table table-bordered"
            )
 
        ]);
        ?>