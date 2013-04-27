<?php

/** @title   group_dataset_by_time
  * @desc    group incoming datapoints by time and collapse values
  *          specified in $index by $op. also does padding for empty
  *          data points in the specified timespan.
  * @return  collapsed dataset
  **/

class Operation
{
	const Average = 0;
	const Maximum = 1;
}

function group_dataset_by_interval($dataset, $index, $initstep, $stepsize = 300, $op = Operation::Maximum)
{
	if (empty($dataset))
		return;

	if (empty($index) || is_array($index) && count($index) == 0) # there is no point in grouping if we have no fields to collapse
		return; 

	if ($stepsize < 300) # recording happens in steps of 300s, so there is no point to have stepsizes less than that as it will create padding between each recording
		$stepsize = 300;

	$out_tmp = array(); # form final output in this temporary array
	$dataset_length = count($dataset);

	# 1) Set up the initial step from first timestamp to timestamp+stepsize
	$step = $initstep;
	$step_until = $step + $stepsize;
	$i = 0;
	while ($i < $dataset_length) { 
		# handle a step
		$step_tmp = array();

		for ($j = $i; $j < $dataset_length; $j++)
		{
			$datapoint = $dataset[$j];

			# find each dataset that belongs to the current step
                        if ($datapoint[0] < $step)
                        {
                                $i++;
                                continue;
                        }
			if ($datapoint[0] > $step_until)
				break;

			# handle specified indexes to each datapoint
			foreach ($index as $iter)
			{
				$step_tmp[$iter][] = $datapoint[$iter];
			}
			$i++;
		}

		# collapse step data
		$collapse_tmp = array();
		# handle steps without data, set values to zero
		if (empty($step_tmp))
			foreach ($index as $iter)
				$collapse_tmp[$iter] = 0;
		# else call function on data row
		else
			foreach ($step_tmp as $iter => $datarow)
			{
				if ($op == Operation::Maximum)
					$collapse_tmp[$iter] = max($datarow);
				elseif ($op == Operation::Average)
					$collapse_tmp[$iter] = round(array_sum($datarow) / count($datarow));
			}

		# fill the collapsed tmp row with persistent data (=iterators not in $index)
		if (isset($dataset[$i]))
		{
			for ($k = 0; $k < count($dataset[$i]); $k++)
			{
				if (in_array($k, $index))
					continue;
				if (isset($dataset[$i][$k]))
					$collapse_tmp[$k] = $dataset[$i][$k];
				else $collapse_tmp[$k] = 0; # TODO: research how setting this value affects the overall output and why $dataset[$i][$k] might trigger undefined index notice
			}
		}
		$collapse_tmp[0] = round(($step + $step_until) / 2);

		# write back step_tmp to out_tmp
		$out_tmp[] = $collapse_tmp;

		# prepare next step
		$step += $stepsize;
		$step_until = $step + $stepsize;
	}

	return $out_tmp;
}

?>
