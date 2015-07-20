# Baseline
Get a baseline grid overlay on your site in one painless, javascript-free step.

Here's an example demonstrating how to get a 24px baseline overlay on your site:

```<link rel="stylesheet" href="http://basehold.it/24">```

Easy, huh?
	
## Further Examples:

Specify a 6 digit hex code: 

```<link rel="stylesheet" href="http://basehold.it/24/DEEFFF">```

Specify separate RGB values: 

```<link rel="stylesheet" href="http://basehold.it/24/255/42/85">```

Specify 50% alpha using RGBA: 

```<link rel="stylesheet" href="http://basehold.it/24/255/42/85/0.5">```

## Image Only Mode

You can use Baseline to grab the image on it's own, if you'd rather apply it as a background in your own stylesheet.

Simple example:

```css
html {
	background-image: url(http://basehold.it/i/24); // 24px baseline
	background-image: url(http://basehold.it/i/24/ff0000); // with Hex colour
	background-image: url(http://basehold.it/i/24/255/0/0); // with RGB colour
	background-image: url(http://basehold.it/i/24/255/0/0/0.85); // with RGBA colour
}
```

## Bookmarklet

Just add this as a bookmark:

```js
javascript:(function(){var%20link=document.createElement("link");link.setAttribute("rel","stylesheet");link.setAttribute("href","http://basehold.it/"+parseInt(window.getComputedStyle(document.body).getPropertyValue("line-height"),10));document.head.appendChild(link);})()
```

This will add the default grid according to your body line-height (using `getComputedStyle`).

## Sass Mixin

@mixin baseline-grid( $line-height:24 ) {
	/* 
	* Useage ( change 24 to your grid size ) 
	* 
	* body {
	*      @include baseline-grid(24);
	* }
	* 
	*/

	position: relative;

	&:after {
		position: absolute;
		width: auto;
		height: auto;
		z-index: 9999;
		content: '';
		display: block;
		pointer-events: none;
		top: 0;
		right: 0;
		bottom: 0;
		left: 0;
		background: url(http://basehold.it/image.php?height=#{$line-height}) repeat top left;
	}
	&:active:after {
		display: none;
	}
}
