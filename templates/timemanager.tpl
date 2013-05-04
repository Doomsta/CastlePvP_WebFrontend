    <p>Von <strong>{$begin}</strong> bis <strong>{$end}</strong>.</p>

    <div class="well well-small">
        <!-- Datum -->
        <form id="datepicker_form" method="GET" style="display:inline;">
        <input type="hidden" name="i" value="{$param_i}" />
        <div id="datepicker" class="input-append" style="display:inline">
            <input data-format="dd.MM.yyyy" name="d" type="text" readonly="" value="{$param_d}" />
            <span class="add-on">
                <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
            </span>
        </div>
        </form>

        <!-- Zeitraum -->
        <div class="btn-group" style="padding-left:10px;">
        <button class="btn"><strong>Intervall:</strong> {$time_period_name[$param_i]}</button>
        <button class="btn dropdown-toggle" data-toggle="dropdown">
        <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
        {foreach $time_period_name as $key => $name}
            <li><a href="?d={$param_d}&amp;i={$key}">{$name}</a></li>
        {/foreach}
        </ul>
        </div>

	<!-- Permalink -->
	<div style="float:right;padding-top:5px;padding-right:5px;">
	<a href="?d={$param_d}&amp;i={$param_i}"><small>Permalink</small></a>
	</div>
    </div>
