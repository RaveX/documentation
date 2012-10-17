Like most [PyroCMS](http://www.pyrocms.com) modules we've kept the installation process to the bare minimum, simply follow these steps and you'll be up and running with your store in no time!

### Installation Steps

1. Clone yourself a copy of the FireSale core
2. Move everything to either your PyroCMS shared_addons or addons/default folder
3. If you are using PyroCMS Community you need to install also the [Multiple Relationship](https://github.com/parse19/PyroStreams-Multiple-Relationships) field type
4. Install the core via the admin modules panel
5. Install the other two modules by the same method
6. Go into settings and choose your preferred options, we strongly advise you to select yes for routes
7. Below you'll find a number of routes we suggest you install; a number of features will not work without them

### Routes

Either via the Routes Add-on or directly into the config we suggest you put the following items into your routes:
 
	$route['category/(order|style)/([a-z0-9]+)'] = 'firesale/front_category/$1/$2';
	$route['category(:any)'] = 'firesale/front_category/index$1';
	$route['product(:any)'] = 'firesale/front_product/index$1';
	$route['search(:any)?'] = 'firesale_search/search/index$1';
	$route['cart(:any)?'] = 'firesale/cart$1';
	$route['users/orders/([0-9]+)'] = 'firesale/front_orders/view_order/$1';
	$route['users/orders'] = 'firesale/front_orders/index';
	$route['users/addresses(/:any)?'] = 'firesale/front_address$1';

If you would like to replace the default PyroCMS dashboard with the FireSale dashboard then you can do so by adding the following route:

	$route['admin'] = 'firesale/admin/index';

### Settings

Additional modules will add more options and details are provided on their respective documentation pages.

Name | Description | Options
-----|-------------|--------
Tax Percentage | This is the additional cost that will be applied to your products during creation and can be toggled on or off on these pages. | Float, default 20
Make Images Square | When images are uploaded this will make them sqaure depending on their largest dimension. This is required for many layouts to keep things consistent. | Yes or No, default No
Products per Page | How many products to display on category and search pages. | integer, default 15
Currency Code | The ISO-4217 code for your selected currency. This does not change your currency symbol as we use the one specified in the default Pyro settings | String, 3 characters, default GBP