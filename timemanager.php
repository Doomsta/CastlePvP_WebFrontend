<?php

// depends on
// * common.php
// * lib/datetime.php
// * lib/tpl.php

// set proper locale
setlocale(LC_ALL, "de_DE.UTF-8");

// parse get parameters
// * d = date/timestamp
$date_input_format = "%d.%m.%Y";
$now = time();
$param_d = strftime($date_input_format, time());
if (isset($_GET['d']))
{
    $now = strtotime($_GET['d']);
    $param_d = strftime($date_input_format, $now);
}

// * i = interval
$param_i = Boundaries::Week; # default to week
$param_i_str = "w";
if (isset($_GET['i']) && isset($_time_period_boundary[$_GET['i']]))
{
    $param_i = $_time_period_boundary[$_GET['i']];
    $param_i_str = $_GET['i'];
}
// assign some templates vars
// load css/js files
$tpl->add_css_file($rootpath."css/bootstrap-datetimepicker.min.css");
$tpl->add_js_file($rootpath."/js/bootstrap-datetimepicker.min.js");
$tpl->add_script("  $(function() {
    $('#datepicker').datetimepicker({
      pickTime: false,
      language : 'de'
    });
    $('#datepicker').on('changeDate', function (e) {
        document.getElementById('datepicker_form').submit();
    });
  });");

// reassign vars to reinsert into urls
$tpl->assign_vars("param_i", $param_i_str);
$tpl->assign_vars("param_d", $param_d);

// date & time
$bounds = get_boundaries($now, $param_i);
$tpl->assign_vars("begin", strftime("%a, %d. %b. %Y", $bounds[0]));
$tpl->assign_vars("end", strftime("%a, %d. %b. %Y", $bounds[1]));

// intervals
$tpl->assign_vars("time_period_name", $_time_period_name);


?>
