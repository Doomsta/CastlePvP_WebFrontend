<section id="delchar">
<h2>Delete Character</h2>
{if !empty($ERROR_MSG)}
    <div class="alert alert-error" style="max-width:250px;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<strong>Warning!</strong> {$ERROR_MSG}
    </div>
{/if}
{if $STEP == 0}
<span> Hier koennen Chars geblacklistet werden und bestehende Eintraege unkenntlich gemacht werden.</span><br /><br />
    <form method="GET" action = "./delchar.php" >
		<fieldset>
			<label>Name des Characters: </label>
				<input type="text" name="cn" placeholder="Type something…">
			
			<label>Grund(optional):	</label>
			<input type="text" name="reason" placeholder="">
			<input type="hidden" value="1" name="step" /><br />
			<button type="submit" class="btn">Submit</button>
		</fieldset>
    </form>
<br>
{/if}
{if $STEP == 2}
Damit wir sicher sind, dass es dein Character ist, musst du folgende Itemslots bitte "leeren", ausloggen und auf "Weiter" klicken.  
<br /><code>
{foreach key=key item=slot from=$SLOTS}
{$slot.nr} -> {$slot.name}
<br>

{/foreach}
</code>
 <form method="GET" action = "./delchar.php" >
 <input type="hidden" value="3" name="step" />
 <input type="hidden" value="{$CN}" name="cn" />
 <button type="submit" class="btn">Weiter</button>
 </form>
<br>
{/if}
{if $STEP == 3}
{foreach key=key item=item from=$STEP_3}
{if $item.fail = true}
  <span style="color: red;">{$item.slotName} </span><br />
{else}
<span style="color: green;">{$item.slotName}</span> <br/>
{/if}
{/foreach}
 <form method="GET" action = "./delchar.php" >
 <input type="hidden" value="3" name="step" />
 <button type="submit" class="btn">Next Try</button>
 </form>
{/if}
