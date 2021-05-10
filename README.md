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

![settings]()


## Settings Page

![settings page]()

## Set as Primary Category

After enabling a taxonomy from your settings, you can select your primaries categories.

![post screen]()

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
	echo '<ul>';
	while ( $query->have_posts() ) {
		$query->the_post();
		echo '<li>' . the_title();
			the_primary_category( 'product_cat', get_the_id(), 'link' );
		echo '</li>';
	}
	echo '</ul>';
	wp_reset_postdata();
}
```
