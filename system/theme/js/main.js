$&&$(function(){!function(e){function t(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,t),o.l=!0,o.exports}var n={};t.m=e,t.c=n,t.d=function(e,n,r){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:r})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=13)}([function(e,t,n){"use strict";function r(e){function t(e){"function"==typeof e?u?(n.off(u+".e2NiceError").on(u+".e2NiceError",function(){n.off(u+".e2NiceError"),e()}),n.addClass(a)):(n.addClass(a),e()):n.addClass(a)}var n=$(".e2-nice-error"),r=n.find(".e2-nice-error-inner"),a="e2-nice-error_hidden",s={en:{"er--js-server-error":"Server error","er--js-appears-offline":"The connection appears to be offline","er--js-connection-timeout":"Server does not respond for too long","er--js-file-upload-not-supported":"The browser does not support file upload","er--js-no-files-to-upload":"No files to upload","er--js-can-upload-only-one-file":"Only one file may be uploaded here","er--js-supported-only-png-jpg-gif":"Only PNG, JPG, and GIF images are supported","er--unsupported-file":"Only PNG, JPG, GIF, & SVG images and MP3 audio files are supported"},ru:{"er--js-server-error":"Ошибка на сервере","er--js-appears-offline":"Похоже, что нет интернета","er--js-connection-timeout":"Сервер не отвечает слишком долго","er--js-file-upload-not-supported":"Браузер не поддерживает загрузку файлов","er--js-no-files-to-upload":"Нет файлов для загрузки","er--js-can-upload-only-one-file":"Можно загрузить только одно изображение","er--js-supported-only-png-jpg-gif":"Поддерживаются только изображения PNG, JPG и GIF","er--unsupported-file":"Поддерживаются только изображения PNG, JPG, GIF, SVG и аудиофайлы MP3"},be:{"er--js-supported-only-png-jpg-gif":"Падтрымлiваюцца толькi выявы PNG, JPG i GIF","er--unsupported-file":"Падтрымлiваюцца толькi выявы PNG, JPG, GIF, SVG i аудыёфайлы MP3"},uk:{"er--js-supported-only-png-jpg-gif":"Підтримуються лише зображення PNG, JPG і GIF","er--unsupported-file":"Підтримуються лише зображення PNG, JPG, GIF, SVG і аудіофайли MP3"}},u=(0,i.default)();!function(){var i=e.message?e.message:"",u=$("html").attr("lang")||"en";if(i&&(void 0!==s[u][e.message]?i=s[u][e.message]:void 0!==s.en[e.message]&&(i=s.en[e.message]),n.hasClass(a)?r.html(i).promise().done(function(){n.removeClass(a),$(document).on("mousedown.e2NiceError keydown.e2NiceError",function(){$(document).off(".e2NiceError"),t()})}):t(function(){r.html(i).promise().done(function(){n.removeClass(a),$(document).on("mousedown.e2NiceError keydown.e2NiceError",function(){$(document).off(".e2NiceError"),t()})})})),"object"===o(e.debug)&&"object"===("undefined"==typeof console?"undefined":o(console))){var d,l;"function"==typeof window.getComputedStyle&&"function"==typeof window.getComputedStyle(document.documentElement).getPropertyValue&&(d=window.getComputedStyle(document.documentElement).getPropertyValue("--errorColor"),l=window.getComputedStyle(document.documentElement).getPropertyValue("--backgroundColor")),"function"==typeof console.log&&("string"==typeof e.debug.message?console.log("%c "+e.debug.message+" ","background: "+(d||"#D20D19")+"; color: "+(l||"#fff")+";"):"string"==typeof i&&console.log("%c "+i+" ","background: "+(d||"#D20D19")+"; color: "+(l||"#fff")+";")),"function"==typeof console.dir&&"function"==typeof console.log&&"object"===o(e.debug.data)&&$.each(e.debug.data,function(e,t){if("object"===(void 0===t?"undefined":o(t))&&t instanceof FormData&&"function"==typeof t.entries){console.log(e);var n=!0,r=!1,a=void 0;try{for(var i,s=t.entries()[Symbol.iterator]();!(n=(i=s.next()).done);n=!0){var u=i.value;console.dir(u[1])}}catch(e){r=!0,a=e}finally{try{!n&&s.return&&s.return()}finally{if(r)throw a}}}else console.log(e),console.dir(t)})}}()}Object.defineProperty(t,"__esModule",{value:!0});var o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},a=n(3),i=function(e){return e&&e.__esModule?e:{default:e}}(a);t.default=r},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=window.localStorage,o=function(){if(void 0===r)return!1;try{return r.setItem("test","test"),r.removeItem("test"),!0}catch(e){return!1}}();t.localStorage=r,t.isLocalStorageAvailable=o},function(e,t,n){"use strict";function r(e){var t={type:"post",timeout:1e4,dataType:"json",cache:!1},n=e.success,r=e.error,a=e.complete,s=e.abort;delete e.success,delete e.error,delete e.complete,delete e.abort;var u=$.ajax($.extend(t,e));return u.done(function(t,a,s){"object"===(void 0===t?"undefined":o(t))?!0===t.success?"function"==typeof n&&n(t,a,s):("object"===o(t.error)?"string"==typeof t.error.message?(0,i.default)({message:t.error.message,debug:{data:{requestData:e.data,response:t}}}):(0,i.default)({message:"er--js-server-error",debug:{message:"Server responce malformed: `response.error.message` is not available",data:{requestData:e.data,response:t}}}):(0,i.default)({message:"er--js-server-error",debug:{message:"Server responce malformed: `response.error` is not an object",data:{requestData:e.data,response:t}}}),"function"==typeof r&&r(s,a)):((0,i.default)({message:"er--js-server-error",debug:{message:"Server responce malformed: `response` is not an object",data:{requestData:e.data,response:t}}}),"function"==typeof r&&r(s,a))}),u.fail(function(e,t){if("object"===(void 0===e?"undefined":o(e))&&"number"==typeof e.status&&"string"==typeof t)if(0===e.status){if("abort"===t)return"function"==typeof s&&s(e,t),!1;"timeout"===t?(0,i.default)({message:"er--js-connection-timeout"}):(0,i.default)({message:"er--js-appears-offline"})}else e.status>=400?(0,i.default)({message:"er--js-server-error",debug:{message:"Server responded with HTTP status code "+e.status,data:{jqXHR:e}}}):200===e.status&&"parsererror"===t?(0,i.default)({message:"er--js-server-error",debug:{message:"Server response is not JSON",data:{jqXHR:e}}}):(0,i.default)({message:"er--js-server-error",debug:{message:"Unexpected server response HTTP status code "+e.status,data:{jqXHR:e}}});else(0,i.default)({message:"er--js-server-error",debug:{message:"Server responce malformed: jqXHR is not an object or it does not contain required fields",data:{jqXHR:e}}});"function"==typeof r&&r(e,t)}),u.always(function(){"function"==typeof a&&a(arguments)}),u}Object.defineProperty(t,"__esModule",{value:!0});var o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},a=n(0),i=function(e){return e&&e.__esModule?e:{default:e}}(a);t.default=r},function(e,t,n){"use strict";function r(){var e,t=document.createElement("div"),n={transition:"transitionend",OTransition:"oTransitionEnd",MozTransition:"transitionend",MSTransition:"msTransitionEnd",WebkitTransition:"webkitTransitionEnd"};for(e in n)if(void 0!==t.style[e])return n[e];return!1}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r},function(e,t,n){"use strict";function r(e,t){var n=e.find("animateTransform"),r=e.find("circle.e2-progress");n.length&&(t?(n[0].setAttribute("repeatCount","indefinite"),n[0].beginElement()):n[0].setAttribute("repeatCount","1"),r.length&&(0,a.default)(r,0,!0))}Object.defineProperty(t,"__esModule",{value:!0});var o=n(5),a=function(e){return e&&e.__esModule?e:{default:e}}(o);t.default=r},function(e,t,n){"use strict";function r(e,t,n){if("number"==typeof t){var r=Math.max(Math.min(t,.9),.1);n&&e.attr("class","e2-progress e2-progress_notransition"),e[0].style.strokeDashoffset=Math.floor(245-245*r),n&&e.attr("class","e2-progress")}}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0}),t.default={mac:/Macintosh/.test(navigator.userAgent),iosdevice:/(iPad)|(iPhone)/.test(navigator.userAgent)}},function(e,t,n){"use strict";function r(e,t,n){var r=void 0,o={event:"keydown",target:document,prevent:!1};n=d(n,o),Array.isArray(e)?(r=[],c.default.mac||(e=e.map(function(e){return e.replace("Cmd","Ctrl")})),e.forEach(function(e){return r.push(a(e,t,n))})):(c.default.mac||(e=e.replace("Cmd","Ctrl")),r=a(e,t,n));var i="string"==typeof n.target?document.querySelector(n.target):n.target;Array.isArray(r)?r.forEach(function(r,o){f[e[o]]||(f[e[o]]=[]),i.addEventListener(n.event,r,!1),f[e[o]].push({event:n.event,elem:i,fn:t,realFn:r})}):(f[e]||(f[e]=[]),i.addEventListener(n.event,r,!1),f[e].push({event:n.event,elem:i,fn:t,realFn:r}))}function o(e,t,n){function r(e){f[e]&&f[e].slice().reverse().forEach(function(e,r,o){e.fn!==t||n.target&&e.elem!==n.target||(e.elem.removeEventListener(e.event,e.realFn,!1),o.splice(o.length-1-r,1))})}n=n||{},Array.isArray(e)?e.forEach(r):r(e)}function a(e,t,n){return e=u(e).split("+"),function(r){i(r,e)&&(t(r),n.prevent&&(r.preventDefault(),r.stopPropagation()))}}function i(e,t){var n=s(e.keyCode),r={enter:13},o={},a=["shift","ctrl","alt","cmd"],i=0;a.forEach(function(e){o[e]={wanted:!1,pressed:!1}}),e.shiftKey&&(o.shift.pressed=!0),e.ctrlKey&&(o.ctrl.pressed=!0),e.altKey&&(o.alt.pressed=!0),e.metaKey&&(o.cmd.pressed=!0);for(var u=0;u<t.length;u++){var d=t[u];a.indexOf(d)>-1?(i++,o[d].wanted=!0):(d.length>1&&r[d]===e.keyCode||n===d)&&i++}return t.length===i&&Object.keys(o).reduce(function(e,t){return e&&o[t].wanted===o[t].pressed},!0)}function s(e){switch(e){case 91:case 93:return"MetaKey";case 188:return",";case 190:return".";case 219:return"[";case 221:return"]";default:return String.fromCharCode(e).toLowerCase()}}function u(e){return e.toLowerCase().replace(/\s/g,"")}function d(e,t){if(e){for(var n in t)void 0===e[n]&&(e[n]=t[n]);return e}return t}Object.defineProperty(t,"__esModule",{value:!0}),t.unbindKeys=t.bindKeys=void 0;var l=n(6),c=function(e){return e&&e.__esModule?e:{default:e}}(l),f={};t.bindKeys=r,t.unbindKeys=o},function(e,t,n){"use strict";function r(e){return e&&e.__esModule?e:{default:e}}Object.defineProperty(t,"__esModule",{value:!0});var o=n(9);Object.defineProperty(t,"default",{enumerable:!0,get:function(){return r(o).default}})},function(e,t,n){"use strict";function r(e){if(Array.isArray(e)){for(var t=0,n=Array(e.length);t<e.length;t++)n[t]=e[t];return n}return Array.from(e)}function o(){var e=this,t=document.head||document.getElementsByTagName("head")[0],n=document.createElement("style");n.type="text/css",n.appendChild(document.createTextNode("::selection { background: transparent; }")),w.forEach(function(r){function o(){function r(){function a(){e.selectionStart=o,e.selectionEnd=i,t.removeChild(n)}t.appendChild(n),setTimeout(a,10),(0,y.unbindKeys)(g,r,{target:e})}var o=e.selectionStart,i=e.selectionEnd,g=["Cmd+Z","Ctrl+Z"];if("inline"!==s||-1===e.value.substring(o,i).indexOf("\n")){var h=d({name:a,pattern:u,text:e.value,start:o,end:i,isConsequent:!0});console.log(h),h.isWrapped?m({name:a,pattern:u,elem:e,start:o,end:i,parsed:h,prefix:l,nextPrefix:c,suffix:f}):p({name:a,pattern:u,elem:e,start:o,end:i,parsed:h,prefix:l,nextPrefix:c,suffix:f}),(0,y.bindKeys)(g,r,{target:e}),$(e).on("input",function(){(0,y.unbindKeys)(g,r,{target:e})})}}var a=r.name,i=r.keys,s=r.type,u=r.regexp,d=r.parse,l=r.prefix,c=r.nextPrefix,f=r.suffix,p=r.wrap,m=r.unwrap;(0,y.bindKeys)(i,o,{target:e,prevent:!0})})}function a(e){var t=e.elem,n=e.text,r=e.start,o=e.end,a=e.nextStart,i=e.nextEnd;t.selectionStart=r,t.selectionEnd=o,document.execCommand("insertText",!1,n),$(t).trigger("input"),t.selectionStart=a,t.selectionEnd=i}function i(e){var t=e.pattern,n=e.text,r=e.start,o=e.end,a=e.isConsequent,i=g({text:n,start:r,end:o}),s=i.value,u=i.start,d=m({text:s,start:r-u,end:o-u,pattern:t,isConsequent:a});if(!d)return{isWrapped:!1};var l=d.value.split(d.unwrappedValue);return v({},d,{isWrapped:!0,realStart:d.start+u,realEnd:d.end+u,prefixLength:l[0].length,suffixLength:l[1].length})}function s(e){var t=e.elem,n=e.start,r=e.end,o=e.prefix,i=e.suffix,s=h({elem:t,start:n,end:r});a({elem:t,text:""+o+s.value+i,start:s.start,end:s.end,nextStart:n+o.length,nextEnd:r+o.length})}function u(e){var t=e.elem,n=e.start,r=e.end,o=e.parsed,i=o.realStart,s=o.realEnd,u=o.unwrappedValue,d=o.prefixLength,l=o.suffixLength;if(!u.length)return void a({elem:t,text:u,start:i,end:s,nextStart:i,nextEnd:i});var c=i+d,f=s-l,p=n-c,m=r-f;p<0&&(m-=p,p=0),m>0&&(m=0),a({elem:t,text:u,start:i,end:s,nextStart:i+p,nextEnd:i+u.length+m})}function d(e){var t=e.elem,n=e.start,r=e.end,o=e.prefix,i=e.suffix,s=h({elem:t,start:n,end:r}),u=s.value,d=void 0;s.value?S.test(s.value)?(u=""+o+s.value+" "+i,d=s.end+o.length+1):(u=o+" "+s.value+i,d=s.start+o.length):(u=o+" "+i,d=n+o.length),a({elem:t,text:u,start:s.start,end:s.end,nextStart:d,nextEnd:d})}function l(e){var t=e.elem,n=e.start,r=e.end,o=e.parsed,a=o.realStart,i=o.unwrappedValue,s=o.prefixLength,d=i.split(" "),l=a+s;d.length>1&&S.test(d[0])?(t.selectionStart=l,t.selectionEnd=l+d[0].length):u({elem:t,start:n,end:r,parsed:o})}function c(e){var t=e.text,n=e.start,o=e.end,a=e.pattern,i=w.filter(function(e){return"block"===e.type}),s=t.split("\n").reduce(function(e,t){var s=e.lastIndex,u=s+t.length;if(!(s<=n&&u>=n||s>=n&&u<=o||s<=o&&u>=o))return v({},e,{lastIndex:u+1});var d=i.reduce(function(e,n){if(e)return e;n.regexp.lastIndex=0;var r=n.regexp.exec(t);if(r){var o=r[0],a=r[1],i=r.index,u=r.index+o.length;return{value:o,wrappedBy:n.name,unwrappedValue:a,prefixLength:o.length-a.length,start:i+s,end:u+s}}},null),l=d||{value:t,start:s,end:u};return a.lastIndex=0,{lines:[].concat(r(e.lines),[l]),lastIndex:u+1,isWrapped:e.isWrapped&&a.test(l.value)}},{lines:[],lastIndex:0,isWrapped:!0});return delete s.lastIndex,s}function f(e){var t=e.elem,n=e.start,o=e.end,i=e.prefix,s=e.pattern,u=e.nextPrefix,d=e.parsed.lines,l=d.reduce(function(e,t){var n=""+i+t.value;return s.lastIndex=0,s.test(t.value)&&u?n=""+u+t.value:t.unwrappedValue&&(n=""+i+t.unwrappedValue),[].concat(r(e),[n])},[]).join("\n"),c=d[0].start,f=d[d.length-1].end,p=n-c,m=o-f;m<c-f&&(m+=c-f-m);var g=c,h=c+l.length;a({elem:t,text:l,start:c,end:f,nextStart:g+p+i.length,nextEnd:h+m})}function p(e){var t=e.elem,n=e.start,o=e.end,i=e.pattern,s=e.parsed.lines,u=s.reduce(function(e,t){return i.lastIndex=0,[].concat(r(e),[i.test(t.value)?t.unwrappedValue:t.value])},[]).join("\n"),d=s[0].start,l=s[s.length-1].end,c=d+s[0].prefixLength,f=l,p=n-c,m=o-f;p<0&&(p=0),m<c-f&&(m+=c-f-m),a({elem:t,text:u,start:d,end:l,nextStart:d+p,nextEnd:d+u.length+m})}function m(e){var t=e.text,n=e.start,r=e.end,o=e.pattern,a=e.isConsequent,i=void 0,s=[];for(console.log(t,n,r),o.lastIndex=0;null!==(i=o.exec(t));){console.log(i);var u=i[0],d=i[1],l=i.index,c=i.index+u.length;l<=n&&c>=r&&s.push({value:u,unwrappedValue:d,start:l,end:c}),a&&(o.lastIndex=i.index+1)}return s.length?(s.sort(function(e,t){return e.value.length-t.value.length}),s[0]):null}function g(e){var t=e.text,n=e.start,r=e.end;for(n-=1;"\n"!==t[n]&&n>0;)n--;for(0!==n&&n++;"\n"!==t[r]&&r<t.length;)r++;return{value:t.substring(n,r),start:n,end:r}}function h(e){var t=e.elem,n=e.start,r=e.end,o=n,a=r,i=t.value.substr(n,r-n);if(n===r){var s=g({text:t.value,start:n,end:r}),u=s.value,d=s.start,l=m({text:u,start:n-d,end:r-d,pattern:/[^\s]+/g});l&&(o=l.start+d,a=l.end+d,i=l.value)}return{start:o,end:a,value:i}}Object.defineProperty(t,"__esModule",{value:!0});var v=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e},y=n(7),b={type:"inline",parse:i,wrap:s,unwrap:u},x={type:"block",parse:c,wrap:f,unwrap:p},w=[v({},b,{name:"bold",keys:"Cmd+B",regexp:/\*\*([^\s]{0,2}|[^\s].*?[^\s])\*\*/g,prefix:"**",suffix:"**"}),v({},b,{name:"italic",keys:"Cmd+I",regexp:/\/\/([^\s]{0,2}|[^\s].*?[^\s])\/\//g,prefix:"//",suffix:"//"}),v({},b,{name:"link",keys:"Cmd+K",regexp:/\(\(\s*(.*?)\s*\)\)/g,prefix:"((",suffix:"))",wrap:d,unwrap:l}),v({},x,{name:"header",keys:"Cmd+Alt+1",regexp:/^[^\S\n]*#[^\S\n]*([^#].*)$/g,prefix:"# "}),v({},x,{name:"subheader",keys:"Cmd+Alt+2",regexp:/^[^\S\n]*##[^\S\n]*([^#].*)$/g,prefix:"## "}),v({},x,{name:"remove headers",keys:"Cmd+Alt+0",regexp:/^[^\S\n]*#{1,2}[^\S\n]*([^#].*)$/g,wrap:p}),v({},x,{name:"increase quote level",keys:"Cmd+]",regexp:/^[^\S\n]*>[^\S\n]*(.*)$/g,prefix:"> ",nextPrefix:">",unwrap:f}),v({},x,{name:"decrease quote level",keys:"Cmd+[",regexp:/^[^\S\n]*>[^\S\n]*(.*)$/g,prefix:"> ",wrap:function(){}})],S=/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=+$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=+$,\w]+@)[A-Za-z0-9.-]+)((?:\/[+~%\/.\w-_]*)?\??(?:[-+=&;%@.\w_]*)#?(?:[.!\/\\\w]*))?)/;t.default=o},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=function(){var e={};return function(t){if(t){var n=t.getAttribute("data-swing-id");n||(n="swing-"+Math.floor(1e5*Math.random()),t.setAttribute("data-swing-id",n)),e[n]&&clearTimeout(e[n]);var r=0;!function t(o){var a=(1/(Math.pow(r,1.25)/20+.5)-.05)*Math.sin(r/2);o.style.transform="translateX("+(0+100*a)+"px)",r++,r<82?e[n]=setTimeout(t.bind(null,o),14):o.style.transform="translateX(0px)"}(t)}}}();t.default=r},,,function(e,t,n){"use strict";function r(e){return e&&e.__esModule?e:{default:e}}var o="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e},a=n(1),i=n(14),s=r(i),u=n(15),d=r(u),l=n(10),c=r(l),f=n(6),p=r(f),m=n(8),g=r(m),h=n(16),v=r(h),y=n(2),b=r(y),x=n(0),w=r(x),S=n(4),_=r(S),E=n(17),C=r(E),j=n(19),M=r(j),k=n(20),I=r(k);"undefined"!=typeof $&&$(function(){(0,M.default)(),(0,v.default)(),function(){$("#text").each(g.default);var e=$();if($(document).on("mouseover","a[href]",function(){var t=$(this),n=t.attr("href");n&&"#"!==n&&!n.match(/^javascript:/)&&(e=$('a[href="'+n+'"]').addClass("hover"))}).on("mouseout","a[href]",function(t){if("object"===(void 0===t?"undefined":o(t))&&"object"===o(t.currentTarget)&&"object"===o(t.relatedTarget)&&$(t.currentTarget).find(t.relatedTarget).length>0)return!0;e.removeClass("hover"),e=$()}),$("a[linkredir]").each(function(){var e=$(this);e.attr("href",e.attr("linkredir")+e.attr("href")),e.removeAttr("linkredir")}),$("#e2-login-sheet").length){var t=$("#e2-visual-login"),n=$("#e2-login-sheet"),r=n.find("#form-login"),i=r.find("#e2-password"),u=r.find(".e2-login-window-password-checking"),l=!1;i.focus(),r.on("submit",function(e){if(l)return!0;e.preventDefault(),r.find(".input-disableable").prop("disabled",!0),i.blur(),(0,_.default)(u,1),u.fadeIn(333);var t=(0,b.default)({url:$("#e2-check-password-action").attr("href"),data:{password:i.val()},success:function(e){if(r.find(".input-disableable").prop("disabled",!1),void 0===e.data||void 0===e.data["password-correct"])return(0,_.default)(u,0),u.fadeOut(333),(0,w.default)({message:"er--js-server-error",debug:{message:"Server response malformed",data:{response:e}}}),!1;e.data["password-correct"]?((0,_.default)(u,0),u.hide(),$("#password-correct").fadeIn(333,function(){l=!0,r.submit()})):((0,_.default)(u,0),u.fadeOut(333),i.focus(),(0,c.default)($("#e2-login-window")[0]))},error:function(){r.find(".input-disableable").prop("disabled",!1),(0,_.default)(u,0),u.fadeOut(333)},abort:function(){r.find(".input-disableable").prop("disabled",!1),(0,_.default)(u,0),u.fadeOut(333)}});return r.data("formLoginAjaxRequest",t),!1}),n.on("E2_SHOW_LOGIN_SHEET",function(){n.addClass("e2-show"),setTimeout(function(){i.focus()},100),t.addClass("e2-visual-login_hidden")}).on("E2_HIDE_LOGIN_SHEET",function(){if(!n.hasClass("e2-hideable"))return!1;i.blur(),n.removeClass("e2-show"),"object"===o(r.data("formLoginAjaxRequest"))&&r.data("formLoginAjaxRequest").abort(),t.removeClass("e2-visual-login_hidden")}),n.on("click",function(e){e.target===this&&$("#e2-login-sheet").trigger("E2_HIDE_LOGIN_SHEET")}),t.length&&($(document).on("mousemove",function(e){var n=t.offset(),r=n.left,o=n.top,a=e.pageX,i=e.pageY,s=Math.pow(Math.pow(a-r,2)+Math.pow(i-o,2),.5);s=Math.max(Math.min(s,600),100),s=(s-100)/500,t.css("opacity",.25+.75*(1-s))}),t.on("click",function(e){return e.preventDefault(),n.trigger("E2_SHOW_LOGIN_SHEET"),!1}))}if($("#e2-subscribe-sheet").length&&$("#e2-note-subscribe-button").length){var f=$("#e2-note-subscribe-button");$("#e2-subscribe-sheet").on("E2_SHOW_SUBSCRIBE_SHEET",function(){$(this).addClass("e2-show")}).on("E2_HIDE_SUBSCRIBE_SHEET",function(){$(this).removeClass("e2-show")}).on("click",function(e){e.target===this&&$("#e2-subscribe-sheet").trigger("E2_HIDE_SUBSCRIBE_SHEET")}),f.addClass("e2-note-subscribe-button-visible").on("click",function(e){return e.preventDefault(),$("#e2-subscribe-sheet").trigger("E2_SHOW_SUBSCRIBE_SHEET"),!1})}if($("#e2-search").length){var m=$("#e2-search"),h=function(){function e(e,t){void 0===t&&(t=e,e=null);var n=document.head||document.getElementsByTagName("head")[0];if(e){var r=document.getElementById(e);r?r.innerHTML=t:(r=document.createElement("style"),r.id=e,r.innerHTML=t,n.appendChild(r))}else{var o=document.createElement("style");o.innerHTML=t,n.appendChild(o)}}function t(t,n){var r=t.get(0).getBoundingClientRect().left,o=void 0;o=t.hasClass("search-field-left-anchored")?$(window).width()-r:r,o<n?e("search-field__input",".search-field { --searchFieldMaxWidth: "+o+"px; }"):e("search-field__input",".search-field { --searchFieldMaxWidth: "+n+"px; } .search-field__input { max-width: "+o+"px; }"),s.default.run()}var n=$(".search-field");if(n.length){var r=s.default.ratifiedVars?parseInt(s.default.ratifiedVars["--searchFieldMaxWidth"],10):parseInt(window.getComputedStyle(n.get(0)).getPropertyValue("--searchFieldMaxWidth"),10);t(n,r),$(window).on("resize",t.bind(null,n,r))}};s.default.run(h),m.on("submit",function(){if(/^ *$/.test($("#query").val()))return!1});var v=m.find(".search-field__input"),y=m.find(".search-field__zoom-icon"),x=m.find(".search-field__tags-icon");v.on("focusin",function(){v.addClass("search-field__input_focused"),y.addClass("search-field__zoom-icon_focused")}).on("focusout",function(e){$(e.relatedTarget).hasClass("search-field__tags-icon")||x.length&&x.is(":active")||(y.removeClass("search-field__zoom-icon_focused"),v.removeClass("search-field__input_focused"))}),y.on("click",function(){v.focus()})}$(document).on("keydown keyup keypress",function(e){if(13===e.which){var t=e.target||e.srcElement;if(t&&t.form){var n=$(t.form);if(n.hasClass("e2-enterable"))return;if(!e.ctrlKey&&$(t).is("textarea"))return;return e.preventDefault(),e.ctrlKey&&"keydown"===e.type&&n.find("#submit-button").length&&!n.find("#submit-button").is(":disabled")&&n.submit(),!1}}}),$(document).on("keyup",function(e){if(27===e.which&&($("#e2-subscribe-sheet").trigger("E2_HIDE_SUBSCRIBE_SHEET"),$("#e2-login-sheet").trigger("E2_HIDE_LOGIN_SHEET")),69===e.which&&e.altKey){var t=$(".e2-edit-link");t.length&&(window.location.href=t.eq(0).attr("href"))}var n=e.target.nodeName.toLowerCase();if("input"!==n&&"textarea"!==n&&"select"!==n&&"option"!==n&&"button"!==n&&(void 0===$(e.target).attr("contenteditable")||"false"===$(e.target).attr("contenteditable"))&&(p.default.mac&&e.altKey&&!e.shiftKey||!p.default.mac&&e.ctrlKey)){var r;switch(e.which){case 37:r=$("#link-prev").attr("href");break;case 39:r=$("#link-next").attr("href");break;case 38:r=$("#link-later").attr("href");break;case 40:r=$("#link-earlier").attr("href")}r&&(window.location.href=r,window.event&&(window.event.returnValue=!1),e.preventDefault&&e.preventDefault())}}),$(".e2-textarea-autosize").each(I.default);var S=$(".e2-note");if(S.length&&a.isLocalStorageAvailable){var E=$("#e2-note-read-href").attr("href"),C=function(e){var t=e.$note,n=e.endpointSuffix,r=t.find("h1 a"),o=t.attr("id").replace("e2-note-",""),a=r.length?r.attr("href"):window.location.origin+window.location.pathname,i=a+n;(0,d.default)({noteId:o,endpointUrl:i})};S.map(function(e,t){var n=$(t);n.find(".e2-published").length&&C({$note:n,endpointSuffix:E})})}}(),(0,C.default)()})},function(e,t,n){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var r=function(){function e(e,t){var n=[],r=!0,o=!1,a=void 0;try{for(var i,s=e[Symbol.iterator]();!(r=(i=s.next()).done)&&(n.push(i.value),!t||n.length!==t);r=!0);}catch(e){o=!0,a=e}finally{try{!r&&s.return&&s.return()}finally{if(o)throw a}}return n}return function(t,n){if(Array.isArray(t))return t;if(Symbol.iterator in Object(t))return e(t,n);throw new TypeError("Invalid attempt to destructure non-iterable instance")}}(),o={run:function(e){if(window.CSS&&window.CSS.supports&&window.CSS.supports("(--foo: red)"))return void(e&&e());o.cb=e,o.ratifiedVars={},o.varsByBlock={},o.oldCSS={},o.findCSS(),o.updateCSS()},findCSS:function(){var e=document.querySelectorAll('style:not([id*="inserted"]), link[type="text/css"], link[rel="stylesheet"]');o.processedStyles=e.length;var t=1;[].forEach.call(e,function(e){var n=void 0;"STYLE"===e.nodeName?(n=e.innerHTML,o.findSetters(n,t),o.processedStyles--):"LINK"===e.nodeName&&(o.getLink(e.getAttribute("href"),t,function(e,t){var n=t.responseText;o.findSetters(n,e),o.oldCSS[e]=n,o.updateCSS(),!--o.processedStyles&&o.cb&&o.cb()}),n=""),o.oldCSS[t]=n,t++})},findSetters:function(e,t){o.varsByBlock[t]=e.match(/(?!var)--[a-zA-Z0-9\-]+:(\s?)(.+?)[;}]/gim)},updateCSS:function(){o.ratifySetters(o.varsByBlock);for(var e in o.oldCSS){var t=o.replaceGetters(o.oldCSS[e],o.ratifiedVars);if(document.querySelector("#inserted"+e))document.querySelector("#inserted"+e).innerHTML=t;else{var n=document.createElement("style");n.innerHTML=t,n.id="inserted"+e,document.getElementsByTagName("head")[0].appendChild(n)}}},replaceGetters:function(e,t){for(var n in t){var r=new RegExp("var\\(\\s*?"+n.trim()+"(\\)|,([\\s\\,\\w]*\\)))","g");e=e.replace(r,t[n])}for(var o=/var\(\s*?([^)^,\.]*)(?:[\s\,])*([^)\.]*)\)/g,a=o.exec(e);a;)e=e.replace(a[0],a[2]),a=o.exec(e);return e},ratifySetters:function(e){for(var t in e)e[t].forEach(function(e){e=e.replace(/[{;]/g,"");var t=e.split(/:\s*/),n=r(t,2),a=n[0],i=n[1];o.ratifiedVars[a]=i})},getLink:function(e,t,n){var r=new XMLHttpRequest;r.open("GET",e,!0),r.overrideMimeType("text/css"),r.onload=function(){r.status>=200&&r.status<400?n(t,r,e):console.warn("error was returned from:",e)},r.onerror=function(){console.warn("cant get css from:",e)},r.send()}};t.default=o},function(e,t,n){"use strict";function r(e){function t(e){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:2,r=new XMLHttpRequest;r.open("GET",u),r.onreadystatechange=function(){r.readyState===XMLHttpRequest.DONE&&(200!==r.status?setTimeout(function(){t(e,n+2)},1e3*n):e())},r.send()}function n(){var e=JSON.parse(o.localStorage.getItem(a)||"[]");e.push(r),o.localStorage.setItem(a,JSON.stringify(e))}var r=e.noteId,u=e.endpointUrl;if(o.isLocalStorageAvailable){if(-1===JSON.parse(o.localStorage.getItem(a)||"[]").indexOf(r))var d=0,l=setInterval(function(){s&&r===document.e2.currentNoteId&&++d>=i&&(clearInterval(l),t(n))},1e3)}}Object.defineProperty(t,"__esModule",{value:!0});var o=n(1),a="read-info",i=1,s=!0;window.addEventListener("focus",function(){return s=!0}),window.addEventListener("blur",function(){return s=!1}),t.default=r},function(e,t,n){"use strict";function r(){var e=document.title;$("input.e2-smart-title").on("input",function(){this.value?document.title=this.value:e&&(document.title=e)});var t=function(){var t,n=$(window).scrollTop(),r=e;n>0&&$(".e2-smart-title").each(function(){return!($(this).position().top>n+window.innerHeight)&&(r=$(this).text(),t=$(this).closest(".e2-note").attr("id").replace("e2-note-",""),!($(this).position().top>n)&&void 0)}),document.title=r,document.e2.currentNoteId=t};$(".e2-smart-title").length>1?($(window).on("scroll resize",t),t()):1===$(".e2-smart-title:not(input)").length&&(document.e2.currentNoteId=$(".e2-smart-title:not(input)").closest(".e2-note").attr("id").replace("e2-note-",""))}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r},function(e,t,n){"use strict";function r(){var e=function(e){if(e.length){var t=(0,a.default)(),n=e.find(".e2-popup-menu-widget"),r=function(){e.removeClass("e2-popup-menu_open"),e.removeClass("e2-popup-menu_visible"),e.removeClass("e2-popup-menu_widgetfrombottom"),e.removeClass("e2-popup-menu_widgetfromright"),$(document).off("click.e2-popup-menu_open-"+t)},o=function(){$(document).on("click.e2-popup-menu_open-"+t,function(t){t.target!==e[0]&&0===e.has(t.target).length&&r()}),e.addClass("e2-popup-menu_open"),e.offset().top+n.position().top+n.outerHeight()>Math.max($("html").outerHeight(),$(window).outerHeight())&&e.addClass("e2-popup-menu_widgetfrombottom"),e.offset().left+n.position().left+n.outerWidth()>$(window).outerWidth()&&e.addClass("e2-popup-menu_widgetfromright"),e.addClass("e2-popup-menu_visible")};e.find(".e2-popup-menu-button").on("click.e2-popup-menu_open-"+t,function(){e.hasClass("e2-popup-menu_open")?r():o()}),e.find(".e2-popup-menu-widget-item").on("click",function(){if("do-not-close-popup-menu"===$(this).data("e2-popup-menu-action"))return!0;r()})}};$(".e2-popup-menu").each(function(){e($(this))}),$(document).on("E2_ADMIN_ITEM_WITH_POPUP_MENU_INIT",function(t,n){!n.$popupMenu instanceof jQuery||e(n.$popupMenu)})}Object.defineProperty(t,"__esModule",{value:!0});var o=n(18),a=function(e){return e&&e.__esModule?e:{default:e}}(o);t.default=r},function(e,t,n){"use strict";function r(){return"xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g,function(e){var t=16*Math.random()|0;return("x"===e?t:3&t|8).toString(16)})}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r},function(e,t,n){"use strict";function r(){function e(){var e=0,t=0,n=0,r=0;"number"==typeof window.innerWidth?(e=window.innerWidth,t=window.innerHeight,n=window.screenY,r=window.screenX):document.documentElement&&(document.documentElement.clientWidth||document.documentElement.clientHeight)?(e=document.documentElement.clientWidth,t=document.documentElement.clientHeight,n=window.screenTop,r=window.screenLeft):document.body&&(document.body.clientWidth||document.body.clientHeight)&&(e=document.body.clientWidth,t=document.body.clientHeight,n=window.screenTop,r=window.screenLeft);var o={};return o.width=e,o.height=t,o.top=n,o.left=r,o}function t(){var e=o.find("#name"),t=o.find("#email"),n=o.find(".e2-gips"),a=o.find("#submit-button"),i=!0,s=n.hasClass("required");e.length&&s&&!e.val()&&(i=!1),t.length&&s&&!r.test(t.val())&&(i=!1),i=i&&$("#text").val(),i?a.prop("disabled",!1):a.prop("disabled",!0)}function n(e,t){var n=new Date((new Date).getTime()+5184e6);document.cookie=e+"="+t+";path=/;expires="+n.toUTCString()}var r=/^([a-z0-9_.-])+@[a-z0-9-]+\.([a-z]{2,11}\.)?[a-z]{2,11}$/i,o=$("#form-comment");o.length&&($(".required").on("input blur cut copy paste keypress",t),t(),o.on("submit",function(){var e=o.find(".e2-gips"),t=o.find("#name"),i=o.find("#email");return n(o.data("cookie"),o.data("cookie-value")),!(e.length&&e.is(":visible")&&e.hasClass("required"))||(!!(e.hasClass("required")&&t.val()&&r.test(i.val()))||((0,a.default)(e[0]),!1))}).show()),$(".e2-email-fields-revealer").on("click",function(e){e.preventDefault(),$(".e2-email-fields").show(),t(),$(this).hide()}),$(".e2-gips a.e2-gip-link").on("click",function(t){t.preventDefault();var n=$(this).attr("href"),r=e(),o=r.left+r.width/2-300,a=r.top+r.height/2-300;o<0&&(o=50),a<0&&(a=50),window.open(n,"gips","left="+o+",top="+a+",width=600,height=600,centerscreen")}),window.oauthAuthorized=function(e){$(".e2-hide-on-login").hide(),$(".e2-gips").removeClass("required"),$(".e2-gip-info").find(".name").text(e.name).end().find(".e2-gip-icon").html(e.gipIcon).end().find(".e2-gip-logout-url").attr("href",e.logoutUrl).end().show(),t()}}Object.defineProperty(t,"__esModule",{value:!0});var o=n(10),a=function(e){return e&&e.__esModule?e:{default:e}}(o);t.default=r},function(e,t,n){"use strict";function r(){$(this).on("input change resize",o),o.call(this)}function o(){var e=this,t=$(e);if(!t.hasClass("e2-textarea-autosize_off")){var n,r=parseInt(e.style.height);if(e.scrollHeight>r)e.style.height=e.scrollHeight+"px";else{var o=t.clone();for(o.css("visibility","hidden").css("position","absolute").css("width",t.width()),t.before(o);parseInt(o[0].scrollHeight)===r;)r-=50,o[0].style.height=r+"px",n=parseInt(o[0].scrollHeight),o[0].style.height=n+"px";o.remove(),e.style.height=n+"px"}t.trigger("autosized")}}Object.defineProperty(t,"__esModule",{value:!0}),t.default=r}])});