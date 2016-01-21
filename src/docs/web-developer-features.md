# Web Developer Features

If you're a web developer customizing Harbor for your client, there are a few "just for web developers" features you should know about.

## Working with the source code

Harbor is built with [Sass](http://sass-lang.com/) and [Gulp](http://gulpjs.com/) using the [Kraken boilerplate](http://cferdinandi.github.io/kraken/).

If you'd like to work with source code, please consult the [Kraken docs](http://cferdinandi.github.io/kraken/) to get started. One small addition: Harbor automatically builds the `style.css` file for you using the `package.json` file.

## Changing the Theme Name

If you're going to make modifications to Harbor, it is strongly suggested that change the name of theme to avoid conflicts in the future. You can do this in the `style.css` file, or if you're using the source files, the `package.json` file.

## Disabling features

Harbor includes a configuration function at very top of the `functions.php` file. Setting any feature to `false` disables it.

```lang-php
function keel_developer_options() {
	return array(
		'fonts' => true, // Custom typefaces
		'social' => true, // Social links in the footer
		'footer' => true, // Custom footer content sections
		'pets' => true, // Pet listings
		'paypal' => true, // PayPal donation integration
		'gallery' => true, // Responsive tiled [gallery] shortcode
		'hero' => true, // Header hero meta box
		'page_width' => false, // Custom page layouts
		'custom_logo' => true, // Custom logo support
		'button_shortcode' => true, // [button] shortcode
		'svg_shortcode' => true, // [svg] shortcode
		'theme_support' => true, // Theme support link under "Appearance"
	);
}
```

If you disable custom typefaces and are working with the source files, you should also set `$fonts` to `false` in the `src/sass/_config.scss` file to reduce overall file size.

## Custom page layouts

Only one feature in Harbor is disabled by default: `page_width`. Setting this to `true` adds a special meta box on pages that let's you customize the width of the page.

`default` is the narrow, content-focused page width (`40em`). `wide` sets the page content to the same width as the header and footer (`80em`).

`diy` removes all padding from the body content and gives you complete control. This is useful when you want to include full-bleed content sections. Check out the [Kraken docs](http://cferdinandi.github.io/kraken/) to learn more about the responsive grid used in Harbor.

You can also hide the page `h1` header by checking the `Hide Page Header` checkbox.

## Inline SVGs

Harbor adds Media Library support for SVGs. While SVGs can be used as the `src` of an `<img>` tag, Harbor also includes the `[[svg]]` shortcode if you'd prefer to inline your SVGs.

An `id` or `url` attribute must be passed in. You can also add classes to the SVG with the `class` attribute.

```lang-php
[[svg url="http://harbor.gomakethings.com/some-image.svg" class="icon icon-large"]]
```