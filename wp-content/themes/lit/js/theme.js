try{console.log("Hello Console.")}catch(e$$5){window.console={};for(var cMethods="assert,count,debug,dir,dirxml,error,exception,group,groupCollapsed,groupEnd,info,log,markTimeline,profile,profileEnd,time,timeEnd,trace,warn".split(","),i=0;i<cMethods.length;i++)console[cMethods[i]]=function(){}}
(function(c){window.Popup=function(h,b){var a=this;a.positionType=b||"fixed";a.el=c("<div />",{id:h}).css({position:this.positionType}).appendTo("body");a.IS_VISIBLE=!1;a.setContent=function(b){typeof b!=="undefined"&&a.el.html(b);return a};a.show=function(b){typeof b!=="undefined"&&a.setContent(b);a.IS_VISIBLE=!0;a.position();a.el.show();return a};a.hide=function(){if(a.IS_VISIBLE)a.el.hide(),a.IS_VISIBLE=!1;return a};a.position=function(b,c){return a.positionType==="fixed"?a.positionFixed():a.positionAbsolute(b,
c)};a.onClick=function(b){b.stopPropagation()};a.positionFixed=function(){if(a.IS_VISIBLE){var b=Math.floor((c(window).width()-a.el.outerWidth())/2),d=Math.floor((c(window).height()-a.el.outerHeight())/2);a.el.css({left:b<0?0:b,top:d<0?0:d})}return a};a.positionAbsolute=function(b,c){a.el.css({left:b,top:c});return a};a.positionType==="fixed"&&c(window).resize(a.positionFixed);a.el.click(a.onClick);return a}})(jQuery);
(function(c){var h=function(b){var a=this,e={contID:"rotator",sliderClass:"slides",controlsClass:"controls",nextText:">>",prevText:"<<",z:1,transitionTime:1E3,gidAtt:"gid",timeoutTime:7500,showControls:!1,linkTo:!1,linkClickCallback:function(){},autoRotate:!1,appendControlsTo:!1},d;for(d in b)e[d]=b[d]||e[d];for(d in e)a[d]=e[d];a.container=null;a.slider=null;a.slides=null;a.controls=null;a.sliderTimeout=null;a.currentSlide=[];a.nextSlide=null;a.binaryControls=null;a.RUNNING=!1;a.other=!1;a.init=
function(){if(c("#"+a.contID).length)a.container=c("#"+a.contID),a.slider=a.container.find("."+a.sliderClass),a.slides=a.slider.children(),a.controls=a.makeControls(),a.controls.children().first().addClass("active"),a.slides.last().addClass("active"),a.currentSlide=a.slides.last().fadeTo(a.transitionTime,1),a.slides.not(".active").fadeOut(0),c(window).resize(a.onResize),a.onResize(),a.RUNNING=!0;return a};a.isRunning=function(){return a.RUNNING};a.onResize=function(){if(a.container.is(":visible")){if(!a.sliderTimeout&&
a.autoRotate)a.sliderTimeout=setTimeout(a.sliderTimeoutFunc,a.timeoutTime)}else if(a.sliderTimeout&&a.autoRotate)clearTimeout(a.sliderTimeout),a.sliderTimeout=null};a.makeControls=function(){var b=c("<div />").addClass(a.controlsClass+" norm");a.slides.each(function(){var d=c(this).attr(a.gidAtt),d=c("<div />",{}).attr(a.gidAtt,d).click(a.ctrlClickHandle).prependTo(b);if(c(this).attr("thumb")){var l=JSON.parse(c(this).attr("thumb"));c("<span />").css({"background-image":'url("'+l[0]+'")'}).appendTo(d)}});
if(a.showControls==="binary")a.binaryControls=a.makeBinaryControls();a.appendControlsTo&&c(a.appendControlsTo).length?b.appendTo(a.appendControlsTo):b.appendTo(a.container);return b};a.makeBinaryControls=function(){var b=c("<div />").addClass(a.controlsClass+" bin");c("<span />",{text:a.prevText}).addClass("prev").click(a.binaryCtrlClickHandle).appendTo(b);c("<span />",{text:a.nextText}).addClass("next").click(a.binaryCtrlClickHandle).appendTo(b);b.appendTo(a.appendControlsTo);b.appendTo(a.container);
return b};a.ctrlClickHandle=function(){var b=c(this).attr(a.gidAtt);a.slideChange(b);return a.linkClickCallback(b,a.linkTo)};a.binaryCtrlClickHandle=function(){var b=c(this).hasClass("prev")?a.getPreviousSlide().attr(a.gidAtt):a.getNextSlide().attr(a.gidAtt);a.slideChange(b);return a.linkClickCallback(b,a.linkTo)};a.getNextSlide=function(){return a.currentSlide.next().length?a.currentSlide.next():a.currentSlide.parent().children().first()};a.getPreviousSlide=function(){return a.currentSlide.prev().length?
a.currentSlide.prev():a.currentSlide.parent().children().last()};a.slideChange=function(b){var c=a.getControlByID(b);if(!c.hasClass("active"))return a.sliderTimeout&&clearTimeout(a.sliderTimeout),a.z++,a.nextSlide=a.getSlideByID(b),a.fadeChange(),a.controls.find(".active").removeClass("active"),c.addClass("active"),a.autoRotate?a.sliderTimeout=setTimeout(a.sliderTimeoutFunc,a.timeoutTime):!0};a.fadeChange=function(){if(!a.nextSlide)return!1;a.slider.find(a.currentSlide).stop(!1,!1);a.slides.not(a.nextSlide).stop(!0,
!1);a.nextSlide.addClass("active").css({zIndex:a.z}).stop(!0,!0).fadeTo(a.transitionTime,1);a.slides.not(a.nextSlide).stop(!0,!0).fadeOut(a.transitionTime).removeClass("active");a.currentSlide=a.nextSlide;a.nextSlide=null};a.getControlByID=function(b){return!b?!1:a.controls.find("["+a.gidAtt+'="'+b+'"]')};a.getSlideByID=function(b){return!b?!1:a.slider.find("["+a.gidAtt+'="'+b+'"]')};a.sliderTimeoutFunc=function(){return a.slideChange(a.getNextSlide().attr(a.gidAtt))};return a.init()};window.EaseRotator=
h;window.EaseRotatorController=function(b){var a=this,e={rotatorsConfig:[],timeoutTime:7500},d;for(d in b)e[d]=b[d]||e[d];for(d in e)a[d]=e[d];a.rotators={};a.sliderTimeout=null;a.init=function(){if(typeof a.rotatorsConfig==="object"&&a.rotatorsConfig.length)c.each(a.rotatorsConfig,a.startRotator),a.sliderTimeout=setTimeout(a.sliderTimeoutFunc,a.timeoutTime);return a};a.startRotator=function(){if(this.linkTo)this.linkClickCallback=a.linkClickCallback;a.rotators[this.contID]=new h(this)};a.sliderTimeoutFunc=
function(){clearTimeout(a.sliderTimeout);c.each(a.rotators,a.rotateInstance);return a.sliderTimeout=setTimeout(a.sliderTimeoutFunc,a.timeoutTime)};a.rotateInstance=function(){!this.autoRotate&&this.RUNNING&&this.container.is(":visible")&&this.slideChange(this.getNextSlide().attr(this.gidAtt));return!0};a.linkClickCallback=function(b,c){if(!b||!c)return!1;clearTimeout(a.sliderTimeout);var d=a.rotators[c];typeof d==="object"&&d.isRunning()&&d.slideChange(b);return a.sliderTimeout=setTimeout(a.sliderTimeoutFunc,
a.timeoutTime)};return a.init()}})(jQuery);
(function(c){window.EasePhotoGallery=function(h){var b=this,a={galleryContSelector:"ease-photo-gallery",linkCls:"ease-img-link",showTitles:!1,showDescriptions:!1,useFrame:!1,dataAttr:"ease_full",dataEl:!1,paginate:!1,paginateContCls:"gallery-page-controls",popupId:"easePopup",isStatic:!1},e;for(e in h)a[e]=h[e]||a[e];for(e in a)b[e]=a[e];b.currentI=0;b.allData=[];b.fullData=[];b.currentPage=1;b.maxPages=0;b.pageContainer=!1;b.pageControls=!1;b.isIE=Ease.ie||c("html.ie").length?!0:!1;b.galleryExists=
!1;b.popup=!1;b.frameCont=null;b.frame=null;b.images={};b.init=function(){if(c(b.galleryContSelector).length){b.galleryExists=!0;b.gallery=c(b.galleryContSelector);if(b.paginate&&b.dataEl)return b.initPaginated();b.links=b.gallery.find("."+b.linkCls);b.links.each(function(a){var f=c(this).attr(b.dataAttr);b.allData[a]=c.parseJSON(f)});b.links.click(b.linkClick);c("body").click(b.closePop)}};b.initPaginated=function(){var a=JSON.parse(c(b.dataEl).text());c.each(a,function(){b.fullData.push(this);b.allData.push(this.full)});
b.maxPages=Math.ceil(a.length/b.paginate);b.useFrame&&b.makeFrame();b.maxPages>1&&(b.makePageContainer(),b.makePaginateControls());c.fn.disableSelection&&c(".pageNext, .pagePrev").disableSelection();b.isStatic?(b.currentI=0,b.makePopup()):(b.buildPage(),c("body").click(b.closePop))};b.makeFrame=function(){var a=b.fullData[0];b.frameCont=c("<div />",{id:"gallery-frame"});b.frame=c("<img />",{src:a.full.src,thisI:0,alt:a.full.title}).attr(b.dataAttr,JSON.stringify(a.full)).click(b.loadPhoto).appendTo(b.frameCont);
b.frameTip=c("<div />",{html:"Click to expand"}).addClass("frame-tip").appendTo(b.frameCont);return b.frameCont.insertBefore(b.gallery)};b.frameClick=function(){};b.makePageContainer=function(){b.pageContainer=c("<div />",{id:"gallery-page-container"});return b.pageContainer.prependTo(b.gallery)};b.buildPage=function(){var a=b.currentPage*b.paginate-b.paginate,c=b.currentPage*b.paginate-1;for(b.pageContainer.html("");a<=c;a++)a<b.fullData.length&&b.makeThumbLink(a).appendTo(b.pageContainer);b.pageControls.find(".pageCounter").text(""+
b.currentPage+" of "+b.maxPages)};b.makeThumbLink=function(a){var f=b.fullData[a];return c("<a>",{href:f.full.src,thisI:a,title:f.full.title,html:c("<img />",{src:f.thumb[0],width:f.thumb[1],height:f.thumb[2]})}).attr(b.dataAttr,JSON.stringify(f.full)).addClass(b.linkCls).click(b.linkClick)};b.makePaginateControls=function(){var a={nextBttn:c("<div />",{html:"Next Page"}).addClass("pageNext").click(b.nextPage),prevBttn:c("<div />",{html:"Prev Page"}).addClass("pagePrev").click(b.prevPage),counter:c("<div />").addClass("pageCounter"),
clear:c("<div />").addClass("clearfix")};b.pageControls=c("<div />",{}).addClass(b.paginateContCls);for(var f in a)b.pageControls.append(a[f]);return b.pageControls.insertAfter(b.pageContainer)};b.nextPage=function(){b.currentPage<b.maxPages?b.currentPage++:b.currentPage=1;b.buildPage()};b.prevPage=function(){b.currentPage>1?b.currentPage--:b.currentPage=b.maxPages;b.buildPage()};b.linkClick=function(a){a.stopPropagation();a.preventDefault();return b.useFrame?b.loadPhotoInFrame.call(this,a):b.loadPhoto.call(this,
a)};b.loadPhotoInFrame=function(a){a.stopPropagation();a.preventDefault();a=c(this).attr("thisI");b.frame.attr({thisI:c(this).attr("thisI"),src:b.fullData[a].full.src}).attr(b.dataAttr,JSON.stringify(b.fullData[a].full))};b.loadPhoto=function(a){a.stopPropagation();a.preventDefault();b.currentI=c(this).attr("thisI")?c(this).attr("thisI"):c(this).index();b.makePopup()};b.closePop=function(){b.popup&&b.popup.hide()};b.nextPop=function(){b.currentI++;if(b.currentI>=b.allData.length)b.currentI=0;b.switchPop()};
b.prevPop=function(){b.currentI==0?b.currentI=b.allData.length-1:b.currentI--;b.switchPop()};b.positionPop=function(){var a=b.popup.width();b.popup.height();dW=c(window).width();sT=c(document).scrollTop();left=Math.floor((dW-a)/2);left<0&&(left=0);b.popup.css({top:40+sT,left:left}).show()};b.resizeHeight=function(b,a,c){b=Math.round(c*a/b);return{height:c,width:b}};b.resizeWidth=function(b,a,c){return{height:Math.round(c*b/a),width:c}};b.switchPop=function(){b.popup.children(".line, img, #pInfo, #pDesc, #pTitle").remove();
var a=b.allData[b.currentI],f=a.height,j=a.width,l="high";b.isStatic&&j>f&&(l="wide");if(!b.isStatic&&j>e)var e=c(window).width()-40,j=b.resizeWidth(f,j,e),f=j.height,j=j.width;if(!b.isStatic&&f>g)var g=c(window).height()-80,j=b.resizeHeight(f,j,g),f=j.height,j=j.width;f={line:c("<div />").addClass("line"),img:c("<img />",{src:a.src,height:f,width:j}).addClass(l).click(b.nextPop)};if(b.showTitles||b.showDescriptions)f.info=c("<div />",{id:"pInfo"});b.showTitles&&c("<div />",{id:"pTitle",html:a.title}).appendTo(f.info);
b.showDescriptions&&c("<div />",{id:"pDesc",html:a.desc}).appendTo(f.info);for(var n in f)b.popup.append(f[n]);b.isStatic?b.popup.show():b.positionPop();b.preloadAdjacentImages()};b.preloadAdjacentImages=function(){b.currentI+1>=b.fullData.length?b.preloadImage(0):b.preloadImage(b.currentI+1);b.currentI-1<0?b.preloadImage(b.fullData.length-1):b.preloadImage(b.currentI-1)};b.preloadImage=function(a){if(!b.images[a])b.images[a]=new Image,b.images[a].src=b.allData[a].src};b.makePopup=function(){if(!b.popup){var a=
{nextBttn:c("<div />",{id:"pNext",html:"next"}).click(b.nextPop),prevBttn:c("<div />",{id:"pPrev",html:"prev"}).click(b.prevPop)};if(!b.isStatic)a.closeBttn=c("<div />",{id:"pClose",html:"&times;"}).click(b.closePop);b.popup=c("<div />",{id:b.popupId}).click(function(a){a.stopPropagation()});for(var f in a)b.popup.append(a[f]);b.isStatic?b.popup.prependTo(b.gallery):b.popup.prependTo("body")}b.switchPop()};b.init();c(window).resize(function(){b.popup&&!b.popup.is(":hidden")&&b.switchPop()});return b.galleryExists?
b:!1}})(jQuery);(function(c){function h(){if(c("#mc-embedded-subscribe-form").length>0){var a=c("#mc-embedded-subscribe-form"),b=a.find("input"),l=a.find("button"),d=!1;a.submit(function(g){g.preventDefault();var g=b.val(),e=Ease.TemplateUrl+"/mailchimp_subscribe.php",k=function(b,j){if(typeof b==="undefined"||!b)b="Well, something went wrong.";var d;c("<span />",{text:b}).addClass(!j?"mcError error":"mcError success").insertAfter(l);return setTimeout(function(){var b=a.find(".mcError");b.length&&b.fadeOut(900,function(){c(this).remove()})},
2500)};a.find(".mcError").remove();if(g==="")return k("We need an email address, please."),!1;d||(d=!0,c.get(e,"email="+g,function(a){d=!1;a=JSON.parse(a);if(a.error){var b=a.error;switch(!0){case a.error.indexOf("already subscribed")!==-1:b="That email's already on our list!";break;case a.error.indexOf("Invalid Email Address")!==-1:b="We need a proper email address, please."}return k(b)}return k("You have been signed up!",!0)}))})}}function b(){if(c("#carousel").length){var a=c("#carousel"),b=c("#outer"),
d=a.find("#inner"),e=a.find(".nav"),a=a.find("a"),g=d.find(".active"),n=0;b.outerWidth();var k=a.first().outerWidth(),m=parseInt(d.css("left").replace("px",""),10),h=!0,q=m;c.each(a,function(){n+=c(this).outerWidth()});e.click(function(){var a=c(this).hasClass("back")?1:-1;parseInt(b.css("left").replace("px",""),10);m+=k*a;m>q||m<5*k-n?a=m-=k*a:(a=h?0:250,a=d.stop(!1,!1).animate({left:m},a,r));return a});var r=function(){h&&o()},o=function(){if(g.position().left-5*k+m>=0)return e.last().trigger("click");
else h=!1};o()}}function a(){if(c("#communityPage").length){var a=c("li.forum a"),b=new Popup("forumPopup"),d=c("<div />",{"data-href":"litmotors.com","data-num-posts":10,"data-width":720}).addClass("fb-comments"),e=function(){typeof window.FB!=="undefined"&&typeof window.FB.XFBML!=="undefined"?FB.XFBML.parse(document.getElementById("forumPopup")):setTimeout(e,15)};a.click(function(a){a.preventDefault();a.stopPropagation();b.show(d);e()});c("body").click(function(){b.hide()})}}function e(){if(c("#shirtForm").length){var a=
c("li.t-shirt a"),b=c("#shirtForm"),d=new Popup("shirtPopup"),e=new Popup("reservePopup"),g=b.find("#theSize"),h=b.find("#theColor");d.setContent(b);a.click(function(a){a.preventDefault();a.stopPropagation();e.hide();d.show()});var k=function(a){a.stopPropagation()},m=function(){var a=c("<div />",{id:"step2"}).click(k);c.each(["google","paypal"],function(){c("<div />",{id:this}).click(p).appendTo(a)});c("<h2 />",{html:"To complete your purchase please choose your preferred payment gateway by clicking on desired icon below:"}).prependTo(a);
return a},p=function(a){var b=c(this).attr("id");a.stopPropagation();e.show("<h2>In a moment you will be transferred to "+b+" to complete your reservation.</h2>");(b=="paypal"?c("#paypalForm"):c("#googleForm")).submit()};b.find("button").click(function(a){a.preventDefault();a.stopPropagation();d.hide();e.show(m())});b.click(k);c("body").click(function(){d.hide();e.hide()});b.find("select").change(function(){var a=g.val(),b=h.val();c('[name="os0"]').val(b);c('[name="os1"]').val(g.val());c('[name="item_selection_1"]').val({Black:{S:1,
M:2,L:3,XL:4,XXL:5},Grey:{S:6,M:7,L:8,XL:9,XXL:10},Orange:{S:11,M:12,L:13,XL:14,XXL:15}}[b][a])})}}function d(){if(c("#reserveForm").length){var a=c("#reserveForm"),b=[],d=new Popup("reservePopup");token=0;valid=!0;if(c("#faq").length){var e=c("#faq").find("a"),g=new Popup("tooltip","absolute");e.click(function(a){a.preventDefault();a.stopPropagation();typeof d!=="undefined"&&d.hide();a=c(this).parent().children(".tip");if(a.length){g.setContent(a.html());var b=c(this).offset(),a=b.top-Math.floor(g.el.outerHeight()/
4),b=b.left-g.el.outerWidth()-20;g.position(b,a).show()}});c("body").click(function(){g.hide()})}var h=function(){var a="";c.each(b,function(){a+="<div>"+this+"</div>"});d.setContent(a).show()},k=function(a){a.parent().addClass("error");return valid=!1},m=function(){b=[];c.ajax({url:Ease.TemplateUrl+"/reserve.php",data:a.serializeArray(),type:"post",complete:function(){},success:p,error:function(){}})},p=function(c){if(typeof c.status=="undefined")return b.push("An error occurred please try again later."),
h();if(c.status!="ok")return typeof c.focus!="undefined"&&k(a.find('[name="'+c.focus+'"]')),b.push(c.message),h();if(c.proceed)token=c.token,d.show(q())},q=function(){var a=c("<div />",{id:"step2"});c.each(["google","paypal"],function(){c("<div />",{id:this}).click(r).appendTo(a)});c("<h2 />",{html:"To complete your reservation please choose your preferred payment gateway by clicking on desired icon below:"}).prependTo(a);return a},r=function(){var a=c(this).attr("id");d.show("<h2>In a moment you will be transferred to "+
a+" to complete your reservation.</h2>");c.ajax({url:Ease.TemplateUrl+"/reserve.php",type:"post",data:{base_url:Ease.Url,template_url:Ease.TemplateUrl,current_url:window.location.href.toString().replace(window.location.search,""),token:token,gateway:a},success:o,error:function(a){d.show("Error:<br/>"+a.responseText)}})},o=function(b){if(typeof b.status=="undefined")return d.show("An error occurred please try again later.");if(b.status!="ok")return d.show(b.message);if(b.proceed&&b.link&&b.method&&
b.link)b.method=="get"?window.location.href=b.link:(a.attr({action:b.link}),a.submit())};c("body").click(function(){d.hide()});c(window).resize(function(){d.position()});a.find('[type="submit"]').click(function(c){c.preventDefault();c.stopPropagation();typeof g!=="undefined"&&g.hide();var c=null,d={deposit:"Please choose your deposit amount.",country:"Please choose your country."},e={zip:"Zip Code is required",firstname:"First Name is required",lastname:"Last Name is required",address:"Address is required",
city:"City is required",state:"State is required",email:"A valid Email is required",phone:"A Phone Number is Required"};a.find(".error").removeClass("error");b=[];valid=!0;for(var l in d)if(c=a.find("[name="+l+"]"),!c.val()||c.val()=="0")k(c),b.push(d[l]);for(l in e)if(c=a.find("[name="+l+"]"),!c.val()||c.val().length<2)k(c),b.push(e[l]);return valid?m():h()});c("#actionReturn").length&&d.show(c("#actionReturn").html())}}c(document).ready(function(){console.log("hello common ready");c("html.ie").length?
Ease.ie=!0:Ease.ie=!1;c("html.lte8").length?Ease.lte8=!0:Ease.lte8=!1;typeof WebKitPoint!=="undefined"?Ease.webkit=!0:Ease.webkit=!1;c("#homeRotate").length&&new EaseRotator({contID:"homeRotate",transitionTime:1E3,timeoutTime:7500,showControls:"binary",autoRotate:!0,appendControlsTo:"#controlWrap"});c("#rotatingGallery").length&&new EasePhotoGallery({galleryContSelector:"#rotatingGallery",dataEl:"#galleryJson",paginate:1E3,isStatic:!0,showTitles:!0,showDescriptions:!0});d();b();e();a();h()})})(jQuery);
