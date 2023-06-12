!function(a,b) {
	b(a)
}(window, function(a,b) { 
	var _ = function(a,b) {
        return new _.fn.init(a,b)
    };
    _.fn = {};
    var A,B = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,C = _.fn.init = function(a, b, c) {   	
        var e, f;
        if (!a) return this;
        if ("string" == typeof a) {
            if (e = "<" === a[0] && ">" === a[a.length - 1] && a.length >= 3 ? [null , a, null ] : B.exec(a),!e || !e[1] && b)
                return !b || b.jquery ? (b || c).find(a) : this.constructor(b).find(a);
            if (e[1]) {
                if (b = b instanceof n ? b[0] : b,
                n.merge(this, n.parseHTML(e[1], b && b.nodeType ? b.ownerDocument || b : d, !0)),
                x.test(e[1]) && n.isPlainObject(b))
                    for (e in b)
                        n.isFunction(this[e]) ? this[e](b[e]) : this.attr(e, b[e]);
                return this
            }
            return f = d.getElementById(e[2]),
            f && f.parentNode && (this.length = 1,
            this[0] = f),
            this.context = d,
            this.selector = a,
            this
        }
        return a.nodeType ? (this.context = this[0] = a,
        this.length = 1,
        this) : n.isFunction(a) ? void 0 !== c.ready ? c.ready(a) : a(n) : (void 0 !== a.selector && (this.selector = a.selector,
        this.context = a.context),
        n.makeArray(a, this))
    };
	a._ = _;
});