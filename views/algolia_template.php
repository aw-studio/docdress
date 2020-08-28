<script id="search_suggestion_template" type="text/template">
	<div class="dd-search-result">
		{{#_highlightResult.hierarchy.lvl0.value}}
		<h5 class="dd-search-result__title">
			{{{ _highlightResult.hierarchy.lvl0.value }}}
		</h5>
		{{/_highlightResult.hierarchy.lvl0.value}}

		<div class="dd-search-result__subtitle color-gray-900">
			{{#_highlightResult.hierarchy.lvl0.value}}
				<span>{{{ _highlightResult.hierarchy.lvl0.value }}}</span>
			{{/_highlightResult.hierarchy.lvl0.value}}

			{{#_highlightResult.hierarchy.lvl1.value}}
				<span> <span class="color-red-500">></span> {{{ _highlightResult.hierarchy.lvl1.value }}}</span>
			{{/_highlightResult.hierarchy.lvl1.value}}

			{{#_highlightResult.hierarchy.lvl2.value}}
			<span> <span class="color-red-500">></span> {{{ _highlightResult.hierarchy.lvl2.value }}}</span>
			{{/_highlightResult.hierarchy.lvl2.value}}

			{{#_highlightResult.hierarchy.lvl3.value}}
				<span> > {{{ _highlightResult.hierarchy.lvl3.value }}}</span>
			{{/_highlightResult.hierarchy.lvl3.value}}

			{{#_highlightResult.hierarchy.lvl4.value}}
			<span> > {{{ _highlightResult.hierarchy.lvl4.value }}}</span>
			{{/_highlightResult.hierarchy.lvl4.value}}

			{{#_highlightResult.hierarchy.lvl5.value}}
			<span> > {{{ _highlightResult.hierarchy.lvl5.value }}}</span>
			{{/_highlightResult.hierarchy.lvl5.value}}
		</div>

		{{#_highlightResult.content}}
		<div class="dd-search-result__text">
			{{{ _highlightResult.content.value }}}
		</div>
		{{/_highlightResult.content}}
	</div>
</script>

<script id="search_empty_template" type="text/template">
	<div class="autocomplete-wrapper empty" style="padding: 1rem 1.5rem">
		We didn't find any result for "{{query}}". Sorry!
	</div>
</script>

<script id="search_footer_template" type="text/template">
	<div class="footer" style="border-top: 1px solid #cbd5e0;padding: 1rem 1.5rem">
		<a target="_blank" href="https://www.algolia.com/docsearch">
            <img width="105"  alt="Algolia">
			<div style="clear: both"></div>
		</a>
	</div>
</script>