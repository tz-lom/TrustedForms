<form id="f1" name="form">
<!--

<form> {
    var="$test"
}

-->

<div id="err"></div>

<input type="text" name="data" id="i1"/>
<!--

<form>data {
 isEqualToField = (ta): @#i1@+err @#err@<<message>>
}
 
ta<form> {
 isIP = (IS_IPV4,FLAG_IPV6) : @#i2@+err
}
-->

<!-- simple comment -->

<textarea name="ta" id="i2"></textarea>

</form>