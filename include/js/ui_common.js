// JavaScript Document

// Top Menu (GNB)
(function($){
	//gnb
	$.fn.gnb = function(options){
		var option = $.extend( {}, $.fn.gnb.defaults, options || {} );
		
		return this.each(function(){
			var $this = $(this)
			, $menu = $this.find("a.gnblink")
			, $smenu = $this.find(".gnb_smenubox")
			, $slkmenu = $this.find(".gnb_smenubox a")
			, oldMenu, oldSMenu, openMenu, setTemp;
			
			// 초기함수
			function _init(){
				$smenu.hide();

				if(option.mCurrent == 0 && option.sCurrent == 0){
					option.openMenu = false;
				}
				
				if( option.openMenu == true ) memPositon(option.mCurrent, option.sCurrent);
			}
						
			// 활성화함수
			function memPositon(pageNum, subNum){
				$menu.eq(pageNum - 1).trigger("mouseover");			
	
				if( $menu.eq(pageNum - 1).next().length ){
					if(subNum > 0){
						$menu.eq(pageNum - 1).next().find("a").removeClass("current");
						$menu.eq(pageNum - 1).next().find("a").eq(subNum - 1).addClass("current");
					}
				}
				
			}
			
			
			// 활성화 초기함수
			function rsReturn(){
				
				if(typeof($(oldMenu).find("img")[0]) == 'undefined' || $(oldMenu).find("img")[0] == null)return;
				
				$(oldMenu).find("img")[0].src = $(oldMenu).find("img")[0].src.replace("_on.", "_off.");
				$(oldMenu).parents('li').removeClass('on');
				$(oldMenu).parent().find(".gnb_smenubox").hide();
				
			}
			
			// $menu mouseenter 이벤트
			$menu.bind("mouseenter focus", function(){
				if( oldMenu ){
					$(oldMenu).find("img")[0].src = $(oldMenu).find("img")[0].src.replace("_on.", "_off.");
					$(oldMenu).parent().find(".gnb_smenubox").hide();
					$(oldMenu).parents('li').removeClass('on');
				}
				$(this).find("img")[0].src = $(this).find("img")[0].src.replace("_off.", "_on.");
				
				$(this).parent().find(".gnb_smenubox").show();
				$(this).parents('li').addClass('on');
								
				oldMenu = this;
			});
			
			// $smenu mouseenter 이벤트
			$slkmenu.bind("mouseenter focusin", function(){
				if( oldSMenu ){
					$(oldSMenu).removeClass("current");
				}
				
				if( $(this).attr("class") == "current"){
					//return false;
				} else {
					$(this).addClass("current");
				}
								
				oldSMenu = this;
			});
			
			// $this mouseenter 이벤트
			$this.bind("mouseenter focusin", function(){
				clearTimeout(setTemp);
			});
			
			// $this mouseleave 이벤트
			$this.bind("mouseleave focusout", function(){
				setTemp = setTimeout(function(){
					if( option.openMenu  == true ) 
						memPositon(option.mCurrent, option.sCurrent);
					else 
						rsReturn();
				}, 100);
			});
	
			_init();			
		});
	}
	// mCurrent - 1뎁스메뉴 활성화 번호, sCurrent - 2뎁스메뉴 활성화 번호
	$.fn.gnb.defaults = { mCurrent : 0, sCurrent : 0, openMenu : true };

})(jQuery);

