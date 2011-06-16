/*
 * TrustedForms.register({
 *  name:'isNumber',
 *  validator: function(val,config){
 *    return {value:val,passed:true};
 *  }
 * });
 *
 * TrustedForms.check({
 *      field: 'input name',
 *      form: 'form name',
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
 * });
 *
 */

(function(window){

var TrustedForms = function(){
        return TrustedForms.prototype.init();
    },
    
    _TrustedForms = window.TrustedForms;

TrustedForms.prototype = {
    init: function(){
        this.validators = {rpcTest: this.rpcTest};
        this.checks = new Array;
        this.errorDisplay = {
            'addClass' : function($el,args){
                $el.addClass(args);
            },
            'removeClass': function($el,args){
                $el.removeClass(args);
            },
			'message': function($el,args){
                $el[0].TrustedForms_old_text ={
                         html:  $el.html(),
                         attr: $el[0].TrustedForms_old_text
                };
				$el.html(args);
			}
        };
        this.errorHide = {
            'addClass': this.errorDisplay['removeClass'],
            'removeClass': this.errorDisplay['addClass'],
			'message': function($el,args){
				var attr = $el[0].TrustedForms_old_text;
                $el.html(attr.html);
                $el[0].TrustedForms_old_text = attr.attr;
			}
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
		return this;
    },
    checkAll: function(){
        this.hideErrors();
        var result = true;
        var self = this;
        jQuery.each(this.checks,function(i,field){
            result &= self.checkField(field,true);
        });
        return result==true;
    },
    checkFieldById: function(id){
        this.hideError(id);
        this.checkField(this.checks[id],true);
    },
    checkField: function(field,ignoreChecked){
        if(field.checked && !ignoreChecked) return;
        if(field.circleSemaphore){
            field.circleSemaphore = false;
            throw 'CircleValidation';
        }
        field.circleSemaphore = true;
        var $el = jQuery(field.element); 
        var res = {value: $el.val(), passed: true};
        for(var i=0; res.passed && i<field.tests.length;i++){
            //res = this.performTest(field.tests[i],res.value);
            res = this.validators[field.tests[i].test].call(this,res.value,field.tests[i].arguments);
            if(!res.passed){
                field.displayedError = this.showError(field.tests[i].error);
            }
        }
        field.checked = true;
        field.circleSemaphore = false;
        if(res.passed){
            field.value = res.value;
            return true;
        }else{
            field.value = undefined;
            return false;
        }
    },
    performTest: function(test, value){
        var res = this.validators[test.test].call(this,value,test.arguments);
        if(!res.passed){
            this.showError(test.error)
        }
        return res;
    },
    check: function(field){
        var id = this.checks.push(field)-1;
        this.checks[id].name = field.field;
        this.checks[id].form = field.form;
        this.checks[id].element = field.form?'form[name="'+field.form+'"] [name="'+field.field+'"]':'[name="'+field.field+'"]';
        var $el = jQuery(this.checks[id].element);
        this.checks[id].circleSemaphore = false;
        this.checks[id].value = undefined;
        this.checks[id].checked = false;
        this.checks[id].displayedError = undefined;
        var self = this;
        $el.bind('performElementValidation',function(){
            self.checkFieldById(id);
        }).bind('change',function(){$(this).trigger('performElementValidation')});
        var $form = $el.parent('form');
        if(!$form.data('TrustedFormsAlreadyBinded')){
            $form.bind('submit',function(){
                return self.checkAll();
            });
        }
            
        return this;
    },
    showError: function(error){
       // this.errors.push(error);
        var self = this;
        jQuery.each(error,function(i,error){
            var $el = jQuery(error.element);
            self.errorDisplay[error.type]($el,error.argument);
        });
        return error;
    },
    hideError: function(id){
        if(!this.checks[id].displayedError) return;
        var self = this;
        jQuery.each(this.checks[id].displayedError,function(i,error){
            var $el = jQuery(error.element);
            self.errorHide[error.type]($el,error.argument);
        });
        this.checks[id].displayedError = undefined;
    },
    hideErrors: function(){
        var self = this;
        jQuery.each(this.checks,function(i,field){
            self.hideError(i);
        });
        this.errors = new Array;
    },
	reset: function(){
		this.hideErrors();
		this.init();
	},
    rpcTest: function(value,options){
        var self = this,
            dat = JSON.stringify({name: options[1],value:value});
        jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            url: options[0],
            cache: false,
            processData: false,
            data: dat,
            error: function(json){
                //@todo: nice features here please xD
            },
            success: function(json){
                if(!json.passed){
                    if(json.error) self.showError(json.error);
                }
            }
        });
        return true;
    },
    getValue: function(name){
        var self = this;
        var val = undefined;
        jQuery.each(this.checks,function(i,check){
           if(check.name==name){
               self.checkField(check);
               val = check.value;
               return false;
           } 
        });
        return val;
    }
}

window.TrustedForms = new TrustedForms;
})(window);
