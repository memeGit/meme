var cookieOption = {
    path: "/"
};
var headerNavFixedOffset = 52;
var topMargin = 20 + headerNavFixedOffset;
var GAG = {};
GAG.Foo = function() {};
GAG.GA = {
    track: function(b, d, a, c) {
        try {
            if (c == undefined) {
                c = 1
            }
            _gaq.push(["_trackEvent", b, d, a, c])
        } catch(f) {}
    }
};
GAG.getProtocol = function() {
    return ("https:" == document.location.protocol) ? "https": "http"
};
GAG.getDomain = function() {
    if ($("siteDomain")) {
        return $("siteDomain").get("text")
    }
    return "9gag.com"
};
GAG.getCookieOptions = function() {
    return {
        path: "/",
        duration: 365 * 20
    }
};
GAG.Page = {
    getCsrfToken: function() {
        return $("csrftoken") ? $("csrftoken").get("value") : ""
    },
    getBackUrl: function() {
        var a = "/";
        if ($("backUrl")) {
            a = $("backUrl").get("text")
        }
        if (a == undefined) {
            a = "/"
        }
        return a
    },
    isLanding: function() {
        return $("page-landing") ? true: false
    },
    isPostView: function() {
        return $("page-post") ? true: false
    },
    isNsfwPostView: function() {
        return $("page-nsfw") ? true: false
    },
    isPostSubmitView: function() {
        return $("page-post-item") ? true: false
    }
};
GAG.Log = {
    REPORT_URL: "/others/ql",
    createPayload: function() {
        return {
            user_agent: navigator.userAgent,
            opera: !!window.opera,
            vendor: navigator.vendor,
            platform: navigator.platform
        }
    },
    checkLastSubmission: function(d) {
        var g = "last_err_msg";
        var f = "last_err_ts";
        var b = Cookie.read(f);
        var c = Cookie.read(g);
        var a = (new Date()).getTime();
        if (!b || c != d) {
            Cookie.write(f, a, GAG.getCookieOptions());
            Cookie.write(g, d, GAG.getCookieOptions());
            return true
        }
        return false
    },
    report: function(b) {
        if (!this.checkLastSubmission(b)) {
            return
        }
        var c = this.createPayload();
        c.err = encodeURIComponent(b);
        c.url = window.location.href;
        c.time = (new Date()).toString();
        var d = "";
        if ($("profile-username")) {
            d = $("profile-username").get("text")
        }
        c.username = d;
        var a = new Request({
            method: "post",
            url: this.REPORT_URL,
            data: c,
            onSuccess: function() {}
        }).send()
    },
    getStackTrace: function(g) {
        var l = [];
        var c = false;
        if (g.stack) {
            var m = g.stack.split("\n");
            for (var d = 0,
            f = m.length; d < f; d++) {
                if (m[d].match(/^\s*[A-Za-z0-9\-_\$]+\(/)) {
                    l.push(m[d])
                }
            }
            l.shift();
            c = true
        } else {
            if (window.opera && g.message) {
                var m = g.message.split("\n");
                for (var d = 0,
                f = m.length; d < f; d++) {
                    if (m[d].match(/^\s*[A-Za-z0-9\-_\$]+\(/)) {
                        var j = m[d];
                        if (m[d + 1]) {
                            j += " at " + m[d + 1];
                            d++
                        }
                        l.push(j)
                    }
                }
                l.shift();
                c = true
            }
        }
        if (!c) {
            var b = arguments.callee.caller;
            while (b) {
                var h = b.toString();
                var a = h.substring(h.indexOf("function") + 8, h.indexOf("")) || "anonymous";
                l.push(a);
                b = b.caller
            }
        }
        return l
    }
};
GAG.Ads = {
    adsUrls: ["http://9gag.com/static/ads/list-ads-300x250.html"],
    getAds: function(a) {
        return this.adsUrls[0]
    },
    reloadIframe: function(b) {
        var a = $(b);
        if (a) {
            a.set("src", a.get("src"))
        }
    }
};
GAG.getResponseInstance = function() {
    return new GAG.Response()
};
GAG.Response = function() {};
GAG.Response.prototype = {
    _isSuccess: false,
    _message: "",
    init: function() {},
    isSuccess: function() {
        return this._isSuccess
    },
    succeed: function(a) {
        this._isSuccess = true;
        this.setMessage(a)
    },
    failed: function(a) {
        this._isSuccess = false;
        this.setMessage(a)
    },
    setMessage: function(a) {
        if (a != undefined) {
            this._message = a
        }
    },
    getMessage: function(a) {
        return this._message
    }
};
GAG.Utils = {
    parseJSON: function(a) {
        if (a.substring(0, 8) == "for(;;);") {
            a = a.substring(8)
        }
        return JSON.decode(a)
    },
    getViewPort: function() {
        var b;
        var a;
        if (typeof window.innerWidth != "undefined") {
            b = window.innerWidth,
            a = window.innerHeight
        } else {
            if (typeof document.documentElement != "undefined" && typeof document.documentElement.clientWidth != "undefined" && document.documentElement.clientWidth != 0) {
                b = document.documentElement.clientWidth,
                a = document.documentElement.clientHeight
            } else {
                b = document.getElementsByTagName("body")[0].clientWidth,
                a = document.getElementsByTagName("body")[0].clientHeight
            }
        }
        return {
            width: b,
            height: a
        }
    },
    formatPostLink: function(a) {
        return "http://" + GAG.getDomain() + "/gag/" + a
    }
};
GAG.Validator = {
    isValidLoginKey: function(a) {
        return this.isValidUsername(a) || this.isValidEmail(a)
    },
    isValidUsername: function(a) {
        return a.test("^[0-9a-zA-Z_]{3,15}$")
    },
    isValidEmail: function(a) {
        return a.test("^([a-zA-Z0-9._-]+)@([a-zA-Z0-9.-]+)\\.([a-zA-Z]{2,4})$")
    },
    isValidPassword: function(b, c, a) {
        var d = true;
        if (c != undefined) {
            if (b.length < c) {
                d = false
            }
        }
        if (a != undefined) {
            if (b.length > a) {
                d = false
            }
        }
        if (b.length == 0) {
            d = false
        }
        return d
    },
    isValidGender: function(a) {
        return a == "F" || a == "M"
    },
    MONTH_DAYS: [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
    isValidDateValues: function(c, d, f) {
        var b = c % 400 == 0 || (c % 100 != 0 && c % 4 == 0);
        this.MONTH_DAYS[1] = b ? 29 : 28;
        var e = (f >= 1 && f <= 31) && (d >= 1 && d <= 12) && (c >= 1900);
        var a = f <= this.MONTH_DAYS[d - 1];
        return e && a
    },
    isValidPostLink: function(a) {
        var b = new RegExp("^http(s?)://" + GAG.getDomain() + "/gag/([1-9])([0-9]*)(\\?[^ ]*)?$");
        return a.trim().test(b)
    },
    lookLikeURL: function(a) {
        var b = new RegExp("^http(s?)://");
        return a.trim().test(b)
    }
};
GAG.isReadOnly = function() {
    if ($("readOnlyMode")) {
        return true
    }
    return false
};
GAG.enabledSignUp = function() {
    if (!$("enabledSignUp") || $("enabledSignUp").get("text") == "1") {
        return true
    }
    return false
};
GAG.requiredAccountSetup = function() {
    if ($("requiredAccountSetup")) {
        return true
    }
    return false
};
GAG.newSignupOn = function() {
    if ($("nsuon")) {
        return true
    }
    return false
};
GAG.facebookTimelineOn = function() {
    if ($("fbtlon")) {
        return true
    }
    return false
};
var FV = {
    tick: function(a) {
        a.removeClass("failed").addClass("success")
    },
    cross: function(a) {
        a.removeClass("success").addClass("failed")
    },
    reset: function(a) {
        a.removeClass("success").removeClass("failed")
    },
    isEmpty: function(a) {
        return a.get("value").length == 0
    },
    checkLength: function(b, a) {
        var c = b.get("value");
        if (c.length >= a) {
            FV.tick(b);
            return true
        } else {
            FV.cross(b);
            return false
        }
    },
    checkRequired: function(a) {
        if (a == null) {
            return false
        }
        var b = a.get("value").trim();
        if (b.length >= 1) {
            FV.tick(a);
            return true
        } else {
            FV.cross(a);
            return false
        }
    },
    checkUrl: function(a, c) {
        var b = a.get("value");
        if (c && b.length == 0) {
            FV.reset(a);
            return true
        }
        if (b.toLowerCase().test("^http://")) {
            FV.tick(a);
            return true
        } else {
            FV.cross(a);
            return false
        }
    },
    checkImage: function(a) {
        var b = a.get("value");
        if (b.toLowerCase().test(".(jpeg|jpg|gif|png)$")) {
            FV.tick(a);
            return true
        } else {
            FV.cross(a);
            return false
        }
    },
    checkUsername: function(el, allowEmpty, checkOnEdited) {
        if (!FV.checkLength(el, 3)) {
            return false
        }
        var val = el.get("value");
        if (val.length >= 3) {
            var req = new Request({
                method: "post",
                url: "/member/check",
                data: {
                    field: "u",
                    value: val
                },
                onComplete: function(j, v) {
                    var data = eval("(" + j + ")");
                    if (data.okay) {
                        FV.tick(el)
                    } else {
                        FV.cross(el)
                    }
                }
            }).send();
            return true
        } else {
            FV.cross(el);
            return false
        }
    },
    checkPassword: function(b, c, a) {
        return FV.checkLength(b, 6)
    },
    checkEmailAvailability: function(el) {
        if (!FV.checkEmailFormat(el)) {
            return false
        }
        var val = el.get("value");
        if (val.length > 0) {
            var req = new Request({
                method: "post",
                url: "/member/check",
                data: {
                    field: "e",
                    value: val
                },
                onComplete: function(j, v) {
                    var data = eval("(" + j + ")");
                    if (data.okay) {
                        FV.tick(el)
                    } else {
                        FV.cross(el)
                    }
                }
            }).send();
            return true
        } else {
            FV.cross(el);
            return false
        }
    },
    checkEmailFormat: function(b, d, a) {
        var c = b.get("value");
        if (c.test("^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,4}$")) {
            FV.tick(b);
            return true
        } else {
            FV.cross(b);
            return false
        }
    }
};
var ScrollSpy = new Class({
    Implements: [Options, Events],
    options: {
        min: 0,
        mode: "vertical",
        max: 0,
        referenceElement: null,
        offsetY: 0,
        container: window,
        onEnter: $empty,
        onLeave: $empty,
        onTick: $empty
    },
    initialize: function(a) {
        this.setOptions(a);
        this.container = $(this.options.container);
        this.enters = this.leaves = 0;
        this.max = this.options.max;
        this.referenceElement = this.options.referenceElement;
        if (this.max == 0) {
            var b = this.container.getScrollSize();
            this.max = this.options.mode == "vertical" ? b.y: b.x
        }
        this.addListener()
    },
    addListener: function() {
        this.inside = false;
        this.container.addEvent("scroll",
        function() {
            var a = this.container.getScroll();
            var e = this.options.mode == "vertical" ? a.y: a.x;
            var c = this.container.getScrollSize();
            var d = $(this.referenceElement);
            var f = d.getCoordinates();
            var b = GAG.Utils.getViewPort();
            e += b.height;
            this.options.min = (f.top > c.y ? c.y: f.top) + this.options.offsetY;
            this.options.max = f.bottom + this.options.offsetY;
            if (e >= this.options.min) {
                if (!this.inside) {
                    this.inside = true;
                    this.enters++;
                    this.fireEvent("enter", [a, this.enters])
                }
                this.fireEvent("tick", [a, this.inside, this.enters, this.leaves])
            } else {
                if (this.inside) {
                    this.inside = false;
                    this.leaves++;
                    this.fireEvent("leave", [a, this.leaves])
                }
            }
        }.bind(this))
    }
});
var LazyLoad = new Class({
    Implements: [Options, Events],
    options: {
        range: 200,
        elements: "img",
        container: window,
        mode: "vertical",
        realSrcAttribute: "data-src",
        useFade: true
    },
    initialize: function(a) {
        this.setOptions(a);
        this.container = document.id(this.options.container);
        this.elements = $$(this.options.elements);
        this.largestPosition = 0;
        var b = (this.options.mode == "vertical" ? "y": "x");
        var d = (this.container != window && this.container != document.body ? this.container: "");
        this.elements = this.elements.filter(function(f) {
            if (this.options.useFade) {
                f.setStyle("visibility", "hidden")
            }
            var e = f.getPosition(d)[b];
            if (e < this.container.getSize()[b] + this.options.range) {
                this.loadImage(f);
                return false
            }
            return true
        },
        this);
        var c = function(f) {
            var g = this.container.getScroll()[b];
            if (g > this.largestPosition) {
                this.elements = this.elements.filter(function(e) {
                    if ((g + this.options.range + this.container.getSize()[b]) >= e.getPosition(d)[b]) {
                        this.loadImage(e);
                        return false
                    }
                    return true
                },
                this);
                this.largestPosition = g
            }
            this.fireEvent("scroll");
            if (!this.elements.length) {
                this.container.removeEvent("scroll", c);
                this.fireEvent("complete")
            }
        }.bind(this);
        this.container.addEvent("scroll", c)
    },
    loadImage: function(j) {
        j.setStyle("visibility", "visible");
        var f = j.get("itemType");
        if (f == "list") {
            var e = j.getElement("img");
            if (e) {
                e.set("src", e.get(this.options.realSrcAttribute))
            }
            var a = j.get("data-url");
            var i = encodeURIComponent(j.get("data-url"));
            var h = encodeURIComponent(j.get("data-text"));
            var c = j.get("gagId");
            var g = '<fb:like href="' + i + '?ref=fb" layout="button_count" send="false" show_faces="false" label="List"></fb:like>';
            var b = '<iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?url=' + i + "&amp;text=" + h + '&amp;via=9GAG" style="width:55px; height:20px; " allowTransparency="true" frameborder="0" class="twitter-share-button twitter-count-none"></iframe>';
            var d = '<g:plusone size="medium" count="true" href="' + a + '"></g:plusone>';
            $("list-share-facebook-" + c).set("html", g);
            FB.XFBML.parse(document.getElementById("list-share-facebook-" + c));
            if ($("list-share-twitter-" + c)) {
                $("list-share-twitter-" + c).set("html", b)
            }
            $("list-share-gplus-" + c).set("html", d);
            gapi.plusone.go("list-share-gplus-" + c)
        } else {
            if (f == "related") {
                var e = j.getElement("img");
                if (e) {
                    e.set("src", e.get(this.options.realSrcAttribute))
                }
            }
        }
    }
});
GAG.Ajax = {};
GAG.Effect = {};
GAG.User = {
    _isLoggedIn: false,
    isLoggedIn: function() {
        if (this._isLoggedIn === false) {
            this._isLoggedIn = $("profile-menu")
        }
        return this._isLoggedIn
    }
};
function requiredLogin() {
    var a = window.location;
    if (!$("profile-menu")) {
        if (GAG.newSignupOn()) {
            GAG.Login.loginAndRedirect(GAG.Page.getBackUrl())
        } else {
            GAG.Login.connectFacebook(a)
        }
        return false
    }
    if (GAG.requiredAccountSetup()) {
        GAG.Login.setupAccount(GAG.Page.getBackUrl());
        return false
    }
    return true
}
GAG.Ajax.LoadPage = {
    _isUnlimitedScrollOn: false,
    _isLoading: false,
    _currPage: 1,
    _loadCount: 0,
    _loadCoutMax: 10,
    _onOffCookieKey: "unlimitedScroll",
    _onOffFlagId: "unlimitedScroll",
    _loadButtonId: "more_button",
    _listId: "entry-list-ul",
    init: function() {
        this._isUnlimitedScrollOn = $(this._onOffFlagId) ? true: false;
        var a = Cookie.read(this._onOffCookieKey);
        this._isUnlimitedScrollOn = this._isUnlimitedScrollOn || (a == "1");
        if ($(this._loadButtonId)) {
            this._currPage = parseInt($(this._loadButtonId).get("currPage"), 10)
        }
        this.bindElements()
    },
    enable: function(a) {
        Cookie.write(this._onOffCookieKey, a ? "1": "0", GAG.getCookieOptions())
    },
    isUnlimitedScrollOn: function() {
        return this._isUnlimitedScrollOn
    },
    getMorePostId: function() {
        return $(this._loadButtonId).get("data-more")
    },
    getLoadCountMax: function() {
        if (this._loadCoutMax == null) {}
        return this._loadCoutMax
    },
    loadPage: function(b, e) {
        if (this._loadCount >= this.getLoadCountMax()) {
            return
        }
        if (GAG.Ajax.LoadPage._isLoading) {
            return
        }
       var h = this.getMorePostId();
       if (!h) {
          h=100;
     }
        var g = $(this._loadButtonId).get("list");
        
        GAG.GA.track("InfiniteScrolling", "Loaded-" + g, "Load-" + (this._loadCount + 1), 1);
        GAG.Ads.reloadIframe("sidebar-ads2");
        GAG.Effect.Read.save(true);
        var f = $(this._loadButtonId).get("plink");
        var a = "list";
        GAG.Ajax.LoadPage._isLoading = true;
        GAG.Ajax.LoadPage.showLoading(true);
     //   var c = "/new/json?list=" + g + "&id=" + h;
        var count = 30;
        var begin = 0;
        var c = "/meme/json.php?type=random&&count="+count+"&&begin="+begin;
        var d = new Request.JSON({
            url: c,
            onSuccess: function(q) {
                GAG.Ajax.LoadPage._currPage++;
                $(GAG.Ajax.LoadPage._loadButtonId).set("data-more", q.prevId);
                GAG.Ajax.LoadPage.updateButtons(1, q.prevId);
                GAG.Effect.Read.save();
                var p = "items-wrap-" +h;
                if (a == "list") {
                    var n = "";
                    if (q.items) {
                        for (var m in q.items) {
                            if (!$(m)) {
                                n += q.items[m]
                            }
                        }
                    }
                    var o = new Element("div", {
                        id: p,
                        html: n,
                        style: "display:none"
                    });
                    $(GAG.Ajax.LoadPage._listId).adopt(o);
                    GAG.Social.Facebook.parseElement(p);
                    GAG.Ajax.Vote.bindVoteUpElements("#" + p + " .badge-vote-up", "click", GAG.Ajax.Vote.voteUpEntrySuccessCb, GAG.Ajax.Vote.voteUpEntryFailureCb, GAG.Ajax.Vote.unvoteEntrySuccessCb, GAG.Ajax.Vote.unvoteEntryFailureCb);
                    GAG.Ajax.Vote.bindVoteDownElements("#" + p + " .badge-vote-down", "click", GAG.Ajax.Vote.voteDownEntrySuccessCb, GAG.Ajax.Vote.voteDownEntryFailureCb, GAG.Ajax.Vote.unvoteEntrySuccessCb, GAG.Ajax.Vote.unvoteEntryFailureCb);
                    GAG.Ajax.Report.bindReportLink("#" + p + " .report-item", "click");
                   // FB.Share._onFirst();
                    var j = o.getElements("li.entry-item");
                    if (j) {
                        for (var l = 0; l < j.length; l++) {
                            $(GAG.Ajax.LoadPage._listId).adopt(j[l])
                        }
                    }
                    o.dispose()
                }
                GAG.Ajax.LoadPage._isLoading = false
            },
            onFailure: function(i) {
                GAG.Ajax.LoadPage._isLoading = false;
                GAG.Ajax.LoadPage.showLoading(false)
            }
        }).post()
    },
    updateButtons: function(d, c) {
        this._loadCount += d;
        var a = $("next_button");
        var b = $("more_button");
        if (c == 0) {
            a.set("href", "/" + a.get("list"))
        } else {
            a.set("href", "/" + a.get("list") + "/id/" + c)
        }
        a.set("data-more", c);
        if (c == 0) {
            b.setStyle("display", "none");
            $("more_img").setStyle("display", "none");
            a.set("text", "Start Over").setStyle("display", "")
        } else {
            if (this._loadCount >= this.getLoadCountMax()) {
                b.setStyle("display", "none");
                $("more_img").setStyle("display", "none");
                a.setStyle("display", "")
            } else {
                this.showLoading(false)
            }
        }
    },
    showLoading: function(a) {
        if (a) {
            $("more_button").setStyle("display", "none");
            $("more_img").setStyle("display", "")
        } else {
            $("more_img").setStyle("display", "none");
            $("more_button").setStyle("display", "")
        }
    },
    bindFooterEvent: function() {
        if (!$("more_button")) {
            return
        }
        var b = this.getLoadCountMax();
        if (this._loadCount >= b) {
            return
        }
        var a = new ScrollSpy({
            referenceElement: "footer",
            offsetY: -800,
            onEnter: function(c) {
                GAG.Ajax.LoadPage.loadPage()
            },
            onLeave: function(c) {}
        })
    },
    bindLoadButton: function() {
        if (!$("more_button")) {
            return
        }
        $("more_button").addEvent("click",
        function(a) {
            if (a) {
                a.preventDefault()
            }
            GAG.Ajax.LoadPage.loadPage()
        })
    },
    bindOnOffToggler: function() {
        $$(".badge-unlimited-scroll-toggler").addEvent("click",
        function(a) {
            a.preventDefault();
            GAG.Ajax.LoadPage.enable(!GAG.Ajax.LoadPage._isUnlimitedScrollOn);
            window.location.reload()
        })
    },
    bindScrollBackButtons: function() {
        $$(".badge-back-to-top").addEvent("click",
        function(a) {
            a.preventDefault();
            GAG.Effect.Scroll.scrollToTop()
        })
    },
    bindElements: function() {
        this.bindOnOffToggler();
        this.bindScrollBackButtons();
        if (this.isUnlimitedScrollOn()) {
            this.bindLoadButton();
            this.bindFooterEvent()
        }
    }
};
GAG.Effect.CountDown = {
    pad: function(b, a) {
        if (a == undefined) {
            a = "0"
        }
        return b < 10 ? a + "" + b: b
    },
    convertTime: function(g) {
        var f = 0;
        var c = 0;
        var a = 0;
        var b = 0;
        if (g < 0) {
            g = 0
        }
        f = parseInt(g / 86400);
        g -= f * 86400;
        c = parseInt(g / 3600);
        g -= c * 3600;
        a = parseInt(g / 60);
        g -= a * 60;
        b = g;
        var e = "";
        if (f > 0) {
            e += this.pad(f) + ":"
        }
        e += this.pad(c) + ":";
        e += this.pad(a) + ":";
        e += this.pad(b);
        return e
    },
    updateDisplay: function(c) {
        var d = c.get("timestamp");
        var b = Math.round((new Date()).getTime() / 1000);
        var e = c.get("start");
        if (e == null) {
            e = b;
            c.set("start", e)
        }
        var a = b - e;
        c.set("text", this.convertTime(d - a))
    },
    updateAll: function() {
        $$(".badge-countdown").each(function(b, a) {
            GAG.Effect.CountDown.updateDisplay($(b))
        })
    },
    bindElements: function() {
        var a = $$(".badge-countdown");
        if (a.length > 0) {
            GAG.Effect.CountDown.updateAll();
            setInterval("GAG.Effect.CountDown.updateAll();", 1000)
        }
    }
};
GAG.Effect.Scroll = {
    _checker: null,
    _checkInterval: 2000,
    _lastScrollY: 0,
    _stickyItems: null,
    monitor: function() {
        if (this._checker == null) {
            this._checker = setInterval("GAG.Effect.Scroll.positionCheck();", this._checkInterval)
        }
    },
    positionCheck: function() {
        var a = $(window).getScrollSize();
        if (this._lastScrollY != a.y) {
            this._lastScrollY = a.y;
            this.initElementsData(true);
            this.checkStickyMenu()
        }
    },
    getStickyItems: function(a) {
        if (!this._stickyItems || a) {
            this._stickyItems = $$("div.sticky-items")
        }
        return this._stickyItems
    },
    _itemsData: {},
    initElementsData: function(a) {
        if (!this.isStickyMenuSupported) {
            return
        }
        this.monitor();
        if (!window.isBindScroll || a) {
            var g = this.getStickyItems(true);
            for (var f = g.length - 1; f >= 0; f--) {
                var n = g[f];
                $(n).setStyle("position", "");
                var h = $(n).getPosition();
                var j = $(n).getCoordinates();
                var e = 80;
                var m = 40;
                var c = $(n).getParent().getPrevious().getCoordinates().height;
                var b = f < g.length - 1 ? (g[f + 1]).getPosition() : {
                    x: 0,
                    y: h.y + c + e - m
                };
                var l = $(n).get("id");
                var d = {};
                d["data-x"] = h.x;
                d["data-y"] = h.y;
                d["data-width"] = j.width;
                d["data-height"] = j.height;
                d["data-y1"] = h.y;
                d["data-y2"] = b.y - j.height - e;
                d["data-y3"] = b.y - e;
                d["entry-id"] = l.split("-").getLast();
                this._itemsData[l] = d
            }
            GAG.Effect.Read.init();
            window.isBindScroll = true
        }
    },
    checkStickyMenu: function() {
        if (this.isStickyMenuSupported && window.onloaded) {
            GAG.Effect.Scroll.initElementsData();
            var a = $(window).getScroll();
            var b = this.getStickyItems();
            var d = (new Date()).getTime();
            this.getStickyItems().each(function(s, g) {
                var r = $(s).get("id");
                var f = GAG.Effect.Scroll._itemsData[r];
                if (f) {
                    var o = parseInt(f["data-x"], 10);
                    var m = parseInt(f["data-y"], 10);
                    var p = parseInt(f["data-y1"], 10);
                    var n = parseInt(f["data-y2"], 10);
                    var j = parseInt(f["data-y3"], 10)
                } else {
                    var o = parseInt($(s).get("data-x"), 10);
                    var m = parseInt($(s).get("data-y"), 10);
                    var p = parseInt($(s).get("data-y1"), 10);
                    var n = parseInt($(s).get("data-y2"), 10);
                    var j = parseInt($(s).get("data-y3"), 10)
                }
                var h = 72;
                var q = a.y + h;
                var l = $(s).getStyle("position");
                var i;
                if (q > p && q <= n) {
                    i = {
                        top: h,
                        left: o - a.x
                    };
                    if (i != "fixed") {
                        i.position = "fixed"
                    }
                    $(s).setStyles(i)
                } else {
                    if (q > n && q <= j) {
                        var e = q - n;
                        i = {
                            top: h - e,
                            left: o - a.x
                        };
                        if (i != "fixed") {
                            i.position = "fixed"
                        }
                        $(s).setStyles(i)
                    } else {
                        if (l != "static" && l != "") {
                            $(s).setStyles({
                                position: "",
                                top: m,
                                left: o
                            })
                        }
                    }
                }
            });
            var c = (new Date()).getTime()
        }
    },
    _isFormMessageShown: null,
    isFormMessageShown: function() {
        if (this._isFormMessageShown == null) {
            this._isFormMessageShown = $$("p.form-message:not(.hide)").length > 0
        }
        return this._isFormMessageShown
    },
    isStickyMenuSupported: (Browser.Platform.mac || Browser.Platform.win || Browser.Platform.linux || Browser.Platform.webos) && (Browser.chrome || Browser.firefox || Browser.safari || Browser.ie || Browser.opera),
    elements: {
        searchbarHeight: 68,
        postControlBarTop: 120,
        headerbarSignupTop: 70,
        formMessageOffset: 64
    },
    checkNavSignupButton: function() {
        var b = this.getHeaderBarSignupTop();
        var a = $("headbar-signup-button");
        if (window.XMLHttpRequest && a) {
            if (document.documentElement.scrollTop > b || self.pageYOffset > b) {
                a.style.display = "block"
            } else {
                if (document.documentElement.scrollTop < b || self.pageYOffset < b) {
                    a.style.display = "none"
                }
            }
        }
    },
    _postSidebarStay: false,
    getPostSidebarStayElement: function() {
        if (this._postSidebarStay === false) {
            this._postSidebarStay = $("post-gag-stay")
        }
        return this._postSidebarStay
    },
    getPostSidebarStayElementCheckTop: function() {
        var a = 274;
        a += 242;
        if (!GAG.User.isLoggedIn() && !GAG.isReadOnly()) {
            a += 60
        }
        if (this.isFormMessageShown()) {
            a += this.elements.formMessageOffset
        }
        if (this.isTimelineButtonShown()) {
            a += 60
        }
        return a
    },
    checkPostSideBar: function() {
        var b = this.getPostSidebarStayElement();
        if (!b) {
            return
        }
        if (!window.XMLHttpRequest) {
            return
        }
        var c = 60;
        var a = this.getPostSidebarStayElementCheckTop();
        if (document.documentElement.scrollTop > a || self.pageYOffset > a) {
            if (b.style.position != "fixed") {
                b.style.position = "fixed";
                b.style.top = c + "px"
            }
        } else {
            if (document.documentElement.scrollTop < a || self.pageYOffset < a) {
                b.style.position = "";
                b.style.top = ""
            }
        }
    },
    _isTimelineButtonShown: false,
    isTimelineButtonShown: function() {
        if (this._isTimelineButtonShown === false) {
            this._isTimelineButtonShown = $("fb-timeline-btn")
        }
        return this._isTimelineButtonShown
    },
    _stickyElements: {},
    checkStickyElements: function() {
        if (!window.XMLHttpRequest) {
            return
        }
        var e = document.documentElement.scrollTop;
        var f = self.pageYOffset;
        for (var h in this._stickyElements) {
            var i = this._stickyElements[h];
            var c = i.fixedY + 1;
            var a = i.initY - c;
            var g = i.initX;
            var d = i.position;
            if (e > a || f > a) {
                if (d != "fixed") {
                    var b = $(i.element);
                    this._stickyElements[h]["position"] = "fixed";
                    b.setStyles({
                        position: "fixed",
                        top: c + "px"
                    })
                }
            } else {
                if (e < a || f < a) {
                    if (d == "fixed") {
                        var b = $(i.element);
                        this._stickyElements[h]["position"] = "";
                        b.setStyles({
                            position: "",
                            top: ""
                        })
                    }
                }
            }
        }
    },
    initStickyElements: function() {
        $$(".badge-sticky-elements").each(function(f, c) {
            var b = $(f).getPosition().x;
            var a = $(f).getPosition().y;
            var g = parseInt($(f).get("data-y"), 10);
            var h = $(f).get("id");
            var d = "id:" + h;
            var e = {
                position: "",
                element: f,
                id: h,
                fixedY: g,
                initX: b,
                initY: a
            };
            GAG.Effect.Scroll._stickyElements[d] = e
        })
    },
    isSearchBarOpened: function() {
        return false;
        var a = GAG.Effect.searchBar.slider && GAG.Effect.searchBar.slider.open;
        a = false
    },
    getPostShareBarTop: function() {
        var a = this.elements.postControlBarTop;
        if (this.isSearchBarOpened()) {
            a += this.elements.searchbarHeight
        }
        if (this.isFormMessageShown()) {
            a += this.elements.formMessageOffset
        }
        return a
    },
    getHeaderBarSignupTop: function() {
        var a = this.elements.headerbarSignupTop;
        if (this.isFormMessageShown()) {
            a += this.elements.formMessageOffset
        }
        return a
    },
    _footerBackToTopButton: false,
    getFooterBackToTopButton: function() {
        if (this._footerBackToTopButton === false) {
            this._footerBackToTopButton = $("footer-back-to-top")
        }
        return this._footerBackToTopButton
    },
    checkBackToTopButton: function() {
        var c = this.getFooterBackToTopButton();
        if (!c) {
            return
        }
        var b = $(window).getScroll();
        var a = 800;
        if (b.y > a) {
            c.removeClass("offscreen")
        } else {
            c.addClass("offscreen")
        }
    },
    scrollToTop: function() {
        new Fx.Scroll(window, {
            duration: 500
        }).toTop()
    },
    onPageScroll: function() {
        this.checkStickyElements();
        this.checkPostSideBar();
        this.checkNavSignupButton();
        this.checkStickyMenu();
        this.checkBackToTopButton();
        GAG.Effect.Read.checkReadItems()
    },
    bindStickyElements: function() {
        window.onscroll = function() {
            GAG.Effect.Scroll.onPageScroll()
        }
    },
    bindElements: function() {
        this.bindStickyElements();
        this.initStickyElements()
    }
};
var showBox = false;
var showLog = false;
if (Cookie.read("show_log") == "1") {
    showLog = true
}
if (Cookie.read("show_box") == "1") {
    showBox = true
}
function doLog(a) {
    if (showLog && console.log) {
        console.log(a)
    }
}
var ViewObject = function(b) {
    this._entryId = b["entry-id"];
    this._isRead = false;
    this._beginY = parseInt(b["data-y"], 10);
    var a = parseInt(b["data-y3"], 10) - this._beginY;
    this._endY = this._beginY + a;
    this._height = a;
    this._readTime = 0;
    this._timestamp = -1;
    var d = "box-" + this._entryId;
    var c = $(d);
    if (showBox) {
        if (!c) {
            var e = "EntryId:" + this._entryId;
            c = this.getBox(this._beginY, this._endY, e);
            document.body.appendChild(c)
        }
        this._box = c
    }
};
ViewObject.prototype.getBox = function(d, b, c) {
    var a = b - d;
    return new Element("div", {
        html: c,
        styles: {
            position: "absolute",
            left: "300px",
            top: d,
            width: "200px",
            color: "pink",
            height: a,
            border: "2px solid yellow",
            "font-size": "20px"
        }
    })
};
ViewObject.prototype.update = function(b) {
    var d = parseInt(b["data-y"], 10);
    var a = parseInt(b["data-y3"], 10) - d;
    var c = d + a;
    if (this._beginY != d || this._endY != c) {
        doLog("new options " + this._entryId + ": " + this._beginY + " > " + d + "," + this._endY + " > " + c);
        this._beginY = d;
        this._endY = c;
        this._height = a;
        if (showBox) {
            this._box.setStyles({
                top: d,
                height: a
            })
        }
    }
};
ViewObject.prototype.resetTimestamp = function() {
    this._timestamp = -1
};
ViewObject.prototype.getEntryId = function() {
    return this._entryId
};
ViewObject.prototype.setRead = function() {
    this._isRead = true;
    this.isRead()
};
ViewObject.prototype.isRead = function() {
    var a = (parseInt(this._height / 800, 10) + 1) * 1000;
    a = Math.max(1000, a);
    doLog("check read threshold " + this.getEntryId() + ", threshold:" + a);
    var b = this._isRead || this._readTime >= a;
    if (showBox) {
        if (b) {
            $(this._box).setStyle("border-color", "green")
        }
    }
    this._isRead = b;
    return b
};
ViewObject.prototype.inViewingY = function(d, c) {
    var b = 200;
    var a = (this._beginY <= d && this._endY >= c) || (this._beginY >= d && this._endY <= c) || (this._beginY <= c - b && this._beginY >= d) || (this._endY >= d + b && this._endY <= c);
    return a
};
ViewObject.prototype.doRead = function(a) {
    doLog("do read " + this._timestamp);
    if (this._timestamp > 0) {
        this._readTime += (a - this._timestamp);
        this._timestamp = a
    }
};
ViewObject.prototype.startView = function(a) {
    doLog("start view " + this.getEntryId());
    if (this._timestamp < 0) {
        this._timestamp = a;
        if (showBox) {
            $(this._box).setStyle("border-color", "orange")
        }
    }
};
ViewObject.prototype.endView = function() {
    doLog("end view " + this.getEntryId());
    this.resetTimestamp();
    if (showBox) {
        $(this._box).setStyle("border-color", "yellow")
    }
};
GAG.Effect.Read = {
    ENABLE: false,
    _unreadItems: null,
    _itemKeys: {},
    _items: {},
    _viewingItems: {},
    _viewedItems: {},
    _checker: null,
    _checkInterval: 500,
    init: function() {
        this.ENABLE = GAG.Page.isLanding();
        if (!this.ENABLE) {
            return
        }
        for (var a in GAG.Effect.Scroll._itemsData) {
            var b = GAG.Effect.Scroll._itemsData[a];
            var d = "entry:" + b["entry-id"];
            if (!this._itemKeys[d]) {
                this._items[d] = new ViewObject(b);
                this._itemKeys[d] = this._items[d]
            } else {
                var c = this._itemKeys[d];
                c.update(b)
            }
        }
        this.checkReadItems();
        this.monitor()
    },
    _lastLog: "",
    printStats: function() {
        var e = [],
        a = [],
        b = [];
        for (var c in this._items) {
            e.push(c)
        }
        for (var c in this._viewingItems) {
            a.push(c)
        }
        for (var c in this._viewedItems) {
            b.push(c)
        }
        var d = "Out :" + e.length + ", In :" + a.length + ", Viewed :" + b.join(",");
        if (this._lastLog != d) {
            doLog(d);
            this._lastLog = d
        }
    },
    monitor: function() {
        if (!this._checker) {
            this._checker = setInterval("GAG.Effect.Read.checkRead();", this._checkInterval)
        }
    },
    setRead: function(c) {
        var b = "entry:" + c;
        var a = this._itemKeys[b];
        var d = this._viewedItems[b];
        if (!a) {
            return
        }
        if (d) {
            return
        }
        d = this._viewingItems[b];
        if (d) {
            delete this._viewingItems[b]
        }
        d = this._items[b];
        if (d) {
            delete this._items[b]
        }
        this._viewedItems[b] = a;
        a.setRead();
        this.save()
    },
    moveToRead: function(a) {},
    checkRead: function() {
        var c = this.getTs();
        var a = $(window).getScroll();
        var g = a.y;
        var f = g + $(window).getSize().y;
        for (var d in this._viewingItems) {
            var e = this._viewingItems[d];
            var b = e.inViewingY(g, f);
            if (b) {
                e.doRead(c);
                if (e.isRead()) {
                    this._viewedItems[d] = e;
                    delete this._viewingItems[d];
                    this.save()
                }
            } else {
                e.endView();
                this._items[d] = e;
                delete this._viewingItems[d]
            }
        }
        this.printStats()
    },
    getTs: function() {
        return (new Date()).getTime()
    },
    checkReadItems: function() {
        if (!this.ENABLE) {
            return
        }
        var a = $(window).getScroll();
        var b = $(window).getSize();
        var f = a.y;
        var e = f + b.y;
        var c = this.getTs();
        for (key in this._items) {
            var d = this._items[key];
            if (d.inViewingY(f, e)) {
                this._viewingItems[key] = d;
                d.startView(c);
                delete this._items[key]
            } else {}
        }
    },
    _processedItems: {},
    _cookieKey: "viewed_ids",
    clear: function() {
        doLog("Clear cookie");
        Cookie.write(this._cookieKey, "", GAG.getCookieOptions())
    },
    updateProcessedItems: function(c) {
        for (var b = 0; b < c.length; b++) {
            var a = "entry:" + c[b];
            this._processedItems[a] = true
        }
    },
    save: function(c) {
        var a = [];
        for (var b in this._viewedItems) {
            var d = b.split(":").getLast();
            if (!this._processedItems["entry:" + d]) {
                a.push(d)
            }
        }
        doLog("Written items: " + a.length);
        Cookie.write(this._cookieKey, a.join("|"), GAG.getCookieOptions());
        if (c) {
            this.updateProcessedItems(a)
        }
    }
};
GAG.Effect.Sidebar = {
    _defaultCount: 5,
    _checkInterval: 1500,
    _checker: null,
    _lastScrollY: 0,
    init: function() {
        this.monitor()
    },
    monitor: function() {
        if (this._checker == null) {
            this._checker = setInterval("GAG.Effect.Sidebar.sidebarCheck();", this._checkInterval)
        }
    },
    sidebarCheck: function() {
        var a = $(window).getScrollSize();
        if (this._lastScrollY != a.y) {
            this._lastScrollY = a.y;
            this.updateSidebarPosts()
        }
    },
    updateSidebarPosts: function() {
        if (GAG.Page.isPostView()) {
            var j = $(window).getCoordinates();
            var b = $(window).getScrollSize();
            var f = 102;
            var h = 75;
            var e = 40;
            var l = 260;
            var c = (j.height - h - e);
            var g = (b.y - GAG.Effect.Scroll.getPostSidebarStayElementCheckTop() - l);
            var a = parseInt(c / f, 10);
            var m = parseInt(g / f, 10);
            var d = c + ":" + a + " , " + g + ":" + m;
            var i = Math.min(a, m);
            $$("#post-gag-stay a.wrap").each(function(o, n) {
                $(o).setStyle("display", n >= i ? "none": "")
            })
        }
    },
    bindElements: function() {
        if (!GAG.Page.isPostView()) {
            return
        }
        this.init();
        this.updateSidebarPosts()
    }
};
GAG.Effect.searchBar = {
    slider: null,
    bindElements: function() {
        if ($("search_wrapper")) {
            GAG.Effect.searchBar.slider = new Fx.Slide("search_wrapper", {
                duration: 250
            }).hide();
            $$("#search_wrapper_, .search-toggler").addEvent("click",
            function() {
                $("header_searchbar").setStyle("display", "");
                if (GAG.Effect.searchBar.slider.open) {
                    $("sitebar_search_header").blur()
                } else {
                    $("sitebar_search_header").set("value", "").focus()
                }
                GAG.Effect.searchBar.slider.toggle()
            })
        }
    }
};
GAG.Effect.AutoComplete = {
    bindElements: function() {
        $$(".tag_input").each(function(a) {
            new Autocompleter.Ajax.Json(a.get("id"), "/tags/suggest", {
                postVar: "tag",
                delay: 1,
                multiple: true,
                separatorSplit: "/[,;]+/"
            })
        });
        $$(".search_input").each(function(a) {
            new Autocompleter.Ajax.Json(a.get("id"), "/tags/suggest", {
                postVar: "tag",
                delay: 1,
                separatorSplit: "/[,;]+/"
            })
        })
    }
};
GAG.Ajax.Report = {
    bindReportLink: function(a, b) {
        $$(a).addEvent(b,
        function(c) {
            $("overlay-shadow").removeClass("hide");
            $("overlay-container").removeClass("hide");
            $("modal-report").removeClass("hide");
            $$("#modal-report input[type=text]").set("value", "").removeClass("failed");
            $$("#modal-report input[type=radio]").set("checked", false);
            $("report_entry_id").set("value", $(this).get("entryId"));
            window.reportOn = true
        })
    },
    bindReportElements: function() {
        $$("#modal-report input[type=radio]").addEvent("click",
        function(e) {
            var btn = $(this);
            if (btn.get("value") == 4) {
                $("repost_link").focus();
                return
            }
            $("repost_link").set("value", "")
        });
        $$("#repost_link").addEvent("focus",
        function(e) {
            $("repost").set("checked", true)
        });
        $$("#modal-report a.close-btn").addEvent("click",
        function(e) {
            e.preventDefault();
            $$("#modal-report a.cancel").fireEvent("click")
        });
        $$("#modal-report a.cancel").addEvent("click",
        function(e) {
            if (e) {
                e.preventDefault()
            }
            window.reportOn = false;
            $("overlay-shadow").addClass("hide");
            $("modal-report").addClass("hide");
            $("overlay-container").fireEvent("click");
            $$("#modal-report a.loading").getParent().addClass("hide");
            $$("#modal-report a.cancel").getParent().removeClass("hide");
            $$("#modal-report a.submit-button").getParent().removeClass("hide")
        });
        $$("#modal-report a.submit-button").addEvent("click",
        function(e) {
            e.preventDefault();
            var entryId = $("report_entry_id").get("value");
            var check = $$("#modal-report input[name=report-reason]:checked");
            var type = 0;
            if (check && check.length > 0) {
                type = check[0].value
            } else {
                return
            }
            var params = {};
            params.entryId = entryId;
            params.type = type;
            if (type == 4) {
                var link = $("repost_link").get("value").toLowerCase();
                var currLink = "http://" + GAG.getDomain() + "/gag/" + entryId;
                if (!link.test("^http://") || (link.test("^" + currLink) && !link.test("^" + currLink + "[0-9]"))) {
                    $("repost_link").addClass("failed");
                    return
                } else {
                    $("repost_link").removeClass("failed")
                }
                params.link = link
            }
            $$("#modal-report a.cancel").getParent().addClass("hide");
            $$("#modal-report a.submit-button").getParent().addClass("hide");
            $$("#modal-report a.loading").getParent().removeClass("hide");
            var req = new Request({
                method: "post",
                url: "/report-post",
                data: params,
                onComplete: function(j, v) {
                    var data = eval("(" + j + ")");
                    if (data && data.okay) {
                        $$("#modal-report a.cancel").fireEvent("click");
                        return
                    }
                    if (data.invalidLink) {
                        $("repost_link").addClass("failed")
                    }
                    $$("#modal-report a.loading").getParent().addClass("hide");
                    $$("#modal-report a.cancel").getParent().removeClass("hide");
                    $$("#modal-report a.submit-button").getParent().removeClass("hide")
                }
            }).send()
        })
    },
    bindElements: function() {
        this.bindReportLink("a.report-item", "click");
        this.bindReportElements()
    }
};
GAG.Overlay = {
    bindElements: function() {
        if ($("overlay-shadow")) {
            $("overlay-shadow").addEvent("click",
            function(a) {
                $("overlay-container").fireEvent("click")
            });
            $("overlay-container").addEvent("click",
            function(a) {
                if (window.reportOn || window.postShareOn || GAG.Overlay.Language.isShown()) {
                    return
                }
                if (a) {
                    a.preventDefault()
                }
                $("overlay-shadow").addClass("hide");
                $$("div.keyboard-instruction").addClass("hide")
            })
        }
    }
};
GAG.Overlay.Language = {
    _isShown: false,
    isShown: function() {
        return this._isShown
    },
    showMenu: function(a) {
        if (a) {
            this.resetMenu();
            $("overlay-shadow").removeClass("hide");
            $("overlay-container").removeClass("hide");
            $("modal-language").removeClass("hide")
        } else {
            $("overlay-shadow").addClass("hide");
            $("overlay-container").addClass("hide");
            $("modal-language").addClass("hide")
        }
        this._isShown = a
    },
    resetMenu: function() {
        $$("#form-modal-language input.current").set("checked", "true")
    },
    updateLanguage: function(c, a) {
        if ($("backUrl")) {
            a = $("backUrl").get("text")
        }
        if (a == undefined) {
            a = "/"
        }
        var b = "http://" + GAG.getDomain() + "/pref/setlanguage/lang/" + c + "?url=" + a;
        window.location.href = b
    },
    bindElements: function() {
        $$(".badge-language-selector").addEvent("click",
        function(a) {
            a.preventDefault();
            GAG.Overlay.Language.showMenu(true)
        });
        $$(".badge-language-close").addEvent("click",
        function(a) {
            a.preventDefault();
            GAG.Overlay.Language.showMenu(false)
        });
        if ($("language-submit-button")) {
            $("language-submit-button").addEvent("click",
            function(b) {
                b.preventDefault();
                var a = $$("#form-modal-language input[name=lang-code]:checked");
                if (a.length > 0) {
                    GAG.Overlay.Language.updateLanguage(a[0].value)
                }
            })
        }
    }
};
GAG.Overlay.postShare = {
    timer: null,
    startTs: 0,
    timeout: 5000,
    showPostShareBox: function(a) {
        if (a) {
            if (a.timeout) {
                this.timeout = a.timeout
            }
        }
        $("overlay-shadow").removeClass("hide");
        $("overlay-container").removeClass("hide");
        $("modal-share").removeClass("hide")
    },
    hidePostShareBox: function() {
        $("overlay-shadow").addClass("hide");
        $("overlay-container").addClass("hide");
        $("modal-share").addClass("hide")
    },
    updatePostShareBox: function() {
        var b = this.timeout - ((new Date()).getTime() - this.startTs);
        var a = Math.round(b / 1000);
        if (a < 0) {
            this.clearTimer();
            this.hidePostShareBox()
        } else {
            $("post-share-dismiss-counter").set("text", "(" + a + ")")
        }
    },
    bindElements: function() {
        $("modal-share").addEvent("click",
        function(a) {
            GAG.Overlay.postShare.clearTimer()
        });
        $$("div#modal-share a.close-btn").addEvent("click",
        function(a) {
            window.postShareOn = false;
            $("modal-share").addClass("hide");
            $("overlay-container").addClass("hide");
            $("overlay-shadow").addClass("hide")
        });
        $$("#post-share-entry-url").addEvent("click",
        function(b) {
            b.preventDefault();
            var a = $("post-share-entry-url").get("value");
            if (a.length > 0) {
                _gaq.push(["_trackEvent", "Post-Share-Url", "Clicked", a, 1]);
                $("post-share-entry-url").selectRange(0, a.length)
            }
            GAG.Overlay.postShare.clearTimer()
        });
        this.setTimer()
    },
    setTimer: function() {
        this.startTs = (new Date()).getTime();
        this.timer = setInterval("GAG.Overlay.postShare.updatePostShareBox();", 1000);
        this.updatePostShareBox()
    },
    clearTimer: function() {
        if (this.timer) {
            clearInterval(this.timer);
            this.timer = null
        }
        $("post-share-dismiss-counter").set("text", "")
    }
};
GAG.Social = {};
GAG.Social.Facebook = {
    appId: null,
    _isLoggedIn: false,
    _isConnected: false,
    _userId: false,
    _bindedUserId: false,
    _accessToken: false,
    _linkedUserId: false,
    _isReady: false,
    _parseQueue: [],
    INIT_FAILURE_MESSAGE: "Facebook Connect is not enabled, please check if there's any browser plugin blocking the function.",
    init: function() {
        var a = $("fb-app-id");
        if (!a) {
            return
        }
        this.appId = a.get("text");
        this.bindEvents()
    },
    onReady: function() {
        while (this._parseQueue.length > 0) {
            var a = this._parseQueue.shift();
            FB.XFBML.parse(document.getElementById(a))
        }
    },
    parseElement: function(a) {
        try {
            FB.XFBML.parse(document.getElementById(a))
        } catch(b) {
            this._parseQueue.push(a)
        }
    },
    bindFailureCb: function() {
        $$(".facebook-init-failed").set("text", this.INIT_FAILURE_MESSAGE).setStyle("display", "")
    },
    bindEvents: function() {
        try {
            var d = GAG.getProtocol();
            var a = d + "://" + GAG.getDomain() + "/static/" + d + "_channel.html";
            FB.init({
                appId: this.appId,
                status: true,
                cookie: true,
                xfbml: true,
                channelUrl: a,
                oauth: true
            });
            if (Browser.ie8) {
                FB.UIServer.setActiveNode = function(f, e) {
                    FB.UIServer._active[f.id] = e
                }
            }
            var c = function(f) {
                if (f.status === "connected") {
                    GAG.Social.Facebook._isLoggedIn = true;
                    if (f.authResponse) {
                        GAG.Social.Facebook._userId = f.authResponse.userID;
                        var g = f.authResponse.accessToken;
                        var e = f.authResponse.expiresIn;
                        if (GAG.Social.Facebook.getUserId() == GAG.Social.Facebook.getBindedUserId()) {
                            GAG.Social.Facebook._isConnected = true;
                            GAG.Submit.showFacebookPublishOption(false)
                        } else {
                            if (!GAG.Social.Facebook.getBindedUserId()) {
                                GAG.Submit.showFacebookPublishOption(false)
                            } else {
                                GAG.Submit.showFacebookPublishOption(true)
                            }
                        }
                    }
                } else {
                    if (f.status === "not_authorized") {
                        GAG.Social.Facebook._isLoggedIn = true;
                        GAG.Submit.showFacebookPublishOption()
                    } else {
                        GAG.Submit.showFacebookPublishOption()
                    }
                }
            };
            FB.getLoginStatus(c);
            FB.Event.subscribe("auth.authResponseChange", c);
            FB.Event.subscribe("edge.create",
            function(f, i, e) {
                var g = i.dom;
                var h = $(g).get("label");
                if (h.length == 0) {
                    h = "Default"
                }
                _gaq.push(["_trackEvent", "Facebook-Like-Button", h + "Liked", f, 1])
            });
            FB.Event.subscribe("edge.remove",
            function(e, h) {
                var f = h.dom;
                var g = $(f).get("label");
                if (g.length == 0) {
                    g = "Default"
                }
                _gaq.push(["_trackEvent", "Facebook-Like-Button", g + "RemovedLike", e, 1])
            });
            FB.Event.subscribe("comment.create",
            function(g, f) {
                var e = g.href;
                _gaq.push(["_trackEvent", "Facebook-Comment", "PostCommentAdded", e, 1]);
                GAG.Social.Facebook.commentOnPost(e, true)
            });
            FB.Event.subscribe("comment.remove",
            function(g, f) {
                var e = g.href;
                _gaq.push(["_trackEvent", "Facebook-Comment", "PostCommentRemoved", e, 1]);
                GAG.Social.Facebook.commentOnPost(e, false)
            })
        } catch(b) {
            this.bindFailureCb();
            return
        }
    },
    bindElements: function() {
        $$(".badge-fb-perm-publish-action").addEvent("click",
        function(a) {
            FB.login(function(b) {
                if (b.authResponse) {} else {}
            },
            {
                scope: "publish_actions"
            })
        })
    },
    getLinkedUserId: function() {
        if (this._linkedUserId === false) {
            var a = $("fb-user-id");
            this._linkedUserId = a ? a.get("text") : null
        }
        return this._linkedUserId
    },
    getBindedUserId: function() {
        if (this._bindedUserId === false) {
            var a = $("fb-user-id");
            this._bindedUserId = a ? a.get("text") : null
        }
        return this._bindedUserId
    },
    getUserId: function() {
        return this._userId
    },
    isLoggedIn: function() {
        return this._isLoggedIn
    },
    isPermsGranted: function() {
        return
    },
    getPermissions: function(a, c, d) {
        if (a) {
            var b = a.join(",");
            FB.login(function(e) {
                if (e.authResponse) {
                    if (c && c instanceof Function) {
                        c()
                    }
                } else {
                    if (d && d instanceof Function) {
                        d()
                    }
                }
            },
            {
                scope: b
            })
        }
    },
    getTimelineApiUri: function(a) {
        return $("fbTimelineApi").get("text")
    },
    getTimelineApiNs: function() {
        return $("fb-timeline-ns").get("text")
    },
    _isFbTimelineEnabled: false,
    isFbTimelineEnabled: function() {
        if (this._isFbTimelineEnabled === false) {
            this._isFbTimelineEnabled = $("fb-timeline-enabled")
        }
        return this._isFbTimelineEnabled
    },
    callTimelineApi: function(d, a, b) {
        if (!GAG.facebookTimelineOn()) {
            return
        }
        if (!this.isLoggedIn()) {
            return
        }
        var f = this.getUserId();
        var c = this.getLinkedUserId();
        var h = this.isFbTimelineEnabled();
        if (f != c) {
            return
        }
        if (!h) {
            return
        }
        try {
            var i = this.getTimelineApiNs();
            var j = "/me/" + i + ":" + d;
            if (b == "post") {
                FB.api(j, "post", {
                    funny_post: a
                },
                function(e) {
                    if (!e || e.error) {} else {
                        var l = a.split("/").getLast();
                        GAG.Social.Facebook.addToOgActionHistory(d, l, e.id)
                    }
                })
            } else {
                if (b == "delete") {
                    FB.api("/" + a, "delete",
                    function(e) {
                        if (!e || e.error) {}
                    })
                }
            }
        } catch(g) {}
        return false
    },
    ogActionHistory: {},
    ogActions: ["laugh_at", "comment_on", "submit"],
    _readOgActionHistory: false,
    readOgActionHistory: function() {
        if (this._readOgActionHistory) {
            return
        }
        for (var b = 0; b < this.ogActions.length; b++) {
            var a = "og_" + this.ogActions[b];
            var c = Cookie.read(a);
            this.ogActionHistory[a] = c ? c.split("|") : []
        }
        this._readOgActionHistory = true
    },
    getOgActionHistory: function(b, f) {
        this.readOgActionHistory();
        var e = "og_" + b;
        var c = this.ogActionHistory[e];
        for (var d = 0; d < c.length; d++) {
            if (c[d].indexOf(f + ":") == 0) {
                var a = c[d].substring(c[d].indexOf(":") + 1);
                return ! (isNaN(parseInt(a, 10)))
            }
        }
        return false
    },
    addToOgActionHistory: function(a, c, d) {
        if (d && !this.getOgActionHistory(a, c)) {
            var b = "og_" + a;
            this.ogActionHistory[b].push(c + ":" + d);
            this.saveOgActionHistory()
        }
    },
    saveOgActionHistory: function() {
        this.readOgActionHistory();
        var d = 10;
        for (var c = 0; c < this.ogActions.length; c++) {
            var b = "og_" + this.ogActions[c];
            var a = this.ogActionHistory[b].slice( - d);
            Cookie.write(b, a ? a.join("|") : "", GAG.getCookieOptions())
        }
    },
    submitPost: function(b) {
        var a = GAG.Utils.formatPostLink(b);
        this.callTimelineApi("submit", a)
    },
    commentOnPost: function(b, c) {
        var a = "comment_on";
        if (c) {
            this.callTimelineApi(a, b, "post")
        }
    },
    laughAtPost: function(e, d) {
        var b = "laugh_at";
        if (d) {
            var c = GAG.Utils.formatPostLink(e);
            var a = this.getOgActionHistory(b, e);
            if (!a) {
                this.callTimelineApi(b, c, "post")
            }
        } else {
            var a = this.getOgActionHistory(b, e);
            if (a) {
                this.callTimelineApi(b, a, "delete")
            }
        }
    }
};
GAG.Login = {
    FB_PERMS: "email",
    FB_CONNECT_CALLBACK_URL: "/connect/facebook-callback",
    _isRequesting: false,
    additionalParams: {},
    addParam: function(a, b) {
        this.additionalParams[a] = b
    },
    getConnectParamsString: function() {
        var b = "";
        var a = 0;
        for (k in this.additionalParams) {
            b += (a == 0 ? "": "&") + k + "=" + encodeURIComponent(this.additionalParams[k]);
            a++
        }
        return b
    },
    getConnectUrl: function(b) {
        var a = GAG.Login.FB_CONNECT_CALLBACK_URL;
        a += "?" + this.getConnectParamsString();
        return a
    },
    connectFacebook: function(f, c, h) {
        try {
            if (f == undefined || f == null) {
                f = "/"
            }
            var d = true;
            if (Browser.chrome) {
                d = false
            }
            if (d) {
                this.addParam("next", f);
                FB.login(function(i) {
                    if (i.authResponse) {
                        var e = response.authResponse.accessToken;
                        window.location = GAG.Login.getConnectUrl(e)
                    }
                },
                {
                    scope: this.FB_PERMS
                })
            } else {
                var a = "https://" + GAG.getDomain() + "/connect/facebook";
                var b = "next=" + encodeURIComponent(f + "?" + this.getConnectParamsString());
                a += "?" + b;
                window.location = a
            }
        } catch(g) {
            if (Browser.ie7 || Browser.ie8) {} else {
                alert(GAG.Social.Facebook.INIT_FAILURE_MESSAGE)
            }
            return
        }
    },
    setupAccount: function(b) {
        var a = "https://" + GAG.getDomain() + "/member/setup?next=" + encodeURIComponent(b);
        window.location = a
    },
    loginAndRedirect: function(b) {
        var a = "https://" + GAG.getDomain() + "/login?ref=" + b;
        window.location = a
    },
    setRequestInvitationLoading: function(a) {
        if (a) {
            $("request-invite-block").setStyle("display", "none");
            $("request-invite-loading").setStyle("display", "")
        } else {
            $("request-invite-loading").setStyle("display", "none");
            $("request-invite-block").setStyle("display", "")
        }
    },
    requestInvitation: function() {
        if (this._isRequesting) {
            return
        }
        var b = $("signup-request-email").get("value");
        var d = GAG.Page.getCsrfToken();
        var a = "/member/request-invitation";
        var e = {
            email: b,
            csrftoken: d
        };
        $("signup-msg").setStyle("display", "none").set("text", "");
        if (!GAG.Validator.isValidEmail(b)) {
            $("signup-msg").setStyle("display", "").set("text", GAG.Login.MSGS.WRONG_EMAIL);
            return
        }
        this._isRequesting = true;
        this.setRequestInvitationLoading(true);
        var c = new Request.JSON({
            url: a,
            data: e,
            onSuccess: function(h, g) {
                GAG.Login._isRequesting = false;
                GAG.Login.setRequestInvitationLoading(false);
                var f = false;
                if (h.okay) {
                    f = true
                }
                switch (h.code) {
                case "ALREADY_IN_LIST":
                    f = true;
                    break;
                case "ALREADY_MEMBER":
                    msg = "Sorry. You don't need an invite.";
                    break;
                case "NOT_IN_LIST":
                case "INVALID_EMAIL":
                case "BLACKLIST_EMAIL":
                    msg = GAG.Login.MSGS.WRONG_EMAIL;
                    break;
                default:
                    msg = "Sorry. Please try again later.";
                    break
                }
                if (f) {
                    $("signup-desc").setStyle("display", "none");
                    $(GAG.Login.ids.inviteBlock).setStyle("display", "none");
                    $("signup-desc-done").setStyle("display", "")
                } else {
                    $("signup-msg").setStyle("display", "").set("text", msg)
                }
            },
            onFailure: function(g, f) {
                GAG.Login._isRequesting = false;
                GAG.Login.setRequestInvitationLoading(false)
            }
        }).post()
    },
    ids: {
        username: "login-username",
        password: "login-password",
        email: "login-email",
        loginForm: "form-signup-login",
        loginBtn: "login-submit",
        loginToRecoverBtn: "login-to-recover",
        recoverToLoginBtn: "recover-to-login",
        loginUsernameBlock: "login-username-block",
        loginEmailBlock: "login-email-block",
        loginPasswordBlock: "login-password-block",
        loginSubmitType: "login-submit-type",
        loginMsg: "login-msg",
        setupMsg: "setup-msg",
        setupUsername: "setup-username",
        setupPassword: "setup-password",
        inviteBlock: "request-invite-block",
        noFacebookBtn: "no-facebook-account",
        inviteEmail: "signup-request-email",
        inviteRequestBtn: "get-email-invitation"
    },
    MSGS: {
        INVALID_LOGIN_COMBINATION: "Wrong Username/Email and password combination.",
        WRONG_EMAIL: "Sorry, something is wrong with your email."
    },
    showLoginMessage: function(a) {
        if (a.length > 0) {
            $(this.ids.loginMsg).set("text", a).setStyle("display", "")
        } else {
            $(this.ids.loginMsg).set("text", "").setStyle("display", "none")
        }
    },
    validateInviteSignup: function() {
        var c = $("invite-signup-username").get("value");
        var h = $("invite-signup-password").get("value");
        var g = $("invite-signup-gender").get("value");
        var b = $("invite-signup-dob-day").get("value");
        var e = $("invite-signup-dob-month").get("value");
        var f = $("invite-signup-dob-year").get("value");
        var a = "Something wrong with your information: ";
        var d = new Array();
        var i = true;
        if (!GAG.Validator.isValidUsername(c)) {
            d.push("Username");
            i = false
        }
        if (!GAG.Validator.isValidPassword(h, 6, 30)) {
            d.push("Password");
            i = false
        }
        if (!GAG.Validator.isValidGender(g)) {
            d.push("Gender");
            i = false
        }
        if (!GAG.Validator.isValidDateValues(f, e, b)) {
            d.push("Date of Birth");
            i = false
        }
        if (!i) {
            a += d.join(", ");
            $("invite-signup-msg").set("text", a).setStyle("display", "")
        }
        return i
    },
    validateReset: function() {
        var b = $("reset-password").get("value");
        var a = GAG.Validator.isValidPassword(b, 6, 30);
        if (a) {
            $("reset-msg").set("text", "").setStyle("display", "none")
        } else {
            $("reset-msg").set("text", "Invalid password.").setStyle("display", "")
        }
        return a
    },
    validateRecover: function() {
        var b = $("recover-email").get("value");
        var a = GAG.Validator.isValidEmail(b);
        if (a) {
            $("recover-msg").set("text", "").setStyle("display", "none")
        } else {
            $("recover-msg").set("text", "Invalid email.").setStyle("display", "")
        }
        return a
    },
    bindResetForm: function() {
        if (!$("reset-submit")) {
            return
        }
        $("reset-submit").addEvent("click",
        function(a) {
            a.preventDefault();
            if (GAG.Login.validateReset()) {
                $("form-signup-login").submit()
            }
        })
    },
    bindRecoverForm: function() {
        if (!$("recover-submit")) {
            return
        }
        $("recover-submit").addEvent("click",
        function(a) {
            a.preventDefault();
            if (GAG.Login.validateRecover()) {
                $("form-signup-login").submit()
            }
        })
    },
    showSetupMessage: function(a) {
        if (a.length > 0) {
            $(this.ids.setupMsg).set("text", a).setStyle("display", "")
        } else {
            $(this.ids.setupMsg).set("text", "").setStyle("display", "none")
        }
    },
    validateLoginSetup: function() {
        this.showSetupMessage("");
        var d = $(this.ids.setupUsername).get("value");
        var c = $(this.ids.setupPassword).get("value");
        var b = GAG.Validator.isValidLoginKey(d);
        var a = GAG.Validator.isValidPassword(c, 6, 30);
        if (!b || !a) {
            if (b) {
                this.showSetupMessage("Invalid password.")
            } else {
                if (a) {
                    this.showSetupMessage("Invalid username.")
                } else {
                    this.showSetupMessage("Invalid email and password.")
                }
            }
            return false
        }
        return true
    },
    validateLogin: function() {
        this.showLoginMessage("");
        var e = $(this.ids.username).get("value");
        var c = $(this.ids.email) ? $(this.ids.email).get("value") : false;
        var b = $(this.ids.password).get("value");
        var d = $(this.ids.loginSubmitType).get("value");
        var a = true;
        if (d == "login") {
            a = GAG.Validator.isValidLoginKey(e);
            a = a && GAG.Validator.isValidPassword(b);
            if (!a) {
                this.showLoginMessage(this.MSGS.INVALID_LOGIN_COMBINATION);
                return false
            }
        } else {
            a = GAG.Validator.isValidEmail(c);
            if (!a) {
                this.showLoginMessage(this.MSGS.WRONG_EMAIL);
                return false
            }
        }
        return true
    },
    bindSigninForm: function() {
        if (!$(this.ids.loginBtn)) {
            return
        }
        var a = "#" + this.ids.username + ",#" + this.ids.password;
        $$(a).addEvent("keydown",
        function(b) {
            if (b.key == "enter") {
                b.preventDefault();
                b.stopPropagation();
                if (GAG.Login.validateLogin()) {
                    $(GAG.Login.ids.loginForm).submit()
                }
            }
        });
        $(this.ids.username).focus();
        if ($(this.ids.loginToRecoverBtn)) {
            $(this.ids.loginToRecoverBtn).addEvent("click",
            function(b) {
                b.preventDefault();
                $(GAG.Login.ids.loginUsernameBlock).setStyle("display", "none");
                $(GAG.Login.ids.loginPasswordBlock).setStyle("display", "none");
                $(GAG.Login.ids.loginEmailBlock).setStyle("display", "");
                $(GAG.Login.ids.loginForm).set("action", "/recover");
                $(GAG.Login.ids.loginBtn).set("value", "Reset");
                $(GAG.Login.ids.loginSubmitType).set("value", "reset");
                $(GAG.Login.ids.username).set("value", "");
                $(GAG.Login.ids.email).set("value", "");
                $(GAG.Login.ids.password).set("value", "");
                $(GAG.Login.ids.loginMsg).set("text", "")
            })
        }
        if ($(this.ids.recoverToLoginBtn)) {
            $(this.ids.recoverToLoginBtn).addEvent("click",
            function(b) {
                b.preventDefault();
                $(GAG.Login.ids.loginEmailBlock).setStyle("display", "none");
                $(GAG.Login.ids.loginUsernameBlock).setStyle("display", "");
                $(GAG.Login.ids.loginPasswordBlock).setStyle("display", "");
                $(GAG.Login.ids.loginForm).set("action", "/login");
                $(GAG.Login.ids.loginBtn).set("value", "Login");
                $(GAG.Login.ids.loginSubmitType).set("value", "login");
                $(GAG.Login.ids.username).set("value", "");
                $(GAG.Login.ids.email).set("value", "");
                $(GAG.Login.ids.password).set("value", "");
                $(GAG.Login.ids.loginMsg).set("text", "")
            })
        }
    },
    bindSignupForm: function() {
        if (!$(this.ids.noFacebookBtn)) {
            return
        }
        $(this.ids.noFacebookBtn).addEvent("click",
        function(a) {
            a.preventDefault();
            $(this).getParent().setStyle("display", "none");
            $(GAG.Login.ids.inviteBlock).setStyle("display", "");
            $(GAG.Login.ids.inviteEmail).focus()
        });
        $("form-signup-login").addEvent("submit",
        function(a) {
            a.preventDefault()
        });
        $(this.ids.inviteEmail).addEvent("keydown",
        function(a) {
            if (a.key == "enter") {
                a.preventDefault();
                a.stopPropagation();
                GAG.Login.requestInvitation()
            }
        });
        $(this.ids.inviteRequestBtn).addEvent("click",
        function(a) {
            a.preventDefault();
            GAG.Login.requestInvitation()
        })
    },
    bindDateElements: function(d) {
        var c = $(d + "-dob-day");
        var b = $(d + "-dob-month");
        var a = $(d + "-dob-year");
        if (c && b && a) {
            b.addEvent("change",
            function(h) {
                var g = c.get("value");
                var f = b.get("value");
                if (f >= 1) {
                    if (g > GAG.Validator.MONTH_DAYS[f - 1]) {
                        c.set("value", -1)
                    }
                }
            });
            c.addEvent("change",
            function(h) {
                var g = c.get("value");
                var f = b.get("value");
                if (f >= 1) {
                    if (g > GAG.Validator.MONTH_DAYS[f - 1]) {
                        b.set("value", -1)
                    }
                }
            })
        }
    },
    bindInviteSignupForm: function() {
        var a = "invite-signup";
        this.bindDateElements(a)
    },
    bindSetupForm: function() {
        if ($("setup-submit")) {
            $("setup-username").focus()
        }
    },
    bindBadgeFbConnect: function() {
        $$(".badge-facebook-connect").addEvent("click",
        function(c) {
            c.preventDefault();
            var a = $(this).get("label");
            if (a == null) {
                a = "Others"
            }
            GAG.GA.track("Facebook-Signup", "Clicked", a);
            var b = $(this).get("next");
            var d = $(this).hasClass("nsfw-post");
            if (d) {
                GAG.Login.addParam("nsfw", 1)
            }
            GAG.Login.connectFacebook(b)
        })
    },
    bindAddToTimelineButtons: function() {
        $$(".badge-add-fb-timeline").addEvent("click",
        function(b) {
            b.preventDefault();
            var a = "publish_actions";
            try {
                FB.login(function(c) {
                    GAG.Login.enableFbTimelineAck(c.authResponse)
                },
                {
                    scope: a
                })
            } catch(b) {}
        })
    },
    _isFacebookPublishGranted: null,
    isFacebookPublishGranted: function() {
        if (this._isFacebookPublishGranted === null) {
            var a = $("fb-publish-granted");
            this._isFacebookPublishGranted = (a && a.get("text") == 1 ? true: false)
        }
        return this._isFacebookPublishGranted
    },
    _isFacebookPublishEnabled: null,
    isFacebookPublishEnabled: function() {
        if (this._isFacebookPublishEnabled === null) {
            var a = $("fb-publish-enabled");
            this._isFacebookPublishEnabled = (a && a.get("text") == 1 ? true: false)
        }
        return this._isFacebookPublishEnabled
    },
    enableFbTimelineAck: function(b) {
        var a = "/member/facebook-timeline";
        var d = {
            on: b ? "on": "off"
        };
        var c = new Request.JSON({
            url: a,
            data: d,
            onSuccess: function(f, e) {}
        }).post()
    },
    bindElements: function() {
        this.bindBadgeFbConnect();
        this.bindAddToTimelineButtons();
        this.bindSignupForm();
        this.bindSigninForm();
        this.bindInviteSignupForm();
        this.bindRecoverForm();
        this.bindSetupForm();
        this.bindResetForm()
    }
};
GAG.Ajax.Vote = {
    URL_VOTE_UP: "/vote/like/id/",
    URL_VOTE_DOWN: "/vote/dislike/id/",
    URL_UNVOTE: "/vote/unlike/id/",
    doVote: function(e, d, f, g) {
        var b = requiredLogin();
        if (!b) {
            return
        }
        GAG.Effect.Read.setRead(d);
        var a = "";
        switch (e) {
        case "down":
            a = this.URL_VOTE_DOWN;
            break;
        case "unvote":
            a = this.URL_UNVOTE;
            break;
        case "up":
        default:
            a = this.URL_VOTE_UP
        }
        a += d;
        f({
            id: d
        });
        var c = new Request.JSON({
            url: a,
            onSuccess: f,
            onFailure: g
        }).get()
    },
    voteUp: function(a, b, c) {
        this.doVote("up", a, b, c);
        GAG.Social.Facebook.laughAtPost(a, true)
    },
    voteDown: function(a, b, c) {
        this.doVote("down", a, b, c)
    },
    unvote: function(a, b, c) {
        this.doVote("unvote", a, b, c)
    },
    voteUpEntryPc: function() {},
    voteUpEntrySuccessCb: function(d) {
        var b = d.id;
        if ($("love_count_" + b) && d.msg) {
            var a = parseInt($("love_count_" + b).get("score"), 10);
            var c = parseInt($("love_count_" + b).get("votes"), 10) - a + 1;
            if (!isNaN(c)) {
                $("love_count_" + b).set("text", c)
            }
        }
        if ($("vote-down-btn-" + b)) {
            $("vote-down-btn-" + b).removeClass("unloved")
        }
        if ($("vote-up-btn-" + b)) {
            $("vote-up-btn-" + b).addClass("loved")
        }
    },
    voteUpEntryFailureCb: function(a) {},
    voteDownEntryPc: function() {},
    voteDownEntrySuccessCb: function(d) {
        var b = d.id;
        if ($("love_count_" + b) && d.msg) {
            var a = parseInt($("love_count_" + b).get("score"), 10);
            var c = parseInt($("love_count_" + b).get("votes"), 10) - a - 1;
            if (!isNaN(c)) {
                $("love_count_" + b).set("text", c)
            }
        }
        if ($("vote-up-btn-" + b)) {
            $("vote-up-btn-" + b).removeClass("loved")
        }
        if ($("vote-down-btn-" + b)) {
            $("vote-down-btn-" + b).addClass("unloved")
        }
    },
    voteDownEntryFailureCb: function() {},
    unvoteEntryPc: function() {},
    unvoteEntrySuccessCb: function(d) {
        var b = d.id;
        if ($("love_count_" + b) && d.msg) {
            var a = parseInt($("love_count_" + b).get("score"), 10);
            var c = parseInt($("love_count_" + b).get("votes"), 10) - a;
            if (!isNaN(c)) {
                $("love_count_" + b).set("text", c)
            }
        }
        if ($("vote-up-btn-" + b)) {
            $("vote-up-btn-" + b).removeClass("loved")
        }
        if ($("vote-down-btn-" + b)) {
            $("vote-down-btn-" + b).removeClass("unloved")
        }
    },
    unvoteEntryFailureCb: function() {},
    bindPostViewSmileIcon: function() {
        if (!$("post_view_love")) {
            return
        }
        $("post_view_love").addEvent("click",
        function(h) {
            if (h) {
                h.preventDefault()
            }
            if (GAG.isReadOnly()) {
                return
            }
            var d = requiredLogin();
            if (!d) {
                return
            }
            scroll(0, 0);
            var i = $(this);
            var c = i.get("rel");
            var f = i.get("data-token");
            var j = i.hasClass("current");
            var b = 0;
            var g = function(n) {
                if (j) {
                    i.removeClass("current");
                    b = 0
                } else {
                    i.addClass("current");
                    b = 1
                }
                var l = "love_count_" + n.id;
                if ($chk(l) && n.msg != undefined) {
                    var e = parseInt($(l).get("score"), 10);
                    var m = parseInt($(l).get("votes"), 10) - e + b;
                    if (!isNaN(m)) {
                        $(l).set("text", m)
                    }
                }
            };
            var a = function(e) {
                if (j) {
                    i.addClass("current")
                } else {
                    i.removeClass("current")
                }
            };
            if (j) {
                GAG.Ajax.Vote.unvote(c, g, a)
            } else {
                GAG.Ajax.Vote.voteUp(c, g, a)
            }
        })
    },
    bindVoteUpElements: function(b, c, a, e, d, f) {
        $$(b).addEvent(c,
        function(i) {
            if (i) {
                i.preventDefault()
            }
            var g = $(this).get("entryId");
            var h = $(this).hasClass("loved");
            if (h) {
                GAG.Ajax.Vote.unvote(g, d, f)
            } else {
                GAG.Ajax.Vote.voteUp(g, a, e)
            }
        })
    },
    bindVoteDownElements: function(a, c, b, e, d, f) {
        $$(a).addEvent(c,
        function(i) {
            if (i) {
                i.preventDefault()
            }
            var g = $(this).get("entryId");
            var h = $(this).hasClass("unloved");
            if (h) {
                GAG.Ajax.Vote.unvote(g, d, f)
            } else {
                GAG.Ajax.Vote.voteDown(g, b, e)
            }
        })
    },
    bindElements: function() {
        if (GAG.isReadOnly()) {
            return
        }
        var a = "#entry-list a.badge-vote-up";
        var c = "click";
        var d = "#entry-list a.badge-vote-down";
        var b = "click";
        this.bindVoteUpElements(a, c, this.voteUpEntrySuccessCb, this.voteUpEntryFailureCb, this.unvoteEntrySuccessCb, this.unvoteEntryFailureCb);
        this.bindVoteDownElements(d, b, this.voteDownEntrySuccessCb, this.voteDownEntryFailureCb, this.unvoteEntrySuccessCb, this.unvoteEntryFailureCb);
        this.bindPostViewSmileIcon()
    }
};
GAG.Keyboard = {
    JUMP_PREV: "JUMP_PREV",
    JUMP_NEXT: "JUMP_NEXT",
    VOTE_UP: "VOTE_UP",
    VOTE_DOWN: "VOTE_DOWN",
    UNVOTE: "UNVOTE",
    JUMP_COMMENT: "JUMP_COMMENT",
    getKeyOptions: function() {
        return {
            type: "keypress",
            propagate: false,
            target: document,
            disable_in_input: true
        }
    },
    jump: function(j) {
        var b;
        var n;
        var e;
        var o = false;
        var l = (Browser.Engine.trident) ? document.documentElement.scrollTop: window.pageYOffset;
        $$(".jump_stop").each(function(p) {
            if (!o) {
                b = n;
                n = p
            } else {
                if (!$chk(e)) {
                    e = p;
                    return
                } else {
                    return
                }
            }
            if (n.getPosition().y >= l + topMargin) {
                o = true
            }
        });
        var m = $("shortcut-event-label") ? $("shortcut-event-label").innerHTML: null;
        scroll(0, n.getPosition().y - topMargin);
        var f = "Keyboard-Shortcut";
        var d = "";
        var a = "";
        var i;
        switch (j) {
        case this.VOTE_DOWN:
            _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-H", m ? m: "Dislike", 1]);
            i = n.getElement("ul li a.unlove");
            break;
        case this.VOTE_UP:
            _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-L", m ? m: "Love", 1]);
            i = n.getElement("ul li a.love");
            break;
        case this.JUMP_COMMENT:
            _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-C", m ? m: "Comment", 1]);
            i = n.getElement("ul li a.comment");
            if (i) {
                window.location = i.get("href")
            }
            break;
        case this.JUMP_PREV:
            _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-K", m ? m: "Previous", 1]);
            if ($chk(b)) {
                scroll(0, b.getPosition().y - topMargin);
                b.focus();
                var h = b.getElement(".jump_focus");
                if ($chk(h)) {
                    h.focus()
                }
            } else {
                if ($chk($("jump_prev"))) {
                    Cookie.write("jumpGAG", "goLast", cookieOption);
                    window.location = $("jump_prev").get("href")
                } else {
                    scroll(0, 0)
                }
            }
            break;
        case this.JUMP_NEXT:
            _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-J", m ? m: "Next", 1]);
            var c = (Browser.Engine.trident) ? (document.documentElement.scrollHeight - document.documentElement.clientHeight) : (document.documentElement.scrollHeight - window.innerHeight);
            if (l == c && $chk($("jump_next"))) {
                Cookie.write("jumpGAG", "goFirst", cookieOption);
                window.location = $("jump_next").get("href")
            } else {
                if ($chk(e)) {
                    var g;
                    if (n.getPosition().y == (l + topMargin)) {
                        g = e
                    } else {
                        g = n
                    }
                    scroll(0, g.getPosition().y - topMargin);
                    g.focus();
                    var h = g.getElement(".jump_focus");
                    if ($chk(h)) {
                        h.focus()
                    }
                    if ($chk($("more_button")) && e.get("do_more") == 1) {
                        e.set("do_more", 0);
                        $("more_button").fireEvent("click")
                    }
                } else {
                    if ($chk($("more_button"))) {
                        $("more_button").fireEvent("click")
                    } else {
                        if ($chk($("jump_next"))) {
                            Cookie.write("jumpGAG", "goFirst", cookieOption);
                            window.location = $("jump_next").get("href")
                        }
                    }
                }
            }
            break
        }
        if (i) {
            i.fireEvent("click")
        }
    },
    bindAction: function(a, b) {
        shortcut.add(a, b, this.getKeyOptions())
    },
    bindJumpPrev: function(a) {
        this.bindAction(a,
        function() {
            GAG.Keyboard.jump(GAG.Keyboard.JUMP_PREV)
        })
    },
    bindJumpNext: function(a) {
        this.bindAction(a,
        function() {
            GAG.Keyboard.jump(GAG.Keyboard.JUMP_NEXT)
        })
    },
    bindPostVoteUp: function(a) {
        this.bindAction(a,
        function() {
            $("post_view_love").fireEvent("click")
        })
    },
    goPrevPost: function() {
        if ($("prev_post")) {
            var a = $("prev_post").get("href");
            if (!a.test("^http")) {
                return
            }
            window.location.href = a
        }
    },
    goNextPost: function() {
        if ($("next_post")) {
            var a = $("next_post").get("href");
            if (!a.test("^http")) {
                return
            }
            window.location.href = a
        }
    },
    bindPostPrev: function(a) {
        this.bindAction(a, this.goPrevPost)
    },
    bindPostNext: function(a) {
        this.bindAction(a, this.goNextPost)
    },
    bindPostPrevCode: function(b) {
        var a = this.getKeyOptions();
        a.type = "keydown";
        shortcut.add(b, this.goPrevPost, a)
    },
    bindPostNextCode: function(b) {
        var a = this.getKeyOptions();
        a.type = "keydown";
        shortcut.add(b, this.goNextPost, a)
    },
    bindOverlay: function() {
        $$("a.keyboard-nav-button, a.keyboard_link").addEvent("click",
        function(a) {
            GAG.Keyboard.showKeyboardOverlay(true)
        })
    },
    showKeyboardOverlay: function() {
        $("overlay-shadow").removeClass("hide");
        $("overlay-container").removeClass("hide");
        $$("#overlay-container div.keyboard-instruction").removeClass("hide");
        _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Clicked", "Popup", 1])
    },
    bindScrollToTop: function(a) {
        this.bindAction(a,
        function() {
            GAG.Effect.Scroll.scrollToTop()
        })
    },
    bindElements: function() {
        if (GAG.Page.isLanding() || GAG.Page.isPostView()) {
            this.bindScrollToTop("b")
        }
        if (GAG.Page.isPostView()) {
            this.bindPostVoteUp("l")
        }
        if (GAG.Page.isPostView() || GAG.Page.isNsfwPostView()) {
            this.bindPostPrev("k");
            this.bindPostNext("j");
            this.bindPostPrevCode("left");
            this.bindPostNextCode("right")
        }
        this.bindOverlay();
        if (window.location.hash && window.location.hash == "#keyboard") {
            this.showKeyboardOverlay(true)
        }
    }
};
GAG.Submit = {
    TITLE_MIN_LENGTH: 6,
    _errorMessages: [],
    resetErrors: function() {
        $$("p.form-message.error").set("html", "").addClass("hide");
        this._errorMessages = []
    },
    putError: function(a) {
        this._errorMessages.push(a)
    },
    getErrors: function() {
        return this._errorMessages
    },
    showErrorMessage: function() {
        var b = "";
        for (var a = 0; a < this._errorMessages.length; a++) {
            if (a > 0) {
                b += " "
            }
            b += this._errorMessages[a]
        }
        $$("p.form-message.error").set("html", b).removeClass("hide")
    },
    getBannedTitlePhrases: function() {
        return window.title_filters ? window.title_filters: []
    },
    getBannedTitles: function() {
        return window.title_blacklist ? window.title_blacklist: []
    },
    isBadTitle: function(e) {
        e += "";
        e = e.replace(/(\t|!|\?|,|:|;|-| )/gi, "");
        if (e.length < this.TITLE_MIN_LENGTH) {
            return true
        }
        var a = this.getBannedTitlePhrases();
        if (a) {
            for (var b = 0; b < a.length; b++) {
                var c = new RegExp(a[b], "i");
                if (e.test(c)) {
                    return true
                }
            }
        }
        var d = this.getBannedTitles();
        if (d) {
            for (var b = 0; b < d.length; b++) {
                var c = new RegExp("^" + d[b] + "$", "i");
                if (e.test(c)) {
                    return true
                }
            }
        }
        return false
    },
    isOriginalPost: function() {
        if (this.isFixedPost) {
            return false
        }
        return ($("submit-original") && $("submit-original").get("checked"))
    },
    isFixedPost: function(b) {
        if ($("page-edit-item")) {
            return false
        }
        var a = new RegExp("fixed", "i");
        return b.test(a)
    },
    isValidSource: function(a) {
        return GAG.Validator.isValidPostLink(a)
    },
    enableSourceField: function(b, a) {
        return;
        b.setStyle("opacity", a ? 1 : 0.5).set("disabled", a ? false: "disabled");
        if (!a) {
            b.set("value", "")
        }
    },
    enableOriginalField: function(a) {
        return;
        var b = $("submit-original");
        if (b) {
            b.set("checked", false).setStyle("opacity", a ? 1 : 0.5).set("disabled", a ? false: "disabled")
        }
    },
    MSG_INVALID_TITLE: "The <b>Post Title</b> doesn't look funny enough to Chuck Norris and other 9gaggers. Think of a descriptive or creative one!",
    MSG_INCOMPLETE_FIXED_POST: "It looks like to be a FIXED post, please provide a valid source URL.",
    MSG_INVALID_SOURCE: "Please provide a valid source URL.",
    MSG_FIXED_DISALLOWED: 'Please use "Fix this post" button to submit [Fixed] posts.',
    MSG_FILE_REQUIRED: "Please select a file to upload.",
    checkImageForm: function() {
        var a = true;
        var d = false;
        var l = false;
        var j = false;
        var b = $("form-modal-post-image");
        var e = b.getElement("input[name=image]");
        var i = b.getElement("input[name=url]");
        var g = b.getElement("input[name=title]");
        var n = b.getElement("input[name=source]");
        if ($("page-post-item")) {
            a = (FV.checkRequired(e) || (FV.checkRequired(i) && FV.checkUrl(i))) && a;
            if (!a) {
                d = true
            }
        }
        if ($("page-edit-item")) {
            a = FV.checkUrl(i, true) && a
        }
        if (e.get("value").length != 0) {
            if (!FV.checkImage(e)) {
                a = false;
                l = true
            }
        }
        if (!FV.checkRequired(g)) {
            a = false;
            j = true
        }
        if (!a) {
            var c = (d || l);
            var f = j;
            if (c && f) {
                if (d) {
                    this.putError("Valid image URL or file is required and title is missing.")
                } else {
                    if (l) {
                        this.putError("Invalid image format and title is missing.")
                    }
                }
            } else {
                if (d) {
                    this.putError("Valid image URL or file is required.")
                } else {
                    if (l) {
                        this.putError("Invalid image format.")
                    } else {
                        if (f) {
                            this.putError("Title is missing.")
                        }
                    }
                }
            }
            this.showErrorMessage()
        }
        var m = g.get("value");
        if (a && this.isBadTitle(m)) {
            FV.cross(g);
            this.putError(this.MSG_INVALID_TITLE);
            this.showErrorMessage();
            a = false
        }
        var h = n.get("value");
        if (this.isFixedPost(m)) {
            FV.cross(g);
            if (a) {
                this.putError(this.MSG_FIXED_DISALLOWED);
                this.showErrorMessage();
                a = false
            }
        } else {
            this.enableOriginalField(true);
            if (this.isOriginalPost()) {
                this.enableSourceField(n, false)
            } else {
                this.enableSourceField(n, true)
            }
            if (false && h.trim().length > 0) {
                if (GAG.Validator.lookLikeURL(h)) {
                    FV.tick(n)
                } else {
                    FV.cross(n);
                    if (a) {
                        this.putError(this.MSG_INVALID_SOURCE);
                        this.showErrorMessage();
                        a = false
                    }
                }
            } else {
                FV.reset(n)
            }
        }
        return a ? b: false
    },
    checkVideoForm: function() {
        var a = true;
        var j = false;
        var m = false;
        var h = false;
        var b = $("form-modal-post-video");
        var e = b.getElement("input[name=video]");
        var f = b.getElement("input[name=title]");
        var l = b.getElement("input[name=source]");
        if ($("page-post-item")) {
            if (!FV.checkRequired(e)) {
                a = false;
                j = true
            }
            if (!FV.checkUrl(e)) {
                a = false;
                m = true
            }
        }
        if ($("page-edit-item")) {
            a = FV.checkUrl(e, true) && a
        }
        if (!FV.checkRequired(f)) {
            a = false;
            h = true
        }
        if (!a) {
            var c = j || m;
            var d = h;
            if (c && d) {
                this.putError("Invalid video URL and title is missing.")
            } else {
                if (c) {
                    this.putError("Invalid video URL.")
                } else {
                    if (d) {
                        this.putError("Title is missing.")
                    }
                }
            }
            this.showErrorMessage()
        }
        var i = f.get("value");
        if (a && this.isBadTitle(i)) {
            FV.cross(f);
            this.putError(this.MSG_INVALID_TITLE);
            this.showErrorMessage();
            a = false
        }
        var g = l.get("value");
        if (this.isFixedPost(i)) {
            FV.cross(f);
            if (a) {
                this.putError(this.MSG_FIXED_DISALLOWED);
                this.showErrorMessage();
                a = false
            }
        } else {
            if (false && g.trim().length > 0) {
                if (GAG.Validator.lookLikeURL(g)) {
                    FV.tick(l)
                } else {
                    FV.cross(l);
                    if (a) {
                        this.putError(this.MSG_INVALID_SOURCE);
                        this.showErrorMessage();
                        a = false
                    }
                }
            } else {
                FV.reset(l)
            }
        }
        return a ? b: false
    },
    checkForm: function() {
        var b = $("post_type").get("value") == "Photo";
        this.resetErrors();
        var a = b ? this.checkImageForm() : this.checkVideoForm();
        return a
    },
    checkFixPostForm: function() {
        this.resetErrors();
        var c = $("form-modal-post-fix");
        var a = $("photo_file_upload");
        var b = FV.checkRequired(a);
        if (!b) {
            this.putError(this.MSG_FILE_REQUIRED);
            this.showErrorMessage();
            b = false
        }
        if (b && a.get("value").length != 0) {
            if (!FV.checkImage(a)) {
                this.putError("Invalid image format.");
                this.showErrorMessage();
                b = false
            }
        }
        return b ? c: false
    },
    isPublishToFacebook: function() {
        var a = $("submit-facebook-publish");
        var b = a && a.getParent("div").hasClass("hide");
        if (a && !b && a.get("checked")) {
            return true
        }
        return false
    },
    onFacebookConnected: function() {},
    _publishOptionKey: "fb_publish_default",
    isPublishDefaultOn: function() {
        var a = Cookie.read(this._publishOptionKey);
        return (!a) || (a == "on")
    },
    setPublishDefault: function(a) {
        Cookie.write(this._publishOptionKey, a ? "on": "off", GAG.getCookieOptions())
    },
    showFacebookPublishOption: function(e) {
        var f = $("submit-facebook-publish");
        if (!f) {
            return
        }
        var a = GAG.Social.Facebook.getUserId() == GAG.Social.Facebook.getBindedUserId();
        var b = GAG.Login.isFacebookPublishEnabled();
        var d = a && b;
        var c = this.isPublishDefaultOn();
        if (e) {
            $$(".fb-publish-checkbox").addClass("hide");
            f.erase("checked")
        } else {
            $$(".fb-publish-checkbox").removeClass("hide");
            if (f) {
                if (c && d) {
                    f.set("checked", "checked")
                }
            }
        }
    },
    promptPermission: function() {
        var d = $("submit-facebook-publish");
        if (!d) {
            return true
        }
        var g = GAG.Submit.isPublishToFacebook();
        var f = GAG.Social.Facebook.getBindedUserId();
        var e = GAG.Social.Facebook.isLoggedIn();
        var c = GAG.Login.isFacebookPublishGranted();
        var b = function(h) {
            GAG.Submit.resetErrors();
            var i = "Please allow 9GAG publishing it to your Facebook";
            if (h) {
                i = "Sorry, unable to connect your Facebook profile"
            }
            GAG.Submit.putError(i);
            GAG.Submit.showErrorMessage()
        };
        var a = function() {
            if (f) {
                GAG.Login._isFacebookPublishGranted = true;
                checkAndSubmitPostForm();
                return
            }
            var h = "/connect/link-facebook";
            var j = {
                enable_publish: 1
            };
            var i = new Request.JSON({
                url: h,
                data: j,
                onSuccess: function(m, l) {
                    if (m.okay) {
                        GAG.Login._isFacebookPublishGranted = true;
                        checkAndSubmitPostForm()
                    } else {
                        b()
                    }
                }
            }).post()
        };
        if (c) {
            GAG.Submit.setPublishDefault(g)
        }
        if (g && (!e || !c)) {
            GAG.Social.Facebook.getPermissions(["publish_stream"], a, b);
            return false
        }
        return true
    },
    bindFbCheckbox: function() {
        var a = $("submit-facebook-publish");
        if (!a) {
            return
        }
        a.addEvent("change",
        function(b) {
            b.preventDefault();
            GAG.Submit.promptPermission()
        })
    },
    bindEditPage: function() {
        if ($("page-edit-item")) {
            $$("#form-modal-post-image a.upload_photo").addEvent("click",
            function(b) {
                b.preventDefault();
                var c = $("form-modal-post-image").getElement("input[name=url]").set("value", "");
                var a = $("form-modal-post-image").getElement("input[name=image]").set("value", "");
                FV.reset(c);
                FV.reset(a);
                $(this).getParent("p").getElement("a.post_link").removeClass("hide");
                $(this).addClass("hide");
                $("photo_post_url").setStyle("display", "none");
                $("photo_file_upload").setStyle("display", "")
            });
            $$("#form-modal-post-image a.post_link").addEvent("click",
            function(b) {
                b.preventDefault();
                var c = $("form-modal-post-image").getElement("input[name=url]").set("value", "");
                var a = $("form-modal-post-image").getElement("input[name=image]").set("value", "");
                FV.reset(c);
                FV.reset(a);
                $(this).getParent("p").getElement("a.upload_photo").removeClass("hide");
                $(this).addClass("hide");
                $("photo_file_upload").setStyle("display", "none");
                $("photo_post_url").setStyle("display", "")
            })
        }
    },
    bindElements: function() {
        $$("#modal-post a.button.send, #modal-edit a.button.send").addEvent("click", checkAndSubmitPostForm);
        if ($("page-post-item") || $("page-edit-item")) {
            $$("#form-modal-post-image input[name=title], #form-modal-post-video input[name=title]").addEvent("blur",
            function(a) {
                a.preventDefault();
                FV.checkRequired($(this))
            });
            $$("#form-modal-post-image input[name=url], #form-modal-post-video input[name=video]").addEvent("blur",
            function(a) {
                a.preventDefault();
                FV.checkUrl($(this), $("page-edit-item") != null)
            });
            $$("#form-modal-post-image div.field input, #form-modal-post-video div.field input").addEvent("keydown",
            function(a) {
                if (a.key == "enter") {
                    a.preventDefault()
                }
            });
            this.bindEditPage()
        }
    }
};
var checkAndSubmitPostForm = function(d) {
    if (d) {
        d.preventDefault()
    }
    var a = $("form-modal-post-fix") ? true: false;
    if (a) {
        var c = GAG.Submit.checkFixPostForm();
        if (!c) {
            return
        }
        $$("#modal-post ul li.form-btn, #modal-edit ul li.form-btn").addClass("hide");
        $$("#modal-post a.button.send, #modal-edit a.button.send").removeEvent("click", checkAndSubmitPostForm).addEvent("click",
        function(f) {
            f.preventDefault()
        });
        $$("#modal-post ul li.loading-btn").removeClass("hide").setStyle("visibility", "visible");
        c.submit()
    } else {
        var b = GAG.Submit.promptPermission();
        if (!b) {
            return
        }
        var c = GAG.Submit.checkForm();
        if (!c) {
            return
        }
        $$("#modal-post ul li.form-btn, #modal-edit ul li.form-btn").addClass("hide");
        $$("#modal-post a.button.send, #modal-edit a.button.send").removeEvent("click", checkAndSubmitPostForm).addEvent("click",
        function(f) {
            f.preventDefault()
        });
        if ($("modal-post")) {
            $$("#modal-post ul li.loading-btn").removeClass("hide").setStyle("visibility", "visible")
        }
        if ($("modal-edit")) {
            $$("#modal-edit ul li.loading-btn").removeClass("hide").setStyle("visibility", "visible")
        }
        $$("#modal-edit div.actions a.delete-button").setStyle("visibility", "hidden");
        c.submit()
    }
};
function ql(b, a) {
    new Request({
        url: "/ql?t=" + b + "&l=" + a
    }).send()
}
if ($("footer_email_subscribe_submit")) {
    $("footer_email_subscribe_submit").addEvent("click",
    function(d) {
        if (d) {
            d.preventDefault()
        }
        var a = $(this);
        var g = a.get("sending");
        var h = 7;
        if (g == "1") {
            return
        }
        var b = $("footer_email_subscribe_email");
        var f = b.get("value");
        var j = $("footer_subscribe_desc");
        var i = $("footer_email_subscribe_email").get("defaultValue");
        if (f != i) {
            if (f.test("^([a-zA-Z0-9._-]+)@([a-zA-Z0-9.-]+)\\.([a-zA-Z]{2,4})$")) {
                a.set("sending", "1");
                var c = {
                    e: f,
                    type: h
                };
                var l = new Request.JSON({
                    url: "/member/subscribe-newsletter",
                    data: c,
                    onSuccess: function(m, e) {
                        a.set("sending", "0");
                        if (m.okay) {
                            j.set("html", "Thank you. Get ready for fun!");
                            b.set("value", "");
                            $("footer_email_subscribe_body").setStyle("display", "none")
                        } else {
                            if (m.code == "duplicated") {
                                j.set("html", "You're already on our list!");
                                b.set("value", "")
                            } else {
                                if (m.code == "invalid") {
                                    j.set("html", "Invalid email. Please try again.")
                                }
                            }
                        }
                    },
                    onFailure: function(m, e) {
                        a.set("sending", "0")
                    }
                }).post()
            } else {
                j.set("html", "Invalid email. Please try again.")
            }
        }
    })
}
if ($("email_subscribe_submit")) {
    $("email_subscribe_submit").addEvent("click",
    function(d) {
        if (d) {
            d.preventDefault()
        }
        var a = $(this);
        var g = a.get("sending");
        if (g == "1") {
            return
        }
        var i = $("email_subscribe_email").get("defaultValue");
        var b = $("email_subscribe_email");
        var f = b.get("value");
        var h = $$("input.email_subscribe_type[name=email_subscribe_type]:checked")[0].value;
        var j = $("email_subscribe_desc");
        if (f != i) {
            if (f.test("^([a-zA-Z0-9._-]+)@([a-zA-Z0-9.-]+)\\.([a-zA-Z]{2,4})$")) {
                a.set("sending", "1");
                var c = {
                    e: f,
                    type: h
                };
                var l = new Request.JSON({
                    url: "/member/subscribe-newsletter",
                    data: c,
                    onSuccess: function(m, e) {
                        a.set("sending", "0");
                        if (m.okay) {
                            j.set("html", "Thank you. Get ready for fun!");
                            b.set("value", "");
                            $("email_subscribe_body").setStyle("display", "none")
                        } else {
                            if (m.code == "duplicated") {
                                j.set("html", "Thanks. You're already on our list!");
                                b.set("value", "")
                            } else {
                                if (m.code == "invalid") {
                                    j.set("html", "Invalid email. Please try again.")
                                }
                            }
                        }
                    },
                    onFailure: function(m, e) {
                        a.set("sending", "0")
                    }
                }).post()
            } else {
                j.set("html", "Invalid email. Please try again.")
            }
        }
    })
}
GAG.Others = {
    bindElements: function() {
        $$("input.text.color").addEvent("focus",
        function(c) {
            c.preventDefault();
            var b = $(this).getParent("div").getElement("a.color-picker").addClass("show")
        });
        $$("input.text.color").addEvent("blur",
        function(b) {
            new Event(b).stop()
        });
        if ($("post_view_share")) {
            $("post_view_share").addEvent("click",
            function(b) {
                b.preventDefault();
                $$("div.sharing-bar").toggleClass("hide")
            })
        }
        if ($("post_view_comment")) {
            $("post_view_comment").addEvent("click",
            function(b) {
                b.preventDefault();
                $("post_view_comment_box").focus()
            })
        }
        $$("div.profile-menu ul, #footer ul.menu").addEvent("mouseover",
        function(b) {
            $(this).getPrevious().addClass("hover")
        });
        $$("div.profile-menu ul, #footer ul.menu").addEvent("mouseout",
        function(b) {
            $(this).getPrevious().removeClass("hover")
        });
        if ($("bookmark-badge")) {
            $("bookmark-badge").addEvent("click",
            function() {
                ql("bookmark", "click");
                bookmarkSite("9GAG - Just for Fun!", "http://9gag.com/?utm_source=bookmark");
                _gaq.push(["_trackEvent", "Bookmark", "Clicked", "Header", 1])
            })
        }
        $$(".badge-js").each(function(c, b) {
            $(c).set("html", $(c).get("key"))
        });
        $$("a.color-picker").addEvent("click",
        function(c) {
            if (c) {
                c.preventDefault()
            }
            var b = $(this).getParent("div").getElement("input.text.color");
            if ($(this).hasClass("show")) {
                $(this).removeClass("show");
                b.color.hidePicker()
            } else {
                $(this).addClass("show");
                b.color.showPicker()
            }
        });
        $$("div.url-box input").addEvent("click",
        function(b) {
            $(this).selectRange(0, $(this).get("value").length)
        });
        $$("input.tipped, textarea.tipped").addEvent("focus",
        function(c) {
            c.preventDefault();
            var b = $(this).getParent("div.field").getElements("p.info");
            if (b) {
                b.setStyle("visibility", "visible")
            }
        });
        $$("input.tipped, textarea.tipped").addEvent("blur",
        function(c) {
            c.preventDefault();
            var b = $(this).getParent("div.field").getElements("p.info");
            if (b) {
                b.setStyle("visibility", "hidden")
            }
        });
        $$(".badge-lazyload-toggler").addEvent("click",
        function(d) {
            d.preventDefault();
            var g = {
                path: "/",
                duration: 365 * 20
            };
            var c = "lazyload_on";
            var b = 300;
            var f = $(this).hasClass("current") ? "0": "1";
            if (f == "1") {
                if (!confirm("Lazyload is an experimental feature, do you want to enable it?")) {
                    return
                }
            }
            Cookie.write(c, f, g);
            setTimeout("window.location.reload();", b)
        });
        function a() {
            try {
                var b = window.location.toString().split("//")[1].split("/")[0];
                return b == "9gag.com"
            } catch(c) {}
            return false
        }
        $$(".badge-track-impression").each(function(d, c) {
            if (!a()) {
                return
            }
            var b = $(d).get("data-i");
            if (!b) {
                return
            }
            b += "?t=" + parseInt(Math.random(1000) * 1000, 10);
            try {
                rmt(b)
            } catch(f) {}
        });
        $$(".badge-track-action").addEvent("click",
        function(c) {
            if (!a()) {
                return
            }
            var b = $(this).get("data-a");
            if (!b) {
                return
            }
            b += "?t=" + parseInt(Math.random(1000) * 1000, 10);
            try {
                rmt(b)
            } catch(c) {}
        })
    }
};
window.addEvent("domready",
function() {
    try {
        GAG.Overlay.bindElements();
        GAG.Submit.bindElements();
        GAG.Effect.AutoComplete.bindElements();
        GAG.Effect.Sidebar.bindElements();
        GAG.Ajax.LoadPage.init();
        GAG.Social.Facebook.init();
        GAG.Social.Facebook.bindElements();
        GAG.Ajax.Vote.bindElements();
        GAG.Login.bindElements();
        function c(u) {
            var o;
            var s;
            var p;
            var m = false;
            var w = (Browser.Engine.trident) ? document.documentElement.scrollTop: window.pageYOffset;
            if (u == "L" || u == "H") {
                var g = $$(".jump_stop");
                var f = (Browser.Engine.trident) ? (document.documentElement.scrollHeight - document.documentElement.clientHeight) : (document.documentElement.scrollHeight - window.innerHeight);
                if (f <= w) {
                    if (g.length > 0) {
                        s = $(g[g.length - 1])
                    }
                } else {
                    for (var r = 0; ! m && r < g.length; r++) {
                        o = s;
                        s = $(g[r]);
                        var l = s.getPosition().y;
                        var h = l - topMargin;
                        if (r == g.length - 1) {} else {
                            if (r == 0) {
                                h = 0
                            }
                            p = $(g[r + 1]);
                            var t = p.getPosition().y;
                            var x = t - topMargin;
                            if (h <= w && w < x) {
                                m = true
                            } else {}
                        }
                    }
                }
            } else {
                $$(".jump_stop").each(function(i) {
                    if (!m) {
                        o = s;
                        s = i
                    } else {
                        if (!$chk(p)) {
                            p = i;
                            return
                        } else {
                            return
                        }
                    }
                    if (s.getPosition().y >= w + topMargin) {
                        m = true
                    }
                })
            }
            var n = $("shortcut-event-label") ? $("shortcut-event-label").innerHTML: null;
            if (u == "H" || u == "L" || u == "S" || u == "C" || u == "V" || u == "R") {
                if (u != "V" && u != "R" && u != "L" && u != "H") {
                    scroll(0, s.getPosition().y - topMargin)
                }
                var j;
                switch (u) {
                case "H":
                    _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-H", n ? n: "Dislike", 1]);
                    j = s.getElement("ul li a.unlove");
                    break;
                case "L":
                    _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-L", n ? n: "Love", 1]);
                    j = s.getElement("ul li a.love");
                    break;
                case "S":
                    _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-S", n ? n: "Share", 1]);
                    j = s.getElement("ul li a.share");
                    break;
                case "C":
                    _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-C", n ? n: "Comment", 1]);
                    j = s.getElement("ul li a.comment");
                    if (j) {
                        window.location = j.get("href")
                    }
                    break;
                case "V":
                    _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-V", n ? n: "Change View", 1]);
                    window.location = $("current_view").get("href");
                    return;
                    break;
                case "R":
                    _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-R", n ? n: "Random", 1]);
                    window.location = "/random";
                    return;
                    break
                }
                if (j) {
                    j.fireEvent("click")
                }
            } else {
                if (u < 0) {
                    _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-K", n ? n: "Previous", 1]);
                    if ($chk(o)) {
                        scroll(0, o.getPosition().y - topMargin);
                        o.focus();
                        var d = o.getElement(".jump_focus");
                        if ($chk(d)) {
                            d.focus()
                        }
                    } else {
                        if ($chk($("jump_prev"))) {
                            Cookie.write("jumpGAG", "goLast", cookieOption);
                            window.location = $("jump_prev").get("href")
                        } else {
                            scroll(0, 0)
                        }
                    }
                } else {
                    _gaq.push(["_trackEvent", "Keyboard-Shortcut", "Pressed-J", n ? n: "Next", 1]);
                    var f = (Browser.Engine.trident) ? (document.documentElement.scrollHeight - document.documentElement.clientHeight) : (document.documentElement.scrollHeight - window.innerHeight);
                    if (w == f && $chk($("jump_next"))) {
                        Cookie.write("jumpGAG", "goFirst", cookieOption);
                        window.location = $("jump_next").get("href")
                    } else {
                        if ($chk(p)) {
                            var v;
                            if (s.getPosition().y == (w + topMargin)) {
                                v = p
                            } else {
                                v = s
                            }
                            scroll(0, v.getPosition().y - topMargin);
                            v.focus();
                            var d = v.getElement(".jump_focus");
                            if ($chk(d)) {
                                d.focus()
                            }
                            if ($chk($("more_button")) && p.get("do_more") == 1) {
                                if (u == "J" || u == 1) {
                                    p.set("do_more", 0);
                                    $("more_button").fireEvent("click")
                                }
                            }
                        } else {
                            if ($chk($("more_button"))) {
                                var e = $("more_button");
                                var q = $("next_button");
                                if (q.getStyle("display") != "none") {
                                    q.fireEvent("click");
                                    window.location = q.get("href")
                                } else {
                                    e.fireEvent("click")
                                }
                            } else {
                                if ($chk($("jump_next"))) {
                                    Cookie.write("jumpGAG", "goFirst", cookieOption);
                                    window.location = $("jump_next").get("href")
                                }
                            }
                        }
                    }
                }
            }
        }
        var a = {
            type: "keypress",
            propagate: false,
            target: document,
            disable_in_input: true
        };
        if (!$("page-post")) {
            shortcut.add("j",
            function() {
                c(1)
            },
            a);
            shortcut.add("k",
            function() {
                c( - 1)
            },
            a);
            shortcut.add("l",
            function() {
                c("L")
            },
            a)
        }
        shortcut.add("h",
        function() {
            c("H")
        },
        a);
        shortcut.add("c",
        function() {
            c("C")
        },
        a);
        if ($("page-landing") || $("page-profile") || $("page-post") || $("page-nsfw")) {
            shortcut.add("r",
            function() {
                c("R")
            },
            a)
        }
        if ($("page-post")) {
            var a = {
                type: "keypress",
                propagate: false,
                target: document,
                disable_in_input: true
            };
            a.keycode = 37;
            a.keycode = 39
        }
        GAG.Keyboard.bindElements();
        GAG.Others.bindElements();
        GAG.Ajax.Report.bindElements();
        if ($("page-settings")) {
            $("settings_submit").addEvent("click",
            function(g) {
                g.preventDefault();
                var d = $("form-settings").getElement("input[name=avatar]").get("value");
                var f = true;
                if (d.length != 0) {
                    if (!d.toLowerCase().test(".(jpeg|jpg|gif|png)$")) {
                        f = false
                    }
                }
                if (f) {
                    $("form-settings").submit()
                } else {
                    $$("p.form-message.success").addClass("hide");
                    $$("p.form-message.error").removeClass("hide")
                }
            })
        }
        GAG.Overlay.Language.bindElements();
        GAG.Effect.CountDown.bindElements();
        GAG.Effect.searchBar.bindElements();
        GAG.Effect.Scroll.bindElements()
    } catch(b) {
        GAG.Log.report(b)
    }
});
function initJumpGAG(c) {
    var a = Cookie.read("jumpGAG");
    if ($chk(a)) {
        var e = $$(".jump_stop");
        var d = 0;
        if ($chk(e) && e.length > 0) {
            if (c && a == "goLast") {
                var b = e.getLast();
                d = b.getPosition().y - topMargin;
                scroll(0, d)
            } else {
                if (false && a == "goFirst") {
                    var b = e[0];
                    d = b.getPosition().y - topMargin;
                    scroll(0, d)
                }
            }
        }
    }
}
function bookmarkSite(d, a) {
    var c = navigator.userAgent;
    if (window.sidebar) {
        window.sidebar.addPanel(d, a, "")
    } else {
        if (window.opera && window.print) {
            var b = document.createElement("a");
            b.setAttribute("href", a);
            b.setAttribute("title", d);
            b.setAttribute("rel", "sidebar");
            b.click()
        } else {
            if (document.all) {
                window.external.AddFavorite(a, d)
            }
        }
    }
}
function bookmark(a) {
    Cookie.write("bookmark", a, cookieOption)
}
window.addEvent("resize",
function() {
    GAG.Effect.Scroll.initElementsData(true);
    GAG.Effect.Scroll.onPageScroll();
    GAG.Effect.Sidebar.updateSidebarPosts()
});
window.addEvent("load",
function() {
    initJumpGAG(true);
    GAG.Effect.Sidebar.updateSidebarPosts();
    Cookie.dispose("jumpGAG", cookieOption);
    window.onloaded = true
});