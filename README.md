# Primary Category
WordPress Plugin that allows publishers/users to designate a primary category for posts/custom post types and query posts/custom post types based on their primary categories

# Installation
1. Copy the `primary-category` folder into your `wp-content/plugins` folder
2. Activate the `Primary Category` plugin via the plugin admin page

# Settings
## Enable primary category feature?

1. Open the settings page from your dashboard Settings > Primary Category.
2. Select the taxonomies what you want to enable the feature.
3. After selecting taxonomies, click in the save changes button.

## Settings > Primary Category

![settings](http://its-wt.com/primary-category/settings-menu.jpeg)


## Settings Page

![settings page](http://its-wt.com/primary-category/settings-page.jpeg)

## Set as Primary Category

After enabling a taxonomy from settings, select primary categories from post-edit or post-new screen.

![post screen](http://its-wt.com/primary-category/set-as-primary.jpeg)

# Functions
| Name | Argument(s) |
|------|-------------|
| the_primary_category | **$taxonomy** *required*<br>support mixed ( int, WP_Term, object, string ) <br>-----<br>**$post_id** *required*<br>support mixed ( int, WP_Post, NULL ) <br>*default value:* NULL<br>-----<br>string **$output** *optional*<br>*default value:* "link"<br>*others values:* "name"<br>-----<br>**$echo** *optional*<br>*default value:* true<br> |

**Basic example**

```PHP
$args = array(
	'post_type' => 'product',
);

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) {
		$query->the_post();
		echo the_title();
		echo "<br/>"
		the_primary_category( 'product_cat', get_the_ID(), 'link' );
	}
}
```
**Note:**

-- $taxonomy and $post_id are required parameters and must be used when using the function<br>
-- $output can be link or name<br>
-- Function can be used with or without echo<br>

# Filters

| Filter | Argument(s) |
|--------|-------------|
| primary_category_html | string **$html**<br>mixed ( int, WP_Term, object, string ) **$taxonomy** *required*<br>mixed ( int, WP_Post, NULL ) **$post_id** *required*<br>string **$output** |

# Shortcode

| Tag | Attribute(s) |
|-----|--------------|
| primary_category | mixed ( int, WP_Term, object, string ) **taxonomy**<br>*required*<br>--<br>mixed ( int, WP_Post, NULL ) **post-id**<br>*default value:* NULL<br>*required*<br>--<br>string **output**<br>*default value:* "link"<br>*others values:* "name"<br>*optional* |

#### How to use
```
[primary_category taxonomy="category"]
```

```
[primary_category taxonomy="category" post-id="12"]
```

```
[primary_category taxonomy="category" post-id="12" output="link"]
```
# WP_Query

**See below how get posts with product_cat taxonomy selected primary category of with terms-ids 18 & 21**

```PHP
$taxonomy = 'product_cat';
$args = array(
       	'post_type' => 'product',
         'meta_query' => array(
         	array(
		  'key'     => '_primary_category_' . $taxonomy,
		  'value'   => array( 18,21 ),  // terms id
		  'compare' => 'IN',
    		)
	),
);

$query = new WP_Query( $args );

if ( $query->have_posts() ) {
      while ( $query->have_posts() ) {
	    $query->the_post();
	    the_title();
      }
}

```
https://developer.wordpress.org/reference/classes/wp_query/#custom-field-post-meta-parameters

# TODO: Gutenberg Compatibility Issue
In order to make this plugin compatible with gutenberg, there was an issue with post-edit/post-new panels. I was unable to find a class to target the panels and display ???set as primary??? button ahead terms. The reason was all panels were having the same class and gutenberg still doesn???t provide any method to add custom class/id.

### Reference Link: https://github.com/WordPress/gutenberg/issues/12082
