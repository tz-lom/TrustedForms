<form id="f1">


<div id="err"><?php  echo $test->getFlag('msg2');  ?></div>

<input type="text" name="data" id="i1" value="<?php  if($test['data']->isChecked()) { echo $test['data']->value(); } else {  ?><?php  }  ?>" class="<?php  if($test->isFlag('clsAdd3')) echo 'class';  ?>"><!-- simple comment --><textarea name="ta" id="i2"></textarea>
</form>