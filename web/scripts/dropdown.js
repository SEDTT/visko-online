							function DropDown(el) {
								this.dd = el;
								this.placeholder = this.dd.children('span');
								this.opts = this.dd.find('ul.dropdown > li');
								this.val = '';
								this.index = -1;
								this.initEvents();
							}
							DropDown.prototype = {
								initEvents : function() {
									var obj = this;

									obj.dd.on('click', function(event){
										$(this).toggleClass('active');
										return false;
									});

									obj.opts.on('click',function(){
										var opt = $(this);
										obj.val = opt.text();
										obj.index = opt.index();
										obj.placeholder.text(obj.val);
									});
								},
								getValue : function() {
									return this.val;
								},
								getIndex : function() {
									return this.index;
								}
							}
							
							$(function() {

								var dd = new DropDown( $('#dd') );
								var dd2 = new DropDown( $('#dd2') );
								var dd3 = new DropDown( $('#dd3') );
								var dd4 = new DropDown( $('#dd4') );
								var dd5 = new DropDown( $('#dd5') );
								var dd6 = new DropDown( $('#dd6') );
								var dd7 = new DropDown( $('#dd7') );

								$(document).click(function() {
									// all dropdowns
									$('.wrapper-dropdown-1').removeClass('active');
								});

							});