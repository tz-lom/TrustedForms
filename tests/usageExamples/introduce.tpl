<!-- this is standart HTML comment -->
<form><!--@form { exportName: form; }-->
    <input type="text">
    <!--@form input:first
	{
		@name text
		@error message="%2 == %1 is not integer" =+"test" flag=+"data"
		@IsNumeric key="value" key2="value" key3="value with = inside,use \\ for slash and \" for quote"
			    key4=value
		//this is comment
		@OtherTest param=value param2=value
	}
	
	this is simple comment
	
	@form input:last
	{
		@ignore
	}
    -->

<!--
    @target name
    @error  message="text"
    @error  add removeClass="" addMessage=""
    @test   IsNumeric strict=true
-->
    
    <!--[V]
    @:last => text
    ! message:"" addClass:"" removeClass:"" addMessage:""
    IsNumeric? strict=true
    +strictSelect
    -->
    <input type="submit">
</form>

<!--
$form = new \TrustedForms\FormValidator();
$form['text'] = new \TrustedForms\VariableValidator();
$form['text']->addReporter(new \TrustedForms\FormErrorReporter());
$form['text']->addToChain(new \TrustedForms\ValueChecks\IsNumeric());
$form['text']->addToChain(new \TrustedForms\ValueChecks\Trololo(array('k'=>'v','k2'=>'v'));
-->






<form>
    <input id="me" type="text" name="me" value=""/> <div id="me-err"/> <div id="superError"/>
    <!--@me:
        regexp="a*b+no one care" : << Ты дурак и даже не знаешь какой тут регэксп >>,
        fooBar=(a, b, c, d|e) : << <b>Лох!</b> >> ("superError"),
        defaultErrReport = "me-err",
        {
            if($value + $mysupervar == "Hi!")
                return true;
        }
        {
            if(value + $mysupervar == "Hi!")
                document...
        }
    -->
</form>


SELECT
    c.field1 AS c_f1,
    c.field2 AS c_f2,
    c2.filed1 AS c2_f1,
    t.abc AS t_abc
FROM
    cap AS c
    LEFT JOIN tap AS t USING(FI),
    cap AS c2
