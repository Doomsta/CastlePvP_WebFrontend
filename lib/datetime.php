<?php

/** @title  get_*_boundaries
  * @desc   Calculate the beginning and end of the (day/week/month/year)
  *         in relation to the given timestamp.
  * @return array(begin, end), where begin and end are
  *         unix timestamps as well
  **/

class Boundaries
{
    const Day = 0;
    const Week = 1;
    const Month = 2;
    const Year = 3;
}

$_time_period_name = array(
    "d" => "Tag",
    "w" => "Woche",
    "m" => "Monat",
    "y" => "Jahr");

$_time_period_boundary = array(
    "d" => Boundaries::Day,
    "w" => Boundaries::Week,
    "m" => Boundaries::Month,
    "y" => Boundaries::Year);

function get_boundaries($timestamp, $boundary)
{
	if ($boundary == Boundaries::Day)
		return get_day_boundaries($timestamp);
	elseif ($boundary == Boundaries::Week)
		return get_week_boundaries($timestamp);
	elseif ($boundary == Boundaries::Month)
		return get_month_boundaries($timestamp);
	elseif ($boundary == Boundaries::Year)
		return get_year_boundaries($timestamp);
	else
		die("get_boundaries: invalid boundary specified.");
}

function get_day_boundaries($timestamp)
{
    $begin = mktime(0, 0, 0, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp));
    $end = mktime(23, 59, 59, date("m", $timestamp), date("d", $timestamp), date("Y", $timestamp));

    return array($begin, $end);
}

function get_week_boundaries($timestamp)
{
    $dow = date("w", $timestamp);
    if ($dow == 0)
        $dow = 7; # move sunday to 7, monday is beginning of the week

    # calculate the day
    $begin = $timestamp - (86400 * ($dow -1));
    $end = $timestamp + (86400 * (7 - $dow));

    # and set the time manually
    $begin = mktime(0, 0, 0, date("m", $begin), date("d", $begin), date("Y", $begin));
    $end = mktime(23, 59, 59, date("m", $end), date("d", $end), date("Y", $end));

    return array($begin, $end);
}

function get_month_boundaries($timestamp)
{
    $begin = mktime(0, 0, 0, date("m", $timestamp), 1, date("Y", $timestamp));
    $end = mktime(23, 59, 59, date("m", $timestamp), date("t", $timestamp), date("Y", $timestamp));

    return array($begin, $end);
}

function get_year_boundaries($timestamp)
{
    $begin = mktime(0, 0, 0, 1, 1, date("Y", $timestamp));
    $end = mktime(23, 59, 59, 12, 31, date("Y", $timestamp));

    return array($begin, $end);
}

?>

