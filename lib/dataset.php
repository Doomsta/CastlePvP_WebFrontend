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
	const Sum = 2;
}

function group_dataset_by_steps($dataset, $index, $firststep, $laststep, $stepsize, $op = Operation::Maximum)
{
	if ($stepsize < 300)
		$stepsize = 300; # recordings don't happen more often than every 300 seconds

	$out_tmp = array();

	$step_count = ($laststep - $firststep) / $stepsize;
	$dataset_iter = 0;
	$dataset_size = count($dataset);
	for ($step_iter = 0; $step_iter < $step_count; $step_iter++)
	{
		# determine step boundaries
		$step_from = $firststep + ($step_iter * $stepsize);
		$step_until = $firststep + (($step_iter + 1) * $stepsize);
		$step_tmp = array();

		# walk over dataset and collect appropriate entries
		for ($i = $dataset_iter; $i < $dataset_size; $i++)
		{
			$datapoint = $dataset[$i];
			
			if ($datapoint[0] < $step_from)
				continue; # too early, skip to first

			if ($datapoint[0] > $step_until)
				break; # too late, there will be no more matching entries

			foreach ($index as $iter)
				$step_tmp[$iter][] = $datapoint[$iter];
		}
		$dataset_iter = $i; # write back iterator

		# collapse the data for this step
		$collapse_tmp = array();
	
		# if we have no data, set values to zero
		if (empty($step_tmp))
			foreach ($index as $iter)
				$collapse_tmp[$iter] = 0;
			# else call $op on each data row
		else
			foreach ($step_tmp as $iter => $datarow)
			{
				switch ($op) {
					case Operation::Maximum:
						$collapse_tmp[$iter] = max($datarow);
						break;
					case Operation::Average:
						$collapse_tmp[$iter] = round(array_sum($datarow) / count($datarow));
						break;
					case Operation::Sum:
						$collapse_tmp[$iter] = array_sum($datarow);
						break;
				}
			}
	
		# fill collapsed_tmp with persistent data (iter not in $index)
		if (isset($dataset[$dataset_iter]))
		{
			for ($j = 0; $j < count($dataset[$dataset_iter]); $j++)
			{
				if (in_array($j, $index))
					continue;
				if (isset($dataset[$dataset_iter][$j]))
					$collapse_tmp[$j] = $dataset[$dataset_iter][$j];
				else $collapse_tmp[$j] = 0; # we have no proper static data for empty time spans
			}
		}
		# set the "average" timestamp
		$collapse_tmp[0] = round($step_from + $step_until) / 2;
	
		# write back step to output temp
		$out_tmp[] = $collapse_tmp;
	}

	return $out_tmp;
}
?>
