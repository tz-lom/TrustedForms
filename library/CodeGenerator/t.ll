<form id="f1">
<!--
@#f1@:
name="$test"
-->

<div id="err"></div>

<input type="text" name="data" id="i1"/>
<!--
@#i1@:
 isEqualToField=ta : @#i1@+err
 
-->

<!--
@#i2@:
 required : @#i2@+err
-->

<!-- simple comment -->

<textarea name="ta" id="i2"></textarea>

</form>