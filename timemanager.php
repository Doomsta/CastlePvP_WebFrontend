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
$now = isset($_SESSION['timemgr_now']) ? $_SESSION['timemgr_now'] : time();
$param_d = isset($_SESSION['timemgr_date_str']) ? $_SESSION['timemgr_date_str'] : strftime($date_input_format, time());
if (isset($_GET['d']))
{
    $now = strtotime($_GET['d']);
    $param_d = strftime($date_input_format, $now);

    // session memory
    $_SESSION['timemgr_now'] = $now;
    $_SESSION['timemgr_date_str'] = $param_d;
}

// * i = interval
$param_i = isset($_SESSION['timemgr_interval']) ? $_time_period_boundary[$_SESSION['timemgr_interval']] : Boundaries::Week; # default to week
$param_i_str = (isset($_SESSION['timemgr_interval'])) ? $_SESSION['timemgr_interval'] : "w";
if (isset($_GET['i']) && isset($_time_period_boundary[$_GET['i']]))
{
    $param_i = $_time_period_boundary[$_GET['i']];
    $param_i_str = $_GET['i'];

    // session memory
    $_SESSION['timemgr_interval'] = $param_i_str;
}
// assign some templates vars
// load css/js files
$tpl->add_css_file($rootpath."css/bootstrap-datetimepicker.min.css");
$tpl->add_js_file($rootpath."/js/bootstrap-datetimepicker.min.js");
$tpl->add_script("  $(function() {
    $('#datepicker').datetimepicker({
      pickTime: false,
      language : 'de',
      weekStart : 1,
      startDate : new Date(2013, 3, 28),
      endDate : new Date()
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
