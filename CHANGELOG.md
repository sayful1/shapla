#### 3.0.1 - Nov 19, 2023

* Tweak - Update color there and typography css variables.
* Dev - Update JavaScript dependencies to latest version.
* Dev - Tested with WordPress 6.4

#### 3.0.0 - Aug 8, 2022

* Feature - Add support for 'Transparent Header' feature to enable from page setting.
* Feature - Add theme.json file with global color palette.
* Feature - Add meta box setting for 'Interior Content Width' removing 'Full Width' and 'Full Screen' page template.
* Feature - Add meta box setting to hide/show post navigation.
* Feature - Add fluid container for header.
* Feature - Re-design header search design using drawer component.
* Feature - Re-design header card icon design using drawer component for WooCommerce.
* Feature - Update navigation design using drawer component for small device.
* Tweak - Add support for **YITH WooCommerce Wishlist** and **TI WooCommerce Wishlist**.
* Tweak - Add function to disable fontawesome style when official fontawesome plugin installed.
* Tweak - Update button and input field design for focus state.
* Tweak - Update block style merging into main style file.
* Tweak - Update button style default to secondary color.
* Tweak - Update widgets style removing Font Awesome icon.
* Dev - Add option to get value from parent theme modifications if it is a child theme.
* Dev - Add filter to hide child stylesheet loading from parent theme.
* Dev - Add new screenshot image.
* Dev - Removed archive.php, page.php, 404.php, single.php and search.php files.
* Fix - Fix PHP notices for variable not set issue on yoast_breadcrumb option.

#### 2.2.1 - Jun 21, 2022

* Tweak - Fix issue to create web-font directory if it is not exists.
* Tweak - Add local fonts preload functionality to improve performance.
* Tweak - Update style to support Font Awesome icon on menu item.
* Tweak - Add query parameter display with value swap for Google Fonts.
* Tweak - Add customize field for header submenu background color, test color and accent color.
* Dev - Add typescript support for frontend scripts.

#### 2.2.0 - Apr 17, 2022

* Tweak - Add webfont loader class to copy google fonts locally.
* Tweak - Update theme default color pallet.
* Dev - Fix sass warning for deprecated operation.

#### 2.1.0 - Apr 15, 2022

* Dev - Add fontawesome from npm to the latest version 6.1.1.
* Dev - Add select2 from npm to the version 4.0.3.
* Dev - Remove dependency over jQuery tipTip plugin.
* Dev - Update Metabox Field classes and re-design to adopt with new block based editor.
* Dev - Update javascript dependencies.
* Dev - Update classes directory structure using PSR-4 autoload standard.
* Dev - Update header.php file.
* Dev - Update customizer panels, sections and fields.
* Dev - Add new (React based) customize control color replacing old color for handling alpha color.
* Dev - Update color sanitize functionality.

#### 2.0.1 - June 21, 2020

* Fix - Page navigation style break if not previous navigation.
* Fix - Full screen template also contain padding on mobile screen.
* Fix - Extra padding on content bottom on full screen page template.
* Fix - Comment area is taking full screen on full screen page template.
* Tweak - Remove product search form javaScript
* Tweak - Add dynamic CSS variables for footer widget area.
* Tweak - Add dynamic CSS variables for footer area.
* Tweak - Remove dynamic CSS variables from DOM to Style section for footer widget and footer area.
* Tweak - Add dynamic CSS variables for page title bar.
* Tweak - Add dynamic CSS variables for site header.
* Tweak - Add `wp_body_open` action hook after body open as recommended from WordPress 5.2
* Tweak - Update coding standard with the latest theme check plugin.

#### 2.0.0 - March 31, 2020

* Feature - Add customize setting for Enable/disable Structured Data.
* Feature - Update single page entry meta design.
* Feature - Add color customize option with CSS variable generation.
* Tweak - Update pagination style.
* Tweak - Update author avatar design.
* Tweak - Add icon container css class to user icon.
* Tweak - Update search form style.
* Tweak - Update PHP RGB color function.
* Tweak - Update WooCommerce product tabs style.
* Tweak - Update sticky header javaScript functionality.
* Tweak - Update WooCommerce single product style.
* Tweak - Set secondary color for star rating.
* Tweak - Removed button color as it will replaced by color system.
* Tweak - Removed primary and text color from typography section.
* Tweak - Update ShaplaNavigation and ShaplaBackToTop javaScript class.
* Tweak - Improved dropdown toggle and menu toggle design.
* Tweak - Update sticky header functionality.
* Tweak - Update WooCommerce cart page style.
* Tweak - Update breadcrumb style by removing customizer typography control.
* Tweak - Update blog entry meta style.
* Tweak - Add css variable for changing font family.
* Tweak - Fixed navigation arrow is now working.
* Tweak - Update comment css classes.
* Removed - Remove button customize settings as it no longer required.
* Dev - Add option to load metabox classes only on admin area.
* Dev - Update SASS directory structure.
* Dev - Change module bundler from Gulp to Webpack and update src directory.

#### 1.5.3 - January 08, 2019

* Fix - Comment area is taking full visual width for full-screen template.
* Fix - Carousel slider post carousel does not take full item width.
* Fix - Fixed embed height issue.

#### 1.5.2 - December 16, 2018

* Add - Add support for full align block on full screen page template.
* Add - Add body class 'shapla-has-blocks' for single posts when using block editor.
* Tweak - Update block button styles.
* Tweak - Set block editor max with as 1140px.
* Tweak - Update gutenberg pullquote style.
* Tweak - Update table style with support form stripes style.
* Tweak - Add margin bottom form fieldset html tag.
* Tweak - Update WooCommerce Order received page style.
* Tweak - Update calendar widget table style.
* Fix - Breadcrumb show on empty slush on second page if latest posts is displaying on homepage.

#### 1.5.1 - December 06, 2018

* Fix - Fix blocks.css file show 404 not found (as it is not available).

#### 1.5.0 - December 06, 2018

* Add - Add gutenberg block style for WordPress version 5.0.
* Tweak - Upgrade to Font Awesome version 5.5.0 from version 4.7.0.

#### 1.4.6 - October 02, 2018

* Add - Add new post class 'shapla-grid-item'.
* Tweak - Rename body class from 'blog-grid' to 'shapla-blog-grid'.
* Fixed - Fixed Elementor Pro Page Builder archive page style issue.

#### 1.4.5 - October 01, 2018

* Add - Add support for Elementor Pro Page Builder Custom Header.
* Add - Add support for Elementor Pro Page Builder Custom Footer.
* Add - Add support for Elementor Pro Page Builder Custom 404 page.
* Add - Add support for Elementor Pro Page Builder Custom single post.
* Add - Add support for Elementor Pro Page Builder Custom archive page.
* Tweak - Update post and comment navigation.
* Tweak - Update WooCommerce my account page style.

#### 1.4.4 - May 03, 2018

* Add - Add metabox option to hide or show breadcrumbs.
* Add - Add metabox option for content padding.
* Add - Add metabox option for sidebar position and sidebar widget area.
* Add - Add metabox option to choose sidebar for WooCommerce shop page.
* Dev - Add dynamic style generator from metabox values.
* Dev - Add spacing field type.
* Dev - Add buttonset field type.
* Dev - Add tab for metabox.

#### 1.4.3 - March 15, 2018

* Fixed - Fixed some typography issue.
* Fixed - Fixed Carousel Slider default value PHP warning.
* Tweak - Update style for comments, reviews, star rating and some others.

#### 1.4.2 - March 13, 2018

* Fixed - Site title show on left on header center layout.
* Tweak - Change handle id from font-awesome to shapla-icons to remove conflict between version 4 and version 5.
* Tweak - Update primary navigation JavaScript code.
* Tweak - Update primary navigation style.
* Tweak - Removed normalize.css file.
* Tweak - Show copyright text on center if footer social menu is not active.
* Dev - Add Shapla_Metabox class for adding metaboxs.

#### 1.4.1 - February 19, 2018

* Feature - Add scroll back to top button with option to enable or disable from customize.
* Fixed - Fix wrong font weight for widget text.
* Fixed - Fix site title font weight showing differently rather than that of front page.

#### 1.4.0 - February 17, 2018

* Feature - Add page title bar section.
* Feature - Page title for default homepage (with the latest posts).
* Feature - Add theme custom breadcrumb class for breadcrumb support.
* Feature - Add Breadcrumb separator, font size, text color, text transform.
* Feature - Add support Yoast SEO breadcrumb feature
* Feature - Add support for generating JSON-LD structured data for breadcrumb.
* Feature - Add Page title bar customize options for background color, background image, and full typography
* Feature - Add Page title bar customize options for text alignment, padding and border color
* Feature - Add body typography with google fonts, font size, font weight, color and more.
* Feature - Add headers typography with google fonts, font size, font weight, color and more.
* Feature - Add background image feature for footer widget area.
* Feature - Add static css file generator for dynamic css generated by customize.
* Tweak - Update JavaScript for primary navigation.
* Tweak - Move page and post title to title bar section.
* Dev - Add slider custom customize control.
* Dev - Add toggle custom customize control.
* Dev - Add background custom customize control.
* Dev - Add typography custom customize control.
* Dev - Add Shapla_Sanitize class for sanitizing values.
* Dev - Add Shapla_Fonts class for theme fonts functionality.
* Remove - Removed old google fonts custom customize control.
* Fix - H1 site title tag on Front page instead of Posts page.

#### 1.3.1 - January 3, 2018

* Added - Add system status tab in theme page.
* Tweak - Update changelog style in theme page.
* Tweak - Update some style related to WooCommerce and header.

#### 1.3.0 - November 12, 2017

* Added - Add option to change google fonts from popular 30 fonts.
* Added - Add custom style for carousel slider plugin.
* Added - Add recommended plugins list in theme page.
* Added - Add radio image customize controller.
* Added - Add radio button customize control.
* Tweak - Add alpha color customize control.
* Tweak - Add new screenshot.png file.
* Tweak - Added new search icon replacing old search icon.
* Tweak - Update button related style.
* Tweak - Update pagination style with primary color.
* Tweak - Update content width up to 1140px.
* Added - Add border radius option on customizer.
* Added - Add WooCommerce related highlight colors.
* Tweak - Update input, select and textarea related style.
* Tweak - Add option to change google font from popular 30 fonts.
* Added - Add three header layout.
* Added - WooCommerce Product search with categories dropdown.
* Added - Added primary menu dropdown direction (LTR or RTL).
* Tweak - Update primary navigation style.
* Tweak - Update menu style for dropdown direction.
* Tweak - Add changelog to theme page.

#### 1.2.2 - September 28, 2017

* Tweak - Update Shapla_Customizer::sanitize_color() method.
* Fixed - Jetpack in infinite-scroll style not working properly.
* Added - Added compatibility with PHP 5.3

#### 1.2.1 - August 15, 2017

* Fixed - Header text and link color is not working for toggle and search icon.
* Tweak - Changed toggle menu width up to 1024px for iPad Pro width.
* Tweak - Changed sticky header minimum width 1025px for iPad Pro width.
* Added - Added new footer widgets rows and columns layout.
* Tweak - Deprecated (Above Footer Widget Region) but will be kept until version 2.0.0

#### 1.2.0 - August 09, 2017

* Added - Added site layout option (Wide or Boxed).
* Added - Added grid layout for blog.
* Added - Added option to hide/show page title on blog page.
* Tweak - Change default header color.
* Tweak - Update WooCommerce shop loop product style.
* Tweak - Remove dependency over Susy grid using CSS3 flexbox.
* Tweak - Show mobile menu for screen size smaller than 1101px.
* Tweak - Updated menu icon with css
* Fixed - Showing published date instate of modified date.

#### 1.1.5 - July 08, 2017

* Added - Added option to make header sticky on scroll.

#### 1.1.4 - Jun 30, 2017

* Tweak - Removed dependency over jQuery and rewrite with vanilla JS.

#### 1.1.3 - Jun 14, 2017

* Added - Added option to sanitize number field for Customizer
* Added - Added option to change WooCommerce products per page
* Added - Added option to change WooCommerce products per row

#### 1.1.2 - Jun 13, 2017

* Added - Added WooCommerce related styles.
* Tweak - Changed table cell padding and input field padding, and some other small fix.

#### 1.1.1 - Apr 28, 2017

* Fixed - Fixed menu-toggle button hover and active color.
* Fixed - Fixed loading button icon is not loading properly.
* Fixed - Fixed .button for a tag text color.
* Fixed - Fixed style when no sidebar.

#### 1.1.0 - Apr 20, 2017

* Added - Added Customizer Option to hide/show author avatar, author name, post date, category list, tag list, comments
  link.
* Added - Added Customizer Option to change sidebar layout: Left or Right.
* Tweak - Improved grids system with Susy.

#### 1.0.1 - Apr 10, 2017

* Added - Added structured data by using JSON-LD.
* Added - Added Customizer Option to customise the look & feel of your site buttons.
* Added - Added support for WooCommerce 3.0 product gallery zoom, lightbox and slider.

#### 1.0.0 - Mar 31, 2017

* Added - Added Shapla Welcome admin page.
* Added - Added Meta box to hide title on page.
* Added - Added Customizer Option to Hide or Show Search Icon from header.

#### 0.1.4 - Mar 24, 2017

* Approved and become live on WordPress theme directory

#### 0.1.0 - Jan 25, 2017

* Initial release
