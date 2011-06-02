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
 
@#i2@:
 isIP = (IS_IPV4,FLAG_IPV6) : @#i2@+err
-->

<!-- simple comment -->

<textarea name="ta" id="i2"></textarea>

</form>