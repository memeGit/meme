/*1328512004,169776318*/

if (window.CavalryLogger) { CavalryLogger.start_js(["N0vYn"]); }

function ExplicitHover(a,b){this._container=a;this._className=b;this._eventHandlers=Event.listen(this._container,{mouseover:this._handleMouseOver.bind(this),mouseout:this._handleMouseOut.bind(this)});}ExplicitHover.prototype={uninstall:function(){for(var a in this._eventHandlers)this._eventHandlers[a].remove();},_enter:function(a){if(this._current!==a){this._leave();a&&(this._current=CSS.addClass(a,'hover'));}},_leave:function(){if(this._current){CSS.removeClass(this._current,'hover');this._current=null;}},_handleMouseOver:function(a){this._enter(Parent.byClass(a.getTarget(),this._className));},_handleMouseOut:function(a){!DOM.contains(this._current,a.getRelatedTarget())&&this._leave();}};