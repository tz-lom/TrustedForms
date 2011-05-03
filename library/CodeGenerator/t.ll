<form id="f1">
<!--
@#f1@:
name="$test"
-->

<div id="err"></div>

<input type="text" name="data" id="i1"/>
<!--
@#i1@:
defaultErrReport : @err@<<me-err>>,
regexp="a*b+no one care" : @err@<< Ты дурак и даже не знаешь какой тут регэксп >>,
fooBar=(a, b, c, de) : @#err@<< <b>Лох!</b> >> @#i1@+superName @#i2@-class
-->

<!-- simple comment -->

<textarea name="ta" id="i2"></textarea>

</form>