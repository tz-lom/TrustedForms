<form id="f1">
<!--
@#f1@:
name="$test"
-->

<div id="err"></div>

<input type="text" name="data" id="i1"/>
<!--
@#i1@:
defaultErrorReport : @err@<<me-err>>,
/*regexp="a*b+no one care" : @err@<< oops,is it realy was in commits?? >>,
fooBar=(a, b, c, de) : @#err@<< <b>sorry</b> >> @#i1@+superName @#i2@-class*/
IsNumeric : @#err@<< message >> @#i1@+class
-->

<!-- simple comment -->

<textarea name="ta" id="i2"></textarea>

</form>