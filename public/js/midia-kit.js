/* Mídia Kit — filtros por marca */
(function () {
	function init(root) {
		var tabs = root.querySelectorAll("[data-vb-mk-filter]");
		var items = root.querySelectorAll("[data-vb-mk-products] > [data-vb-mk-brand]");
		var empty = root.querySelector("[data-vb-mk-empty]");
		if (!tabs.length || !items.length) return;

		tabs.forEach(function (tab) {
			tab.addEventListener("click", function () {
				var filter = tab.getAttribute("data-vb-mk-filter") || "";
				tabs.forEach(function (t) {
					var on = t === tab;
					t.classList.toggle("is-active", on);
					t.setAttribute("aria-selected", on ? "true" : "false");
				});
				var visible = 0;
				items.forEach(function (item) {
					var brand = item.getAttribute("data-vb-mk-brand") || "";
					var show = !filter || brand === filter;
					item.hidden = !show;
					if (show) visible += 1;
				});
				if (empty) empty.hidden = visible > 0;
			});
		});
	}

	function boot() {
		document.querySelectorAll("[data-vb-mk]").forEach(init);
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", boot);
	} else {
		boot();
	}
})();
