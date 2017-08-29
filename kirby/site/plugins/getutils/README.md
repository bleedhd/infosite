# Overview
This plugin is a bundle of small Getunik Kirby utilities that saves the hassle of copy-pasting the same code everywhere. All the tools and features are described in more detail below.

# Installation
From within your Kirby root directory, add this repository as a submodule like this:

```bash
git submodule add git@bitbucket.org:getunik/kirby-utilities.git site/plugins/getutils
```

# Features

## Responsive Images / Image Styles
The concept of responsive images and image styles in this context refer to two different aspects of the same general
idea: displaying images specifically optimized for a certain viewport.

The term _responsive image_ here refers to the process whereby the `src` attribute of an image is changed to point to
a completely different file, while _image styles_ are a way to replace the `src` attribute with a different Kirby
`thumb` cropped version of the _same_ file.

### Mobile or Desktop First?
Depending on your preferences, the responsive image handling can be mobile-first or desktop first. This can be
configured in your `config.php` as follows:
```php
// mobile-first order (default)
c::set('image-style.breakpoints', ['xs', 'sm', 'md', 'lg', 'xl']);
// desktop-first order
c::set('image-style.breakpoints', ['xl', 'lg', 'md', 'sm', 'xs']);
```

The approach to both responsive images and image styles is the same in that it walks through the breakpoints in order
and if there is a _definition_ for the breakpoint, then it will add an alternate `data-src-*` attribute to the image
and the JavaScript processes those in such a way that if there is no data attribute for the current breakpoint, the
_previous_ one in the breakpoint order is applied.

### Responsive Images
To get started with responsive images, follow the steps below.

#### 1. Setup
Add the `responsive` global field definition to all of your blueprints where you want to have responsive images.
```yaml
files:
  fields:
    responsive: responsive
```

Now you can select your _main_ image on any image field on your blueprint and then go to the edit screen for that main
image file. There you can now choose an alternate image for any breakpoint you like.

#### 2. Rendering a Responsive Image
```php
<?php echo $page->my_image_field()->responsive(); // no image style ?>
```

### Image Styles
In addition _or_ instead of having a different image per breakpoint, you can configure your own image styles that make
use of Kirby's `thumb` image generation function to crop images for your.

You can do this in your `config.php` file by setting the `image-style.definitions` key. The value is an array keyed by
image style name and it's values are arrays that map breakpoints to `thumb` parameters. An example will make this much
more clear:

```php
c::set('image-style.definitions', [
	'my_image_style' => [
		// setting a breakpoint explicitly to NULL ensures that the original image URL is used
		'lg' => [
			'width' => 1440,
			'height' => 796,
			'crop' => true,
			'quality' => 100,
		],
		'md' => [
			'width' => 720,
			'height' => 300,
			'crop' => true,
			'quality' => 100,
		],
		'sm' => [
			'width' => 320,
			'height' => 200,
			'crop' => true,
			'quality' => 100,
		],
	],
]);
```

You should always define the breakpoint crop parameters in the order specified in `image-style.breakpoints`. If for a
given breakpoint, there is no matching thumb definition, the previous one will be used.

With one or more image styles configured, you can apply them to an image by passing the image style name to the
`responsive` function.

```php
<?php echo $page->my_image_field()->responsive('my_image_style'); // using defined my_image_style ?>
```

### Customization Options
TODO
* overriding global field definitions
* overriding responsive-image snippet


## Asset Management
TODO

## JS Utilities
TODO

## GTM Data Layer
When setting up a site that works with the Google Tag Manager (GTM), there are two things that you'll probably want
that the GTM documentation does not mention at all:
1. A client-side JS library to wrap the `dataLayer` array with some useful APIs
2. A server-side library that allows you to add events to the data layer for _the next time_ a page will be rendered

Assuming that you are using the asset manager also provided by this plugin, you can include the client-side library by
adding the following code to your controller or template.

```php
assets('js')->register([
    'type' => 'script',
    'src' => '/assets/plugins/getutils/getu-data-layer.js',
]);
```

In order for the server-side library to do its thing, you have to add its output to the `<head>` of your pages like so:
```php
<?php echo dataLayer(); ?>
```

This will generate code that initializes the `dataLayer` array for you.
```js
var dataLayer = dataLayer || [];
dataLayer.push({}); // one push statement for each event that you generate on the server
```

With all this in place, you can _generate_ data layer events on the server at any place you like by just calling the
`push` method on the `DataLayer` class.
```php
DataLayer::push(['event' => 'my-event', 'my-data' => 42]);
```

## Search
There are so many different ways to do some kind of search that it is very difficult to provide a one-size-fits-all
solution. The Kirby documentation suggests using the page APIs [to build a simple custom search](http://getkirby.com/docs/solutions/search).
This approach leads to various ever-so-slightly different search implementations that are hard to maintain. This is
why this plugin provides a reasonable and configurable base implementation that should work for most cases.

### The "indexable" Field
In many situations you will end up with pages that are _composed_ from sub-pages. If the sub-pages are not meant to be
actual pages, but instead _only_ serve as components of their parent page, then search becomes a bit more complex.
We still want the _contents_ of those sub-pages to be searched, but we want them to be _found_ on their parent page.

To solve this, we introduce the `indexable` field which is a checkbox that indicates whether the current page is
indexable by the search or not. If the search term matches a page that is **not** indexable, the search controller
will check the parents of the page until it finds one that **is** indexable. It then adds the indexable parent page
to the search results instead of the sub-page with the actual match and also takes care of potential duplicates for you.

To enable the search filter for the `indexable` field, add this to your configuration
```php
c::set('search-indexable', true);
```

The plugin already contains a global field definition for this field, so you can add it
to your templates like this:

```yaml
fields:

  Page Meta Data:
    label: Page Meta Data
    type: headline

  indexable: indexable

  title:
    label: Navigation title
    type:  text
```

**Note:** If you have a blueprint for pages that will _never_ be indexable, you simply don't add the indexable field and
since it's absence is equivalent to setting it to `false`, those pages will not be indexable.

### Search Page
To build a simple user facing search page, you will need a controller and a template that displays the search results.

```php
<?php
// search.php controller
return function($site, $pages, $page) {
	$results = \GetUtils\SearchController::search($site);
	$results = $results->paginate(50);

	return [
		'query'      => get('q'),
		'results'    => $results,
		'pagination' => $results->pagination(),
	];
};
```

```php
// search.php template
<?php snippet('html-header'); ?>
<?php snippet('default-content'); ?>

<form>
	<input type="search" name="q" value="<?php echo esc($query) ?>">
	<input type="submit" value="Search">
</form>

<ul>
	<?php foreach($results as $result): ?>
		<li>
			<a href="<?php echo $result->url() ?>">
				<?php echo $result->title()->html() ?>
			</a>
		</li>
	<?php endforeach ?>
</ul>

<?php snippet('html-footer'); ?>
```

### Search JSON API / AJAX Search
If you want to use the search API for AJAX requests, then you first have to enable it.
```php
c::set('search-api-enabled', true);
```

With the API enabled you can do your search queries in a JavaScript-friendly fashion by fetching
e.g. `/api/search?q=foo&lang=de` and you'll get a result along the lines of
```json
[
  {"id":"home","url":"http:\/\/localhost:3000\/de","uid":"home","title":"Home DE"},
  {"id":"page","url":"http:\/\/localhost:3000\/de\/page","uid":"page","title":"Page DE"}
]
```

#### Configuration Options
```php
// If you want to be able to call your API with the Path '/api/my/custom/search' instead of '/api/search'
c::set('search-api-path', 'my/custom/search'); // defaults to 'search'
// To include additional page fields in the JSON response
c::set('search-api-fields', ['id', 'url', 'uid', 'title', 'leadText']); // defaults to ['id', 'url', 'uid', 'title']
// Customize the search text parameter name
c::set('search-param-name', 'foo'); // defaults to 'q'
```

## Sitemap (sitemap.xml)
The plugin comes with a built-in `/sitemap.xml` route that generates a machine readable sitemap of your site for search
engines. If you don't do anything, the sitemap will contain all of your pages except for the `error` page. However, in
most situations you will need to tweak that a bit. There are several ways you can do this.

### Exclude Configuration
Explicitly exclude pages by listing them in your configuration.

```php
// exclude the pages with URIs 'page' and 'page/sub'
c::set('xml-sitemap-exclude', ['page/sub', 'page']);
```

### Use the Indexable field from the Search Feature
See [the search feature documentation](#search) for more details on the `indexable` field. If you are using the
`indexable` field, you can simply enable the corresponding feature toggle of the sitemap and it will only include pages
where the `indexable` field is present and set to `1`.
```php
c::set('xml-sitemap-indexable', true);
```

### Custom Filter Function
Instead of relying on the default filter, you can simply provide your own filter function.

```php
c::set('xml-sitemap-filter', function ($pages) {
    // call the default filter function if you just like to add some more filtering
    $pages = \GetUtils\XmlSitemapController::defaultFilter($pages);
    // filter out all pages that use the 'hidden' template
    return $pages->filterBy('template', '!=', 'hidden');
});
```

### Customizing Templates
The sitemap is built with two templates (in the `snippets` directory) that you can override in your Kirby
`site/snippets` directory to completely customize the sitemap output. Just copy the templates to your snippets
directory and start customizing.


## Helpers
TODO

### classes
TODO
### device
TODO
### browserCaps
TODO
