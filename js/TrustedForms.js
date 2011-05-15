/*
 * TrustedForms.register({
 *  name:'isNumber',
 *  validator: function(val,config){
 *    return {value:val,passed:true};
 *  }
 * });
 *
 * TrustedForms.check([
 * {
 *      name: 'name',
 *      form : '#form',
 *      tests: [
 *          {
 *              test: 'isNumber',
 *              arguments: [],
 *              error: [
 *                  {element: '#id1',type:'addClass',argument: 'class'},
 *                  {element: '#id1',type:'addClass',argument: 'class2'},
 *                  {element: '#id1',type:'removeClass',argument: 'class3'}
 *              ]
 *          }
 *      ]
 * }]);
 *
 */

(function(window){

var TrustedForms = function(){
        return TrustedForms.prototype.init();
    },
    
    _TrustedForms = window.TrustedForms;

TrustedForms.prototype = {
    init: function(){
        this.validators = new Object;
        this.errors = new Array;
        this.checks = new Array;
        this.errorDisplay = {
            'addClass' : function($el,args){
                $el.addClass(args);
            },
            'removeClass': function($el,args){
                $el.removeClass(args);
            }
        };
        this.errorHide = {
            'addClass': this.errorDisplay['removeClass'],
            'removeClass': this.errorDisplay['addClass']
        };
    },
    register: function(item){
        if(item instanceof Array){
            for(var i=0;i<item.length;i++){
                this.register(item[i]);
            }
        } else {
            this.validators[item.name] = item.validator;
        }
    },
    checkAll: function(){
        this.hideErrors();
        var result = true;
        var self = this;
        jQuery.each(this.checks,function(i,field){
            //if(formName==undefined || this.form == formName)
                result &= self.checkField(field);
        });
        return result==true;
    },
    checkField: function(field){
        var $el = jQuery(field.form+' [name='+field.name+']'); //@todo: don't forget to escape "name" in generator
        var res = {value: $el.val(), passed: true};
        for(var i=0; res.passed && i<field.tests.length;i++){
            res = this.performTest(field.tests[i],res.value);
        }
        return res.passed;
    },
    performTest: function(test, value){
        var res = this.validators[test.test](value,test.arguments);
        if(!res.passed){
            this.showError(test.error)
        }
        return res;
    },
    check: function(field){
        this.checks.push(field);
        //@todo: append checks to form AND elements of form
        var $el = jQuery(field.form+' [name='+field.name+']');
        var self = this;
        $el.bind('change',function(){ //@todo : on focus lost, not change
            self.checkAll();
        });
        var $form = jQuery(field.form);
        if(!$form.data('TrustedFormsAlreadyBinded')){
            $form.bind('submit',function(){
                return self.checkAll();
            });
        }
            
        return this;
    },
    showError: function(error){
        this.errors.push(error);
        var self = this;
        jQuery.each(error,function(i,error){
            var $el = jQuery(error.element);
            self.errorDisplay[error.type]($el,error.argument);
        });
    },
    hideErrors: function(){
        var self = this;
        jQuery.each(this.errors,function(i,errors){
            jQuery.each(errors,function(i,error){
                var $el = jQuery(error.element);
                self.errorHide[error.type]($el,error.argument);
            });
        });
        this.errors = new Array;
    }
}

window.TrustedForms = new TrustedForms;
})(window);
