/*  BridgeJS 1.1.2
 *  (c) 2010-2011 Nick Stakenburg - http://www.nickstakenburg.com
 *
 *  Bridge is freely distributable under the terms of an MIT-style license.
 *
 *  Adapter API largely based on PrototypeJS (http://www.prototypejs.org)
 *
 *  GitHub: https://github.com/staaky/bridgejs
 */

(function(){window.Bridge||(window.Bridge={});var a=window.Bridge,b={Version:"1.1.2",options:{adapter:"auto",path:!1},Framework:{Prototype:{included:!!window.Prototype&&Prototype.Version,required:"1.7"},jQuery:{included:!!window.jQuery&&jQuery.fn.jquery,required:"1.5"}},insertScript:function(a){try{document.write("<script type='text/javascript' src='"+a+"'></script>")}catch(b){var c=document.head||document.getElementsByTagName("head")[0],d=document.createElement("script");d.type="text/javascript",d.src=a,c.appendChild(d)}},start:function(){function e(a,b){return d(a)>=d(b)}function d(a){var b=a.match(c),d=b&&b[1]&&b[1].split(".")||[],e=0;for(var f=0,g=d.length;f<g;f++)e+=parseInt(d[f]*Math.pow(10,6-f*2));return b&&b[3]?e-1:e}var c=/^(\d+(\.?\d+){0,3})([_-]+[A-Za-z0-9]+)?/;if(a.options)for(var f in a.options)b.options[f]=a.options[f];var g=this.options.adapter=="auto";if(g||!g&&this.Framework[this.options.adapter]&&!this.Framework[this.options.adapter].included){this.options.adapter=null;for(var h in this.Framework){var i=this.Framework[h];i.included&&e(i.included,i.required)&&(this.options.adapter=h)}if(!this.options.adapter||this.options.adapter=="auto"){var j=[];for(h in this.Framework)j.push(h+" >= "+this.Framework[h].required);var k=j.join(", "),l=k.lastIndexOf(", ");l&&(k=k.substring(0,l)+" or "+k.substring(l+2)),alert("BridgeJS requires "+k+" included before bridge.js")}}if(this.options.path)this.path=this.options.path||"",this.path.substr(this.path.length-1)!="/"&&(this.path+="/");else{var m=document.getElementsByTagName("script"),n=/bridge([\w\d-_.]+)?\.js(.*)/;for(var o=0,p=m.length;o<p;o++){var q=m[o];q.src.match(n)&&(this.path=q.src.replace(n,""))}}a.Shared||this.insertScript(this.path+"adapters/shared.js"),a.$||this.insertScript(this.path+"adapters/"+this.options.adapter.toLowerCase()+".js")}};for(var c in b)a[c]=b[c];a.start()})();