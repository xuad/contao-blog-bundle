// Fix $ from other frameworks
var $j = jQuery.noConflict()

$j(document).ready(function() {

	var tags = new TagsManager();
	tags.initialisize();
});

/**
 * Class AjaxTagsRequest
 */
function TagsManager()
{
	this.newsId = 0;
	this.parsedResponseJson = null;

	/**
	 * Initialisize tags
	 */
	this.initialisize = function()
	{
		// Init tags list
		$j('#ctrl_tags').after('<ul id="input_tags" data-name="nameOfSelect"></ul>');
		$j('#ctrl_tags').hide();

		$j('#input_tags').tagit({
			initialTags: $j.parseJSON($j('#ctrl_tags').val()),
			sortable: false,
			tagsChanged: function() {
				// Save tags in dc field
				$j('#ctrl_tags').val(JSON.stringify($j('#input_tags').tagit("tags")));
			}
		});

		// Initialiste tag cloud
		$j('fieldset#pal_tags_legend legend').after('<div id="tag-cloud"><ul></ul></div>');

		//var tags = [{tag: "computers", count: 56}, {tag: "mobile", count: 12}];
		var tags = this.getAllTags()


		$j.each(tags, function(key, value) {
			var liElement = $j('<a href="#add-tag" title="'+ value.tag +'" data-count="' + value.count + '">' + value.tag + '(' + value.count + ')</a>');
			liElement.css("fontSize", (value.count / 10 < 1) ? value.count / 10 + 1 + "em" : (value.count / 10 > 2) ? "2em" : value.count / 10 + "em")
			liElement.click(function() {
				$j('#input_tags').tagit("add", {label: $j(this).attr("title"), value: $j(this).attr("title")});
				
				return false;
			});

			$j("#tag-cloud ul").append(
					$j('<li>', {}).append(
					liElement));
		});
	}

	/**
	 * Get tags from news id
	 * News id will read in php with get param
	 */
	this.getTagsFromNews = function()
	{
		var parsedJson;

		this.sendBackendAjaxJsonRequest("getTagsFromNewsId", "data", function(json) {
			parsedJson = $j.parseJSON(json);
		});

		return parsedJson;
	}

	/**
	 * Get tags from news id
	 * News id will read in php with get param
	 */
	this.getAllTags = function()
	{
		var parsedJson;

		this.sendBackendAjaxJsonRequest("getAllTags", "data", function(json) {
			parsedJson = $j.parseJSON(json);
		});

		return parsedJson;
	}

	/**
	 * Send a ajax request
	 */
	this.sendBackendAjaxJsonRequest = function(method, data, onSuccessFunction)
	{
		// Contao request json
		var requestJson = {'action': method, 'REQUEST_TOKEN': Contao.request_token, 'data': data};

		$j.ajax({
			type: "POST",
			async: false,
			url: window.location.href,
			data: requestJson,
			success: onSuccessFunction
		});

		return false;
	}
}